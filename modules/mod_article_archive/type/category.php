<?php
/**
* @version		1.5.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2012 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.txt
**/

defined('_FINDEX_') or die('Access Denied');

$cat = mod_param('cat',$modParam);
$end = mod_param('end',$modParam);
$start = mod_param('start',$modParam);

if(!$cat) 
	echo "Error::please set up your <b>Article Archive</b> module!";
else {
	if(!$start) $start = "1000-1-1";
	if(!$end) $end = date("Y-m-d");
	$cats = explode(",","$cat");
	$coma = substr_count("$cat",",");
	$no = 1;
	$catx = $cato ='';
	
	foreach($cats  as $p ) {
		if($no != $coma+1)
			$cato = "category=$p or ";
		else
			$cato = "category=$p";		
		$catx .= $cato;
		$no++;
	}
	
	if($cat) $catn = "$catx"; else $catn = "";
	$filter = "date >= $start";
	$archveQuery = $db->select(FDBPrefix."article","*,DATE_FORMAT(date,'%m') as m,DATE_FORMAT(date,'%M') as mo,DATE_FORMAT(date,'%d-%b') as month,DATE_FORMAT(date,'%Y') as y"," $filter AND $catn","category ASC");
	$no = $x = 0;

	while($archveRow=mysql_fetch_array($archveQuery))
	{		
		$link="?app=article&view=item&id=$archveRow[id]";	
		$link = make_permalink($link);		
		if($archveRow['date'] >= $start  AND $archveRow['date'] <= $end  )
		{							
			$catname = oneQuery('article_category','id',"$archveRow[category]",'name');
			$s = FQuery('article',"category = $archveRow[category] AND status = 1");
				
			if(isset($m) AND $m != $archveRow['category'] ) {
				echo "</ul></li></ul>";				
			}			
			
			if(@$m != $archveRow['category'] ) {	
				$open ='';
				if(app_param('app') == 'article' AND (app_param('view') == 'category' or app_param('view') == 'item'))
					if(articleInfo('category') == "$archveRow[category]")
						$open = " open";
				echo "
				<ul class='mod-article-archive'>
					<li class='archive-head'><a class='archive-head-a'>$catname  ($s)</a>
				<ul class='archive-list$open'>";
			}						
			if($archveRow['status']==1) {
				$active = '';
				if(app_param('app') == 'article' AND app_param('view') == 'item')
					if(articleInfo('id') == "$archveRow[id]")
						$active = "active";
				$article ="<a title='Read \"$archveRow[title]\"' href='$link' class='$active'>$archveRow[title]</a>";
				echo "<li>$article</li>";	
				$x++;		
			}
			$m=$archveRow['category'];	
		}
	}
	//set m to null
	$m = 0;
	if($x==0)
		echo "Article not found";
}
?>