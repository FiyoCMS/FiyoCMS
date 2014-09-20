<?php
/**
* @version		2.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2014 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.
**/

session_start();
if(!isset($_SESSION['USER_LEVEL']) AND $_SESSION['USER_LEVEL'] > 3) die ();
define('_FINDEX_','BACK');

require_once ('../../../system/jscore.php');
$db = new FQuery();  
$db->connect(); 

$act=$_POST['act'];

switch($act)
{
	default :
		if(strlen($_POST['username'])<4) echo 2;
		else{
			$sql = $db->select(FDBPrefix.'user','*',"user='$_POST[username]'"); 
			$user = mysql_num_rows($sql); 	
			echo $user;
		}
	break;
	case 'email':	
		if(!preg_match("/^.+@.+\\..+$/",$_POST['email']) or substr_count($_POST['email'],"@")>1) echo 2;
		else {
			$sql2 = $db->select(FDBPrefix.'user','*',"email='$_POST[email]'"); 
			$email = mysql_num_rows($sql2); 	
		echo $email;
		}
	break;
}
