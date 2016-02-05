<?php
/**
* @version		2.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2014 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.
**/

defined('_FINDEX_') or die('Access Denied');

function loadAppsSystem() {	
	loadLang(dirname(__FILE__));
	$apps = app_param('app');
	$file = "apps/app_$apps/sys_$apps.php";
	if(file_exists($file))
		require_once ($file);
}

function loadAppsCss() {	
	$apps = app_param('app');
	$file = "apps/app_$apps/app_style.php";	
	if(file_exists($file)) {
		require_once ($file);
	}
}

function loadAppsJs() {	
	$apps = app_param('app');
	$file = "apps/app_$apps/app_js.php";	
	if(file_exists($file)) {
		require_once ($file);
	}
}

function loadApps($echo = false) {
	ob_start();
	$db = new FQuery();  
	$db ->connect(); 
	$qr = null; //set $qr to null value
	$view = app_param('app');
	if(isset($_GET['theme']) AND $_GET['theme'] =='module' AND $_SESSION['USER_LEVEL'] > 3) {	
		$view = '';
	}
	$sql=$db->select(FDBPrefix.'apps','*',"folder='app_$view'"); 
	if(count($sql) !== 0)
	{		
		$sql2=$db->select(FDBPrefix.'menu','*',"id=".Page_ID); 
		$qrs = $sql2[0];	
		
		$theme = siteConfig('site_theme');
		$tfile = "themes/$theme/apps/app_$view/index.php";
		$file  ="apps/app_$view/index.php";	
		
		if(file_exists($file)){
			if(_FEED_ != 'rss') 
				echo '<div class="apps'.$qrs["class"].$qrs["class"].'">';
			if(!empty($qrs['title']) AND $qrs['show_title']) 
				define("Apps_Title","$qrs[title]");	
			if($qrs['show_title'])	
				if(!defined('Apps_Title'))
				define("Apps_Title","$qrs[name]");			
			if(_FEED_ != 'rss') 
				echo '<div class="main_apps">';				
			if(file_exists($tfile))
				include($tfile);
			else if(file_exists($file))
				include($file);				
			if(_FEED_ != 'rss') 
				echo' </div></div>';
		}		
	}
	else {
		if(isset($_GET['theme']) AND $_GET['theme'] =='module' AND $_SESSION['USER_LEVEL'] < 3) {
			echo "<div style='border: 2px solid #e3e3e3; background: rgba(250,250,250,0.8);	color :#aaa; padding: 30px; text-align: center; margin: 5px 3px; font-weight: bold;'>Main Content</div>";
		} 
		else {
		}
	}
	$apps = ob_get_contents();
	ob_end_clean();	
	
	static $flag ;
	if ( $flag === null ) {
		$flag = true;
		if($echo == true)
			return $apps;
		else
			echo $apps;
	}
}
