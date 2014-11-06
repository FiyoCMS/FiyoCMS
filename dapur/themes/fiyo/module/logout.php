<?php
/**
* @version		2.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2014 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.
**/

session_start();
define('_FINDEX_','BACK');
require('../../../system/jscore.php');
$db = new FQuery();  
$db->delete(FDBPrefix."session_login","user_id=$_SESSION[USER_ID]");			
$_SESSION['USER_ID']  	= "";
$_SESSION['USER'] 		= "";
$_SESSION['USER_NAME']	= "";
$_SESSION['USER_EMAIL']	= "";
$_SESSION['USER_LEVEL'] = "";
$_SESSION['USER_LOG'] 	= "";