<?php
/**
* @version		1.5.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2012 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.txt
*/

defined('_FINDEX_') or die('Access Denied');

if(siteConfig('lang') == 'id') {
	$module_desc 	= "Menampilkan daftar komentar";
}
else {
	$module_desc	= "Displays comments on article";
}

$module_name='Comments';
$module_version='1.5.0';
$module_date='19 August 2013';
$module_author='Fiyo CMS';
$module_author_url='http://dev.fiyo.org';
$module_author_email='dev@fiyo.org';