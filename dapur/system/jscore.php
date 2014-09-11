<?php
/**
* @version		2.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2012 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.txt
**/

defined('_FINDEX_') or die('Access Denied');

//memuat file pendukung query dan fungsi lainya
require_once ('../../../../config.php');
require_once ('../../../../system/query.php');
require_once ('../../../../system/function.php');
require_once ('../../../../system/user.php');
loadLang 	 ('../../../system');

//check table setting
mysql_num_rows(mysql_query("SHOW TABLES LIKE '".FDBPrefix."setting'")) or die();

//set timezone
$time = siteConfig('timezone');
if($time) date_default_timezone_set(siteConfig('timezone'));