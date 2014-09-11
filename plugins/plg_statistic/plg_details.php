<?php
/**
* @nama			Fi Statistic
* @type			Plugin
* @version		1.0.0
* @copyright	Copyright (C) 2012 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.txt
**/

defined('_FINDEX_') or die('Access Denied');

$plg_name = 'Statistic';
$plg_author = 'Fiyo CMS';
if(siteConfig('lang') == 'id') {
	$plg_desc 	= "Plugin untuk mengetahui statistik pengunjung";
}
else {
	$plg_desc	= "Plugin to see visitor stats";
}