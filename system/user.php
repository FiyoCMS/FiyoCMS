<?php 
/**
* @version		2.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2012 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.txt
**/

defined('_FINDEX_') or die('Access Denied');
/****************************************************/
/*				   User Constants					*/
/****************************************************/
if(empty($_SESSION['USER_LEVEL']) or $_SESSION['USER_LEVEL'] == 0 or $_SESSION['USER_LEVEL'] == 99)	{		
	$_SESSION['USER_LEVEL']  = 99;
	$_SESSION['USER']  = null;
	$_SESSION['USER_ID']  = null;
	$_SESSION['USER_NAME']  = null;
	$_SESSION['USER_EMAIL']  = null;
}

// user defined
define('USER', $_SESSION['USER']); 
define('USER_ID', $_SESSION['USER_ID']);
define('USER_NAME', $_SESSION['USER_NAME']);
define('USER_LEVEL',$_SESSION['USER_LEVEL']);
define('USER_EMAIL', $_SESSION['USER_EMAIL']);

// Quick sql access level
define('Level_Access',"AND level >= ".USER_LEVEL);
define('SQL_USER_LEVEL',"level >= ".USER_LEVEL);
