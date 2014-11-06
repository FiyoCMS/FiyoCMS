<?php
/**
* @version		2.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2014 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.txt
* @description	Statistic
**/

session_start();
define('_FINDEX_',1);
if($_SERVER['REQUEST_METHOD'] != 'POST') {
	die("Access Denied!");
} else {
//load file
require('../../../system/jscore.php');
require ('../browser.php');

//get ip
$ip = getIP();
if(!empty($_SERVER['REMOTE_ADDR'])) $ip =  $ip;
if(!checkLocalhost()) {
	$url = 'http://freegeoip.net/json/';
	$content = file_get_contents($url);
	$json = json_decode($content, true);
	$country = $json['country_name'];
	$city  = $json['city'];
	$timeZone = $json['timezone'];


} else {
	$country	= "Local"."";
	$city 		= "Local"."";
	$timeZone 	= siteConfig('timezone')."";
}

$browser 	= _browser();
$platform	= ucfirst($browser['platform']);
$browser 	= ucfirst($browser['browser']);

//get timestamp

//get user id
$userId	= USER_ID;	

$time 	= date("Y-m-d H:i:s"); 
$date 	= date("d"); 

//set visitor online
if (!isset($_SESSION['VISIT_SESSION_CREATED'])) {	
    $key  = $_SESSION['VISIT_SESSION_KEY'] = md5($ip.getUrl().$time);
    $time = $_SESSION['VISIT_SESSION_CREATED'] = time();  // update creation time
	$db->insert(FDBPrefix.'statistic_online',array("","$ip",getUrl(),"$time","$browser","$platform","$country","$city","$key"));
} 
else if (time() - $_SESSION['VISIT_SESSION_CREATED'] > 300) {
	$key  = $_SESSION['VISIT_SESSION_KEY'] = md5($ip.getUrl().$time);
    $time = $_SESSION['VISIT_SESSION_CREATED'] = time();  // update creation time
	$db->insert(FDBPrefix.'statistic_online',array("","$ip",getUrl(),"$time","$browser","$platform","$country","$city","$key"));	
	
}

	
$time 	= date("Y-m-d H:i:s"); 
//update session_online
$url = getUrl();
$db->update(FDBPrefix.'statistic_online',array("url"=>"$url"), "`key` = '".$_SESSION['VISIT_SESSION_KEY']."'");
$timer = time() - 300;
$db->delete(FDBPrefix.'statistic_online',"time < $timer");
$_SESSION['VISIT_SESSION_URL'] = getUrl();

//update session visitor
if(!isset($_SESSION['VISIT_SESSION_DAY']) or $date != @$_SESSION['VISIT_SESSION_DAY']) {	
    $_SESSION['VISIT_SESSION_DAY'] = $date;	
	$db->insert(FDBPrefix.'statistic',array("","$ip","$_SESSION[USER_ID]","$time","$browser","$platform","$country","$city"));
    $_SESSION['VISIT_SESSION_DAILY'] = time();
}
else if (!isset($_SESSION['VISIT_SESSION_DAILY'])) {	
	$db->insert(FDBPrefix.'statistic',array("","$ip","$_SESSION[USER_ID]","$time","$browser","$platform","$country","$city"));
    $_SESSION['VISIT_SESSION_DAILY'] = time();
} 
else if (time() - $_SESSION['VISIT_SESSION_DAILY'] > 7200) {
	$db->insert(FDBPrefix.'statistic',array("","$ip","$_SESSION[USER_ID]","$time","$browser","$platform","$country","$city"));
	$_SESSION['VISIT_SESSION_DAILY'] = time();	
}

//set visitor timezone
@date_default_timezone_set($visitor_location['LocalTimeZone']);
}

function getIP() {
        $ipaddress = '';
        if(isset($_SERVER['HTTP_CF_CONNECTING_IP'])) {
            $ipaddress =  $_SERVER['HTTP_CF_CONNECTING_IP'];
        } else if (isset($_SERVER['HTTP_X_REAL_IP'])) {
            $ipaddress = $_SERVER['HTTP_X_REAL_IP'];
        }
        else if (isset($_SERVER['HTTP_CLIENT_IP']))
            $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
        else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        else if(isset($_SERVER['HTTP_X_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
        else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
        else if(isset($_SERVER['HTTP_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_FORWARDED'];
        else if(isset($_SERVER['REMOTE_ADDR']))
            $ipaddress = $_SERVER['REMOTE_ADDR'];
        else
            $ipaddress = 'UNKNOWN';

    return $ipaddress;
}

?>