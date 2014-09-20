<?php
/**
* @version		2.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2014 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.
**/

session_start();
if(!isset($_SESSION['USER_LEVEL']) AND $_SESSION['USER_LEVEL'] > 2) die ();
define('_FINDEX_','BACK');

require_once ('../../../system/jscore.php');
$db = new FQuery();  
$db->connect(); 

/****************************************/
/*	    Enable and Disbale Modules		*/
/****************************************/
if(isset($_GET['stat'])) {
	if($_GET['stat']=='1'){
		$db->update(FDBPrefix.'module',array("status"=>"1"),'id='.$_GET['id']);
		alert('success',Status_Applied,1);
	}
	if($_GET['stat']=='0'){
		$db->update(FDBPrefix.'module',array("status"=>"0"),'id='.$_GET['id']);
		alert('success',Status_Applied,1);
	}
}

/****************************************/
/*	    Enable and Disbale Name			*/
/****************************************/
if(isset($_GET['name'])) {
	if($_GET['name']=='1'){
		$db->update(FDBPrefix.'module',array("show_title"=>"1"),'id='.$_GET['id']);
		alert('success',Status_Applied,1);
	}
	if($_GET['name']=='0'){
		$db->update(FDBPrefix.'module',array("show_title"=>"0"),'id='.$_GET['id']);
		alert('success',Status_Applied,1);
	}
}