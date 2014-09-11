<?php
/**
* @version		1.5.0
* @package		Fi pdf
* @copyright	Copyright (C) 2012 Fiyo Developers.
* @license		GNU/GPL, see LICENSE.txt
**/

defined('_FINDEX_') or die('Access Denied');

$id 	 = app_param('id');
$view 	 = app_param('view');
addCss(FUrl.'/apps/app_pdf/style/default.css');

switch($view)
{
	case 'category':			
		require("apps/app_pdf/view/category.php");
	break;
	case 'item':
		require("apps/app_pdf/view/item.php");
	break;	
	case 'pdf':
		require("apps/app_pdf/view/category.php");
	break;
	default :
		require("apps/app_pdf/view/default.php");
	break;
	
}