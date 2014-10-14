<?php
/**
* @version		2.0
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


$db 	= new FQuery();  

$cat = explode(",",$cat);
$c = '';
foreach ($cat as $idx => $qry ) {
	if($idx != 0)
		$c .= ' OR ';	
	$c .= "category=$qry";
}

if(function_exists('articleInfo')) :
$level	= Level_Access;
$date = articleInfo('date');
$sql = $db->select(FDBPrefix."article",'*',"status = 1 AND ($c) AND date < '$date' $level ","date DESC LIMIT 1");
$prev = mysql_fetch_array($sql);

$sql2 = $db->select(FDBPrefix."article",'*',"status = 1 AND ($c) AND date > '$date' $level","date ASC LIMIT 1");
$next = mysql_fetch_array($sql2);

$prev['link'] ="?app=article&view=item&id=$prev[id]";	
$prev['link']= make_permalink($prev['link']);
$next['link'] ="?app=article&view=item&id=$next[id]";
$next['link'] = make_permalink($next['link']);	


echo "<div class='article-nextprev'>";

if(!empty($prev['title'])) {
echo"<div class='prev'>
		<a href='$prev[link]'><span>< Prev</span> $prev[title]</a>
	</div>";
} else {
echo "
	<div class='prev'>
		<a><span>||</span></a>
	</div>";
}

if(!empty($next['title'])) {
echo "<div class='next'>
		<a href='$next[link]'>$next[title] <span>Next ></span></a>
	</div>";
} else {
echo "<div class='next'>
		<a><span>||</span></a>
	</div>";
}
echo "</div>";

else :

echo "Not found any article.";
endif;
?>

<script>
	$(function() {
		function main() {
		var p = $('.article-nextprev .prev').height();
		var n = $('.article-nextprev .next').height();
		if(p > n) n = p;
		$('.article-nextprev .prev').height(n);
		$('.article-nextprev .next').height(n);
		}
			main();
		$(window).resize(function() {
			main();
		});
	});
</script>