<?php
/**
* @version		2.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2014 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.
**/

defined('_FINDEX_') or die('Access Denied');

function loadAppsSystem() {	
	loadLang(__dir__);
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

function loadApps() {
	$db = new FQuery();  
	$db ->connect(); 
	$qr = null; //set $qr to null value
	$view = app_param('app');
	if(isset($_GET['theme']) AND $_GET['theme'] =='module' AND $_SESSION['USER_LEVEL'] > 3) {	
		$view = '';
	}
	$sql=$db->select(FDBPrefix.'apps','*',"folder='app_$view'"); 
	mysql_fetch_array($sql);
	if(mysql_affected_rows()!=0) 
	{		
		$sql2=$db->select(FDBPrefix.'menu','*',"id=".Page_ID); 
		$qrs = @mysql_fetch_array($sql2);	
		
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
			echo "<div style='border: 2px solid #e3e3e3; background: rgba(250,250,250,0.8);	color :#aaa; 
		padding: 30px; text-align: center; margin: 5px 3px; font-weight: bold;'>Main Content</div>";
		} 
		else {
			$lang = siteConfig('lang');
		
			echo '<div class="apps'.$qr["class"].'">'._404_.'</div><p>';		
				$file="modules/mod_search/mod_search.php";	
				if(file_exists($file))
					include($file);	
			echo '</p>';	
				loadModule('404');
		}
	}	
}
