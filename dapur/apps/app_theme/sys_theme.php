<?php
/**
* @version		1.5.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2012 Fiyo CMS.
* @license		GNU/GPL, see license.txt
* @description	
**/

defined('_FINDEX_') or die('Access Denied');

// Access only for Administrator
if($_SESSION['USER_LEVEL'] > 2)
	redirect('index.php');

$db = new FQuery();  
$db->connect();  

if(isset($_POST['themes_submit'])) { 		
	if(empty($_POST['folder_themes'])) {	
		alert('error',Please_select_theme);
	}			
	else {	
		$qr=$db->update(FDBPrefix.'setting',array('value'=>"$_POST[folder_themes]"),"name='site_theme'");	
		if($qr) {	
			alert('info',Theme_successfully_applied);
		}
	}
}
if(isset($_POST['themes_files'])) { 		
	if(empty($_POST['folder_themes'])) {	
		alert('error',Please_select_theme);
	}			
	else {	
		$thm = $_POST['folder_themes'];
		if($_GET['act'] == 'admin')
			redirect("?app=theme&act=afiles&theme=$thm");
		else
			redirect("?app=theme&act=files&theme=$thm");
	}
}	
	
if(isset($_POST['themes_admin'])) { 	
	if(empty($_POST['folder_themes'])) {	
		alert('error',Please_select_theme);
	}			
	else {	
		$qr=$db->update(FDBPrefix.'setting',array('value'=>$_POST['folder_themes']),"name='admin_theme'"); 				
		if($qr) {	
				alert('info',Theme_successfully_applied);
		}
	}
}
/*
if(isset($_GET['theme']) or isset($_GET['theme']) == 'files') {
	if(empty($_GET['theme']) or !file_exists("../themes/$_GET[theme]/index.php"))
		redirect('?app=theme');
}*/