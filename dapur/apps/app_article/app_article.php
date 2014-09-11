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
		 require_once('view_article.php');
		break;
		case 'add':	 
		 require('add_article.php');
		break;
		case 'edit':
		 require('edit_article.php');
		break;
		case 'view':
		 require('view_article.php');
		break;			
	}
	break;
	case 'category': 		 
	 switch($act) {	
		default :	 
		 require('category/view_category.php');
		break;
		case 'edit':	 
		 require('category/edit_category.php');
		break;
		case 'add':	 
		 require('category/add_category.php');
		break;	
	}	
	break;	
	case 'tag': 		 
	 switch($act) {	
		default :	 
		 require('tag/view_tag.php');
		break;
		case 'edit':	 
		 require('tag/edit_tag.php');
		break;
		case 'add':	 
		 require('tag/add_tag.php');
		break;	
	}	
	break;	
	case 'comment': 		 
	 switch($act) {	
		default :	 
		 require('comment/view_comment.php');
		break;
		case 'edit':	 
		 require('comment/edit_comment.php');
		break;
		case 'add':	 
		 require('comment/add_comment.php');
		break;	
	}	
	break;	
}