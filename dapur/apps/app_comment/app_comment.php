<?php
/**
* @version		1.4.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2012 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.txt
* @description	
**/

defined('_FINDEX_') or die('Access Denied');

if(isset($_REQUEST['act']))
	$act=$_REQUEST['act'];
else
	$act = null;
	
switch($act)
{	
	default :
	 require('view_comment.php');
	break;
	case 'config':	 
	 require('config_comment.php');
	break;
	case 'edit':
	 require('edit_comment.php');
	break;
	case 'view':
	 require('view_comment.php');
	break;	
}