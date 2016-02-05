<?php
/**
* @version		2.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2014 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.txt
* @description	Article Rating
**/

session_start();
define('_FINDEX_',1);
require('../../../system/jscore.php');
if(!isset($_POST['send'])) { 
	alert('error','Access Denied!',true,true);
	die();
} else {			
	$red = $id = 0;
	$delay_time = time();
	if(isset($_SESSION['COMMENT_DELAY'])) $delay_time = $_SESSION['COMMENT_DELAY'];
	loadLang('..');
	//reCaptcha
	if($delay_time - time()  <= 0) : 
	$privatekey = oneQuery('comment_setting','name',"'recaptcha_privatekey'",'value');
	$publickey	= oneQuery('comment_setting','name',"'recaptcha_publickey'",'value');
	if(checkOnline() AND !empty($_POST["recaptcha_challenge_field"]) AND !empty($_POST["recaptcha_response_field"])) {
		$capthca = recaptcha_check_answer ($privatekey,
			   $_SERVER["REMOTE_ADDR"],
			   $_POST["recaptcha_challenge_field"],
			   $_POST["recaptcha_response_field"]);			
		if($capthca->is_valid AND checkOnline()) 
		$valid = 1;
	}
	
	if(!@$_SESSION['ENABLE_CAPTCHA']) {
		$valid = true;
		if(!isset($_SESSION['captcha'])) $captcha = true; else $captcha = $_SESSION['captcha'];
		$_POST['secure'] = $captcha ;
	}
	
	if(empty($_POST['name']) or empty($_POST['email']) or empty($_POST['text'])) {
				$status = "error";
				$notice = comment_Notice_Error;	
	}
	else if(!preg_match("/^.+@.+\\..+$/",$_POST['email'])){	
				$status = "error";
				$notice = comment_Notice_Error2;	
	}
	else if($_POST['captcha'] == $_SESSION['captcha'] or isset($valid)){
		$name = oneQuery('comment_setting','name',"'name_filter'",'value');
		$name = explode(",",$name);
		foreach($name as $namef) {
			if(strtolower($_POST['name']) == strtolower(trim($namef)))
			$name = 0;
		}		
		$email = oneQuery('comment_setting','name',"'email_filter'",'value');
		$email = explode(",",$email);
		foreach($email as $emailf) {
			if(strtolower($_POST['email']) == strtolower(trim($emailf)))
			$email = 0;
		}		
		$filter = oneQuery('comment_setting','name',"'word_filter'",'value');
		$filter = explode(",",$filter);
		foreach($filter as $filterf) {
			$f = strtolower(trim($filterf));
			$t = strtolower($_POST['text']);
			$s = @strpos($t,$f);
			$s = str_replace(0,1,$s) ;
			if(!empty($s))
			$filter = 0;
		}		
		
		if(!$name  AND $_SESSION['USER_LEVEL'] != 1 AND $_SESSION['USER_LEVEL'] != 2) {
				$status = "error";
				$notice = comment_Notice_Error3;			
		}
		else if(!$filter) {			
				$status = "error";
				$notice = comment_Notice_Error4;	
		}
		else if(strlen($_POST['text']) < 10) {			
				$status = "error";
				$notice = comment_Notice_Error6;	
		}
		else {		
			if($_SESSION['USER_LEVEL'] ==1 or $_SESSION['USER_LEVEL'] ==2) 
				$auto = 1;
			else {
				$auto = oneQuery('comment_setting','name',"'auto_submit'",'value');
			}
			$no = null;
			$_POST['url'] = str_replace("<","&lt;",$_POST['url']);
			$_POST['url'] = str_replace(">","&gt;",$_POST['url']);
			$_POST['url'] = str_replace(" ","",$_POST['url']);
			$_POST['url'] = str_replace("  ","",$_POST['url']);
			$text = htmlentities($_POST['text']);
			$parent = 1;
			$apps = app_param();
			if(!isset($_SESSION['USER_ID'])) $uid = 0; else $uid = $_SESSION['USER_ID'];
			$com = $db->insert(FDBPrefix.'comment',array("","$_POST[link]",$uid,"$_POST[name]","$_POST[email]","$_POST[url]",date("Y-m-d H:i:s",time()),"$text","$auto","$apps","$parent","$parent","$parent"));
			
			if($com AND $auto) {
				$_SESSION['COMMENT_DELAY'] = time()+180;
				$status = "info";
				$notice = comment_Notice_Info;
				$red = 1;
				$sid = $db->select(FDBPrefix.'comment','id','','date DESC LIMIT 1' );
				if(!empty($sid[0])) $id = $sid[0];
				$id = $id['id'];
				}		
			else if($com) {
				$_SESSION['COMMENT_DELAY'] = time()+180;
				$status = "info";
				$notice = comment_Notice_Info2;
				}
			else {
			$status = "error";
			$notice = comment_Notice_Error5;
			
			}
		}
	}
	else {
		$status = "error";
		$notice = comment_Notice_Error5;
	}
	else :
		$status = "error";
		$notice = comment_Notice_Info3;	
	endif;
}

echo "{ \"status\":\"$status\" , \"notice\":\"$notice\" , \"redirect\":\"$red\", \"id\":\"$id\" }";