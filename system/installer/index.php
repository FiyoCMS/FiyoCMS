<?php
/**
* @version		2.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2014 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.txt
**/

defined('_FINDEX_') or die('Access Denied');
$start_time = microtime(TRUE);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=9">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=0" />
    <title>Fiyo Installer</title>
	<link rel="shortcut icon" href="system/installer/images/favicon.png" />
	<link href="system/installer/css/bootstrap.min.css" rel="stylesheet" />
	<link href="system/installer/css/main.css" rel="stylesheet" />
	<script src="system/installer/js/jquery.min.js"></script>	
</head>
<body>
<div id="alert"></div>
<div id="wrap">
	<?php 
include('sys_installer.php'); ?>
	 
     <!-- /#left -->
	<div id="content">
        <div class="main">
			<div class="removeSidebar blocks"></div>
            <div class="inner">
				<div class="logo">
				</div>
				<div id="alert_top"></div>
				<div id="mainApps">
					<?php include('installer.php'); ?>
				</div>
            </div>
				<div class="line-bottom">
					<div class="crumbs"> 
						<span class="right "><a href="http://www.fiyo.org/" target="_blank">Comunity</a> <span style="color:#ccc; margin: 2px;">//</span> 
						<a href="http://docs.fiyo.org/" target="_blank">Documentation</a> <span style="color:#ccc; margin: 2px;">//</span> 
						
						Version : <span class="version-val"><b>2.0 beta</b></span>
						
						
						</span>Generate Time : <span id="load-time"><?php
						$end_time = microtime(TRUE);
						echo substr($end_time - $start_time,0,7);
						?></span>s
					</div>
				</div>
		<!-- end .inner -->
        </div>
        <!-- end .outer -->
     </div>
   <!-- end #content -->
</div> 
<!-- /#wrap -->
<script src="system/installer/js/loader.min.js"></script>
<script src="system/installer/js/main.js"></script>	
</body>
</html>
