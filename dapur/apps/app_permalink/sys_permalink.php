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
/*			   Add permalink			*/
/****************************************/
if(isset($_POST['save_new']) OR isset($_POST['apply_new'])){
	if(!empty($_POST['permalink']) AND !empty($_POST['link'])) {
		$qr=$db->insert(FDBPrefix.'permalink',array("","$_POST[link]","$_POST[permalink]","$_POST[page]","$_POST[status]","$_POST[lock]")); 
		
		if($qr AND isset($_POST['save_new'])){
			notice('success',Status_Added);
			redirect('?app=permalink');
		}
		else if($qr AND isset($_POST['apply_new'])){
			$sql = $db->select(FDBPrefix.'permalink','id','','id DESC' ); 	  
			$qr = mysql_fetch_array($sql);
			notice('success',Status_Added);	
			redirect('?app=permalink&act=edit&id='.$qr['id']);
		}
		else {		
			notice('error',Status_Fail,2);
		}					
	}
	else {							
		notice('error',Status_Invalid,2);
	}
}
	
/****************************************/
/*			  Permalink Edit			*/
/****************************************/
if(isset($_POST['save']) or isset($_POST['apply'])){
	if(!empty($_POST['permalink']) AND !empty($_POST['link'])) {
		$qr=$db->update(FDBPrefix.'permalink',array(				
		"permalink"=>"$_POST[permalink]",
		"link"=>"$_POST[link]",
		"locker"=>"$_POST[lock]",
		"status"=>"$_POST[status]",
		"pid"=>"$_POST[page]"),
		"id=$_POST[id]"); 			
		
		if($qr AND isset($_POST['save'])){
			notice('success',Status_Applied);
			redirect('?app=permalink');
		}
		else if($qr AND isset($_POST['apply'])){
			notice('success',Status_Applied);	
			redirect(getUrl());					
		}
		else {
			notice('error',Status_Exist);
		}					
	}
	else 
	{				
		notice('error',Status_Invalid);
	}
}


/****************************************/
/*		    Permalink Delete			*/
/****************************************/

if(isset($_POST['delete']) or isset($_POST['delete_confirm'])){
	$source = @$_POST['check'];
	$source = multipleSelect($source);
	$delete = multipleDelete('permalink',$source,'permalink','id','locker = 1');
	if($delete == 'noempty') 
		notice('error',Status_Cant_Delete);
	else if(isset($delete))
		notice('info',Status_Deleted);
	else
		notice('error',Status_Please_Select);
	
	redirect(getUrl());		
	
}
	


/****************************************/
/*	    Enable and Disbale permalink	*/
/****************************************/
if(isset($_REQUEST['act'])) {
	if($_REQUEST['act']=='enable' AND !isset($_POST['delete'])){
		$db->update(FDBPrefix.'permalink',array('status'=>'1'),'id='.$_REQUEST['id']); 
		notice('info',Status_Applied);
	}

	if($_REQUEST['act']=='disable' AND !isset($_POST['delete'])){
		$db->update(FDBPrefix.'permalink',array('status'=>'0'),'id='.$_REQUEST['id']); 
		notice('info',Status_Applied);
	}
}

/****************************************/
/*	    Lock and Unlock permalink		*/
/****************************************/
if(isset($_REQUEST['act'])) {
	if($_REQUEST['act']=='lock' AND !isset($_POST['delete'])){
		$db->update(FDBPrefix.'permalink',array('locker'=>'1'),'id='.$_REQUEST['id']); 
		notice('info',Status_Applied);
	}

	if($_REQUEST['act']=='unlock' AND !isset($_POST['delete'])){
		$db->update(FDBPrefix.'permalink',array('locker'=>'0'),'id='.$_REQUEST['id']); 
		notice('info',Status_Applied);
	}
}
/****************************************/
/*	Redirect when permalink-Id notfound */
/****************************************/
if(!isset($_POST['save']) AND !isset($_POST['apply'])) {
	if(isset($_REQUEST['act']))
	if($_REQUEST['act']=='edit'){
		$db->connect(); 
		$sql=$db->select(FDBPrefix.'permalink','*','id='.$_REQUEST['id']); 
		$jml=mysql_num_rows($sql);
		if($jml<=0) header('location:?app=sef');
	}	
}

define('SEF_helper',"<h3>Bantuan untuk <i>Media Manager</i></h3><ul><li>Halaman <b>Media Manager</b> berguna untuk mengelola segala bentuk gambar atau animasi berupa swf pada situs anda yang disimpan di server anda.</li><li>Folder media terletak di folder <b>files/</b> pada situs anda. Jadi jika anda membuka <b>Images Media</b>, folder yang dibuka adalah <b>files/images/</b>.<br>Sehingga jika ingin memanggil gambar menggunakan alamat <b>files/images/nama_gambar.jpg</b></li></ul>");

define('SEF_link_tip',"SEF Link");
define('Original_link_tip',"Link asli atau link sumber");
define('LockSEF_tip',"Kunci/amankan SEF");
define('EnableSEF_tip',"Aktifkan SEF");
define('PageIDSEF_tip',"ID dari menu ID");

