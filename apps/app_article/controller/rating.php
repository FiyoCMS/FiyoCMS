<?php
/**
* @version		2.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2014 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.txt
* @description	Article Rating
**/

session_start();
define('_FINDEX_',1);
require('../../../system/jscore.php');

if(!isset($_POST['id'])) { 
	alert('error','Access Denied!',true,true);
	die();
} 
else if(isset($_POST['do']) AND isset($_POST['id'])) {
	$id = (int)$_POST['id'];	
	$db = new FQuery();  
	$db->connect(); 	
	$qrs = $db->select(FDBPrefix.'article','parameter',"id=$id","",1);
	$qrs = $qrs[0];
		if($_POST['do']=='rate'){
			$rating = $_POST['rating'];
			$va = mod_param('rate_value',$qrs['parameter']);
			$rating += $va;
			$vo = mod_param('rate_counter',$qrs['parameter']);
			
			if(!is_numeric($vo) or !is_numeric($va)) $vo1 = 0;
			$vo1 = $vo+1;
			$param = $qrs['parameter'];
			
			$pva = strpos($param,"rate_value=$va");
			if($pva)		
				$param = str_replace("rate_value=$va","rate_value=$rating",$param);
			else		
				$param .= "rate_value=$rating".";\n";
				
				
			$pvo = strpos($param,"rate_counter=$vo");
			if($pvo)	
			$param = str_replace("rate_counter=$vo","rate_counter=$vo1",$param);
			else
				$param .= "rate_counter=$vo1".";\n";
			
			$param = strip_tags($param);
			$qr = $db->update(FDBPrefix.'article',array("parameter"=>"$param"),"id=$id"); 
			if($qr)		
				$_SESSION["article_rate_$id"] = true;
		}
		else if($_POST['do']=='getrate'){
			$va = mod_param('rate_value',$qrs['parameter']);
			$vo = mod_param('rate_counter',$qrs['parameter']);
			$rating = (@round($va / $vo,1)) * 20; 
			echo $rating;					
		}
		
}
