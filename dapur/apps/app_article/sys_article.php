<?php
/**
* @version		2.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2014 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.
**/

defined('_FINDEX_') or die('Access Denied');

$db = new FQuery();  
	
/****************************************/
/*		   Add category article			*/
/****************************************/
if(isset($_POST['save_category']) or isset($_POST['add_category'])){	
	if(!empty($_POST['name'])) {
		$_POST['name'] = str_replace('"','',$_POST['name']);
		$_POST['name'] = str_replace("'",'',$_POST['name']);
		$qr=$db->insert(FDBPrefix.'article_category',array("","$_POST[name]","$_POST[parent_id]","$_POST[desc]","$_POST[keys]","$_POST[level]"));
		if($qr AND isset($_POST['add_category'])){
			notice('success',Category_Added,2);		
			redirect('?app=article&view=category');
		}
		else if($qr AND isset($_POST['save_category'])){
			$sql2 = $db->select(FDBPrefix.'article_category','id','','id DESC LIMIT 1' ); 
			notice('success',Category_Added,2);
			$qrs = mysql_fetch_array($sql2);			
			redirect("?app=article&view=category&act=edit&id=$qrs[id]");			
		}
		else {		
			$_SESSION['NOTICE_ERROR'] = alert('error',Status_Invalid);
		}
	}
	else {				
		$_SESSION['NOTICE_ERROR'] = alert('error',Status_Invalid);
	}
}

/****************************************/
/*		 Edit Category Article			*/
/****************************************/
if(isset($_POST['edit_category']) or isset($_POST['apply_category']) ){
	if(!empty($_POST['name']) AND !empty($_POST['id'])){	
		$_POST['name'] = str_replace('"','',$_POST['name']);
		$_POST['name'] = str_replace("'",'',$_POST['name']);	    
		$qr=$db->update(FDBPrefix.'article_category',array("name"=>"$_POST[name]",
		'parent_id'=>"$_POST[parent_id]",
		'level'=>"$_POST[level]",
		'keywords'=>"$_POST[keys]",
		'description'=>"$_POST[desc]"),
		'id='.$_POST['id']); 		
		if($qr AND isset($_POST['edit_category'])){				
			notice('success',Category_Saved);
			redirect('?app=article&view=category');
		}
		else if($qr AND isset($_POST['apply_category'])) {
			notice('success',Category_Saved);		
			redirect(getUrl());
		}
		else 			
			$_SESSION['NOTICE_ERROR'] = alert('error',Status_Invalid);						
	}
	else 				
		notice('error',Status_Invalid);
	
}		

