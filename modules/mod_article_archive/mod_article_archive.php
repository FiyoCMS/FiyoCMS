<?php
/**
* @version		1.5.0
* @package		Article Related
* @copyright	Copyright (C) 2012 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.txt
**/

defined('_FINDEX_') or die('Access Denied');

$type = mod_param('type',$modParam);

switch($type) {
	case 'category' :
		require ("type/category.php");
	break;
	default :
		require ("type/default.php");
}

@include_once('js.php');
