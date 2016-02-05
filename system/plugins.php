<?php 
/**
* @version		2.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2014 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.txt
**/

defined('_FINDEX_') or die('Access Denied');


function loadPluginCss() {	
	$db = new FQuery();   
	$qr = $db->select(FDBPrefix.'plugin','*',"status=1");	
	foreach($qr as $qr){	
		$folder = "plugins/$qr[folder]/plg_css.php";
		if(file_exists($folder))
			include($folder);
	}	
}

function loadPluginJs() {	
	$db = new FQuery();   
	$qr = $db->select(FDBPrefix.'plugin','*',"status=1");	
	foreach($qr as $qr){	
		$folder = "plugins/$qr[folder]/plg_js.php";
		if(file_exists($folder))
			include($folder);
	}
}

//load active plugins
loadPlugin();