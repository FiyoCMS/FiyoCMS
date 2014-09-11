<?php
/**
* @version		v 1.2.1
* @package		Fiyo CMS
* @copyright	Copyright (C) 2012 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.php
* @description	
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
		 require('view_contact.php');
		break;
		case 'add':	 
		 require('add_contact.php');
		break;
		case 'edit':
		 require('edit_contact.php');
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
	 
	 
	 }
	break;		
}