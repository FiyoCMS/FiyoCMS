<?php
/**
* @version		2.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2012 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.txt
* @description	Article Editor
**/


session_start();
define('_FINDEX_',1);
require('../../../system/jscore.php');
if(!isset($_POST['id'])) { 
	alert('error','Access Denied!',true,true);
	die();
}
$db = new FQuery();  
$db->connect(); 

if(isset($_POST['art_title']) AND !empty($_POST['art_title'])) {
	$title = $_POST['art_title'];
	$title =  str_replace('"',"&quot;",$title);
	$qr=$db->update(FDBPrefix.'article',array("title"=>"$title","editor"=>$_SESSION['USER_ID']),"id=$_POST[id]"); 
	if(@$qr)
		echo "Saved";
	else
		echo "Failed!";
}


if(isset($_POST['_content_article']) AND !empty($_POST['_content_article'])) {		
	$article = $_POST['_content_article'];
	if(!get_magic_quotes_gpc() ) {
		$article = str_replace('="',"='","$article");
		$article = str_replace('" ',"' ","$article");
		$article = str_replace('">',"'>","$article");
		$article = str_replace('"',"&quot;","$article");
	}
	else {		
		$article = str_replace('"',"'","$article");
	}
	if(checkLocalhost()) {
		$flocal = $_POST['flocal'];
		$article = str_replace("http://localhost/$flocal","/",$article);	
	}
		
	$qr=$db->update(FDBPrefix.'article',array("article"=>"$article","editor"=>$_SESSION['USER_ID']),"id=$_POST[id]"); 
	if(@$qr)
		echo "Saved";
	else
		echo "Failed!";
}