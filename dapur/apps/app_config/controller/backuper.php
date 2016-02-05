<?php
/**
* @version		2.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2014 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.
**/

define('_FINDEX_','BACK');
session_start();
if(!isset($_SESSION['USER_LEVEL']) AND $_SESSION['USER_LEVEL'] > 2) die ();

require_once ('../../../system/jscore.php');

if(isset($_GET['type'])) {		
	if($_GET['type'] == 'database') {		
		@unlink("../../../../.backup/$_GET[file]");		
		if(!file_exists('../../../../.backup'))
			mkdir('../../../../.backup');			
		$date = md5(date("Ymd:His"));
		$file = "db-backup-$date";
		$c = backup_tables("*",'../../../../.backup',"$file",true);
		if($c) 		{
			$size = format_size(filesize("../../../../.backup/$file.sql"));
			$time = date("Y/m/d H:i:s",filemtime("../../../../.backup/$file.sql"));	
			$r = "$size - $time";
			echo "{ \"file\":\"$file.sql\" , \"info\":\"$r\" }";
			
		}
	}	
	if($_GET['type'] == 'table') {		
		@unlink("../../../../.backup/.table/$_GET[file]");		
		if(!file_exists('../../../../.backup'))
			mkdir('../../../../.backup');		
		if(!file_exists('../../../../.backup/.table'))
			mkdir('../../../../.backup/.table');		
		$date = md5(date("Ymd:His"));
		$file = "tbl-backup-$date";
		$c = backup_tables("$_GET[table]",'../../../../.backup/.table',"$file",true);
		if($c) 		{
			$size = format_size(filesize("../../../../.backup/.table/$file.sql"));
			$time = date("Y/m/d H:i:s",filemtime("../../../../.backup/.table/$file.sql"));	
			$r = "$size - $time";
			echo "{ \"file\":\"$file.sql\" , \"info\":\"$r\" }";
			
		}
	}
	if($_GET['type'] == 'installer') {		
		@unlink("../../../../.backup/$_GET[file]");
		$file = '../../../../system/installer.zip';
		$cfile = '../../../../config.php';
		$cfile2 = '../../../../_config.php';
		@copy($cfile,$cfile2);
		extractZip($file,'../../../../system');
		if(!file_exists('../../../../.backup'))
			mkdir('../../../../.backup');		
		backup_tables('*','../../../../system/installer','data',true);
		archiveZip('../../../../system/installer','../../../../system/installer.zip');
		$date = md5(date("Ymd:His"));
		$file = "installer-backup-$date.zip";
		$c = archiveZip('../../../../',"../../../../.backup/$file");
		@unlink("$cfile2");
		if($c) 		{
			$size = format_size(filesize("../../../../.backup/$file"));
			$time = date("Y/m/d H:i:s",filemtime("../../../../.backup/$file"));	
			$r = "$size - $time";
			echo "{ \"file\":\"$file\" , \"info\":\"$r\" }";			
		}
	}

	if($_GET['type'] == 'delete') {
		if($_GET['act'] == 'installer' || $_GET['act'] == 'db')	
		@unlink("../../../../.backup/$_GET[file]");
		
		if($_GET['act'] == 'tables')	
		@unlink("../../../../.backup/.table/$_GET[file]");		
	}
}

?>