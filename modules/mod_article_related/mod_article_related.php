<?php
/**
* @version		1.5.0
* @package		Related Article
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

$thumbW = 100 / $limit ;

$db 	= new FQuery();  
$db->connect(); 	
$level	= Level_Access;
if(app_param() == 'article') :
$t 	= @articleInfo($filter);
$t 	= str_replace("'",'',$t);
$t 	= str_replace('"','',$t);
$t 	= str_replace('%','',$t);
$t 	= str_replace('?','',$t);
$q 	= explode(" ",$t);
$z 	= $c = '';

foreach ($q as $idx => $qry ) {
	if($idx != 0)
		$z .= '+';
	$z .= "$qry";
}
$z = "`article` LIKE '%$z%'";

$cat = explode(",",$cat);
foreach ($cat as $idx => $qry ) {
	if($idx != 0)
		$c .= ' OR ';	
	$c .= "category=$qry";
}

$sql = $db->select(FDBPrefix."article",'*',"status = 1 AND $c AND $z $level","RAND() LIMIT $limitd");
	
echo "<ul id='article-related'>";
$x = 0;
foreach($sql as $qr) {
	if($x >= $limit) break;
	$link="?app=article&view=item&id=$qr[id]";	
	if(defined('SEF_URL')){
		$link = make_permalink($link);
	}
	else {
		if(defined('Page_ID')) $_GET['id'] = Page_ID;
		$link = "$link&pid=".Page_ID;			
		$link = FUrl.$link;
	}
	
	$img ='';
	$opentag = strpos($qr['article'],"<img");
	if($opentag) {
		$closetag = substr($qr['article'],$opentag);
		$closetag = strpos($closetag,">");
		$image = substr($qr['article'],$opentag,$opentag+$closetag);
		$a = strpos($image,'src="');
		if(empty($a)) $a = strpos($image,"src='");
			$b = substr($image,$a+5);					
			$c = strpos($b,'"');
		if(empty($c))$c = strpos($b,"'");
			$img =  substr($image,$a+5,$c);					
	}
		
	if(checkLocalhost()) {
		$img = str_replace(FLocal."media/","media/",$img);
		$img = str_replace("/media/",FUrl."media/",$img);				
	}
	$img = str_replace("/media","/media/.thumbs",$img);
	
	if(!empty($img))
	$img = "<img src='$img' width='".$thumbW."' alt='$qr[title]'/>";
	if(!$showImg) $img = ''; 
	
	
	if($showImg) {
		$article ="<div class='related-title' ><a title='$qr[title]' href='$link'>$img$qr[title]</a></div>";
		echo "<li style='width:".$thumbW."%; min-height:".$height."px' class='related-img'>$article</li>";
	}
	else
		echo "<li><a title='$qr[title]' href='$link'>$img$qr[title]</a></li>";
	$x++;
}
echo "</ul>";
else :	
echo "";	
endif;	

