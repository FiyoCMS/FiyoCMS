<?php
/**
* @version		2.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2014 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.
**/

defined('_FINDEX_') or die('Access Denied');

//memuat file pendukung query dan fungsi lainya
require_once ('../config.php');
require_once ('../system/query.php');
require_once ('../system/function.php');
require_once ('../system/user.php');
require_once ('../system/site.php');
require_once ('function.php');

//check table setting
$r = mysql_query("SHOW TABLES LIKE '".FDBPrefix."setting'");
mysql_num_rows($r) or die(alert("error","Table setting is not found. Please check <b>DBPrefix</b> on file config.php!",true,true));

//set default timezone
$time = siteConfig('timezone');
if($time) date_default_timezone_set(siteConfig('timezone'));

//memuat file bahasa jika ditemukan
loadLang("system");

define('MetaDesc', 	siteConfig('site_desc'));
define('MetaKeys', 	siteConfig('site_keys'));
define('TitleValue',app_param('name'));

//memuat file pendukung system dan file appss
loadSystemApps();