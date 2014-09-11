<?php
/**
* @version		2.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2014 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.
**/

defined('_FINDEX_') or die('Access Denied');

//load Apps System
loadAppsSystem();

if(!defined('MetaDesc'))
define('MetaDesc', 	siteConfig('site_desc'));
if(!defined('MetaKeys'))
define('MetaKeys', 	siteConfig('site_keys'));
if(!defined('TitleValue'))
define('TitleValue', app_param('name'));
if(!defined('MetaAuthor'))
define('MetaAuthor',siteConfig('site_name'));
if(!defined('MetaRobots')) {
	if(app_param('app') == null)
		define('MetaRobots', 'noindex');
	else if(siteConfig('follow_link'))
		define('MetaRobots', 'index, follow');
	else
		define('MetaRobots', 'index, nofollow');
}

/********************************************/
/*  		Define Type & Site Title	  	*/
/********************************************/
if(isset($_GET['theme']) AND $_GET['theme'] =='module')
	define('PageTitle','Module_Position'); 
else if(!defined('PageTitle')) 
	define('PageTitle','404');
if(TitleType==1)
	define('FTitle',PageTitle.TitleDiv.SiteTitle);
else if(TitleType==2) 
	define('FTitle',SiteTitle.TitleDiv.PageTitle);
else if(TitleType==3) 
	define('FTitle',PageTitle);
else if(TitleType==0) 
	define('FTitle',SiteTitle);	

	
/********************************************/
/*  		Define Type & Site Title	  	*/
/********************************************/
$themes = siteConfig('site_theme');
define("FThemeFolder", $themes); 
define("FThemePath",FUrl."themes/".FThemeFolder."");
define("FThemes","themes/".FThemeFolder."/index.php");


/********************************************/
/*  		  Load default theme		  	*/
/********************************************/
if(!file_exists(FThemes)) {	
	echo alert("error","Theme is not found!",true,true);
	die();
}
else if(_FEED_ == 'rss' or _FINDEX_ == 'blank') {
	loadApps();
}
else {
	require_once(FThemes);
}

?>
