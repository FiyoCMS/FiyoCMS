<?php
/**
* @version		1.5.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2012 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.php
**/

defined('_FINDEX_') or die('Access Denied');

if(isset($_POST['install'])) {
	$zip = new ZipArchive;
    $res = $zip->open('system/installer.zip');
    if ($res === TRUE ) {
		$zip->extractTo(__dir__);
        $zip->close();
	}
}

$furl = str_replace('index.php','',$_SERVER["HTTP_HOST"].$_SERVER["PHP_SELF"]);
if(_FINDEX_=='BACK') {
	$jurl = substr_count($furl,"/")-1;
	$ex = explode("/",$furl);
	$no = 1 ;
	$FUrl = '';
	foreach($ex as $b) {$FUrl .= "$b/";  if($no==$jurl) break; $no++;}	
}
else {
	$FUrl= $furl;
}

$FUrl = str_replace("www.","",$FUrl);	
$url = $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
$url = str_replace("'","",$url);
	
if($url !== $FUrl) header("location:http://$FUrl");

$file = "system/installer/index.php";

if(file_exists($file)) {
	include($file);
}
else {
	echo "<div style='border: 2px solid #09f; font-size: .8em; font-family: Arial;background: #FCF0F0;border: 2px solid #F07272;padding: 10px;'><form action='' method='POST' style='margin:0 0 2px;'>
	Configuration file (<b>config.php</b>) is not found! Please upload config.php file or start <input type='submit' value='new installation' name='install'>
	</form></div>";
}
