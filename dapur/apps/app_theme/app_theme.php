<?php
/**
* @version		2.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2014 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.
**/

defined('_FINDEX_') or die('Access Denied');

$view = $folder = false;
if(isset($_REQUEST['folder']))
	$folder=$_REQUEST['folder'];

if(isset($_REQUEST['view']))
	$view=$_REQUEST['view'];
			
if($view == 'admin')
	 require('admin_theme.php');
else if($folder AND $folder != 'blank') 
	 require('edit_theme.php');
else
	 require('site_theme.php');
	 
?>