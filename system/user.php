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
if(empty($_SESSION['USER_LEVEL']) or $_SESSION['USER_LEVEL'] == 0 or $_SESSION['USER_LEVEL'] == 99 or !userInfo('user_id'))	{		
	$_SESSION['USER_LEVEL']  = 99;
	$_SESSION['USER']  = null;
	$_SESSION['USER_ID']  = null;
	$_SESSION['USER_NAME']  = null;
	$_SESSION['USER_EMAIL']  = null;
}

define('USER', userInfo('user')); 
define('USER_ID', userInfo('user_id'));
define('USER_NAME', userInfo('name'));
define('USER_LEVEL',userInfo('level'));
define('USER_EMAIL',userInfo('email'));

// Quick sql access level
define('Level_Access',"AND level >= ".USER_LEVEL);
define('SQL_USER_LEVEL',"level >= ".USER_LEVEL);
