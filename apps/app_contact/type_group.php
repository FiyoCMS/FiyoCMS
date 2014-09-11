<?php
/**
* @version		Beta 1.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2011 Fiyo CMS.
* @license		GNU/GPL, see liCENSE.php
* @description	mengolah data JQuery untuk mendapatkan nilai dari kategori
**/

$cat=$_GET[cat];
$vw=$_GET[view];

require('../../config.php');
require('../../system/query.php');

$db = new FQuery();  
$db->connect(); 
$db->select('app_store_category','*',"id='$cat'"); 
$qr = $db->getResult(); 
echo "?app=app_store&cat=$qr[id]&view=$vw";
?>
