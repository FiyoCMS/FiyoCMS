<?php 
/**
* @version		2.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2012 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.txt
**/

//set session start
session_start();
ob_start();

//flag for main file
define( '_FINDEX_', 1 );

//define root directory
define('_PATH_BASE_', dirname(__FILE__) );

//check file configuration
if(!file_exists('config.php'))
{
	require_once ('system/installer.php');
	die();
}
else
{	
	require_once ('system/core.php');
}

