<?php
/**
* @version		2.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2014 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.
**/

//set single flag file
define('_FINDEX_','BACK');

//load query and function files
require_once ('../../../system/jscore.php');

//logical for image spot and auto fill
$name = siteConfig('site_theme');
$html = file_get_html("../../../../themes/$name/index.php");
$pos = str_replace("<?=loadModule('","{",$html);
$pos = str_replace("loadModule('","{",$html);
$pos = str_replace("loadModule(\"","{",$pos);
$pos = str_replace("')","}",$pos);
$pos = str_replace("\")","}",$pos);
	
preg_match_all('/\{(.*?)\}/',$pos,$position); 
if(!empty($position[1])) {
	$no = 1;
	foreach($position[1] as $val) {
		if($no != 1) echo ",";
		echo "$val";
		$no++;
	}
}	
