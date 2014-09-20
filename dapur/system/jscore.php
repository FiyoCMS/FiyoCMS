<?php
/**
* @version		2.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2014 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.txt
**/

if(!isset($_SERVER['HTTP_REFERER']) or !defined('_FINDEX_')) die('Access Denied!');

//memuat file pendukung query dan fungsi lainya
require_once ('../../../../config.php');
require_once ('../../../../system/query.php');
require_once ('../../../../system/function.php');
require_once ('../../../../system/user.php');
loadLang 	 ('../../../system');

$api = siteConfig('apikey');
if(!empty($api)) {
	if(strpos(stripslashes($_SERVER['HTTP_REFERER']),stripslashes("http://".FUrl())) === false OR $_POST['apikey'] == "$api") 
	die('Access Denied!');
} else {
	if(strpos(stripslashes($_SERVER['HTTP_REFERER']),stripslashes("http://".FUrl())) === false) 
	die('Access Denied!');
}

//check table setting
mysql_num_rows(mysql_query("SHOW TABLES LIKE '".FDBPrefix."setting'")) or die();

//set timezone
$time = siteConfig('timezone');
if($time) date_default_timezone_set(siteConfig('timezone'));