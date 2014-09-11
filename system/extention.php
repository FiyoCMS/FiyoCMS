<?php 
/**
* @version		2.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2012 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.txt
**/

defined('_FINDEX_') or die('Access Denied');

if(siteConfig('site_status') or !empty($_SESSION['USER_ID'])) {
	require_once ('user.php'); 
	require_once ('site.php'); 
	require_once ('html.php'); 
	require_once ('plugins.php'); 
	require_once ('apps.php'); 
	require_once ('modules.php');
	require_once ('themes.php');
}
else {	
	define('_OFFSITE_',1) ;
	require_once ('site.php'); 
	require_once ('themes-off.php');
}
