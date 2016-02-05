<?php
/**
* @version		2.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2014 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.txt
**/



//memuat file pendukung query dan fungsi lainya
require_once ('../../../../config.php');
require_once ('../../../../system/database.php');
require_once ('../../../../system/function.php');
require_once ('../../../../system/user.php');
require_once ('../../../../system/site.php');
loadLang 	 ('../../../system');

$api = siteConfig('apikey');


//check table setting
$db = new FQuery();  
if(!$db->tableExists(FDBPrefix."setting")) die("Table setting not found!");

//set timezone
$time = siteConfig('timezone');
if($time) date_default_timezone_set(siteConfig('timezone'));