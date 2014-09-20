<?php
/**
* @version		2.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2014 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.
**/

define('_FINDEX_','BACK');
session_start();
if(!isset($_SESSION['USER_LEVEL']) AND $_SESSION['USER_LEVEL'] > 2 AND (empty($_GET['fp']) or empty($_GET['id']))) die ();


require_once ('../../../system/jscore.php');
$db = new FQuery();  
$db->connect(); 

/****************************************/
/*	    	Article Front Page			*/
/****************************************/
if(isset($_GET['fp'])) {
	if($_GET['fp']=='1'){
		$db->update(FDBPrefix.'article',array("featured"=>"1"),'id='.$_GET['id']);
		alert('success',Status_Applied,1);
	}
	if($_GET['fp']=='0'){
		$db->update(FDBPrefix.'article',array("featured"=>"0"),'id='.$_GET['id']);
		alert('success',Status_Applied,1);
	}
}

/****************************************/
/*	    Enable and Disbale Article		*/
/****************************************/
if(isset($_GET['stat'])) {
	if($_GET['stat']=='1'){
		$db->update(FDBPrefix.'article',array("status"=>"1"),'id='.$_GET['id']);
		alert('success',Status_Applied,1);
	}
	if($_GET['stat']=='0'){
		$db->update(FDBPrefix.'article',array("status"=>"0"),'id='.$_GET['id']);
		alert('success',Status_Applied,1);
	}
}