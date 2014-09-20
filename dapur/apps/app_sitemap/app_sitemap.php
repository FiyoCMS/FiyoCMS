<?php
/**
* @version		2.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2012 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.txt
* @description	
**/

defined('_FINDEX_') or die('Access Denied');

$title = @$_GET['view'];
$a = $b = $c = '';	
$xml = false;
if(@$_GET['view'] == 'setup') 	{
	if(@$_GET['action'] == 'search')	{
		define('sitemapTitle','Search Page(s)');	
		$c='active';
		$page = 'sitemap.php';
	}
	else {
		define('sitemapTitle','Expert Setting');
		$b = 'active';
		$page = 'sitemap.php';
	}
}
else {
	define('sitemapTitle','Sitemap Page(s)');
	$type = 'images';
	$a = 'active';
	$page = 'links.php'; 
	$xml = @simplexml_load_file("../sitemap.xml");
}
?>


<div id="app_header" class="media">
	 <div class="warp_app_header">		
		<div class="app_title">Sitemap Manager</div>	
	 </div>
</div>
	<div class="panel box"> 
	<?php if(!$xml) : ?>
		<header>
			<h5><?php echo sitemapTitle;?></h5>
		</header>
	<?php endif; ?>
		<?php include($page); ?>
	</div>
<div class="app_link tabs">		
	<div class="app_link">		
		<a class="add btn btn-default <?php echo $a; ?>" href="?app=sitemap"><i class="icon-link"></i> Links</a>		
		<a class="add btn btn-default <?php echo $b; ?>" href="?app=sitemap&view=setup"><i class="icon-camera-retro"></i> Setup</a>		
		<a class="add btn btn-default <?php echo $c; ?>" href="?app=sitemap&view=setup&action=search"><i class="icon-file-text-alt"></i> Search</a>			
	</div>		
</div>	