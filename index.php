<?php
	$token = md5(date("Y-m-d").'games');
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Carter's Games~</title>
		<!-- BEGIN META -->
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">		
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="keywords" content="carter, games">
		<meta name="description" content="Games!">
		<?php require_once('css.php'); ?>
	</head>
	<body class="menubar-hoverable header-fixed">
		<?php	include 'header.php'; ?>
		<div id="base">
			<div id="content" class="content">
				<section>
					<!-- <div class="section-header">
						<ol class="breadcrumb">
							<li class="active">Games!</li>
						</ol>
					</div> -->
					<div class="section-body">
						<div class="card timesheet-card">
							<div class="card-head style-primary card-head-sm">
								<div class="tools pull-left width-50">
									<div class="form">
										<div class="col-sm-12">
											<div class="form-group no-padding no-margin flex">
												<!-- <div class="search-game"><i class="fa fa-search"></i></div> -->
												<input type="text" id="search" class="form-control" placeholder="Search games" autocomplete="off" />
												<button type="submit" class="btn btn-icon-toggle ink-reaction game-search" id="search-game"><i class="fa fa-search"></i></button>
											</div>
										</div>
									</div>
								</div>
								<button type="button" class="update-timberline ready loading-btn btn btn-info btn-transparent btn-block btn-loading-state" data-loading-text="<i class='fa fa-spinner fa-spin'></i> Loading..." data-complete-text="Timesheets Loaded" data-error-text="Error">Loading...</button>
								<div class="tools pull-right">
									<button class="add-btn btn btn-flat btn-primary grey-border filter-btn" data-toggle="modal" data-target="#addGameModal"><i class="md md-my-library-add"></i> GAME</button>									
								</div>
							</div>
							<div class="card-body default-card-body">
								<div class="new-table-container hide">
									<div>
										<table class="table-game table-striped table-bordered display" cellspacing="0" cellpadding='0' width="100%" id="game-table">
											<thead>
												<tr>
													<th>PUBLISHER</th>
													<th>NAME</th>
													<th>NICKNAME</th>
													<th>RATING</th>
												</tr>
											</thead>
											<tbody class="game-tbody"></tbody>
											<tfoot>
												<tr>
						            	<th></th>
													<th></th>
													<th></th>
													<th></th>
						            </tr>
											</tfoot>
										</table>
									</div>
								</div>	
							</div>
						</div>
					</div>
				</section>
			</div>			
		</div>

		<!-- add game modal -->
		<div class="modal fade modal-primary filter-container" id="addGameModal" role="dialog" aria-labelledby="formModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
						<h4 class="modal-title" id="formModalLabel">ADD NEW GAME:</h4>
					</div>
					<form class="form" method="post" enctype="multipart/form-data" id="add-game-form">
						<div class="card-body">							
							<div class="row">
								<div class="col-sm-6">
									<div class="form-group append-to-body">
										<label for="fman-input">Publisher</label>
										<input type="text" id="publisher-input" class="add-input form-control" required="required" action="publisher"/>
									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group employee">
										<label for="emp-input">Name</label>
										<input type="text" id="name-input" class="add-input form-control" action="name" required="required" />
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-sm-6">
									<div class="form-group">
										<label for="fman-input">Nickname</label>
										<input type="text" id="nickname-input" class="add-input form-control" action="nickname"/>
									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group fg-other" style="width:100%;">
										<label class="select-label">
											<span class="bold-label grey-label">Rating:</span>
											<select id="rating-select" class="form-control add-input" action="rating" style="width:100%;" required="required">
												<option></option>
												<option value="favorite">Favorite</option>
												<option value="meh">Meh</option>
												<option value="dislike">Dislike</option>
											</select>
										</label>
									</div>									
								</div>								
							</div>							
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-default btn-danger ink-reaction action-btn cancel-btn pull-left" data-dismiss="modal">Cancel</button>
							<button type="submit" class="btn btn-primary submit-btn create ink-reaction" id="add-game-submit">Create Game</button>
						</div>				
					</form>
				</div>
			</div>
		</div>

		<?php require_once 'jscript.php'; ?>
		<script type="text/javascript">			
			session_token = '<?php echo $token; ?>';			
			load_btn = $('.loading-btn');
			
			$(document).ready(function(){				
				indexFns();			
			});

			function clearForm(){
				$('.add-input').val('');
				$('#rating-select').val(-1).trigger('change');
			}

			function indexFns(){
				// init the select2
				$('#rating-select').select2({
					allowClear:true,
					placeholder:"Please select a rating",
				})

				// clear the inputs just in case
				$(document).on('click','.clear-btn, .add-button',function(){
					clearForm();
				});				

				// submit the new game add
				$(document).on('submit','#add-game-form',function(e){
					e.preventDefault();

					// init the form
					var form = preBuild(); 

					// loop through inputs to build the request form
					$('.add-input').each(function(){
						var val = $(this).val();
						var field = $(this).attr('action');

						form.append(field,val);
					});

					// init ajax call
					let promise = ajaxCall(form,'add_game.php');
			    promise.then(function(data) {
			      if (data.status == 'NO') { // check for no response
		          errorMessage(data.content);
			      } else {
			      	$('#addGameModal').modal('toggle');
			      	// if successful
			        successMessage("Game added.");
			        // clear form
			        clearForm();
			      }
			    })
				})

				// trigger the search if they hit enter
				$(document).on('keypress','#search',function(e){
					var key = e.keyCode;					
					if (key == 13){
						$('#search-game').trigger('click');
					}					
				})

				// search gmes
				$(document).on('click','#search-game',function(){
					var query = $('#search').val();

					// validate they entered something in the search input
					if (query.length == 0 || query == ''){
						warningMessage('Please enter a valid query');
						return;
					}

					// limit searches to 3 characters or more - to avoid crazy search results
					if (query.length < 3){
						warningMessage('Please search with at least 3 characters');
						return;	
					}
					var form = preBuild();
					form.append('query',query);
					
					$('.new-table-container').removeClass('hide');
					// init ajax call
					let promise = ajaxCall(form,'search.php');
			    promise.then(function(data) {
			      if (data.status == 'NO') { // check for no response
		          errorMessage(data.content);
			      } else {
			      	// if successful
			        var dc = data.content;			        
			        game_table = $('#game-table').DataTable({
			        	data:dc,
			        	responsive:true,
								destroy:true,
								// info:false,
								searching:true,
								// paging:true,
								deferRender:    true,
		            scrollY:        200,
		            scrollCollapse: true,
		            scroller:       true,
								columns:[
									{
										"data":"publisher",
									},
									{
										"data":"name",
									},
									{
										"data":"nickname",
									},
									{
										"data":"rating",
									},									
								],
								initComplete: function () {
			            this.api().columns().every( function (i) {
			            	if (i == 3){				            	
			                var column = this;
			                var select = $('<select class="tfoot-select"><option value="">Filter By:</option></select>')
		                    .appendTo( $(column.footer()).empty() )
		                    .on( 'change', function () {
	                        var val = $.fn.dataTable.util.escapeRegex(
	                          $(this).val()
	                        );
	 
	                        column
	                          .search( val ? '^'+val+'$' : '', true, false )
	                          .draw();
		                    });
			                column.data().unique().sort().each( function ( d, j ) {
			                	if (d != ''){
		                    	select.append( '<option value="'+d+'">'+d+'</option>' )			                		
			                	}
			                });			            		
			            	}
			            });
				        }
			        })
			      }
			    })
				});
			}			
		</script>
	</body>
</html>