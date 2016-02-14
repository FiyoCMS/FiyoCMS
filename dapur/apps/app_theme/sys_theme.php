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



/****************************************/
/*		   Add Layout		*/
/****************************************/
if(Input::post('add_layout') or Input::post('save_layout')){
        $t = Input::post('name');
	if(!empty($t)) {
            
		$qr=$db->insert(FDBPrefix.'theme_layout',array(
                    "desc"=>Input::post('desc'),
                    "theme"=>Input::post('theme'),
                    "name"=>Input::post('name'))); 		
		if($qr AND Input::post('save_layout')){
			notice('success',Status_Saved);	
			redirect('?app=theme&view=layout');
		}
		else if($qr){ 
			$sql2 = $db->select(FDBPrefix.'theme_layout','*','','id DESC'); 
			$qrs = $sql2[0];
			notice('success',Status_Saved);
			redirect("?app=theme&view=layout&act=edit&id=$qrs[id]");
		}
		else {			
			notice('error',Status_Invalid,2);
		}					
	}
	else {				
		notice('error',Status_Invalid,2);
	}
}

/****************************************/
/*		 		Edit Layout				*/
/****************************************/
if(Input::post('edit_layout') or Input::post('apply_layout')){
        $t = Input::post('name');
	if(!empty($t) AND !empty(Input::post('id'))){		    
		$qr=$db->update(FDBPrefix.'theme_layout',array(
                    "desc"=>Input::post('desc'),
                    "theme"=>Input::post('theme'),
                    "name"=>Input::post('name')),
                    'id='.Input::post('id')); 		
		if($qr AND Input::post('edit_layout')){				
			notice('success',Status_Applied);
			redirect('?app=theme&view=layout');
		}
		else if($qr AND Input::post('apply_layout')) {
			notice('success',Status_Applied);	
			refresh();
		}	
		else {
                    notice('error',Status_Invalid,2);	
		}	
	}
	else 				
		notice('error',Status_Invalid,2);
	
}	

/****************************************/
/*		      Delete Layout				*/
/****************************************/ 	
if(Input::post('delete_layout') or Input::post('check_layout')){
	$source = Input::post('check_layout');
	$source = multipleSelect($source);
	$delete = multipleDelete('theme_layout',$source);	
	if(isset($delete)){
		notice('info',Status_Deleted);
		redirect(getUrl());
	}
	else {
		notice('error',Status_Deleted);
		redirect(getUrl());
	}
}	