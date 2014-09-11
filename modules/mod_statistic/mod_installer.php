<?php
/**
* @version		v.1.2.0
* @package		Fi Tracker Module
* @copyright	Copyright (C) 2012 Fiyo CMS.
* @license		GNU/GPL
* @description	
**/


$sql = "CREATE TABLE IF NOT EXISTS `".FDBPrefix."tracker` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `ip` varchar(30) NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `info` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;";

$sql = fiyo_query($sql);

if($sql)
	$fail = "creat new table successfuly!";
else
	$fail = "Failed to creat new table (table already exists)!";
	
$module_info ='<img src="../modules/mod_tracker/images/logo.png" align="left" /><h1>Fi-Tracker successfuly installed</h1>Fi-Tracker dapat membantu anda untuk mengetahui jumlah pengunjung website anda.<br>Anda bisa mengaktifkan dan melakukan konfigurasi melaui <a href="?app=module" class="link">Module Manager</a>';
$module_info  .="<br>Installer information :<i> $fail </i>";
?>