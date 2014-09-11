<?php
/**
* @version		2.0
* @package		Fiyo CMS Installer
* @copyright	Copyright (C) 2014 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.
**/

defined('_FINDEX_') or die('Access Denied');

$file_name = "_config.php";
if(!file_exists($file_name))
{
	$file = "system/installer/_config.php";
	@copy($file,'../');
} else if(!isset($_POST['step_1'])) {			
	include ("_config.php");							
	$_POST['dbase'] = $DBName;
	$_POST['host'] = $DBHost;
	$_POST['user'] = $DBUser;
	$_POST['pass'] = $DBPass;
	$_POST['prefix'] = $DBPrefix;		
}

if(isset($_POST['step_1']) AND empty($_SESSION['host']))
{
	$user = $_POST['user'];
	$pass = stripslashes($_POST['pass']); 
	$conn = @mysql_connect($_POST['host'],"$user","$pass");
	if($conn)
	{	
		if($_POST['host'] == 'localhost') $_POST['host'] = '127.0.0.1';
	
		$createDB = false;	
		if(($_SERVER['SERVER_ADDR'] == '127.0.0.1' or $_SERVER['SERVER_ADDR'] == '::1')) {
			if(isset($_POST['overwrite'])) {
				if(mysql_select_db("$_POST[dbase]"))
					$createDB = true;
			} else
				$createDB = mysql_query("CREATE DATABASE $_POST[dbase]");		
		}
		else 
			$createDB = true;	
		if($createDB)
		{	
			notice('success',"Database has been successfully connected!");	
			refresh();
			
			$fo = @fopen($file_name,"w+");
			$s = fgets($fo,6);
			$text = ("<?php
/**
* @version		2.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2014 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.txt
* @description 	Database Configuration.
**/

\$DBName	= '$_POST[dbase]';
\$DBHost	= '$_POST[host]';
\$DBUser	= '$_POST[user]';
\$DBPass	= '$_POST[pass]';
\$DBPrefix	= '$_POST[prefix]';");
		
			rewind($fo);
			fwrite($fo,$text);
			$conn = fclose($fo);
			
			$db = @mysql_select_db($_POST['dbase']);	
			if($db)		
			{
				$_SESSION['host']=$_POST['host'];
				$_SESSION['base']=$_POST['dbase'];
				$_SESSION['user']=$_POST['user'];
				$_SESSION['pass']=$_POST['pass'];
				$_SESSION['prefix']=$_POST['prefix'];
				
			notice('success',"Database has been successfully connected!",3);	
			notice('success',"Database has been successfully connected!");	
			}
			else
			{
				notice('error',"User can't access the database!",3);
			}
		}
		else
		{
			notice('error','The database name is invalid or exists!',3);
		}
		
	}
	else
	{
		notice('error','Username or password database invalid!',3);
	}
}

if(isset($_POST['step_-1'])) {
	$_SESSION['success'] = "";
	$_SESSION['host'] = "";
}

if(isset($_POST['step_2']))
{ 
	if(!empty($_POST['site']) or !empty($_POST['username']) or !empty($_POST['email']) or !empty($_POST['userpass']))
	{			
		$nama_file = "system/installer/data.sql";
		$open_file = @fopen($nama_file,"a+");
		if($open_file) 
		{
			while(!feof($open_file))
			{
				$data=fgets($open_file,50);
				@$file.=$data;
			}
			
			require('_config.php');
			require('system/query.php');
			$db = new FQuery();  
			$db->connect();		
			$mod = explode("--",$file);
			$go = null;
			foreach($mod as $val) 
			{	
				$val=str_replace("db_prefix_",FDBPrefix,$val);
				$val=str_replace("_site_title","$_POST[site]",$val);				
				$val=str_replace("_site_desc","$_POST[desc]",$val);				
				$go = $db->query("$val");
			}
			fclose($open_file);
		}	
			
		if($go)
		{ 	
			notice('success',"SQL Query successfully!",3);
			refresh();
		} 
		
		if(preg_match('/^.+@.+\\..+$/',$_POST['email']))
		{
			$qr=$db->insert(FDBPrefix.'user',array("","$_POST[username]","Administrator",MD5("$_POST[userpass]"),"$_POST[email]","1","1",date('Y-m-d H:i:s'),date('Y-m-d H:i:s'),"")); 
			if($qr) {
				$_SESSION['user'] = "$_POST[username]";
				$_SESSION['host'] = "";
				$_SESSION['success']=1;
				
			} 
		}
		else
		{
			notice('error',"Email or User are invalid!",2);
		}
	}
	else
		notice('error',"Please fill the fields correctly!",2);
}

if(isset($_POST['admin']))
{ 		
	session_destroy();
	rename("_config.php","config.php");	
	header("location:dapur");
}
else if(isset($_POST['home']))
{ 	
	session_destroy();
	rename("_config.php","config.php");
	header("location:#");
}
function InsUrl() {
	$InsUrl = str_replace('index.php','',$_SERVER["HTTP_HOST"].$_SERVER["PHP_SELF"]);
	if(_FINDEX_=='BACK') {
		$jurl = substr_count($InsUrl,"/")-1;
		$ex = explode("/",$InsUrl);
		$no = 1 ;
		$InsUrl = '';
		foreach($ex as $b) {$InsUrl .= "$b/";  if($no==$jurl) break; $no++;}	
	}
	else {
		$InsUrl= $InsUrl;
	}
	return "http://$InsUrl";
}


//status informasi pada saat eksekusi database
function alert($type , $text){
	$alert = "<div class='alert $type'>$text</div>";	
	echo $alert;
}

      
function notice($type , $text, $num = 0) {
	$_SESSION['NOTICE'] = alert($type , $text);
	$_SESSION['num'] = $num;
}


function formRefill($input_name, $val=null, $txt=null) {	
	if(isset($_POST["$input_name"]) AND empty($val)) 
		$val = $_POST["$input_name"];
	if(isset($_POST["$input_name"]) or !empty($val))  {
		if($txt == "textarea")
			echo "$val"; 
		else
			echo "value=\"$val\""; 		
	}	
}

function printAlert($name = null, $ref = false) {
	if(empty($name)) $name = 'NOTICE';
	if($ref) $_SESSION['num'] = 0;
	if(!empty($_SESSION[$name])){ 
		if(empty($_SESSION['num']) or !isset($_SESSION['num']) AND !$ref) $_SESSION['num'] = 1; 
		if(!empty($_SESSION['num']) AND isset($_SESSION['num']) AND !$ref) $_SESSION['num'] += 1;
		if((!$ref AND $_SESSION['num'] > 2) or $ref or $name == 'NOTICE_REF') {
			echo $_SESSION[$name]; 
			$_SESSION['num'] = 0;
			$_SESSION[$name]= null; 
		}		
	}
} 

function getUrl() {
	$url = $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
	$url = str_replace("'","",$url);
	if(!empty($_SERVER['HTTPs']))
		$url = "https://".$url;
	else
		$url = "http://".$url;
	return	$url;
}		

function refresh() {
	header("location:".getUrl());
}