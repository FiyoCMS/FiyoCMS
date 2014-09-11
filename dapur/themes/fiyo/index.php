<?php
/**
* @version		2.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2014 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.txt
**/

defined('_FINDEX_') or die('Access Denied');
if(!isset($_SESSION['THEME_WIDTH']) or checkMobile()) $_SESSION['THEME_WIDTH'] = null;

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=9">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=0" />
    <title><?php echo SiteName; ?> - AdminPanel</title>
	<link rel="shortcut icon" href="<?php echo AdminPath;?>/images/favicon.png" />
	<link href="<?php echo AdminPath; ?>/css/font/font-awesome.css" rel="stylesheet" />
	<link href="<?php echo AdminPath; ?>/css/chosen.css" rel="stylesheet" />
	<link href="<?php echo AdminPath; ?>/css/bootstrap.min.css" rel="stylesheet" />
	<link href="<?php echo AdminPath; ?>/css/datetimepicker.css" rel="stylesheet" />
	<link href="<?php echo AdminPath; ?>/css/main.css" rel="stylesheet" />
	<script src="<?php echo AdminPath; ?>/js/jquery.min.js"></script>
	
</head>
<body class="<?php echo $_SESSION['THEME_WIDTH'];?>">
<div id="alert"></div>
<div id="wrap">
	<div id="top">
		<!-- .navbar -->
		<nav class="navbar navbar-inverse navbar-fixed-top">
    <!-- Brand and toggle get grouped for better mobile display -->
			<header class="navbar-header">
				<a data-placement="bottom" class="side-bar changeSidebarPos">
					<i class="icon-reorder"></i>
				</a>
				<a data-placement="bottom" class="side-bar right userSideBar">
					<i class="icon-tasks"></i>
				</a>
				<span class="navbar-logo" href="index.php"></span>
			</header>
			
			<div class="site-title">
				<a href="<?php echo FUrl; ?>" target="_blank" data-placement="right" data-original-title="View Site" data-toggle="tooltip" ><?php echo SiteName; ?></a>
			</div>
			
			<?php require('module/header.php'); ?>
			
		</nav>
	<!-- /.navbar -->
	</div>
    <!-- /#top -->
    <div id="left">		
		<!-- #menu -->
        <?php require('module/menu.php'); ?>
		<!-- /#menu -->
    </div>
     <!-- /#left -->
	 
	 
     <!-- /#left -->
	<div id="content">
        <div class="main">
			<div class="removeSidebar blocks"></div>
            <div class="inner">
				<div id="alert_top"></div>				
				<div class="crumbs"> 
					  <ul id="breadcrumbs" class="breadcrumb stats"> 
						<li><a href="index.php"><i class="icon-home"></i>Dashboard</a></li>
					  </ul> 
					  <span class="calendar"> 
							<?php echo date("l, d F Y"); ?>
					  </span> 
				</div>
				
				<div id="mainApps">
				<?php loadAdminApps();?>
				</div>
				<div class="line-bottom">
					<div class="crumbs"> 
						<span class="right "><a href="http://www.fiyo.org/" target="_blank"><i class=" icon-globe"></i><?php echo Comunity ?></a> <span style="color:#ccc; margin: 2px;">//</span> 
						<a href="http://docs.fiyo.org/" target="_blank"><i class="icon-book"></i><?php echo Documentation ?></a> <span style="color:#ccc; margin: 2px;">//</span> 
						
						<?php echo Version; ?> : <span class="version-val"><b><?php echo siteConfig('version'); ?></b></span>
						
						
						</span>Generate Time : <span id="load-time"><?php
						$end_time = microtime(TRUE);
						echo substr($end_time - _START_TIME_,0,7);
						?></span>s
					</div>
				</div>
            </div>
		<!-- end .inner -->
        </div>
        <!-- end .outer -->
     </div>
   <!-- end #content -->
</div> 
<?php include('module/modal.php'); ?>
<!-- /#wrap -->
<?php if(!checkMobile()) : ?>	
<script src="<?php echo AdminPath; ?>/js/loader.js"></script>
<?php else : ?>
<script src="<?php echo AdminPath; ?>/js/loader.min.js"></script>
<?php endif; ?>
<script src="<?php echo AdminPath; ?>/js/main.js"></script>	
<script src="<?php echo AdminPath; ?>/js/datatables.js"></script>
<script src="<?php echo AdminPath; ?>/js/highcharts.js"></script>
<script src="../plugins/plg_ckeditor/ckeditor.js"></script>	
<?php addJs("apps/app_theme/libs/edit_area/edit_area_full.js"); ?>
<script language="javascript" type="text/javascript">
$(function() {	
	var hash = $('.gravatar[data-gravatar-hash]').attr('data-gravatar-hash');
	$.ajax({
		url: 'http://gravatar.com/avatar/'+ hash +'?size=32' ,
		type : 'GET',
		timeout: 5000, 
		error:function(data){
			$('.gravatar[data-gravatar-hash]').prepend(function(){
				var img = $(this).find("img").length ;
				if(img > 0) img.remove();
				var hash = $(this).attr('data-gravatar-hash')
				return '<img width="34" height="34" alt="" src="../apps/app_comment/images/user.png" >'; 
			});	
		},
		success: function(data){
			$('.gravatar[data-gravatar-hash]').prepend(function(){
				var img = $(this).find("img").length ;
				if(img > 0) img.remove();
				var hash = $(this).attr('data-gravatar-hash')
				return '<img width="34" height="34" alt="" src="http://gravatar.com/avatar.php?size=36&gravatar_id=' + hash + '">';
			});
		}
	});
	
});	
</script>
</body>
</html>
