<?php
/**
* @name			Module Statistic
* @version		1.5.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2012 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.txt
*/

defined('_FINDEX_') or die('Access Denied');

require_once ("./plugins/plg_statistic/browser.php");

//get guest IP
if(!empty($_SERVER['REMOTE_ADDR'])) $ip =  $_SERVER['REMOTE_ADDR'];
//get timestamp
$date = date("Y-m-d"); 
$time = date("H:i:s"); 

if($ip =='::1' or $ip =='127.0.0.1' ) $ip = "localhost";

$html	=	'';
$html	.=	"IP : $ip <br> Browser : ";
$browser = _browser();
if (!empty( $browser )){
	$html	.=	( $browser['browser'] == "Msie" ? "Internet Explorer":ucwords($browser['browser']) );
	$html	.= " ";
	$html	.= $browser['version'];
	$html	.= "<br>Platform : ";
	$html	.= ucwords($browser['platform']) ;
	$html		.= "<br /> ";
	$html		.= "Online Visitors : ";
	$html	.= FQuery("statistic_online") ;
	$html		.= "<br /> ";
}

/****************************************/
/*			  Make New Date	 			*/
/****************************************/ 
function mkdate($day = null, $month = null, $year = null) {
	return date("Y-m-d", mktime(0,0,0,date("m")+$month,date("d")+$day,date("Y")+$year));
}

/****************************************/
/*			Check statistic Today			*/
/****************************************/ 		
//get database statistic
function valday($date) {	
	return FQuery('statistic',"time BETWEEN  '$date 00:00:00' AND  '$date 23:59:59'");
}

function valmonth($x) {
	$x = substr($x,0,7);
	$val = 0;
	$db = new FQuery();  
	$db ->connect(); 
	$sql = $db->select(FDBPrefix.'statistic','*');
	while($qr=mysql_fetch_array($sql)) {
		$month = substr($qr['time'],0,7);
		if($month == $x)
			$val ++;
	}
	return $val;	
}



// Daily controller
$today 		= valday(mkdate());
if($today < 1) $today = 1;
$yesterday	= valday(mkdate(-1));

// Weekly controller
$lastweek 	= 0;
for($i=7; $i< 14; $i++)
	$lastweek += valday(mkdate(-$i));

$thisweek	= 0;
for($i=0; $i< 7; $i++)
	$thisweek += valday(mkdate(-$i));
	
	
// Monthly controller
$thismonth = valmonth(mkdate());
$lastmonth = valmonth(mkdate(-31));


// Total controller
$total = FQuery('statistic');
