<?php
/**
* @name			Plugin Statistic
* @version		1.5.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2012 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.txt
* @description	
**/

defined('_FINDEX_') or die('Access Denied');
if(!isset($_GET['theme'])) {
$timezones = DateTimeZone::listAbbreviations();

$cities = array();
foreach( $timezones as $key => $zones )
{
    foreach( $zones as $id => $zone )
    {
        /**
         * Only get timezones explicitely not part of "Others".
         * @see http://www.php.net/manual/en/timezones.others.php
         */
        if ( preg_match( '/^(America|Antartica|Arctic|Asia|Atlantic|Europe|Indian|Pacific)\//', $zone['timezone_id'] ) )
            $cities[$zone['timezone_id']][] = $key;
    }
}

// For each city, have a comma separated list of all possible timezones for that city.
foreach( $cities as $key => $value )
    $cities[$key] = join( ', ', $value);

// Only keep one city (the first and also most important) for each set of possibilities. 
$cities = array_unique( $cities );

// Sort by area/city name.
ksort( $cities );


//geo statistic
$country = $city = 'other';


//browser details
require ("browser.php");
require ('ip.codehelper.io.php');



//get ip
$_ip = new ip_codehelper();

// Detect Real IP Address & Location
$ip = $_ip->getRealIP();
if(!empty($_SERVER['REMOTE_ADDR'])) $ip =  $ip;
if(!checkLocalhost()) {

$visitor_location = $_ip->getLocation($ip);
// Output result
$country	= $visitor_location['CountryName']."";
$city 		= $visitor_location['CityName']."";
$timeZone 	= $visitor_location['LocalTimeZone']."";
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