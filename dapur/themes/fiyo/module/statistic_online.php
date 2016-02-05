<?php 
/**
* @version		2.0.2
* @package		Fiyo CMS
* @copyright	Copyright (C) 2015 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.txt
**/

session_start();
if(!isset($_SESSION['USER_ID']) or !isset($_SESSION['USER_ID']) or $_SESSION['USER_LEVEL'] > 3) die();
define('_FINDEX_','BACK');

require_once ('../../../system/jscore.php');

$so = FDBPrefix."statistic_online";
$row = $db->select("$so","COUNT(*) AS val");
$online = angka($row[0]['val']);

$st = FDBPrefix."statistic";
$row = $db->select("$st","COUNT(*) AS val");
$total = angka($row[0]['val']);

$dtf = date('Y-m-d 00:00:00');
$row = $db->select("$st","COUNT(*) AS val","time >= '$dtf'");
$today = angka($row[0]['val']);

$dtf = date('Y-m-d 00:00:00',strtotime("-1 Months"));
$row = $db->select("$st","COUNT(*) AS val","time >= '$dtf'");
$month = angka($row[0]['val']);
	
$timer = time() - 300;
$db->delete(FDBPrefix.'statistic_online',"time < $timer");

echo "
{ \"today\":\"$today\" , \"month\":\"$month\", \"total\":\"$total\", \"online\":\"$online\" }";
