<?php
/**
* @version		2.0
* @package		Related Article
* @copyright	Copyright (C) 2012 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.txt
*/

defined('_FINDEX_') or die('Access Denied');

$height	= mod_param('height',$modParam);
$limit	= mod_param('limit',$modParam);
$limitd = mod_param('limit',$modParam)+10;
$filter = mod_param('filter',$modParam);
$cat 	= mod_param('cat',$modParam);


$db 	= new FQuery();  

$cat = explode(",",$cat);

$next = $prev = $c = null;
foreach ($cat as $idx => $qry ) {
	if($idx != 0)
		$c .= ' OR ';	
	$c .= "category=$qry";
}

if(function_exists('articleInfo')) :
$level	= Level_Access;
$date = articleInfo('date');
$prev  = $db->select(FDBPrefix."article",'*',"status = 1 AND ($c) AND date < '$date' $level ","date DESC LIMIT 1");
$next = $db->select(FDBPrefix."article",'*',"status = 1 AND ($c) AND date > '$date' $level","date ASC LIMIT 1");

if(isset($prev[0])) {
	$prev = $prev[0];
	$prev['link'] ="?app=article&view=item&id=$prev[id]";	
	$prev['link']= make_permalink($prev['link']);
}
if(isset($next[0])) {
	$next = $next[0];	
	$next['link'] ="?app=article&view=item&id=$next[id]";
	$next['link'] = make_permalink($next['link']);	
}

echo "<div class='article-nextprev'>";

if(!empty($prev['title'])) {
echo"<span class='prv'>&laquo;</span><div class='prev'>
		<a href='$prev[link]'> $prev[title]</a>
	</div>";
} else {
echo "
	<div class='prev'>
		<em>||</em>
	</div>";
}

if(!empty($next['title'])) {
echo " <span>&raquo;</span><div class='next'>
		<a href='$next[link]'>$next[title]</a>
	</div>";
} else {
echo "<div class='next'>
		<em>||</em>
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
		var a = $('.article-nextprev').height();
		var n = $('.article-nextprev .next').height();
		var p = $('.article-nextprev .prev').height();
		nn = (a -n)/2;
		pn = (a -p)/2;
		if(a<= 60) a = 30;
		else if(a<= 80) a = 60;
		$('.article-nextprev span').css("top",a/3);
		$('.article-nextprev .next').css("margin-top",nn);
		$('.article-nextprev .prev').css("margin-top",pn);
		}
		main();
		$(window).resize(function() {
			main();
		});
	});
</script>
