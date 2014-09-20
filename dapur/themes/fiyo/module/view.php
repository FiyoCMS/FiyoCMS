<?php
/**
* @version		2.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2012 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.txt
**/
 
session_start();
if(!isset($_SESSION['USER_ID']) or !isset($_SESSION['USER_ID']) or $_SESSION['USER_LEVEL'] > 9 or !isset($_POST['url'])) die();

if(isset($_POST['view'])) {
	if(!isset($_SESSION['THEME_WIDTH']) or empty($_SESSION['THEME_WIDTH'])) {
		$_SESSION['THEME_WIDTH'] = 'hide-sidebar';
	} else {
		$_SESSION['THEME_WIDTH'] = null;
	}
}