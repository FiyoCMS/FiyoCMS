<?php
/**
* @version		1.4.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2012 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.txt
**/

defined('_FINDEX_') or die('Access Denied');
$category 	= mod_param("category",$modParam);
$sub_title 	= mod_param("sub_title",$modParam);
$sub_menu 	= mod_param("sub_menu",$modParam);
$type_menu 	= mod_param("type",$modParam);

require_once("mod_system.php");
switch($type_menu) {
	case 1 :
	include("type/row_style.php");
	break;
	case 2 :
	
	include("type/list_style.php");
	break;
}

