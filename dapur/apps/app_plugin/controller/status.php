<?php
/**
* @version		2.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2014 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.
**/

define('_FINDEX_',1);
session_start();
if(!isset($_SESSION['USER_LEVEL']) AND $_SESSION['USER_LEVEL'] > 2) die ();

require_once ('../../../system/jscore.php');
$db = new FQuery();  
$db->connect(); 


/****************************************/
/*	    Enable and Disbale Modules		*/
/****************************************/
if(isset($_GET['stat'])) {
	if($_GET['stat']=='1'){
		$db->update(FDBPrefix.'plugin',array("status"=>"1"),'id='.$_GET['id']);
		alert('success',Status_Applied,1);
	}
	if($_GET['stat']=='0'){
		$db->update(FDBPrefix.'plugin',array("status"=>"0"),'id='.$_GET['id']);
		alert('success',Status_Applied,1);
	}
}
