<?php 
/**
* @version		1.5.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2012 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.txt
**/

defined('_FINDEX_') or die('Access Denied');

class searchArticle {	
	function item($q,$menuId) {	
		/* Call new FQuery */
		$db = new FQuery();  
		$db->connect(); 
		
		/* Set Access_Level */
		$accessLevel = Level_Access;	
			
		$q = str_replace("'","",$q);
		$q = str_replace("/","",$q);
		$q = str_replace("\\","",$q);
		$q = str_replace('"',"",$q);
		$q = str_replace('  '," ",$q);
		
		if(empty($q)){
			$q = $_SESSION['search'];
		}
		
		
		/* Call new paging */
		loadPaging();
		$paging = new paging();
		$rowsPerPage = 10;
		$keyword = trim($q);//remove space before and after
				
		$article	= explode_query($q , 'article');
		$title		= explode_query($q , 'title');
		$author 	= explode_query($q , 'author');
		$tag 		= explode_query($q , 'tags');
		
		$condition 	= "$article $title $author $tag";
		$user 		= FQuery('user',"`name` LIKE  '%$q%'",'id');
		
		/* Check total article by query */
		FQuery('article',"status=1 AND (`author_id` ='$user' $condition) $accessLevel");
		$total = mysql_affected_rows();
		
		/* paging query */
		$result=$paging->pagerQuery(FDBPrefix.'article',"*,DATE_FORMAT(date,'%d %M %Y') as date,DATE_FORMAT(date,'%Y-%m-%d %H:%i:%s') as order_date",
		"status=1 AND (`author_id` ='$user' $condition) 
		$accessLevel",'order_date DESC',$rowsPerPage);
		$no=0;
		$jml = mysql_affected_rows();
		while($qr=mysql_fetch_array($result)) {
			//category
			$category = oneQuery('article_category','id',$qr['category'],'name');
			$catlink  = make_permalink("?app=article&view=category&id=$qr[category]");	
			
			//autho
			if(!empty($qr['author_id'])) {
				if(!empty($qr['author'])) 
					$author = $qr['author'];
				else  
					$author	= oneQuery('user','id',$qr['author_id'],'name');	
			}
			else
				$author = "Administrator";
			
			$strpos = 0;	
			$article = stripTags($qr['article']);
			$article2 = strtolower($article);
			$strpos = strpos("$article2","$q");
			
			
			$query = str_replace(", ",",",$q);
			$query = str_replace(" ,",",",$q);
			$query = trim($query);
			if(strpos($query,",")) 
				$query = explode(",",$query);
			else
				$query = explode(" ",$q);
			$i = 0;
			$z = '';
			$y = '';
			foreach($query as $v){
				$y[$i] = $v ;
				
				$i++;
			}
			for($n = ($i*$i) -1; $n >= 0; $n--) {
			
			
			}
			
			if($strpos >= 40) {
				$strpos = $strpos - 40 ;	
				$article2 = substr("$article2",$strpos);	
				$strpos2 = strpos("$article2"," ");
				$article = substr("$article",$strpos + $strpos2);		
				$article = "...".$article;
			}
			$article = cutWords($article,35);
			$article .= "...";
			
				
				$link="?app=article&view=item&id=$qr[id]";	
				$link = make_permalink($link,Page_ID);	
				
				
					$qr['title'] = search_match($qr['title'],$q);	
					$article = search_match($article,$q);
					$author = search_match($author,$q);		
					$category = search_match($category,$q);
				
				
				$title = "<a href=\"$link\">$qr[title]</a>";
				$readmore = null;
												
				$this -> category[$no]	= $category;
				$this -> catlink[$no]	= $catlink;
				$this -> readmore[$no]	= $readmore;
				$this -> author[$no]	= $author;
				$this -> title[$no] 	= $title;
				$this -> date[$no]		= $qr['date'];
				$this -> article[$no]	= $article;
				$this -> perrows 		= $jml;
				$this -> total			= $total;
						
				if(defined('SEF_URL')) {		
					$link = link_paging('?');	
				}
				else {		
					$link="?app=article&view=category&id=$categoryId";	
					$link = make_permalink($link,Page_ID);
					$link = $link."&";		
				}				
				$no++;
			}
			
			FQuery('article',"status=1 AND (`author_id` ='$user' $condition) $accessLevel");
			$jml= mysql_affected_rows();
			if($jml>$rowsPerPage)
				$pagelink = $paging->createPaging($link);	
			else
				$pagelink = null;
				
			if(strpos(getUrl(),'?q')) 
			 $pagelink = str_replace("?page=","&page=",$pagelink);
			$this -> pglink		= $pagelink;
	}
}

function search_match($value,$query) {
	$query = str_replace(", ",",",$query);
	$query = str_replace(" ,",",",$query);
	$q = trim($query);
	if(strpos($q,",")) 
		$q = explode(",",$q);
	else
		$q = explode(" ",$q);
	foreach($q as $v){
		if(strlen($v) > 2) {
			if($v != 'span' or $v != 'style' or $v != 'background' or $v != 'yellow' or $v != '/') 
			$value = preg_replace("/($v)/i", '<span style="background: yellow;">\1</span>', $value); 
		}
	}
	return $value;
}

function explode_query($q , $target) {
	$q = trim($q);
	if(strpos($q,",")) 
		$q = explode(",",$q);
	else
		$q = explode(" ",$q);
	$value = '';
	foreach($q as $v){ 
		if(strlen($v) > 2) {
	
		if(empty($value))$value .= " OR (`$target` LIKE '%$v%' ";
			else  $value .= " OR `$target` LIKE '%$v%' ";
			}
	}
	if(!empty($value))$value .=") ";
	return $value;
}
/* add search permalink */
if(getLink() == '?app=search') 
	add_permalink('search');

/* define search page title */
define('PageTitle', 'Search Page');