/****************************************/
/*		  Delete Article Category 		*/
/****************************************/
if(isset($_POST['check_category'])){
	$source = @$_POST['check_category'];
	$source = multipleSelect($source);
	$delete = multipleDelete('article_category',$source,'article','','','');
	if($delete == 'noempty') {
		notice('error',Category_Not_Empty);
		redirect(getUrl());
	}
	else if(isset($delete)) {
		notice('info',Category_Deleted);
		redirect(getUrl());
	}
	else {
		notice('error',Please_Select_Category);
		redirect(getUrl());
	}
}
	
	
/****************************************/
/*			 Add New Article			*/
/****************************************/
if(isset($_POST['save_add']) or isset($_POST['add_new']) or isset($_POST['apply_add']) or isset($_POST['save_as'])){
	if( !empty($_POST['title']) AND 
		!empty($_POST['cat']) AND 
		!empty($_POST['editor'])) {
		$param=''; // first value from $param
		for($p=1;$p<=$_POST['totalparam'];$p++){
			$param = $param.$_POST["nameParam$p"]."=".$_POST['param'.$p].';\n';
		}		
		$parameter = $param;			
		if(empty($_POST['date'])) $_POST['date'] = date("Y-m-d H:i:s");
		$article = str_replace('"',"'","$_POST[editor]");
		$title 	= htmlentities($_POST['title']);
		$keys 	= htmlentities($_POST['keyword']);
		$desc 	= htmlentities($_POST['desc']);
		$tags = @$_POST['tags'];
		$tags = @multipleSelect($tags);		
		
		if(checkLocalhost()) {
			$article = str_replace(FLocal."media/","media/",$article);			
		}
		
		$qr=$db->insert(FDBPrefix.'article',array("","$title","$_POST[cat]","$article","$_POST[date]","$_POST[author]",$_SESSION['USER_ID'],"$desc", "$tags","$keys","$_POST[featured]","$_POST[status]","$_POST[level]","1","$parameter","",""));				
		
		if($qr AND isset($_POST['save_as'])){
			$sql = $db->select(FDBPrefix.'article','id','','id DESC' ); 
			$qrs = mysql_fetch_array($sql);					
			notice('success',Article_Saved);
			$_SESSION['DUPLICATED'] = alert('success',Article_Saved);
			$n = time();
			redirect('?app=article&act=edit&id='.$qrs['id']."&dupe=$n");
		}
		if($qr AND isset($_POST['apply_add'])){
			$sql = $db->select(FDBPrefix.'article','id','','id DESC' ); 
			$qrs = mysql_fetch_array($sql);					
			notice('success',Article_Saved);
			redirect('?app=article&act=edit&id='.$qrs['id']);
		}
		else if($qr AND isset($_POST['save_add'])) {
			notice('success',Article_Saved);
			redirect('?app=article&cat='.$_POST['cat']);
		}	
		else if($qr AND isset($_POST['add_new'])) {
			notice('success',Article_Saved);
			redirect('?app=article&act=add');
		}				
	}
	else if(empty($_POST['editor'])){	
		notice('error',Please_write_some_text);
	}
	else if(empty($_POST['title'])){	
		notice('error',Please_fill_article_title);
	}
	else if(empty($_POST['category'])){	
		notice('error',Please_Select_Category);
	}
	else{	
		notice('error',Status_Invalid);
	}
}

/****************************************/
/*		      Edit Article				*/
/****************************************/ 
if(isset($_POST['save_edit']) or isset($_POST['save_new']) or isset($_POST['apply_edit'])){		
	if( !empty($_POST['title']) AND 
		!empty($_POST['cat']) AND 
		!empty($_POST['editor'])) {	
		
		$param=''; // first value from $param
		for($p=1;$p<=$_POST['totalparam'];$p++)
		{
			$param = $param.$_POST["nameParam$p"]."=".$_POST['param'.$p].';\n';
		}		
		$parameter=$param;
		
		$db->select(FDBPrefix.'article');
		if(!empty($_POST['hits_reset'])) {
			$db->update(FDBPrefix.'article',array('hits'=>"0"),"id=$_POST[id]");
		}	
		
		$cat  = $_POST['cat'];
		$time = date("H:i:s");
		$desc = htmlentities($_POST['desc']);		
		$keys = htmlentities($_POST['keyword']);
		$title = htmlentities($_POST['title']);
		$author = htmlentities($_POST['author']);	

		$tags = @$_POST['tags'];
		$tags = @multipleSelect($tags);		
		
		$article = str_replace('"',"'","$_POST[editor]");
		
		if(checkLocalhost()) {
			$article = str_replace(FLocal."media/","media/",$article);			
		}		
		$qr=$db->update(FDBPrefix.'article',array(				
		"category"=>"$_POST[cat]",
		"title"=>"$title",
		"author"=>"$author",
		"date"=>"$_POST[date]",
		"status"=>"$_POST[status]",
		"featured"=>"$_POST[featured]",
		"level"=>"$_POST[level]",
		"tags"=>"$tags",
		"keyword"=>"$keys",
		"description"=>"$desc",
		"article"=>"$article",
		"editor"=> $_SESSION['USER_ID'],
		"parameter"=>"$parameter"),
		"id=$_POST[id]");
			
		if($qr AND isset($_POST['save_edit'])){		
			notice('success',Article_Saved);
			redirect("?app=article&cat=$_POST[cat]");		
		}
		else if($qr AND isset($_POST['save_new'])){		
			notice('success',Article_Saved);	
			redirect("?app=article&act=add");		
		}
		else if($qr AND isset($_POST['apply_edit'])){ 
			notice('success',Article_Saved);
			redirect(getUrl());
			}
		else 
			notice('error',Status_Fail);					
	}
	else if(empty($_POST['editor'])){	
		notice('error',Please_write_some_text);
	}
	else if(empty($_POST['title'])){	
		notice('error',Please_fill_article_title);
	}
	else if(empty($_POST['category'])){	
		notice('error',Please_Select_Category);
	}
	else 	
		notice('error',Status_Invalid);
	
}


