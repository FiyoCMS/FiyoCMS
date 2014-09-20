<?php
/**
* @version		2.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2012 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.php
**/

//set mulai session
session_start();
//mendefinisikan _FINDEX_ sebagai halaman utama
define('_FINDEX_', 'BACK' );

$start_time = microtime(TRUE);
define('_START_TIME_', $start_time );

$sn = substr($_SERVER['PHP_SELF'],1);
$sm = strpos($sn,'/');
$sm = substr($sn,0,$sm);

define('_ADMINPANEL_', $sm );


//mengecek file konfigurasi
if(!file_exists('../config.php')) 
	header("location:../");
	
//memuat file pendukung query dan fungsi lainya
require_once ('system/core.php');

//melakukan pengecekan login AdminPanel
check_backend_login();

