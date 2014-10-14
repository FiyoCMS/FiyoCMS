<?php 
/**
* @version		1.5.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2012 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.txt
* @description	
**/

define('_FINDEX_',1);

require_once ('../../../system/jscore.php');
$db = new FQuery();  
$db->connect(); 


$online = angka(FQuery('statistic_online'));
$total = angka(FQuery('statistic'));

$dtf = date('Y-m-d 00:00:00');
$today = angka(FQuery('statistic',"time >= '$dtf'","","","time ASC"));

$dtf = date('Y-m-d 00:00:00',strtotime("-1 Months"));
$month = angka(FQuery('statistic',"time >= '$dtf'","","","time ASC"));
	
$timer = time() - 300;
$db->delete(FDBPrefix.'statistic_online',"time < $timer");

echo "
{ \"today\":\"$today\" , \"month\":\"$month\", \"total\":\"$total\", \"online\":\"$online\" }";
