<?php
/**
* @version		2.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2014 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.
**/
defined('_FINDEX_') or die('Access Denied');

if(isset($_REQUEST['act']))
	$act=$_REQUEST['act'];
else
	$act = null;

if(isset($_REQUEST['view']))
	$view=$_REQUEST['view'];
else
	$view = null;
switch($view)
{	
	default :
	 switch($act) {	
		default :
		 require('view_user.php');
		break;
		case 'add':	 
		 require('add_user.php');
		break;
		case 'edit':
		 require('edit_user.php');
		break;
		case 'view':
		 require('view_user.php');
		break;			
	}
	break;
	case 'group': 		 
	 switch($act) {	
		default :	 
		 require('group/view_group.php');
		break;
		case 'edit':	 
		 require('group/edit_group.php');
		break;
		case 'add':	 
		 require('group/add_group.php');
		break;	
	}	
	break;	
}