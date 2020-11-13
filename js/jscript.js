var session_token = '';

$(document).ready(function(){
	$(document).on('click','.global-search-icon',function(){
		if ($('.search-results-div').hasClass('active')){
			return;
		}
		$('.search-results-div').show().addClass('active');
		$('.global-search-input').val('').focus();
		$('.search-results-list').html('');
		setTimeout(function(){
			$('.navbar-search').removeClass('expanded');
		},300);
	});

	// search handlers
	$(document).on('click','.search-modal-backdrop',function(){
		$('.search-results-div').hide().removeClass('active');
	});

	var tout;
	$(document).on('keyup','.global-search-input',function(e){
		e.stopImmediatePropagation();
		e.preventDefault();
		var key = e.keyCode;
		if (key != 38 && key != 40 && key != 13){		
			clearTimeout(tout);
			tout = setTimeout(search,350);			
		}
	});

	$(document).on('search',"input[type='search']", function(){
		if ($(this).val() == 0){
			$('.search-results-list').html('');
		}
	});

	$(document).on('click','.search-li a',function(){
		$('.main-no-search-results').hide();
		var target = $(this).parent().attr('target');		
		$('.main-no-search-results, .search-li').removeClass('active');
		$(this).parent().addClass('active');

		if (target == 'all'){
			$('.search-result-header, .search-result-row').show();		
		} else {
			$('.search-result-row, .search-result-header, .results-no-results').hide();
			$('.search-result-row.result-row-type-'+target+', .no-res-cat-'+target).show();			
		}
		var count = $('.search-result-row:visible').length;

		if (count == 0){
			$('.main-no-search-results').addClass('active');
		}
	});
	
	/**
	 * Search function
	 */
	var search = function(){
		var val = $('#searchInput').val();	

		if (val.length == 0){
			$('.search-results-list').html('').hide();			
			return;
		} else {
			if (val.length < 2){
				$('.search-results-list').html('').hide();
				return;
			} else {
				$('.search-results-list').html('<li class="result-search-text waiting">SEARCHING..</li>').show();				
			}			
		}

		$('.search-li').show();
		var form = preBuild();
		form.append('query',val);

		$.ajax({
			type: "POST",
			url: baseURL + "global.php",
			contentType: false,
			cache: false,
			processData: false,
			data: form,
			success: function(data){
				if (data.status == 'NO'){
					if (data.content == 'invalid_session') {
	          if (session_exp == false) {
	            session_exp = true;
	            checkSession();
	          }
	        } else {	          
						errorMessage(data.content);
						return;
	        }
				} else {
					$('.search-results-list').html('');
					
					var r = data.content;
					var cats = r.categories;					
					// var totalSearch = 0;

					var html = '<div class="col-xs-12 search-result-row main-no-search-results">'
											+'<p>No results available.</p>'
										+'</div>';

					for (var i = 0; i < cats.length; i++) {
						var cat_name = cats[i];						
						if (r[cat_name].length != undefined){
							// totalSearch += 1;
							// var text ='';
							// if (i == 0){
							// 	text = 'first';
							// }

							if (r[cat_name].length == 0){
								$('.search-li.ink-reaction[target="' + cat_name + '"]').hide();
							} else {
								html += '<div class="col-xs-12 col-lg-12 search-result-header search-category cat-'+cat_name+'">'+cat_name+'</div>';
								$('.search-li.ink-reaction[target="' + cat_name + '"]').show();
							}
							for (var k = 0; k < r[cat_name].length; k++) {							
								var disp = r[cat_name][k].display;
								var link = r[cat_name][k].link;
								html += '<div class="col-xs-12 search-result-row result-row-type-' + cat_name + '" url="' + link + '">'
													+'<a href="' + link + '" class="result-search-text"><li class="search-result-text">' + disp + '</li></a>'
												+'</div>';								
							}							
						}
					}
					$('.search-results-list').html(html);
					$('.search-li.active a').trigger('click');					
				}
			}
		});
	}	
});

/**
 * form for ajax calls
 * user group is array of users
 */
function preBuild() {
	var form = new FormData();	
	form.append('token', session_token);	
	return form;
}

