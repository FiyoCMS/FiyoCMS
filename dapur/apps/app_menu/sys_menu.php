<?php
/**
* @version		2.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2014 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.
**/

defined('_FINDEX_') or die('Access Denied');

// Access only for Administrator
if($_SESSION['USER_LEVEL'] > 2)
	redirect('index.php');
	
$db = new FQuery();  
$db->connect();

/****************************************/
/*			 Add Category Menu			*/
/****************************************/
if(isset($_POST['add_category']) or isset($_POST['save_category'])){		
	$db = new FQuery();  
	$db->connect();				
	if(!empty($_POST['title']) AND !empty($_POST['cat']) AND !empty($_POST['level'])) {
		$cat=strtolower(str_replace(" ","","$_POST[cat]"));	
		$qr=$db->insert(FDBPrefix.'menu_category',array("","$cat","$_POST[title]","$_POST[desc]","$_POST[level]")); 
		if(isset($_POST['add_category']) AND $qr ){	
			$sql = $db->select(FDBPrefix.'menu_category','id','','id DESC' ); 	  
			$qr = mysql_fetch_array($sql);	
			notice('success',Category_Menu_Saved);
			redirect('?app=menu&view=edit_category&id='.$qr['id']);
		}		
		else if(isset($_POST['save_category']) AND $qr){
			notice('success',Category_Menu_Saved);
			redirect('?app=menu&view=category');
		}
		else {				
			notice('error',Category_Exists,2);
		}					
	}
	else {
		notice('error',Status_Invalid);
	}
}
	

