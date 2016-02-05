<?php
/**
* @version		2.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2014 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.
**/

session_start();
if(@$_SESSION['USER_LEVEL'] > 5 or !isset($_POST['id'])) die ('Access Denied!');
define('_FINDEX_','BACK');
require('../../../system/jscore.php');
$g = date("Y-m-d h:i:s");
$qr = $db->update(FDBPrefix."sitemap",array("$_POST[type]"=>"$_POST[val]","time"=>"$g"),"id = $_POST[id]");
if($qr) echo alert("success",Status_Applied);

?>