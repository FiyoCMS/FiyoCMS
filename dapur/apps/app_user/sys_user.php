<?php
/**
* @version		2.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2014 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.
**/

defined('_FINDEX_') or die('Access Denied');


$db = new FQuery();  
$db->connect();

/****************************************/
/*			 Add Group User				*/
/****************************************/
if(isset($_POST['add_group']) or isset($_POST['apply_group'])){
	$db = new FQuery();  
	$db->connect();			
	if(!empty($_POST['group']) AND !empty($_POST['level'])) {
		$qr=$db->insert(FDBPrefix.'user_group',array("","$_POST[group]","$_POST[level]","$_POST[desc]","","")); 
		if($qr AND isset($_POST['add_group'])){	
			notice('success',User_Group_Added);
			redirect('?app=user&view=group');
		}
		else if($qr AND isset($_POST['apply_group'])){
			$sql = $db->select(FDBPrefix.'user_group','id','','id DESC' ); 	  
			$qr = mysql_fetch_array($sql);		
			notice('success',User_Group_Added);
			redirect('?app=user&view=group&act=edit&id='.$qr['id']);
		}
		else {				
			notice('error',User_Group_Exists,2);
		}					
	}
	else 
	{				
		notice('error',Status_Invalid,2);
	}
}
	

/****************************************/
/*			Delete Group User			*/
/****************************************/
if(isset($_POST['check']) or isset($_POST['delete_confirm'])){
	$source = @$_POST['check'];
	$source = multipleSelect($source);
	$delete = multipleDelete('user_group',$source,'user','level','','','1,2,3,4');		
	if($delete == 'noempty') {
		notice('error',User_Group_Not_Empty);
		refresh();		
	}
	else if(isset($delete)) {
		notice('info',Category_Deleted);
		refresh();		
	}
	else {
		notice('error',Please_Select_Category);
		refresh();		
	}
}

	
/****************************************/
/*			 Edit Group User			*/
/****************************************/
if(isset($_POST['edit_group']) or isset($_POST['save_group'])){
	$db = new FQuery();  
	$db->connect();			
	if(!empty($_POST['level']) AND !empty($_POST['group'])) {	
		$qr=$db->update(FDBPrefix."user_group",array(
		"level"=>"$_POST[level]",
		"group_name"=>"$_POST[group]",
		"description"=>"$_POST[desc]"),
		"id=$_POST[id]"); 		
		$qr=$db->update(FDBPrefix."user",array(
		"level"=>"$_POST[level]"),
		"level=$_POST[levels]"); 
		if($qr AND isset($_POST['save_group'])){
			notice('success',User_Group_Saved);
			refresh();			
		}
		else if($qr AND isset($_POST['edit_group'])){
			notice('success',User_Group_Saved);
			redirect('?app=user&view=group');
		}
		else {				
			notice('error',Status_Fail);
		}					
	}		
	else 
	{				
		notice('error',Status_Invalid);
	}			
}

	
	
