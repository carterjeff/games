<?php
	
?>
<!DOCTYPE html>
<html>
	<head>
		<title>NRE Admin Portal | Timesheets</title>
		<!-- BEGIN META -->
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">		
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="keywords" content="your,keywords">
		<meta name="description" content="New River Electrical">
		<?php require_once('css.php'); ?>
	</head>
	<body class="menubar-hoverable header-fixed">
		<?php	include 'header.php'; ?>
		<div id="base">
			<div id="content" class="content">
				<section>
					<div class="section-header">
						<ol class="breadcrumb">
							<li class="active">Games!</li>
						</ol>
					</div>
					<div class="section-body">
						<div class="card timesheet-card">
							<div class="card-head style-primary card-head-sm">
								<button type="button" class="update-timberline ready loading-btn btn btn-info btn-transparent btn-block btn-loading-state" data-loading-text="<i class='fa fa-spinner fa-spin'></i> Loading..." data-complete-text="Timesheets Loaded" data-error-text="Error">Loading...</button>
								<div class="tools pull-left"></div>
							</div>
							<div class="card-body default-card-body">
								<div class="new-table-container">
									<div>
										<table class="table-foreman stripe cell-border" cellspacing="0" cellpadding='0'  width="100%" id="foreman-table">
											<thead>
												<tr>
													<th>DATE</th>
													<th>FOREMAN</th>
												</tr>
											</thead>
											<tbody class="foreman-tbody"></tbody>
										</table>
									</div>
								</div>	
							</div>
						</div>
					</div>
				</section>
			</div>
			<?php include 'menuBar.php'; ?>
		</div>
		<div class="modal fade" id="tsUpdatedModal" role="dialog" tabindex="-1" aria-labelledby="formModalLabel" aria-hidden="true">
			<div class="modal-dialog modal-primary">
				<div class="modal-content">
					<div class="modal-header header-sm">
						<button type="button" class="close close-modal" data-dismiss="modal" aria-hidden="true">×</button>
						<h4 class="modal-title uppercase" id="formModalLabel">Timesheet Update</h4>
					</div>
					<form class="form-horizontal" role="form" action="" method="post" enctype="multipart/form-data">
						<div class="modal-body">
							<p class="center modal-p">Did you make any changes to the chosen timesheet?</p>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-default no-btn" data-dismiss="modal">No</button>
							<button type="button" class="btn btn-primary refresh-confirm confirm-btn yes selected main-submit-btn yes-btn">Yes</button>
						</div>
					</form>
				</div>
			</div>
		</div>	

		<?php require_once 'jscript.php'; ?>
		<script type="text/javascript">			
			
			load_btn = $('.loading-btn');
			
			$(document).ready(function(){				
				indexFns();
			});

			function indexFns(){
				
			}			
		</script>
	</body>
</html>