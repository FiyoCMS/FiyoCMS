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
/*         Define Type & Site Title         */
/********************************************/
$themes = FLayout("theme");
if(empty($themes)) $themes = siteConfig('site_theme');
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
	echo alert("error",FThemes."Theme is not found!",true,true);
	die();
}
else if(_FEED_ == 'rss' or _FINDEX_ == 'blank' or (isset($_POST['theme']) AND  $_POST['theme'] == 'blank'))  {
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
		if(function_exists('loadModuleCss')) loadModuleCss();
		$cssasset = ob_get_contents();
	ob_end_clean();
	
	ob_start(); 
		loadAppsJs();	
		loadPluginJs();
		$jsasset = ob_get_contents();
		$jsasset = preg_replace("/(?:(?:\/\*(?:[^*]|(?:\*+[^*\/]))*\*+\/)|(?:(?<!\:|\\\)\/\/.*))/", "", $jsasset);
	ob_end_clean();
	
	$tlx = strpos($output,"<link");
	$ntx = substr($output , 0, $tlx );
	$output = str_replace($ntx, $ntx.$cssasset,$output);
		
	/* check module position */
	preg_match_all('/\{chkmod:(.*?)\}/',$output,$position); 
	if(!empty($position[1])) {
		foreach($position[1] as $val) {
			$valc = $val;
			$coma = strpos($val,",");
			if($coma) {
				$c = explode(",",$val);
				if(is_array($c)) $valc = $c;	
			}
			$posm = strpos($output,"{chkmod:$val}");
			$posn = strpos($output,"{/chkmod}")+9;
			if(checkModule($valc)){
				$strpos = substr($output,0,$posn);
				$strpos = str_replace(array("{chkmod:$val}"),"",$strpos);
				$strpos = str_replace(array("{/chkmod}"),"",$strpos);	
				$else = strpos($strpos,"{else:}");
				if($else) {
					$strpos = substr($strpos,0,$else);
					$output = $strpos.substr($output, $posn);
				} else {
					$output = $strpos.substr($output,$posn);
				}	
			
			} else {		
				$strpos = substr($output,0,$posn);
				$else = strpos($strpos,"{else:}");
				if($else) {
					$strpos = substr($strpos,0,$posm);
					$posn2 = strpos(substr($output, $else+7),"{/chkmod}");
					$outpuk = $strpos.substr($output, $else+7,$posn2);
					$output = $outpuk.substr($output,$posn);
				} else {
					$strpos = substr($output,0,$posm);
					$output = $strpos.substr($output,$posn);
				}							
				
			}
		}
	}

	
	ob_start();
	if(!_AUTO_HTML_CONSTRUCT_) {
		$output = str_replace(array("href=\"css","href=\"/css"), "href=\"".FThemePath."/css",$output);
		$output = str_replace(array("href=\"/asset", "href=\"asset"), "href=\"".FThemePath."/asset",$output);
		$output = str_replace(array("src=\"/asset", "src=\"asset"), "src=\"".FThemePath."/asset",$output);
		$output = str_replace(array("src=\"/js","src=\"js"), "src=\"".FThemePath."/js",$output);
		$output = str_replace(array("src=\"/image", "src=\"image"), "src=\"".FThemePath."/image",$output);
		$output = str_replace(array("href=\"/image", "href=\"image"), "href=\"".FThemePath."/image",$output);
		$output = str_replace(array("src=\"/img","src=\"img"), "src=\"".FThemePath."/img",$output);		
		$output = str_replace(array("src=\"/media","src=\"media"), "src=\"".FUrl."/media",$output);		
		$output = str_replace(array("href=\"/media","href=\"media"), "href=\"".FUrl."/media",$output);		
		$output = str_replace(array("{sitetitle}","{siteTitle}"),FTitle,$output);
		$output = str_replace(array("{siteHome}","{siteUrl}","{homeurl}"),FUrl,$output);
		$output = str_replace(array("{sitename}","{siteName}"),SiteName,$output);
		$output = str_replace(array("{pagetitle}","{pageTitle}"),PageTitle,$output);
		$output = str_replace(array("{metadesc}","{metaDescription}"),MetaDesc,$output);
		$output = str_replace(array("{metakeys}","{metaKeywords}"),MetaKeys,$output);
		$output = str_replace(array("{metaauthor}","{metaAuthor}"),MetaAuthor,$output);
		$output = str_replace(array("{metarobots}","{metaRobots}"),MetaRobots,$output);
		$output = str_replace("{lang}",SiteLang,$output);
		$output = str_replace("{lang}",SiteLang,$output);
		if(checkMobile()) $m = "m-"; else $m = "";
		$output = str_replace("{m-}",$m,$output);
		$output = str_replace("{pid}",Page_ID,$output);		
		if(checkHomePage()) $h = "home"; else $h = "default";
		$output = str_replace("{home}",$h,$output);
		if(USER_ID) {
			$output = str_replace("{userid}",USER_ID,$output);
			$output = str_replace("{username}",USER_NAME,$output);
			$output = str_replace("{userlevel}",USER_LEVEL,$output);		
		} else {		
			$output = str_replace("{userid}",'',$output);
			$output = str_replace("{username}",'',$output);
			$output = str_replace("{userlevel}",'',$output);	
		}
	}
	
	$tlb = strpos($output,"</body>");
	$ntb = substr($output ,$tlb );
	$output = str_replace($ntb, $jsasset.$ntb,$output);	
	ob_end_clean();
}

ob_start();
$output = preg_replace('#^\s*//.+$#m', "", $output);
$output = preg_replace('/<!--(.*)-->/Uis', "", $output);
$output = preg_replace(array('(( )+\))','(\)( )+)'), ')', $output);
$output = str_replace(array("\t","\n"), ' ', $output);
$output = str_replace(array("  ","   "), ' ', $output);
$output = str_replace("  ", ' ', $output);


preg_match_all('/\{module:(.*?)\}/',$output,$position); 
if(!empty($position[1])) {
	$no = 1;
	foreach($position[1] as $val) {
		$output = str_replace(array("{module:$val}"),loadModule($val,true),$output);
		$no++;
	}
}	


$output = str_replace(array("{loadApps}"),loadApps(true),$output);

/* timer */
$et = microtime(TRUE) - _START_TIME_;
$et = substr($et,0,6)."s";

$output = str_replace(array("{loadtime}","{loadTime}"),$et,$output);
/* timer */

if(isset($_SERVER['HTTPS'])) $output = str_replace("http://", "https://", $output);
echo $output;
ob_end_flush();