<?php
/**
* @version		1.5.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2012 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.txt
**/

defined('_FINDEX_') or die('Access Denied');

$type 	= mod_param('type',$modParam);
$item 	= mod_param('item',$modParam);
$info 	= mod_param('info',$modParam);
$other 	= mod_param('other',$modParam);
$value 	= mod_param('value',$modParam);
$filter = mod_param('filter',$modParam);

if($item=="" or empty($item)) $item = 5;
else if($type==1) $type = "date DESC";
else if($type==2) $type = "hits DESC";
	
if($filter==0) $filter = "1";
else if($filter==1) $filter = "category = $value";
else if($filter==2) $filter = "author_id = $value";
$db = new FQuery();  
$db->connect(); 	
$level 	= Level_Access;
if(!empty($filter) or !empty($filter) or !empty($filter)) :
$sql = $db->select(FDBPrefix."article",'*',"$filter $level AND status=1","$type LIMIT $item");
	
echo '<ul class="mod-article-list">';
foreach($sql as $qr){	
	$link="?app=article&view=item&id=$qr[id]";	
	if(defined('SEF_URL')){			
		$link = make_permalink($link);
	}
	else {
		if(defined('Page_ID')) $_GET['id'] = Page_ID;
		$link = "$link&pid=".Page_ID;			
		$link = FUrl.$link;
	}
	$date = "$qr[date]";
	$month = substr($date,5,2);
	$day = substr($date,8,2);
	$year = substr($date,2,2);
	$article ="<div class='title'><a title='$qr[title]' href='$link'>$qr[title]</a></div>";
	$date = "<div class='mod-article-date'><div>$day<span>$month/$year</span></div></div>";				
	if($type=="hits DESC") {
	$h = $qr['hits'];
	if($h > 900) {
		$h = $h / 1000;
		$h = substr($h,0,3);
		$c = substr($h,2);
		if($c == 0)	
			$h = substr($h,0,1);
		$h = $h."k";	
	}
	
	$date = "<div class='mod-article-date'><div>$h<span>HITS</span></div></div>";		
		}
	
	
	if($info) $date = $date; else $date = '';
	if(!empty($date))
	echo "<li class='no-list'>$date $article </li>";
	else
	echo "<li>$date $article </li>";
}	
	$link="?app=article&view=category&id=$value";	
	$link = make_permalink($link);
	
	if($other)
	echo "<li><a title='berita lainya' href='$link' class='more tooltip'>Berita Lainya</a></li>";
echo "</ul> ";	

else :
echo "Please check <b>article_list</b> parameter!";	

endif;
echo "";
?>
