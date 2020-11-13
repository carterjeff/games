var session_token = '';

$(document).ready(function(){
	
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
// function initGlobal(){
// 	(function(namespace, $) {
// 		"use strict";

// 		var clients = function() {
// 			// Create reference to this instance
// 			var o = this;
// 			// Initialize app when document is ready
// 			$(document).ready(function() {
// 				o.initialize();
// 			});
// 		};
// 		var p = clients.prototype;
// 		p.map = null;
// 		p.initialize = function() {			
// 			this._initGMaps();			
// 		};
		
// 		//ADD CLIENT FORM MAP INIT
// 		p._initGMaps = function() {
// 			if (typeof GMaps === 'undefined') {
// 				return;
// 			}
// 			if ($('#map-canvas').length === 0) {
// 				return;
// 			}

// 			this.map = new GMaps({
// 				div: '#map-canvas',
// 				zoom: 11,
// 				disableDefaultUI: true
// 			});

// 			this._initGMapsEvents();
// 		};

// 		p._initGMapsEvents = function() {
// 			var o = this;
// 			$('#street, #streetnumber, #city, #zip').on('change', function(e) {
// 				o._startGeocoding();
// 			});
// 		};

// 		p._startGeocoding = function() {
// 			var o = this;
// 			GMaps.geocode({
// 				address: o._formatAddress(),
// 				callback: function(results, status) {
// 					if (status === 'OK') {
// 						o._addMarker(results, status);
// 					}
// 				}
// 			});
// 		};

// 		p._addMarker = function(results, status) {
// 			this.map.removeMarkers();
// 			var latlng = results[0].geometry.location;
// 			this.map.setCenter(latlng.lat(), latlng.lng());
// 			this.map.addMarker({
// 				lat: latlng.lat(),
// 				lng: latlng.lng()
// 			});
// 		};

// 		p._formatAddress = function(results, status) {
// 			var address = [];
// 			var street = $('#street').val() + " " + $('#streetnumber').val();
// 			var city = $('#city').val();
// 			var zip = $('#zip').val();

// 			// Add values to array if not empty
// 			if ($.trim(street) !== '') {
// 				address.push(street);
// 			}
// 			if ($.trim(city) !== '') {
// 				address.push(city);
// 			}
// 			if ($.trim(zip) !== '') {
// 				address.push(zip);
// 			}

// 			// Format address to search string
// 			return address.join(',');
// 		};
// 		namespace.clients = new clients;
// 	}(this.materialadmin, jQuery)); 
// }

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
