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
if(isset($_POST['config_save'])) {
	if(empty($_POST['web']) AND empty($_POST['timeout']) AND empty($_POST['ex_dir']) AND empty($_POST['ex_file']) AND empty($_POST['xml']) AND empty($_POST['txt'])) 
	{	
		notice('error','invalid');
	}			
	else	
	{	 
		$db->connect(); 		
		$qr=$db->update(FDBPrefix."sitemap_setting",array('value'=>"$_POST[web]"),"name='root_url'");
		$qr=$db->update(FDBPrefix."sitemap_setting",array('value'=>"$_POST[timeout]"),"name='timeout'");
		$qr=$db->update(FDBPrefix."sitemap_setting",array('value'=>"$_POST[ex_dir]"),"name='ex_dir'");
		$qr=$db->update(FDBPrefix."sitemap_setting",array('value'=>"$_POST[ex_file]"),"name='ex_file'");
		$qr=$db->update(FDBPrefix."sitemap_setting",array('value'=>"$_POST[xml]"),"name='xml'");
		$qr=$db->update(FDBPrefix."sitemap_setting",array('value'=>"$_POST[txt]"),"name='txt'");
		
			notice('success',Status_Applied);
			refresh();
	}
}

if(isset($_POST['save_crawler']) AND isset($_SESSION['CRAWLER_DATA'])) {
    $c = $_SESSION['CRAWLER_DATA'];
    if(!empty($c)) {
	$db->connect(); 
	$g = date("Y-m-d h:i:s");
	foreach($c as $h) { 
		if(oneQuery("sitemap","url","$h")) {
			$f = "UPDATE `".FDBPrefix."sitemap` SET `time`= '$g' WHERE `url` = '$h'";	
			$qr=$db->query($f);
		}
		else {
			$f = "INSERT INTO `".FDBPrefix."sitemap` (`id`,`url`,`time`) VALUES ('','$h','$g');";
                      
			$qr=$db->query($f);
		}
	}	
        if(isset($f)) {
            $qr=$db->delete(FDBPrefix."sitemap","time < '$g'");

            notice('success',Status_Saved);
            redirect("?app=sitemap");
        }
    }
}
                            