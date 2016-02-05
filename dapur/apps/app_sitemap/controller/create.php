<?php
/**
* @version		2.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2014 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.
**/

session_start();
if(@$_SESSION['USER_LEVEL'] > 5 or !isset($_POST['type'])) die ('Access Denied!');
define('_FINDEX_','BACK');
require('../../../system/jscore.php');

$sql 	= $db->select(FDBPrefix.'sitemap_setting','*'); 
$row 	= $sql[0];
$xml 	= oneQuery("sitemap_setting","name","xml","value");
$txt 	= oneQuery("sitemap_setting","name","txt","value");

if($_POST['type'] == "xml") {
/****************************************/
/*				XML Sitemap 			*/
/****************************************/
	$fo = fopen("../../../../$xml","w");
	$sql = $db->select(FDBPrefix.'sitemap','*',"","url ASC");	
	$xml = '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';				
	foreach($sql as $row){	
		if($row['freq'] == 0) {
			$p = "never";
		} else if($row['freq'] == 1) {
			$p = "mothly";		
		} else if($row['freq'] == 2) {
			$p = "weekly";			
		} else if($row['freq'] == 3) {
			$p = "dayly";		
		} else if($row['freq'] == 4) {
			$p = "hourly";		
		} else if($row['freq'] == 5) {
			$p = "always";		
		} else if($row['freq'] == 6) {
			$p = "yearly";		
		}
		$d = substr($row['time'],0,10);
		$xml .= "<url>
			<loc>$row[url]</loc>
			<lastmod>$d</lastmod>
			<changefreq>$p</changefreq>
			<priority>$row[priority]</priority>
	   </url>";   
		}
	$xml .= '</urlset>';
	fputs($fo, $xml);
	fclose($fo);
	echo alert("success","File successfully created ");
} else {
/****************************************/
/*				TXT Sitemap 			*/
/****************************************/
	$txt = oneQuery("sitemap_setting","name","txt","value");
	$fo = fopen("../../../../$txt","w");
	$sql = $db->select(FDBPrefix.'sitemap','*',"","url ASC");		
	$txt = null;		
	foreach($sql as $row){
		$txt .= "$row[url]\n";
	}
	fputs($fo, $txt);
	fclose($fo);
	echo alert("success","File successfully created ");
}

?>