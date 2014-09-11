<?php 
/**
* @version		2.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2012 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.txt
**/

defined('_FINDEX_') or die('Access Denied');

/*
* Load core files
*/ 
require_once ('config.php');
require_once ('system/query.php');
require_once ('system/function.php');

//check table setting
$ress = mysql_query("SHOW TABLES LIKE '".FDBPrefix."setting'");
mysql_num_rows($ress) or die(alert("error","Table setting is not found. Please check <b>DBPrefix</b> on file config.php!",true,true));

//set default timezone
$time = siteConfig('timezone');
if($time) date_default_timezone_set(siteConfig('timezone'));

/*
* Load extentions
*/ 
loadExtention() ;