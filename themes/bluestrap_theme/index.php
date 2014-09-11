<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title><?php echo FTitle; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Le styles -->
	<?php loadAppsCss(); ?>
	<?php loadModuleCss(); ?>
    <script src="<?php echo FThemePath; ?>/assets/js/jquery-2.0.3.min.js"></script>
    <link href="<?php echo FThemePath; ?>/assets/css/bootstrap.css" rel="stylesheet">
    <link href="<?php echo FThemePath; ?>/assets/css/bootstrap-responsive.css" rel="stylesheet"> 
	<link href="<?php echo FThemePath; ?>/css/style.css" rel="stylesheet">

    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="<?php echo FThemePath; ?>/assets/js/html5shiv.js"></script>
    <![endif]-->

    <!-- Fav and touch icons -->
    <link rel="shortcut icon" href="<?php echo FThemePath; ?>/image/favicon.png">
  </head>

  <body>


  <header>
	<div  class="container">
	<div class="logo"><h1><a href="<?php echo FUrl; ?>"><?php echo SiteName; ?></a></h1>
	</div>
	<div class="right"><?php loadModule('header'); ?></div>
	</div>
  </header>
  
	<div class="container">	
		<div class="navbar">
		  <div class="navbar-inner">
			  <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			  </button>
			  <div class="nav-collapse collapse">
			   <?php loadModule('mainmenu'); ?>
			   <div>
				<?php loadModule('search'); ?>
			   </div>
			  </div><!--/.nav-collapse -->
		  </div>
		</div>
	</div>
	
    <div class="container">
	<div class="row-fluid main">
	
	
	<div class="padding10">
	  <div class="span12">
		<div class="row-fluid">
			<?php if(checkModule('left') AND checkModule('right')): ?>
		  <div class="span7">
			<?php elseif(checkModule('right') or checkModule('left')): ?>
		  <div class="span8">
			<?php else: ?>
		  <div class="span12">
			<?php endif; ?>
			
			<div class="slide">
				<?php loadModule('slide'); ?>
			</div>
			<?php loadApps(); ?>
		  </div>
		  
		  <?php if(checkModule('left') AND checkModule('right')): ?>
			<div class="span5 right-top">
		  <?php else: ?>
			<div class="span4 right-top">
		  <?php endif; ?>
			
			<?php if(checkModule('left') or checkModule('right')): ?>
			<div class="row-fluid right-item">
				
				<?php if(checkModule('left')): ?>
					<?php if(checkModule('right')): ?>
					  <div class="span5">
					<?php else: ?>
					  <div class="span12">
					<?php endif; ?>
					<?php loadModule('left'); ?>
					  </div>
				<?php endif; ?>
				  
				<?php if(checkModule('right')): ?>
					<?php if(checkModule('left')): ?>
					  <div class="span7">
					<?php else: ?>
					  <div class="span12">
					<?php endif; ?>
					<?php loadModule('right'); ?>
					  </div> 			  
				<?php endif; ?>
			</div>
			<?php endif; ?>
			
			<?php if(checkModule('bottom')): ?>
			<div class="row-fluid">
			  <div class="span12"><?php loadModule('bottom'); ?></div>
			</div>
			<?php endif; ?>
		  </div>
		</div>
	  </div>
	</div>
	
		<div class="breadcrumb">
			<div class="container">
				<?php loadModule('breadchumb'); ?>
			</div>		
		</div>
	
	</div>	
	</div>	
	<footer>
		<div class="container">
			<div class="padding10">
				<div class="left">&copy; <a href="<?php echo FUrl; ?>"><?php echo SiteName; ?></a> <?php echo date("Y") ;?>. All Rights Reserved.</div>
				<div class="right">Design by <a href="http://firstryan.net/" title="Web Programmer & Web Designer">First Ryan</a></div>
			</div>	
		</div>	
	</footer>  

	
	<div class="badge-bottom-right ">
		<?php loadModule('badge-bottom-right'); ?>
	</div>	  

    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="<?php echo FThemePath; ?>/assets/js/bootstrap-transition.js"></script>
    <script src="<?php echo FThemePath; ?>/assets/js/bootstrap-alert.js"></script>
    <script src="<?php echo FThemePath; ?>/assets/js/bootstrap-modal.js"></script>
    <script src="<?php echo FThemePath; ?>/assets/js/bootstrap-dropdown.js"></script>
    <script src="<?php echo FThemePath; ?>/assets/js/bootstrap-scrollspy.js"></script>
    <script src="<?php echo FThemePath; ?>/assets/js/bootstrap-tab.js"></script>
    <script src="<?php echo FThemePath; ?>/assets/js/bootstrap-tooltip.js"></script>
    <script src="<?php echo FThemePath; ?>/assets/js/bootstrap-popover.js"></script>
    <script src="<?php echo FThemePath; ?>/assets/js/bootstrap-button.js"></script>
    <script src="<?php echo FThemePath; ?>/assets/js/bootstrap-collapse.js"></script>
    <script src="<?php echo FThemePath; ?>/assets/js/bootstrap-carousel.js"></script>
    <script src="<?php echo FThemePath; ?>/assets/js/bootstrap-typeahead.js"></script>

  </body>
</html>
