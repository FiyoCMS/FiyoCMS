<?php 
/**
* @version		2.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2014 Fiyo CMS.
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
	
if(isset($_POST['upload']) or isset($_POST['copy'])) {
	$c = false;
	if(isset($_POST['upload'])  AND !empty($_FILES['zip'])) {
		$path_file = $_FILES['zip']['tmp_name'];
		$name_file = $_FILES['zip']['name'];
		$name_file = md5($path_file);
		$_SESSION['file'] = $path_file;
		$c = true;
	} else if(isset($_POST['copy']) AND !empty($_POST['url'])) {
		$url_file  = $_POST['url'];
		if(!file_exists("../tmp"))
		mkdir("../tmp");
		$name_file = md5($url_file);
		$path_file = "../tmp/$name_file.zip";
		$c = @copy($url_file, $path_file);
	}
	if(!empty($path_file) AND $c) {
		if(extractZip($path_file,"../tmp/$name_file")) {
		if(file_exists("../tmp/$name_file/installer.php")) {				
				include("../tmp/$name_file/installer.php");
					
				//Modules Installer
				if($addons['type'] == 'modules') {
					$folder	= "../modules/$addons[folder]";
					$copy	= @copy_directory("../tmp/$name_file",$folder);
				}
				//Plugins Installer
				else if($addons['type'] == 'plugins'){	
					insert_new_plg(@$addons['folder'],@$addons['parameter']);
					$folder	= "../plugins/$addons[folder]";				
					$copy	= @copy_directory("../tmp/$name_file",$folder);
				}
				//Apps Installer
				else if($addons['type'] == 'apps'){					
					if($addons['app_type'] > 0) {
						if(isset($addons['app_icon'])) $icon = $addons['app_icon']; else $icon = null;
						if(isset($addons['app_style'])) $style = $addons['app_style']; else $style = null;
						insert_new_apps($addons['name'],$addons['folder'],$addons['author'],$addons['app_type'], $icon, $style);
						$folback = siteConfig('backend_folder');
						if($addons['app_type'] == 3 or $addons['app_type'] == 1)
						$copy = @copy_directory("../tmp/$name_file/$addons[frontend]","../apps/$addons[folder]");
						if($addons['app_type'] == 2 or $addons['app_type'] == 1) 
						$copy = @copy_directory("../tmp/$name_file/$addons[backend]","../$folback/apps/$addons[folder]");
					}
				}
				//Themes Installer
				else if($addons['type'] == 'themes'){					
					$folder	= "../themes/$addons[folder]";	
					$copy = @copy_directory("../tmp/$name_file","../themes/$addons[folder]");
				}
				//Admin Themes installer
				else if($addons['type'] == 'admin_themes'){
					$flback = siteConfig('backend_folder');	
					$folder	= "../$flback/themes/$addons[folder]";	
					$copy	= @copy_directory("../tmp/$name_file",$folder);
				}
				//updater / patcher
				else if($addons['type'] == 'updater'){
					$copy	= @copy_directory("../tmp/$name_file","../");
					$dapur 	= siteConfig('backend_folder');
					if(siteConfig('backend_folder') != 'dapur')		
						@copy_directory("../dapur","../$dapur",true);
				} else {
					$fail = true;						
					alert('error',File_uploaded_not_valid,true);			
				}
				
				if(!isset($fail)) {
					if(isset($folder) AND file_exists("$folder/installer.php"))
						@unlink("$folder/installer.php",true);
					if($copy)
						alert('info',AddOns_installed);
					if(isset($addons['info'])) {
						$_SESSION['INSTALL_NOTICE'][0] = 3;
						$_SESSION['INSTALL_NOTICE'][1] = "<div class='install_info panel box'><h2>$addons[name] ".successfully_installed."</h2>
						$addons[info]</div>";
						refresh();
					}
					delete_directory('../tmp');	
				}
			}
			else {
				alert('error',File_uploaded_not_valid,true);
			}
		}
		else{
			alert('error',File_not_support,true);
		}
	}
	else if(!$c) {
		alert('error',File_uploaded_not_valid,true);
	}
	else {
		alert('error',Please_choose_file,true);
	}
	delete_directory('tmp');
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
		$qr=$db->update(FDBPrefix."setting",array('value'=>"$_POST[disk_space]"),"name='disk_space'");	
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


function insert_new_apps($name, $folder, $author, $type, $icon = null, $style = null) {
	$db = new FQuery();  
	$qr = $db->insert(FDBPrefix.'apps',array("","$name","$folder","$author","$type"));  
	$fl = str_replace("app_","",$folder);
	$pi = FQuery('menu', "category = 'adminpanel' AND sub_name='apps'",'id');
	if(!FQuery('menu', "category = 'adminpanel' AND link = '?app=$fl' AND parent_id > 0 "))
	$db->insert(FDBPrefix.'menu',array("","adminpanel","$name","?app=$fl","$folder","$pi","1","0", "3","0", "","1","$fl","$icon","$style","",""));
	
	$qr = $db->insert(FDBPrefix.'apps',array("","$name","$folder","$author","$type")); 
	return $qr;
}
function insert_new_plg($folder,$param = null) {
	$db = new FQuery();  
	$qr = $db->insert(FDBPrefix.'plugin',array("","$folder","1","$param")); 
	return $qr;
}