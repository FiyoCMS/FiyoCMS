<?php
/**
* @version		1.5.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2012 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.txt
* @description	Article Editor
**/

session_start();
if($_SESSION['USER_LEVEL'] <= 4) {
	define('_FINDEX_',1);
	require_once ('../../../system/jscore.php');
	$db = new FQuery();  
	$db->connect(); 

	if(isset($_POST['art_title']) AND !empty($_POST['art_title'])) {
		$title = $_POST['art_title'];
		$title =  str_replace('"',"'",$title);
		$qr=$db->update(FDBPrefix.'article',array("title"=>"$title","editor"=>$_SESSION['USER_ID']),"id=$_POST[id]"); 
		if(@$qr)
			echo "Saved";
		else
			echo "Failed!";
	}


	if(isset($_POST['_content_article']) AND !empty($_POST['_content_article'])) {		
		$article = str_replace('"',"'","$_POST[_content_article]");

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
}