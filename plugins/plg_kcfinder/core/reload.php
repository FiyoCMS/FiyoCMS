<?php
/**
* @version		2.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2014 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.txt
* @description	Article Editor
**/

session_start();
define('_FINDEX_',1);
require('../../../system/jscore.php');

if(!isset($_POST['id'])) { 
	alert('error','Access Denied!',true,true);
	die();
} else {	
	require "core/autoload.php";
}
?>
