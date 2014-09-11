<?php
/**
* @version		1.5.0
* @package		Article Tags
* @copyright	Copyright (C) 2012 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.txt
*/

defined('_FINDEX_') or die('Access Denied');

$height	= mod_param('height',$modParam);
$thumbW = mod_param('thumbW',$modParam);
$thumbH = mod_param('thumbH',$modParam);
$limit	= mod_param('limit',$modParam);
$limitd = mod_param('limit',$modParam)+10;
$filter = mod_param('filter',$modParam);
$cat 	= mod_param('cat',$modParam);
$showImg = mod_param('showImg',$modParam);


$db 	= new FQuery();  

$level	= Level_Access;
$tags = '';
$sql = $db->select(FDBPrefix."article",'tags',"status = 1 AND tags != '' $level","RAND() LIMIT 50");
while($tag = mysql_fetch_array($sql)) {
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
	
	if(!empty($tag) AND $tag != $tagb)
	$tags .= "<a class='tag$size tag-$ltag' href='$link'>$tag</a> ";		
	$tagb = $tag;			
}

echo "<div class='article-tags'>$tags</div>";