/****************************************/
/*		      Delete Article			*/
/****************************************/ 	
if(isset($_POST['delete']) or isset($_POST['delete_confirm'])){
	$source = @$_POST['check'];
	$source = multipleSelect($source);
	$delete = multipleDelete('article',$source);	
	if(isset($delete)) {
		notice('info',Article_Deleted);
		redirect(getUrl());
	}
	else {
		notice('error',Article_Not_Select);		
		redirect(getUrl());
	}
}


/****************************************/
/*		  		 Add Tag				*/
/****************************************/
if(isset($_POST['add_tag']) or isset($_POST['save_tag'])){	
	if(!empty($_POST['name'])) {
		$qr=$db->insert(FDBPrefix.'article_tags',array("","$_POST[name]","$_POST[desc]","")); 		
		if($qr AND isset($_POST['save_tag'])){		
			notice('success',Tag_Added,2);	
			redirect('?app=article&view=tag');
		}
		else if($qr){ 
			$sql2 = $db->select(FDBPrefix.'article_tags','*','','id DESC'); 
			$qrs = mysql_fetch_array($sql2);
			notice('success',Tag_Added,2);
			redirect("?app=article&view=tag&act=edit&id=$qrs[id]");
		}
		else {			
			notice('error',Tag_Exists,2);
		}					
	}
	else {				
		notice('error',Status_Invalid);
	}
}

/****************************************/
/*		 		Edit Tag				*/
/****************************************/
if(isset($_POST['edit_tag']) or isset($_POST['apply_tag']) ){
	if(!empty($_POST['name']) AND !empty($_POST['id'])){		    
		$qr=$db->update(FDBPrefix.'article_tags',array("name"=>"$_POST[name]","description"=>"$_POST[desc]"),
		'id='.$_POST['id']); 		
		if($qr AND isset($_POST['edit_tag'])){				
			notice('success',Tag_Saved);
			redirect('?app=article&view=tag');
		}
		else if($qr AND isset($_POST['apply_tag'])) {
			notice('success',Tag_Saved);	
			refresh();
		}	
		else {
			notice('error',Tag_Exists,2);	
		}	
	}
	else 				
		notice('error',Status_Invalid);
	
}	

/****************************************/
/*		      Delete Tag				*/
/****************************************/ 	
if(isset($_POST['delete_tag']) or isset($_POST['check_tag'])){
	$source = @$_POST['check_tag'];
	$source = multipleSelect($source);
	$delete = multipleDelete('article_tags',$source);	
	if(isset($delete)){
		notice('info',Tag_Deleted);
		redirect(getUrl());
	}
	else {
		notice('error',Please_Select_Item);
		redirect(getUrl());
	}
}	


/****************************************/
/*		       Edit comment				*/
/****************************************/ 		
if(isset($_POST['save_comment']) or isset($_POST['apply_comment'])){		
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
		if($qr AND isset($_POST['save_comment'])){	
			notice('success',Comment_Updated);
			redirect('?app=article&view=comment');
		}
		else if($qr AND isset($_POST['apply_comment'])){ 
			notice('success',Comment_Updated);
			redirect(getUrl());
		}
		else {alert('error',Status_Invalid,'','','NOTICE');}					
	}
	else {alert('error',Status_Invalid,'','','NOTICE');}
}


