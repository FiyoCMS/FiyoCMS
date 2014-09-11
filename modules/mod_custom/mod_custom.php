<?php
/**
* @version		1.5.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2012 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.txt
*/

defined('_FINDEX_') or die('Access Denied');

$param = $qr['parameter'];
if(checkLocalhost()) {
	$param = str_replace(FLocal."media/","media/",$param);
	$param = str_replace("/media/",FUrl."media/",$param);				
}
echo $param;
