<?php 
/**
* @version		2.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2014 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.txt
* @description	
**/

defined('_FINDEX_') or die('Access Denied!');

$id 	= app_param('id');
$view 	= app_param('view');
$format	= menu_param('format');
if($format != 'blog' AND $format != 'list') $format = 'default';

switch($view)
{
	case 'featured':		
		require("apps/app_article/view/featured.php");
	break;
	case 'archives':		
		require("apps/app_article/view/default.php");
	break;
	case 'category':			
		require("apps/app_article/view/category.php");
	break;
	case 'item':
		require("apps/app_article/view/item.php");
	break;
	default :	
		if(app_param('tag') != null)			
			require("apps/app_article/view/tag.php");
		else
			echo "<h3>Opps, Articles you are looking for is not available! <Opps</h3>";
	break;
	
}