/****************************************/
/*				Add User				*/
/****************************************/
if(isset($_POST['save']) or isset($_POST['apply'])){
	$us=strlen("$_POST[user]");
	$ps=strlen("$_POST[password]");
	$user = $_POST['user'];
	$name = $_POST['name'];
	preg_match('/[^a-zA-Z0-9]+/', $user, $matches);
	if(!empty($_POST['password']) AND 
		!empty($_POST['user'])AND 
		!empty($_POST['name'])AND 
		!empty($_POST['email'])AND 
		!empty($_POST['level'])AND 
		$_POST['password']==$_POST['kpassword'] AND 
		$us>2 AND $ps>3 AND @ereg("^.+@.+\\..+$",$_POST['email']) AND !$matches) {
		
		$qr=$db->insert(FDBPrefix.'user',array("","$user","$name",MD5("$_POST[password]"),"$_POST[email]","$_POST[status]","$_POST[level]",date('Y-m-d H:i:s'),'',"$_POST[bio]")); 
		
		if($qr AND isset($_POST['save'])){			
			notice('success',User_Added);
			redirect('?app=user');
		}
		else if($qr AND isset($_POST['apply'])){
			$sql = $db->select(FDBPrefix.'user','id','','id DESC'); 	  
			$qr = mysql_fetch_array($sql);		
			notice('success',User_Added);
			redirect('?app=user&act=edit&id='.$qr['id']);
		}
		else {				
			notice('error',Status_Fail);
		}					
	}
	else  {							
		notice('error',Status_Invalid);
	}
}
	
	
/****************************************/
/*				User Edit				*/
/****************************************/
if(isset($_POST['edit']) or isset($_POST['applyedit'])){
		$us=strlen("$_POST[user]");
		$ps=strlen("$_POST[password]");	
		$user = $_POST['user'];
		$name = $_POST['name'];
		preg_match('/[^a-zA-Z0-9]+/', $user, $matches);
		if(!empty($_POST['user'])AND !empty($_POST['name'])AND !empty($_POST['email'])AND !empty($_POST['level']) AND $us>2 AND @ereg("^.+@.+\\..+$",$_POST['email']) AND !$matches) 
		{
			$qr = false;
			if($_POST['id'] == $_SESSION['USER_ID']) $_POST['status'] = 1;
			if(empty($_POST['password'])){
				$qr = $db->update(FDBPrefix.'user',array(				
				"user"=>"$_POST[user]",
				"name"=>"$_POST[name]",
				"email"=>"$_POST[email]",
				"status"=>"$_POST[status]",
				"about"=>"$_POST[bio]",
				"level"=>"$_POST[level]"),
				"id=$_POST[id]"); }
			elseif($_POST['password']==$_POST['kpassword']){
				$qr = $db->update(FDBPrefix.'user',array(				
				"user"=>"$_POST[user]",
				"name"=>"$_POST[name]",
				"password"=>MD5("$_POST[password]"),
				"email"=>"$_POST[email]",
				"about"=>"$_POST[bio]",
				"status"=>"$_POST[status]",
				"level"=>"$_POST[level]"),
				"id=$_POST[id]"); 
				}
				
			if($qr AND isset($_POST['edit'])){		
				notice('success',User_Saved);
				redirect('?app=user');
			}
			else if($qr AND isset($_POST['applyedit'])){
				notice('success',User_Saved);	
				redirect(getUrl());			
			}
			else {				
				notice('error',Status_Invalid);
			}					
		}
		else 
		{				
			notice('error',Status_Invalid);
		}
	}


/****************************************/
/*				User Delete				*/
/****************************************/
if(isset($_POST['delete']) or isset($_POST['delete_confirm'])){
	$source = @$_POST['check'];
	$source = multipleSelect($source);
	$delete = multipleDelete('user',$source);	
	if(isset($delete))
		notice('info',User_Deleted);
	else
		notice('error',Please_Select_User);
	redirect(getUrl());		
}


/****************************************/
/*	 Redirect when User-Id not found	*/
/****************************************/
if(!isset($_POST['save_edit']) AND !isset($_POST['apply_edit'])) {
	if(isset($_REQUEST['act']))
	if($_REQUEST['act']=='edit' AND !isset($_REQUEST['view'])){
		$id=$_REQUEST['id'];
		$db = new FQuery();  
		$db->connect(); 
		$sql=$db->select(FDBPrefix.'user','*','id='.$id); 
		$jml=mysql_num_rows($sql);
		if($jml<=0) {
			notice('info','UserID is null, wait for redirecting ...');
			redirect('?app=user',3);
		}
	}
}


/****************************************/
/*		   User Configurtation			*/
/****************************************/
if(isset($_POST['config'])){
	$qr=$db->update(FDBPrefix."setting",array('value'=>"$_POST[new_member]"),"name='new_member'");	
	if(isset($qr))
		notice('info',Status_Applied);
}