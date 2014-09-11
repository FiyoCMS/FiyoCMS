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
	$archveQuery = $db->select(FDBPrefix."article","*,DATE_FORMAT(date,'%m') as m,DATE_FORMAT(date,'%M') as mo,DATE_FORMAT(date,'%d-%b') as month,DATE_FORMAT(date,'%Y') as y"," $filter AND $catn","DATE DESC");
	$no = $x = 0;

	while($archveRow=mysql_fetch_array($archveQuery))
	{
		$link="?app=article&view=item&id=$archveRow[id]";	
				
		if(defined('SEF_URL'))
		{			
			$link = make_permalink($link);
		}
		else 
		{
			if(defined('Page_ID')) $_GET[id] = Page_ID;
			$link = "$link&pid=".Page_ID;	
			$link = "http://".FUrl.$link;
		}
		
		if($archveRow['date'] >= $start  AND $archveRow['date'] <= $end  )
		{
			$s = 0;
			$cats = explode(",","$cat");
			$coma = substr_count("$cat",",");
			$catx = $cato ='';
			foreach($cats  as $p ) {
				$s += FQuery('article',"date LIKE '%$archveRow[y]-$archveRow[m]%' AND status = 1 AND category = $p");
			}
				
			if(isset($m) AND $m != $archveRow['m'] ) {			
				echo "</ul></li></ul>";				
			}
			
			if(@$m != $archveRow['m'] ) { 
				$open ='';	
				if(app_param('app') == 'article' AND app_param('view') == 'item')
					if(substr(articleInfo('date'),0,7) == "$archveRow[y]-$archveRow[m]")
						$open = " open";			
				echo "
				<ul class='mod-article-archive'>
					<li class='archive-head'><a class='archive-head-a'>$archveRow[mo] $archveRow[y] ($s)</a>
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
				$x++;	
			}
			$m=$archveRow['m'];	
		}
	}
	//set m to null
	$m = 0;
	if($x==0)
		echo "Article not found";
}
?>