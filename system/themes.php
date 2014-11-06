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
	$file = str_replace(".php",".html",FThemes);
	if(file_exists($file))
	if(@rename($file,FThemes)) refresh();
	echo alert("error","Theme is not found!",true,true);
	die();
}
else if(_FEED_ == 'rss' or _FINDEX_ == 'blank') {
	loadApps();
}
else {
	include(FThemes);
}

$output = ob_get_contents();
ob_end_clean();

if(_FEED_ !== 'rss' AND _FINDEX_ !== 'blank') {

	ob_start(); 
		loadAppsCss();
		loadModuleCss();
		$cssasset = ob_get_contents();
	ob_end_clean();
	
	ob_start(); 
		loadAppsJs();	
		loadPluginJs();
		$jsasset = ob_get_contents();	
		
	ob_end_clean();
	
	$tlx = strpos($output,"<link");
	$ntx = substr($output , 0, $tlx );

	$tlb = strpos($output,"</body>");
	$ntb = substr($output ,$tlb );

	$output = str_replace($ntx, $ntx.$cssasset,$output);
	
	
	$output = str_replace(array("href=\"css","href=\"/css"), "href=\"".FThemePath."/css",$output);
	$output = str_replace(array("href=\"/asset", "href=\"asset"), "href=\"".FThemePath."/asset",$output);
	$output = str_replace(array("href=\"/images", "href=\"images"), "href=\"".FThemePath."/images",$output);
	$output = str_replace(array("src=\"/asset", "src=\"asset"), "src=\"".FThemePath."/asset",$output);
	$output = str_replace(array("src=\"/js","src=\"js"), "src=\"".FThemePath."/js",$output);
	$output = str_replace(array("src=\"/images", "src=\"images"), "src=\"".FThemePath."/images",$output);
	$output = str_replace(array("src=\"/img","src=\"img"), "src=\"".FThemePath."/img",$output);
	
	$jsasset = preg_replace("/(?:(?:\/\*(?:[^*]|(?:\*+[^*\/]))*\*+\/)|(?:(?<!\:|\\\)\/\/.*))/", "", $jsasset);
	$output = str_replace($ntb, $jsasset.$ntb,$output);
	
	ob_end_clean();
}

$html = str_get_html($output);
$css = $js = '';
foreach($html->find('link[rel=stylesheet]') as $element) {
	if(strpos($element->href,".css"))
	$css .= $element."\n";
	$output = str_replace($element -> outertext,"",$output);
}

$tlx = strpos($output,"</head>");
$ntx = substr($output , 0, $tlx );
$output = str_replace($ntx, $ntx.$css,$output);
	
$et = microtime(TRUE);
$output = preg_replace('#^\s*//.+$#m', "", $output);
$output = preg_replace('/<!--(.*)-->/Uis', "", $output);
$output = preg_replace(array('(( )+\))','(\)( )+)'), ')', $output);
$output = str_replace(array("\t","\n"), ' ', $output);
$output = str_replace(array("  ","   "), ' ', $output);
$output = str_replace("  ", ' ', $output);
echo $output;