<?php 
/**
* @version		2.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2012 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.txt
**/

defined('_FINDEX_') or die('Access Denied');
/*
* Access only for Super Administrator
*/
if(empty($_SESSION['USER_LEVEL']) or $_SESSION['USER_LEVEL'] > 2)
	redirect('index.php');
	
if (get_magic_quotes_gpc()) {
    function stripslashes_gpc(&$value)
    {
        $value = stripslashes($value);
    }
    array_walk_recursive($_GET, 'stripslashes_gpc');
    array_walk_recursive($_POST, 'stripslashes_gpc');
    array_walk_recursive($_COOKIE, 'stripslashes_gpc');
    array_walk_recursive($_REQUEST, 'stripslashes_gpc');
}
	
if(isset($_POST['config_save'])) {
	if(empty($_POST['site_name']) AND empty($_POST['site_title']) AND empty($_POST[site_url]) AND empty($_POST['site_status']) AND empty($_POST['site_title']) AND empty($_POST['file_allowed']) AND empty($_POST['file_size'])) 
	{	
		notice('error','invalid');
	}			
	else	
	{	
		$db = new FQuery();  
		$db->connect(); 
		$lang = siteConfig('lang');
		
		/*
		* SEF Extention remark
		*/
		$ext = siteConfig('sef_ext');
		$pxt = $_POST['sef_ext'];
		$pxt = str_replace("\\","",$pxt);
		$pxt = str_replace("@","",$pxt);
		$pxt = str_replace("#","",$pxt);
		$pxt = str_replace("*","",$pxt);
		$pxt = str_replace("!","",$pxt);
		if($ext != $pxt) {
			if(empty($pxt)) ;
			else if(empty($ext)) {
				if(!strpos("x$pxt","/")) {
				$pxt = str_replace(".","",$pxt);
				$pxt = ".$pxt";}
			}
			else {		
				if(!strpos("x$pxt","/")) {
				$pxt = str_replace(".","",$pxt);
				$pxt = ".$pxt";}
			}
		}
		
		/*
		* Query configuration
		*/
		$qr=$db->update(FDBPrefix."setting",array('value'=>"$_POST[site_name]"),"name='site_name'");	
		$qr=$db->update(FDBPrefix."setting",array('value'=>"$_POST[title]"),"name='site_title'");	
		$qr=$db->update(FDBPrefix."setting",array('value'=>"$_POST[url]"),"name='site_url'");
		$qr=$db->update(FDBPrefix."setting",array('value'=>"$_POST[mail]"),"name='site_mail'");
		$qr=$db->update(FDBPrefix."setting",array('value'=>"$_POST[status]"),"name='site_status'");	
		$qr=$db->update(FDBPrefix."setting",array('value'=>"$_POST[meta_keys]"),"name='site_keys'");	
		$qr=$db->update(FDBPrefix."setting",array('value'=>"$_POST[meta_desc]"),"name='site_desc'");	
		$qr=$db->update(FDBPrefix."setting",array('value'=>"$_POST[sef]"),"name='sef_url'");	
		$qr=$db->update(FDBPrefix."setting",array('value'=>"$_POST[file_size]"),"name='file_size'");
		$qr=$db->update(FDBPrefix."setting",array('value'=>"$_POST[file_allowed]"),"name='file_allowed'");
		$qr=$db->update(FDBPrefix."setting",array('value'=>"$_POST[media_theme]"),"name='media_theme'");	
		$qr=$db->update(FDBPrefix."setting",array('value'=>"$_POST[title_type]"),"name='title_type'");	
		$qr=$db->update(FDBPrefix."setting",array('value'=>"$_POST[title_divider]"),"name='title_divider'");
		$qr=$db->update(FDBPrefix."setting",array('value'=>"$_POST[lang]"),"name='lang'");		
		$qr=$db->update(FDBPrefix."setting",array('value'=>"$_POST[follow_link]"),"name='follow_link'");	
		$qr=$db->update(FDBPrefix."setting",array('value'=>"$_POST[member_registration]"),"name='member_registration'");		
		$qr=$db->update(FDBPrefix."setting",array('value'=>"$_POST[member_activation]"),"name='member_activation'");	
		$qr=$db->update(FDBPrefix."setting",array('value'=>"$_POST[member_group]"),"name='member_group'");	
		$qr=$db->update(FDBPrefix."setting",array('value'=>"$pxt"),"name='sef_ext'");
		$qr=$db->update(FDBPrefix."setting",array('value'=>"$_POST[www]"),"name='sef_www'");
		$qr=$db->update(FDBPrefix."setting",array('value'=>"$_POST[timezone]"),"name='timezone'");
		
		/*
		* Edit AdminPanel folder
		*/
		$new_folder = $_POST['folder_new'];
		$old_folder = $_POST['folder_old'];
		if($old_folder != $new_folder) {
			$ok = @rename("../$old_folder","../$new_folder");
			if($ok) {
				$qr=$db->update(FDBPrefix."setting",array('value'=>"$_POST[folder_new]"),"name='backend_folder'");
				$_SESSION['notice'] = true;
				notice('success',Status_Applied,2);
				redirect("../$new_folder/?app=config");			
			}
			else {		
				$_SESSION['notice'] = true;		
				notice('error',Folder_unchange,2);
			}
		}
		else if($qr)
		{				
			notice('success',Status_Applied);
			refresh();
		}
		$_SESSION['media_theme'] = $_POST['media_theme'];
	}		
}
