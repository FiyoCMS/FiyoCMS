<?php
/**
* @version		1.4.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2012 Fiyo CMS.
* @license		GNU/GPL, see license.txt
* @description	
**/

defined('_FINDEX_') or die('Access Denied');

$db = new FQuery();  
$db->connect(); 	

/****************************************/
/*		       Edit comment				*/
/****************************************/ 		
if(isset($_POST['save_edit']) or isset($_POST['apply_edit'])){		
	if( !empty($_POST['name']) AND 
		!empty($_POST['comment']) AND 
		!empty($_POST['email'])) {
		
		$qr = $db->update(FDBPrefix.'comment',array(				
		"comment"=>"$_POST[comment]",
		"name"=>"$_POST[name]",
		"website"=>"$_POST[web]",
		"email"=>"$_POST[email]",
		"status"=>"$_POST[status]"),
		"id=$_POST[id]");
		if($qr AND isset($_POST['save_edit'])){	
			alert('loading');
			alert('info',Comment_Updated);
			redirect('?app=comment',2);
		}
		else if($qr AND isset($_POST['apply_edit'])){ 
			alert('info',Comment_Updated);
		}
		else {alert('error',Status_Invalid);}					
	}
	else {alert('error',Status_Invalid);}
}


/****************************************/
/*		      Delete comment			*/
/****************************************/ 	
if(isset($_POST['delete'])){
	$source = @$_POST['check'];
	$source = multipleSelect($source);
	$delete = multipleDelete('comment',$source);	
	if(isset($delete))
		alert('info',Comment_Deleted);
	else
		alert('error',Please_Select_Item);
}
	

/****************************************/
/*	    Enable and Disbale comment		*/
/****************************************/
if(isset($_REQUEST['act'])) {
	if(!isset($_POST['delete']) AND $_REQUEST['act']=='enable'){
		$db->update(FDBPrefix.'comment',array("status"=>"1"),'id='.$_REQUEST['id']);
		alert('info',Status_Applied);
	}

	if(!isset($_POST['delete']) AND $_REQUEST['act']=='disable'){
		$db->update(FDBPrefix.'comment',array("status"=>"0"),'id='.$_REQUEST['id']);
		alert('info',Status_Applied);
	}
}

/****************************************/
/*	 Redirect when comment-Id not found	*/
/****************************************/
if(isset($_REQUEST['act']))
	if($_REQUEST['act']=='edit'){
		$sql = $db->select(FDBPrefix.'comment','*',"id=$_REQUEST[id]"); 
		if(mysql_num_rows($sql)<=0) header('location:?app=comment');
	}

function update($a,$b) {	
	$db = new FQuery();  
	$db->connect(); 
	$qr=$db->update(FDBPrefix."comment_setting",array('value'=>"$b"),"name='$a'");
	if($qr) return true;

}



if(isset($_POST['save_config'])) { 	
	$qr = update('auto_submit',$_POST['auto']);
	$qr = update('name_filter',"$_POST[name]");
	$qr = update('email_filter',"$_POST[email]");
	$qr = update('word_filter',"$_POST[word]");			
	$qr = update('recaptcha_publickey',"$_POST[public]");			
	$qr = update('recaptcha_privatekey',"$_POST[private]");			
	if($qr)
	{					
		alert('info',Status_Applied);
	}
}
	
