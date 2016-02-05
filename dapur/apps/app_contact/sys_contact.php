<?php
/**
* @version		1.5.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2012 Fiyo CMS.
* @license		GNU/GPL, see license.php
* @description	
**/

defined('_FINDEX_') or die('Access Denied');

$db = new FQuery();  
$db->connect();

/****************************************/
/*			 Add group contact			*/
/****************************************/
if(isset($_POST['add_group']) or isset($_POST['save_group'])){
	if(!empty($_POST['name']) AND !empty($_POST['desc'])) {
	$row=$db->insert(FDBPrefix.'contact_group',array("","$_POST[name]","$_POST[desc]")); 
		if($row AND isset($_POST['save_group'])){		
			notice('success',Group_Saved);
			redirect('?app=contact&view=group');
		}
		else if($row AND isset($_POST['add_group'])){
			$sql = $db->select(FDBPrefix.'contact_group','group_id','','group_id DESC' ); 	  
			$row = $sql[0];
			notice('success',Group_Saved);
			redirect('?app=contact&view=group&act=edit&id='.$row['group_id']);
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
/*			Delete group contact		*/
/****************************************/
if(isset($_POST['check_group'])){
	$source = @$_POST['check_group'];
	$source = multipleSelect($source);
	$delete = multipleDelete('contact_group',$source,'contact','group_id');		
	if($delete == 'noempty') {
		notice('error',Group_contact_Not_Empty);
	}
	else if(isset($delete))
		notice('info',Group_Deleted);
	else
		notice('error',Please_Select_Group);
	refresh();
}
		
	
/****************************************/
/*			 Edit group contact			*/
/****************************************/
if(isset($_POST['edit_group']) or isset($_POST['apply_group'])){
	if(!empty($_POST['name']) AND !empty($_POST['desc'])){
		$row=$db->update(FDBPrefix.'contact_group',array("group_name"=>"$_POST[name]",
		'group_desc'=>"$_POST[desc]"),
		'group_id='.$_POST['id']); 		
		//edit or update catgory name
		$sql =  $db->select(FDBPrefix.'contact'); 	  
		foreach($sql as $sq){
			$db->update(FDBPrefix.'contact',array("group_id"=>$_POST['id']),'id='.$_POST['id']);
		}					
		if($row AND isset($_POST['edit_group'])){
			notice('success',Group_Saved);
			redirect('?app=contact&view=group');
		}		
		else if($row AND isset($_POST['apply_group'])){
			notice('success',Group_Saved);
			redirect(getUrl());
		}
		else {
			notice('error',Status_Fail);
		}
	}
	else {
		notice('error',Status_Invalid);
	}
}

	
/****************************************/
/*			 Add New contact				*/
/****************************************/
if(isset($_POST['save_add']) or isset($_POST['apply_add'])){	
	$db = new FQuery();  
	$db->connect(); 	
	if( !empty($_POST['name']) AND 
		!empty($_POST['gender']) AND 
		!empty($_POST['group'])) {			
		$row=$db->insert(FDBPrefix.'contact',array("","$_POST[name]","$_POST[gender]","$_POST[email]","$_POST[address]","$_POST[city]","$_POST[state]","$_POST[country]","$_POST[zip]", "$_POST[phone]", "$_POST[fax]", "$_POST[job]","$_POST[photo]","$_POST[web]","$_POST[ym]","$_POST[fb]","$_POST[tw]","$_POST[desc]","$_POST[group]",1));
		if($row AND isset($_POST['apply_add'])){
			$sql = $db->select(FDBPrefix.'contact','id','','id DESC' ); 	  
			$row = $sql[0];
			notice('success',Contact_Saved);
			redirect('?app=contact&act=edit&id='.$row['id'],2);
		}
		elseif($row AND isset($_POST['save_add'])) {	
			notice('success',Contact_Saved);
			redirect('?app=contact',2);
		}
		else {				
			notice('error',Status_Fail);
		}
	}
	else {	
		notice('error',Status_Invalid);
	}	
}

/****************************************/
/*		       Edit contact				*/
/****************************************/ 		
if(isset($_POST['save_edit']) or isset($_POST['apply_edit'])){	
	if( !empty($_POST['name']) AND !empty($_POST['gender']) AND !empty($_POST['group'])) {	
		$row=$db->update(FDBPrefix.'contact',array(
		"name"=>"$_POST[name]",			
		"gender"=>"$_POST[gender]",
		"group_id"=>"$_POST[group]",
		"email"=>"$_POST[email]",
		"address"=>"$_POST[address]",
		"city"=>"$_POST[city]",
		"state"=>"$_POST[state]",
		"country"=>"$_POST[country]",
		"zip"=>"$_POST[zip]",
		"phone"=>"$_POST[phone]",
		"fax"=>"$_POST[fax]",
		"job"=>"$_POST[job]",
		"photo"=>"$_POST[photo]",
		"web"=>"$_POST[web]",
		"ym"=>"$_POST[ym]",
		"fb"=>"$_POST[fb]",
		"tw"=>"$_POST[tw]",
		"description"=>"$_POST[desc]"),
		"id=$_POST[id]");
		if($row AND isset($_POST['save_edit'])){	
			notice('success',Contact_Saved);
			redirect('?app=contact');
		}
		else if($row AND isset($_POST['apply_edit'])){ 
			notice('success',Contact_Saved);
			refresh();
		}
		else {notice('error',Status_Fail, 2);}					
	}
	else {notice('error',Status_Invalid, 2);}
}


/****************************************/
/*		      Delete contact				*/
/****************************************/ 	
if(isset($_POST['delete'])){
	$source = @$_POST['check'];
	$source = multipleSelect($source);
	$delete = multipleDelete('contact',$source);	
	if(isset($delete))
		notice('info',Contact_Deleted);
	else
		notice('error',Please_Select_contact);	
	redirect(getUrl());		
}


/****************************************/
/*	 Redirect when contact-Id not found	*/
/****************************************/
if(!isset($_POST['save_edit']) AND !isset($_POST['apply_edit'])) {
	if(isset($_REQUEST['view']))
		if($_REQUEST['view']=='edit'){
		$id = $_REQUEST['id'];
		$react = oneQuery('contact','id',$id,'id');
		if(!isset($react)) header('location:?app=contact');
		}
}
