<?php
/**
* @version		2.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2014 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.
**/

if(!isset($_POST['user'])) die('Access Denied!');
session_start();
define('_FINDEX_',1);
require('../../../system/jscore.php');
$db = new FQuery();  
		$user =  mysql_real_escape_string($_POST['user']);
		$sql = $db->select(FDBPrefix."user","*","status=1 AND user='".$user."' AND password='".MD5($_POST['pass'])."'");
		$qr = mysql_fetch_array($sql);
		$jml = mysql_affected_rows();
		if($jml > 0) {
			$_SESSION['USER_ID']  	= $qr['id'];
			$_SESSION['USER'] 		= $qr['user'];
			$_SESSION['USER_NAME']	= $qr['name'];
			$_SESSION['USER_EMAIL']	= $qr['email'];
			$_SESSION['USER_LEVEL'] = $qr['level'];
			$_SESSION['USER_LOG'] 	= $qr['time_log'];			
			$time_log = date('Y-m-d H:i:s');
			$db->update(FDBPrefix.'user',array("time_log"=>"$time_log"),"id=$qr[id]"); 
			
			$db->delete(FDBPrefix."session_login","user_id=$qr[id]");			
			$qr = $db->insert(FDBPrefix."session_login",array("$qr[id]","$qr[user]","$qr[level]",date('Y-m-d H:i:s')));
		}		
		if($qr or !empty($_SESSION['USER_ID']) AND $_SESSION['USER_LEVEL'] <= 3 AND userInfo()){
			echo "{ \"status\":\"1\"}";	
		}
		else {
			echo "{ \"status\":\"0\" , \"alert\":\"".alert('error',Login_Error)."\"}";	
		}