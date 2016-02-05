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
/*	   		  	Site Theme				*/
/****************************************/
if(isset($_GET['file']))
$file	= '../../../../../'.$_GET['file'];
$ori	= '../../../'.$_GET['ori'];

if(isset($_GET['delete']) AND $_GET['delete'] == 'true' AND file_exists($ori.".ori")) {
	unlink($ori);
	rename($ori.".ori",$ori);
	alert('success','Logo Successfuly Restore',1);	
}
else if(isset($_GET['file']) AND !empty($_GET['file']) AND file_exists($file) AND file_exists($ori.".ori")) {
	copy($file,$ori);
	alert('success','Logo Successfuly Updated',1);
	
}
else if(isset($_GET['file']) AND !empty($_GET['file']) AND file_exists($file)){
	copy($ori,$ori.".ori");
	copy($file,$ori);
	alert('success','Logo Successfuly Updated',1);
}

?>
<script>notice();</script>