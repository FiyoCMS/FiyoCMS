<?php
/**
* @version		1.5.0
* @package		Article Tags
* @copyright	Copyright (C) 2012 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.txt
*/

defined('_FINDEX_') or die('Access Denied');

$db 	= new FQuery();  
$level	= Level_Access;
$tags	= '';
$qry = $db->select(FDBPrefix."article",'tags',"status = 1 AND tags != '' $level","RAND() LIMIT 50");
foreach($qry as $tag) {
	$tags .= $tag['tags'].",";
}

$tagz = explode(",",$tags);
sort($tagz);
$tags = $tagb = null;
foreach($tagz as $tag) {
	$size = rand(1,4);	
	$link = str_replace(" ","-","?app=article&tag=$tag");
	$link = make_permalink($link);
	$ltag = strtolower($tag);
	$tag = str_replace(" ","_",$tag);
	if(!empty($tag) AND $tag != $tagb)
	$tags .= "<a class='tag$size tag-$ltag' href='$link'>#$tag</a> ";		
	$tagb = $tag;			
}

echo "<div class='article-tags'>$tags</div>";