/**
 * reusable ajax call, replacing current code with this 
 * to cut down on code
 */
function ajaxCall(form, url) {
	return Promise.resolve($.ajax({
		type: "POST",
		url: 'php/'+url,
		contentType: false,
		cache: false,
		processData: false,
		data: form,
	}))
};

/**
 * init maps 
 */
function initGlobal(){
	(function(namespace, $) {
		"use strict";

		var clients = function() {
			// Create reference to this instance
			var o = this;
			// Initialize app when document is ready
			$(document).ready(function() {
				o.initialize();
			});
		};
		var p = clients.prototype;
		p.map = null;
		p.initialize = function() {			
			this._initGMaps();			
		};
		
		//ADD CLIENT FORM MAP INIT
		p._initGMaps = function() {
			if (typeof GMaps === 'undefined') {
				return;
			}
			if ($('#map-canvas').length === 0) {
				return;
			}

			this.map = new GMaps({
				div: '#map-canvas',
				zoom: 11,
				disableDefaultUI: true
			});

			this._initGMapsEvents();
		};

		p._initGMapsEvents = function() {
			var o = this;
			$('#street, #streetnumber, #city, #zip').on('change', function(e) {
				o._startGeocoding();
			});
		};

		p._startGeocoding = function() {
			var o = this;
			GMaps.geocode({
				address: o._formatAddress(),
				callback: function(results, status) {
					if (status === 'OK') {
						o._addMarker(results, status);
					}
				}
			});
		};

		p._addMarker = function(results, status) {
			this.map.removeMarkers();
			var latlng = results[0].geometry.location;
			this.map.setCenter(latlng.lat(), latlng.lng());
			this.map.addMarker({
				lat: latlng.lat(),
				lng: latlng.lng()
			});
		};

		p._formatAddress = function(results, status) {
			var address = [];
			var street = $('#street').val() + " " + $('#streetnumber').val();
			var city = $('#city').val();
			var zip = $('#zip').val();

			// Add values to array if not empty
			if ($.trim(street) !== '') {
				address.push(street);
			}
			if ($.trim(city) !== '') {
				address.push(city);
			}
			if ($.trim(zip) !== '') {
				address.push(zip);
			}

			// Format address to search string
			return address.join(',');
		};
		namespace.clients = new clients;
	}(this.materialadmin, jQuery)); 
}

function fixDate(date,format){
  if (format == ''){
    format = 'YYYY-MM-DD hh:mm A';
  }
  d = '--';
  if (date != '0000-00-00 00:00:00'){
    // d = moment.utc(date).local().format(format);
    d = moment(date).format(format);
  }
  if (d == 'Invalid date'){
    d = '--';
  }
  return d;
}

/**
 * regex to check emails are in correct format
 * takes param email
 */
function IsEmail(email){
	var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
	return regex.test(email);
}

/****** TOAST MESSAGES ******/
function successMessage(message) {
	toastr.clear();
	toastr.options.positionClass = 'toast-top-center';
	toastr.options.closeDuration = 100;
	toastr.options.closeButton = 'true';
	toastr.success(message);
}
function errorMessage(message) {
	toastr.options.positionClass = 'toast-top-center';
	toastr.options.closeDuration = 100;
	toastr.options.closeButton = 'true';
	toastr.error(message);
}
function warningMessage(message) {
	toastr.clear();
	toastr.options.positionClass = 'toast-top-full-width';
	toastr.options.closeDuration = 100;
	toastr.options.closeButton = 'true';
	toastr.warning(message);
}
function smallWarning(message) {
	toastr.clear();
	toastr.options.positionClass = 'toast-top-center';
	toastr.options.closeDuration = 100;
	toastr.options.closeButton = 'true';
	toastr.warning(message);
}
function actionMessage(message) {
	toastr.options.positionClass = 'toast-top-center';
	toastr.options.closeDuration = 100;
	toastr.options.closeButton = 'true';
	toastr.info(message);
}
/****** TOAST MESSAGES ******/

/**
 * hide load button once ajax call fails/succeeds
 * takes no params
 */
function hideBtn(){
	setTimeout(function(){
		load_btn.hide();
	},300);
}