/****************************************/
/*		      Delete Comment			*/
/****************************************/ 	
if(isset($_POST['delete_comment']) or isset($_POST['check_comment'])){
	$source = @$_POST['check_comment'];
	$source = multipleSelect($source);
	$delete = multipleDelete('comment',$source);	
	if(isset($delete)){
		notice('info',Comment_Deleted);
		redirect(getUrl());
	}
	else {
		notice('error',Please_Select_Item);
		redirect(getUrl());
	}
}

/****************************************/
/*	 Redirect when Article-Id invalid	*/
/****************************************/
if(!isset($_POST['save_edit']) AND !isset($_POST['apply_edit'])) {
	if(!isset($_REQUEST['view']) AND isset($_REQUEST['act'])) {
		if($_REQUEST['act']=='edit'){
			$id = $_REQUEST['id'];
			$level = USER_LEVEL;
			$db = new FQuery();  
			$sql = $db->select(FDBPrefix."article","*","id=$id");
			$row = mysql_fetch_array($sql); 
			$edlvl = mod_param('editor_level',$row['parameter']);
			if(!$row['id'] or $level > $row['level'] or (!empty($edlvl) AND $level > $edlvl))
				redirect('?app=article');
		}
	}
}


/****************************************/
/*	 	   Sub Article Category			*/
/****************************************/ 
// membuat fungsi sub-article yang akan di tampilkan dibawah parent_id	
function sub_article($parent_id,$nos,$pre = null) {
	$db = new FQuery();  
	$db->connect(); 
	$sql = $db->select(FDBPrefix."article_category","*","parent_id=$parent_id");
	$no=1;
	while($qr=mysql_fetch_array($sql)) {					
		$db->select(FDBPrefix.'article','*',"category=$qr[id]"); 
		$sum= mysql_affected_rows();
			
		$sql2 = $db->select(FDBPrefix.'user_group');
		while($qrs=mysql_fetch_array($sql2)){
			if($qrs['level']==$qr['level'])
				$level = "$qrs[group_name]";
			else					
				$level = _Public;
		}			
				
		if($qr['level'] >= $_SESSION['USER_LEVEL'] ) {
			$checkbox ="<input type='checkbox' data-name='rad-$qr[id]' name='check_category[]' value='$qr[id]' rel='ck'>";	
			
			$name ="<a class='tips' data-placement='right'  title='".Edit."' href='?app=article&view=category&act=edit&id=$qr[id]'>$qr[name]</a>";
			}
		else {
			$checkbox ="<span class='icon lock'></lock>";
			$name ="$qr[name]";
		}
			
		echo "<tr>";
		echo "<td align='center'>$checkbox</td><td>$pre|_ $name <span class='label label-primary right visible-xs'>$sum</span></td><td align='center'  class='hidden-xs'>$level</td><td align='center'  class='hidden-xs'>$sum</td>";
		echo "</tr>";
		sub_article($qr['id'],"$nos.$no",$pre."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;");
		$no++;	
	}			
}

/****************************************/
/*		Sub Option (Admin Panel)		*/
/****************************************/ 	
function option_sub_cat($parent_id,$pre) {
	$db = new FQuery();  
	$db ->connect(); 
	if(!isset($_REQUEST['id']) or $_REQUEST['act'] == 'add') 
		$sql=$db->select(FDBPrefix."article_category","*","parent_id=$parent_id"); 
	else
		$sql=$db->select(FDBPrefix."article_category","*","parent_id=$parent_id AND id != $_REQUEST[id]"); 
	while($qr = @mysql_fetch_array($sql)){
		if($qr['level'] >= $_SESSION['USER_LEVEL'] ){		
			$scat = $pcat = 0;			
			if(isset($_REQUEST['id'])) {
				$scat = oneQuery('article','id',$_REQUEST['id'],'category');
				$pcat = oneQuery('article_category','id',$scat,'parent_id');
			}			
			if($pcat == $qr['id'] or $scat == $qr['id']) $s ="selected"; else $s="";
			echo "<option value='$qr[id]' $s>$pre|_ $qr[name]</option>";
			option_sub_cat($qr['id'],$pre."&nbsp;&nbsp;&nbsp;&nbsp;");
		}
	}		
}
