<?php 
/**
* @version		2.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2012 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.txt
**/

defined('_FINDEX_') or die('Access Denied');

/** Load core files **/ 
include_once ('config.php');
include_once ('system/query.php');
include_once ('system/function.php');

if(siteConfig('site_status') == true OR !empty($_SESSION['USER_ID'])) {
	include_once ('user.php'); 
	include_once ('site.php'); 
	include_once ('plugins.php'); 
	include_once ('apps.php'); 
	include_once ('modules.php');
	include_once ('themes.php');
}
else {	
	define('_OFFSITE_',1) ;
	include_once ('site.php'); 
	include_once ('themes-off.php');
}
