<?php
/**
* @version		2.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2014 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.
**/

if(!isset($_GET['user'])) die('Access Denied!');
session_start();
define('_FINDEX_','BACK');
require('../../../system/jscore.php');
		$user = addslashes($_GET['user']);
		$sql = $db->select(FDBPrefix."user","*","status=1 AND user='".$user."' AND password='".MD5($_GET['pass'])."'");
		if(!empty($sql[0]))
		$qr = $sql[0];
		if(isset($qr) AND count($qr) > 0) {
			$_SESSION['USER_ID']  	= $qr['id'];
			$_SESSION['USER'] 		= $qr['user'];
			$_SESSION['USER_NAME']	= $qr['name'];
			$_SESSION['USER_EMAIL']	= $qr['email'];
			$_SESSION['USER_LEVEL'] = $qr['level'];
			$_SESSION['USER_LOG'] 	= $qr['time_log'];			
			$time_log = date('Y-m-d H:i:s');
			$db->update(FDBPrefix.'user',array("time_log"=>"$time_log"),"id=$qr[id]"); 
			
			$db->delete(FDBPrefix."session_login","user_id=$qr[id]");			
			$qr = $db->insert(FDBPrefix."session_login",
                                array("$qr[id]","$qr[user]","$qr[level]",date('Y-m-d H:i:s')));
		}		
		if(isset($qr) or !empty($_SESSION['USER_ID']) AND $_SESSION['USER_LEVEL'] <= 3 AND userInfo()){
			echo "{ \"status\":\"1\" , \"alert\":\"".alert('success',Login_Success)."\"}";	
		}
		else {
			echo "{ \"status\":\"0\" , \"alert\":\"".alert('error',Login_Error)."\"}";	
		}