<?php
/**
* @version		2.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2014 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.txt
**/

defined('_FINDEX_') or die('Access Denied');

if(isset($_REQUEST['act']))
	$act=$_REQUEST['act'];
else
	$act = null;
	
switch($act)
{	
	default :
	 require('view_permalink.php');
	break;
	case 'add':	 
	 require('add_permalink.php');
	break;
	case 'edit':
	 require('edit_permalink.php');
	break;
	case 'view':
	 require('view_permalink.php');
	break;
	case 'group':	 
	 require('group/view_group_permalink.php');
	break;	
	case 'add_group':	 
	 require('group/add_group_permalink.php');
	break;
	case 'edit_group':	 
	 require('group/edit_group_permalink.php');
	break;
}