/****************************************/
/*			Delete category menu		*/
/****************************************/
if(isset($_POST['delete_category']) or isset($_POST['check'])){
	$source = $_POST['check'];
	$source = multipleSelect($source);
	$delete = multipleDelete('menu_category',$source,'menu','category');
	if($delete == 'noempty') {
		notice('error',Category_Menu_Not_Empty);
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
/*			 Edit category menu			*/
/****************************************/
if(isset($_POST['edit_category']) or isset($_POST['apply_category'])){
	$db = new FQuery();  
	$db->connect();
	$cat=strtolower(str_replace(" ","","$_POST[cat]"));	
	if(!empty($_POST['title']) AND !empty($_POST['cat'])){
		$qr=$db->update(FDBPrefix.'menu_category',array("title"=>"$_POST[title]",
		'category'=>"$cat",
		'level'=>"$_POST[level]",
		'description'=>"$_POST[desc]"),
		'id='.$_POST['id']); 		
		//edit or update catgory name
		$sql =  $db->select(FDBPrefix.'menu'); 	  
		while(mysql_fetch_array($sql)){	
			$qrs=$db->update(FDBPrefix.'menu',array("category"=>"$cat"),"category='$_POST[cats]'");
		}					
		if(isset($_POST['edit_category']) AND $qr){
			notice('loading');
			notice('success',Category_Menu_Saved);
			redirect('?app=menu&view=category',1);
		}			
		else if(isset($_POST['apply_category']) AND $qr){
			notice('success',Category_Menu_Saved);
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
/*			 Add New Menu				*/
/****************************************/
if(isset($_POST['save_add']) or isset($_POST['apply_add'])){	
	$db = new FQuery();  
	$db->connect(); 	
	if( !empty($_POST['name']) AND 
		!empty($_POST['cat']) AND 
		!empty($_POST['apps'])AND 
		!empty($_POST['link'])) {
		
		$param=''; // first value from $param
		if(isset($_POST['totalParam']))
			for($p=1;$p<=$_POST['totalParam'];$p++)
			{
				if($p!=$_POST['totalParam'])
				{
					@$param=$param.$_POST["nameParam$p"]."=".$_POST['param'.$p].';\n';
				}
				else
				{
					@$param=$param.$_POST['param'.$p];			
				}
			}
		@$param = str_replace('"',"'","$_POST[editor]");
		@$parameter .= $param;	
		$param = str_replace('"',"'",$param);	
		$qr=$db->insert(FDBPrefix.'menu',array("","$_POST[cat]","$_POST[name]","$_POST[link]","$_POST[apps]","$_POST[parent_id]","$_POST[status]","$_POST[short]", "$_POST[level]","0", "$_POST[title]","$_POST[show_title]","$_POST[sub_name]","$_POST[class]","$_POST[style]","$parameter",""));
		if($qr AND isset($_POST['apply_add'])){
			$sql = $db->select(FDBPrefix.'menu','id','','id DESC' ); 	  
			$qr = mysql_fetch_array($sql);
			notice('success',Menu_Saved,2);
			redirect('?app=menu&view=edit&id='.$qr['id']);
		}
		elseif($qr AND isset($_POST['save_add'])) {
			notice('success',Menu_Saved,2);
			redirect('?app=menu');
		}
		else {				
			notice('error',Status_Invalid);
		}					
	}
	else {	
		notice('error',Status_Invalid);
	}	
}


/****************************************/
/*		       Edit Menu				*/
/****************************************/ 		
if(isset($_POST['save_edit']) or isset($_POST['apply_edit'])){		
	if( !empty($_POST['name']) AND 
		!empty($_POST['cat']) AND 
		!empty($_POST['link'])) {
		$param=''; // first value from $param
		if(isset($_POST['totalParam']))
			for($p=1;$p<=$_POST['totalParam'];$p++)
			{
				@$param=$param.$_POST["nameParam$p"]."=".$_POST['param'.$p].';\n';
			}
			$param = str_replace('"',"'",$param);
		@$parameter = $param;		
		$db = new FQuery();  
		$db->connect();
		$db->select(FDBPrefix.'menu');
		$cat=$_POST['cat'];
		$qr=$db->update(FDBPrefix.'menu',array(				
		"category"=>"$_POST[cat]",
		"name"=>"$_POST[name]",
		"link"=>"$_POST[link]",
		"app"=>"$_POST[apps]",
		"parent_id"=>"$_POST[parent_id]",
		"status"=>"$_POST[status]",
		"show_title"=>"$_POST[show_title]",
		"level"=>"$_POST[level]",
		"title"=>"$_POST[title]",
		"sub_name"=>"$_POST[sub_name]",
		"class"=>"$_POST[class]",
		"style"=>"$_POST[style]",
		"short"=>"$_POST[short]",
		"parameter"=>"$parameter"),
		"id=$_POST[id]");
		if($qr AND isset($_POST['save_edit'])){	
			notice('success',Menu_Updated);
			redirect("?app=menu&cat=$_POST[cat]");
		}
		else if($qr AND isset($_POST['apply_edit'])){ 
			notice('success',Menu_Updated);
			redirect(getUrl());
		}
		else {notice('error',Status_Invalid);}					
	}
	else {notice('error',Status_Invalid);}
}


/****************************************/
/*		      Delete Menu				*/
/****************************************/ 	
if(isset($_POST['delete']) or isset($_POST['delete_confirm'])){
	$source = @$_POST['check'];
	$source = multipleSelect($source);
	$delete = multipleDelete('menu',$source,'','','','',1);
	
	if(isset($delete))
		if($delete == 'noempty')		
			notice('info',Menu_Contain_Submenu);
		else
			$_SESSION['NOTICE'] =notice('info',Menu_Deleted);
	else
		$_SESSION['NOTICE'] =notice('error',Please_Select_Menu);
	redirect(getUrl());
}


/****************************************/
/*	 Redirect when menu-Id not found	*/
/****************************************/
if(!isset($_POST['save_edit']) AND !isset($_POST['apply_edit'])) {
	if(isset($_REQUEST['view']))
		if($_REQUEST['view']=='edit'){
		$id = $_REQUEST['id'];
		$review = oneQuery('menu','id',$id,'id');
		if(!isset($review)) header('location:?app=menu');
		}
}

/****************************************/
/*				 Sub Menu 				*/
/****************************************/ 			
function sub_menu($parent_id,$pre,$nos) {
	$db = new FQuery();  
	$db->connect(); 
	$sql =  $db->select(FDBPrefix."menu","*","parent_id=$parent_id","short ASC"); 
	$no=1;
	while($qr=mysql_fetch_array($sql)){
		/* logika status aktif atau tidak */
		$sts = "<span style='display:none'>disable</span>";
		if($qr['status']==1)
			{ $stat1 ="selected"; $stat2 =""; $sts = "<span style='display:none'>enable</span>";}							
		else
			{ $stat2 ="selected";$stat1 ="";}				
		$status ="
		<p class='switch'>
			<label class='cb-enable $stat1'><span>On</span></label>
			<label class='cb-disable $stat2'><span>Off</span></label>
			<input type='text' value='$qr[id]' id='id' class='invisible'><input type='text' value='$qr[status]' id='type' class='invisible'>
		</p>";												
							
		$name = "<a class='tips' title='".Edit."' data-placement='right' href='?app=menu&view=edit&id=$qr[id]'>$pre|_ $qr[name]</a>";
							
		$checkbox = "<input type='checkbox' name='check[]' value='$qr[id]' rel='ck'  data-parent='$parent_id'>";
					

				if($qr['status']==1)
				{ $stat1 ="selected"; $stat2 =""; $enable = ' enable';}							
				else
				{ $stat2 ="selected";$stat1 =""; $enable = 'disable';}
				
				$status ="<span class='invisible'>$enable</span>
					<div class='switch s-icon activator'>
					<label class='cb-enable $stat1 tips' data-placement='right' title='".Disable."'><span>
					<i class='icon-remove-sign'></i></span></label>
					<label class='cb-disable $stat2 tips' data-placement='right' title='".Enable."'><span>
					<i class='icon-ok-sign'></i></span></label>
					<input type='text' value='$qr[id]' id='id' class='invisible'>
					<input type='text' value='$qr[status]' id='type' class='invisible'>
				</div>";					
				
				/* change home page */
				if($qr['home']==1)
				{ $hm = "selected"; $hms = ""; }							
				else
				{ $hm = ""; $hms = "selected";  }		
				$home ="
				<div class='switch s-icon home'>
					<label class='cb-enable $hm tips' data-placement='left' title='".Set_as_home_page."'>
					<span style='padding: 3px 11px 1px 9px'>
					<i class='icon-home'></i></span></label>
					<label class='cb-disable $hms tips' data-placement='left' title='".As_home_page."'>
					<span style='padding: 3px 11px 1px 9px'>
					<i class='icon-home'></i></span></label>
					<input type='text' value='$qr[id]' data-category='$qr[category]' id='id' class='invisible'><input type='text' value='stat' id='type' class='invisible'>
				</div>";
				
		/* auto change default page */			
		if($qr['global']==1)
		{ $dm = "selected"; $dms = ""; }							
		else
		{ $dm = ""; $dms = "selected";  }		
		$default ="<div class='switch s-icon star'>
			<label class='cb-enable $dm tips' title='".Set_as_default_page."'><span>
			<i class='icon-star'></i>
			</span></label>
			<label class='cb-disable $dms tips' title='".As_default_page."'><span>
			<i class='icon-star'></i></span></label>
			<input type='text' value='$qr[id]'  class='invisible' id='id'><input type='text' value='fp' id='type' class='invisible'>
		</div>";	
				
		//creat user group values	
		$sql2=$db->select(FDBPrefix.'user_group','*',"level=$qr[level]"); 
		$level=mysql_fetch_array($sql2);				
		if($qr['level']==99) $level = _Public;
		else $level = $level['group_name'];
		
		echo "<tr>";
		echo "<td align='center'>$checkbox</td><td>$name</td><td class='hidden-xs hidden-sm' align='center'><div class='switch-group'>$home$default$status</div></td><td class='hidden-xs'>$qr[category]</td><td class='hidden-xs'>$qr[app]</td><td class='hidden-xs hidden-sm' align='center'>$qr[short]</td><td align='center' class=''>$level</td><td align='center' class=''>$qr[id]</td>";
		echo "</tr>";
		sub_menu($qr['id'],$pre."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;","$nos.$no");
		$no++;	
	}
}
	
/****************************************/
/*		      Option Sub Menu 			*/
/****************************************/ 	
function option_sub_menu($parent_id,$sub = NULL,$pre) {
	$db = new FQuery();  
	$db->connect(); 
	if($_REQUEST['id']) $eid = "AND id!=$_REQUEST[id]";
	$sql = $db->select(FDBPrefix."menu","*","parent_id=$parent_id $eid");  
	while($qr=mysql_fetch_array($sql)){	
		if($sub==$qr['id']) $s="selected"; else $s="";
		echo "<option value='$qr[id]' $s>$pre|_ $qr[name]</option>";
		option_sub_menu($qr['id'],$sub,$pre."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;");	
	}	
}

	
function option_sub_cat($parent_id,$pre) {
	$db = new FQuery();  
	$db ->connect(); 
	$sql=$db->select(FDBPrefix."article_category","*","parent_id=$parent_id AND id!=$_REQUEST[id]"); 
	while($qr=mysql_fetch_array($sql)){
		//select article 'info'rmation
		$sql2=$db->select(FDBPrefix.'article','*',"id=$_REQUEST[id]"); 
		$at=mysql_fetch_array($sql2);
		//select article category 'info'rmation		
		$sql3=$db->select(FDBPrefix.'article_category','*',"id=$_REQUEST[id]"); 
		$pd = mysql_fetch_array($sql3);
		if($pd['parent_id']==$qr['id'] or $at['category']==$qr['id'])$s ="selected";else $s="";
		echo "<option value='$qr[id]' $s>$pre |_ $qr[name]</option>";
		option_sub_cat($qr['id'],$pre."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;");
	}		
}
