<?php
/**
* @version		2.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2014 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.
**/

defined('_FINDEX_') or die('Access Denied');

$db = @new FQuery() or die;  
$db->connect(); 

$type = null;
if(isset($_REQUEST['view']))
	$type = $_REQUEST['view']; 

	switch($type) {
		case 'apps':	 
		 require('manages/apps.php');
		break;
		case 'plugins':
		 require('manages/plugins.php');
		break;
		case 'themes':
		 require('manages/themes.php');
		break;
		case 'modules':
		 require('manages/modules.php');
		break;
		case 'backup':
		 require('backup.php');
		break;
		case 'install':
		 require('installer.php');
		break;
		default :
		 require('general.php');
		break;
	}	
?>	