<?php
	// token
	include_once 'jscript.php';
?>

<div id="menubar" class="menubar-inverse animate">
	<div class="menubar-fixed-panel">
		<div class="expanded">
			<a class="sidebar-link" href="index.php">
				<span class="text-lg text-bold text-primary ">Games</span>
			</a>
		</div>
	</div>	
	<div class="nano">
		<div class="nano-content" tabindex="0">
			<div class="menubar-scroll-panel" style="padding-bottom: 33px;">
				<!-- BEGIN MAIN MENU -->
				<ul id="main-menu" class="gui-controls">
					<li class="index menubar-dash">
						<a class="sidebar-link" href="index.php">
							<div class="gui-icon"><i class="fa fa-file-o"></i></div>
							<span class="title">Games!</span>
						</a>							
					</li>						
				</ul>					
				<div class="menubar-foot-panel">					
					<small class="no-linebreak hidden-folded center">
						<span class="opacity-75">Copyright © <?php echo date('Y'); ?></span> <strong>Jeffrey Carter</strong>
					</small>
				</div>
			</div>
		</div>
	</div>
</div>