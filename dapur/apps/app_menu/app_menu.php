<?php
/**
* @version		2.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2014 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.
**/

defined('_FINDEX_') or die('Access Denied');

if(isset($_REQUEST['view']))
	$view =$_REQUEST['view'];
else
	$view = null;
	
switch($view)
{	
	default :
	 require('view_menu.php');
	break;
	case 'add':	 
	 require('add_menu.php');
	break;
	case 'edit':
	 require('edit_menu.php');
	break;
	case 'view':
	 require('view_menu.php');
	break;	
	case 'category':	 
	 require('category/view_category.php');
	break;
	case 'edit_category':	 
	 require('category/edit_category.php');
	break;
	case 'add_category':	 
	 require('category/add_category.php');
	break;		
}