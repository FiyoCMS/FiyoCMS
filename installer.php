<?php
/**
* @name			Updater
* @version		2.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2014 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.txt
*/

defined('_FINDEX_') or die('Access Denied');

$version	 	= '2.0 1.8';
$addons['name'] = 'Patch 2.0 1.8';
$addons['type'] = 'updater';
$addons['info'] = '<h1>Update Successfully</h1><p>Version $version. successfully updated.</p>';


$db = new FQuery();
$db->update(FDBPrefix.'setting',array("value"=>"$version"),"name='version'");