<?php
/**
* @version		1.5.0
* @package		Fi pdf
* @copyright	Copyright (C) 2012 Fiyo Developers.
* @license		GNU/GPL, see LICENSE.txt
**/

defined('_FINDEX_') or die('Access Denied');

function categoryInfo($output) {	
	$id = app_param('id');
	$output = oneQuery('pustaka_category','id',$id ,$output);
	return  $output;
}

function categoryLink($value) {
	$link = make_permalink("?app=pdf&view=category&id=$value");
	return $link ;
}


function itemLink($value) {
	$link = make_permalink("?app=pdf&view=item&id=$value");
	return $link ;
}

function lecToLink($labels) {
	$tgs = explode(",",$labels);
	$labels = null;
	$no = 0;
	foreach($tgs as $label) {	
		$no++;
		$llabel = str_replace(" ","-",$label);			
		$llabel = strtolower($llabel);
		$llabel = "?app=pdf&label=$llabel";	
		$llabel = make_permalink($llabel);
		$label2 = substr($label,0,1);
		$label3 = strtolower(substr($label,0,1));	
		$output = oneQuery('pustaka_pembimbing','id',"'$label'" ,'nama');
		if(!empty($label2) AND $no == 1)	
		$labels .= "$output";					
		else if(!empty($label2))	
		$labels .= ",$output";					
	}
	return $labels;
}
function labelToLink($labels) {
	$tgs = explode(",",$labels);
	$labels = null;
	foreach($tgs as $label) {				
		$llabel = str_replace(" ","-",$label);			
		$llabel = strtolower($llabel);
		$llabel = "?app=pdf&label=$llabel";	
		$llabel = make_permalink($llabel);
		$label2 = substr($label,0,1);
		$label3 = strtolower(substr($label,0,1));	
		if(!empty($label2))	
		$labels .= "<li>$label2</a></li>";				
	}
	return $labels;
}
	
function pdfConfig($output) {
	$output = oneQuery('pustaka_config','name',"'$output'" ,'value');
	return  $output;

}
function pdfInfo($output) {
	$id = app_param('id');
	$output = oneQuery('pustaka_file','id',$id ,"$output");
	return  $output;
}

function pdfUser($id,$output) {
	$output = oneQuery('pustaka_user','id',$id,"$output");
	return  $output;
}
function pdfParameter($value) {	
	$menu_id = Page_ID;
	$param	 = pageInfo($menu_id ,'parameter');
	$param	 = mod_param($value,$param);
	return 1;
}

function pdfHits() {
	$db = new FQuery();  
	$db->connect();
	$hits = pdfInfo('pdfed') + 1 ;
	$id = pdfInfo('id');
	$db->update(FDBPrefix.'pustaka_file',array("pdfed" => "$hits"),"id =$id");	
}

function pdfFile() {
	$link = pdfInfo('link');
	$hits = pdfInfo('pdfed');	
	if(substr_count($link,"http://") > 0)				
		$file = "$link";
	else
		$file = FUrl."$link";					
/********** update pdfed hist ************/					
	if(!file_exists($file))
	$file = "http://".siteConfig('site_url')."$link";
	header("Content-Disposition: attachment; filename=\"" . basename($file) . "\"");
	header("Content-Length: " . filesize($file));
	header("Content-Type: application/octet-stream;");
	readfile($file);
}


if(app_param('go') == 'pdf') {	
	pdfFile();
	pdfHits();
}

class pdf {	
	function item($id,$menuId,$DL = null) {			
		if(FQuery("pustaka_file","id=$id")) {
		$db = new FQuery();  
		$db->connect();
		$sql=$db->select(FDBPrefix."pustaka_file","*","id=$id AND status=1"); 		
		$qr = mysql_fetch_array($sql);	
		
			if($qr) {
			$category = oneQuery('pustaka_category','id',$qr['category'],'name');
			$catlevel = oneQuery('pustaka_category','id',$qr['category'],'level');
			$author	  = oneQuery('user','id',$qr['lecturer'],'name');
			
			if(USER_LEVEL <= $catlevel or USER_LEVEL <= $qr['level'])  {
				$catlink	= categoryLink($qr['category']);			
				$labels		= labelToLink($qr['tags']);
				
				$category = "<a href='$catlink' title='See more $category'>$category</a>";
				
				/*********** File Link *************/
				$x = substr_count($qr['link1'],".zip");
				$r = substr_count($qr['link1'],".rar");
				$z = substr_count($qr['link1'],".7zip");
				if($x > 0 or $r > 0 or $z > 0) {				
					$vlink="?app=pdf&view=item&id=$qr[id]&go=pdf";
					$link = make_permalink($vlink);	
					$link = "<a href='$link' class='pdf' title='pdf File'><span>@</span> pdf</a>";
				}
				else {
					$link = $qr['link1'];				
					$link = "<a href='$link' target='_blank' class='pdf' title='pdf File'><span>@</span> pdf</a>";
				}

				/********** author link ***********/
				if(!empty($qr['author'])) 
					$author = $qr['author'];				
				$alink="?app=pdf&view=author&id=$qr[id]";
					$author = $qr['author'];		
				$lecturer = lecToLink($qr['lecturer']);
				
				/********** date updated ***********/
					
				/********** pdf hits ***********/
				$pdfed = "<a class='pdf' style='margin-right:0 !important' title='Hits'><span>$</span> 1</a>";
				
				$this -> pdf		= $link;
				$this -> pdff		= $qr['link1'];
				$this -> author		= $author;
				$this -> lecturer	= $lecturer;
				// $this -> labels		= $labels;	
				$this -> category	= $category;
				$this -> pdfed		= $pdfed;
				$this -> title		= $qr['title'];	
				$this -> year 		= $qr['year'];
				$this -> desc		= $qr['description'];
				$this -> hits 		= angka($qr['hits']);
			}
			else {		
				echo pustaka_Page_Denied;
			}
		}
		else
			echo pustaka_Page_Notfound;	
		}
	}	

function category($id,$menuId,$fp = null) {	

		//validation page type
		$categoryName = $categoryDesc = null;
		$label = app_param('label');
		if($id > 0) {
			$flag = FQuery("pustaka_category","id=$id",'',1);
		}
		else {
			if(!empty($label)) {
				$label = app_param('label');
				$label = str_replace("-"," ",$label);
				$label =  "AND tags LIKE '%".$label."%' ";
			}
			$flag = true;
		}
		//if page type is valid 
		if($flag){
			$db = new FQuery();  
			$db->connect(); 
			
			/************** Parameter Page ***************/		
			$per_page	= 10;	
			$categoryId	= $id;
			
			if(empty($param )){
					$show_panel = 1 ;
					$per_page = 10 ;
			}
			if(url_param('feed') == 'rss') {
				$per_page = 10;
				$pages = url_param('page');
				
				if($pages != null) {
					$link = str_replace("?page=$pages","",getUrl());
					redirect("$link?feed=rss");					
				}
			}
			if(isset($label)) {
				$per_page = 10;
			}
			if(empty($per_page))$per_page = 10;
			
			//$fp is default page		
			if(!isset($fp) AND !isset($label)) {
				$categoryName = oneQuery('pustaka_category','id',$categoryId,'name');
				$categoryDesc = oneQuery('pustaka_category','id',$categoryId,'description');
			}
			$level_access = Level_Access;	
			
			//$if category id is not found
			if(!$categoryId AND !isset($fp) AND !isset($label))
				echo pustaka_Page_Notfound;
			else {	
				if(isset($categoryName)) 
					$whereCat ="AND category = $categoryId"; 
				else 
					$whereCat = null;
			
				//call paging class				
				loadPaging();		
				$paging = new paging();
				$rowsPerPage = $per_page;
			
				//paging results		
				$result = $paging->pagerQuery(FDBPrefix.'pustaka_file',"*","status=1 $whereCat $label",'id DESC',$rowsPerPage);
				$no=0;
				
				//count rows
				$jml = mysql_affected_rows();
				while($qr=mysql_fetch_array($result)) {				
					
					/********** File Author ***********/
						$author = $qr['author'];						
						
					/********** File Category ***********/
					$catlink  = categoryLink($qr['category']);					
					$category = oneQuery('pustaka_category','id',$qr['category'],'name');
					$category = "<a href='$catlink' title='See more $category'>$category</a>";
					
					/********** pdf Link ***********/						
					$flink="?app=pdf&view=item&id=$qr[id]";	
					$link = make_permalink($flink,Page_ID);	
					$title = "<a href='$link'>$qr[title]</a>";	
										
					/********** File Labels ***********/	
					$labels = labelToLink($qr['tags']);
					
					/********** File Compability ***********/	
					$this -> perrows 		 = $jml;
					$this -> show_panel		 = $show_panel;
					$this -> category[$no]	 = $category;
					$this -> catlink[$no]	 = $catlink;
					$this -> author[$no]	 = $author;
					$this -> title[$no] 	 = $title;
					$this -> link[$no] 		 = $link;
					$this -> labels[$no] 	 = $labels;
					$this -> date[$no]		 = $qr['year'];
					$this -> hits[$no]		 = $qr['hits'];
					$this -> desc[$no]		 = $qr['description'];
						
					if(url_param('feed') == 'rss' AND url_param('feed') == 'rss' or app_param('label')) 	
					$this -> description[$no]= $qr['description'];
					if(defined('SEF_URL')) {		
						$link = link_paging('?');	
					}
					else if(checkhomepage())  {
						$link = "?";
					}
					else {		
						$link="?app=pdf&view=category&id=$categoryId";	
						$link = make_permalink($link,Page_ID);
						$link = $link."&";		
					}				
					$no++;
				}
				
				if($no == 0 )
					echo "<h1 style='margin:20px auto'>Pustaka Kosong !!!!</h1>";
				
				//start paging links
				$db -> select(FDBPrefix.'pustaka_file','*',"status=1 $whereCat  $level_access");
				$jml = mysql_affected_rows();
				if($jml > $rowsPerPage) 					
					$pagelink = $paging->createPaging($link);
				else
					$pagelink = null;
				
				//send paging var relsult
				$this -> pglink		= $pagelink;				
				
				//if parameter found rss page
				if(url_param('feed') == 'rss' AND url_param('feed') == 'rss' or app_param('label')) {
					$this -> catName	= $categoryName;
					$this -> catDesc	= $categoryDesc;				
				}			
			}	
		}	
		else {
			pustaka_Page_Notfound;
		}
	}	
}




/****************************************/
/*			   SEF pdf				*/
/****************************************/
$view = app_param('view');
$id = app_param('id');
if($view != 'default') {
	$a = FQuery("pustaka_category","id=$id",'',1); 
	if(!$a)
	$a = FQuery("pustaka_file","id=$id",'',1); 
	if(!$a AND app_param('label') != null)
	$a = app_param('label');
}
else {
	$a = app_param('view')=='default';
}
if($a){
	$sef_prefix = "pustaka";
	if(defined('SEF_URL')){
		$page = check_permalink('permalink','addons','pid');
		if($view == 'item') {
			$item = oneQuery('pustaka_file','id',$id,'title');
			$vcat = oneQuery('pustaka_file','id',$id,'category');
			$ncat = oneQuery('pustaka_category','id',$vcat,'name');		
			$page = oneQuery('menu','link',"'?app=pdf&view=category&id=$vcat'",'id');
			if(!$page) {
				$page = oneQuery('permalink','link',"'?app=pdf&view=default'",'pid');
			}
			if(app_param('go') != 'pdf')	
				add_permalink("$id-$item","$sef_prefix/$ncat",$page);
			else
				add_permalink("$id-$item/pdf","$sef_prefix/$ncat",$page);
		}
		else if($view == 'category') {				
			$vcat = oneQuery('pustaka_file','id',$id,'category');
			$page = oneQuery('menu','link',"'?app=pdf&view=category&id=$vcat'",'id');
			if(!$page) 
				$page = oneQuery('permalink','link',"'?app=pdf&view=category&id=$vcat'",'pid');
			$ncat = oneQuery('pustaka_category','id',$id,'name');		
			if(url_param('feed') == 'rss');			
			else add_permalink("$sef_prefix/$id-$ncat");
		}			
		else if(app_param('view')=='default')	
			add_permalink("$sef_prefix");
		else if (app_param('label') != null) {		
			$tag = app_param('label');
			if(url_param('feed') == 'rss');			
			else add_permalink("$sef_prefix/label/$tag",'',$page);
		} 
			
					
	}
};

/****************************************/
/*			 pdf Title				*/
/****************************************/
if($id > 0) {
	$a = FQuery("pustaka_category","id=$id",'',1); 
	if(!$a) {
		$a = FQuery("pdf","id=$id",'',1); 
	}
	
	if(!$a){
		if(app_param('view')=='default')
			$a = 1;
		if(siteConfig('follow_link'))
			$follow = 'index, follow';
		else {
			$follow = 'index, nofollow';
			define('MetaRobots',"$follow");
		}
	}
}
if($a){
	if(!checkHomePage()) {	
		if ($view=="item") {
			define('PageTitle', pdfInfo('title'));
			
			$desc = pdfInfo('description');
			if(!empty($desc)) 	
				define('MetaDesc', pdfInfo('description'));
			
			$keys = pdfInfo('keyword');		
			if(!empty($keys)) 	
				define('MetaKeys', pdfInfo('keyword'));
			
			if(siteConfig('follow_link'))
				$follow = 'index, follow';
			else
				$follow = 'index, nofollow';
			define('MetaRobots',"$follow");
			
			$author = pdfInfo('author');
			if(empty($author))
				$author = oneQuery('user','id',pdfInfo('lecturer'),'name');
			if(define('MetaAuthor',$author));
		}
		else if($view=="category" or $view=="catlist") {
			define('PageTitle', categoryInfo('name'));
			$desc = categoryInfo('description');
			if(!empty($desc )) 
				define('MetaDesc', $desc);
			$keys = categoryInfo('keywords');
			if(!empty($keys)) 
				define('MetaKeys', $keys );
			
			
			$cat = app_param('id');
			$qry = oneQuery("menu","link","'?app=pdf&view=category&id=$cat'");
			if(!$qry)
				$qry = oneQuery("menu","link","'?app=pdf&view=catlist&id=$cat'");
			if($qry) {
				if(siteConfig('follow_link'))
					$follow = 'index, follow';
				else
					$follow = 'index, nofollow';
			}
			else
				$follow = 'none';
			define('MetaRobots',"$follow");			
		}		
		else if(app_param('label') != null )			
			define('PageTitle', app_param('label')." label");
		else 
			define('PageTitle', "Pustaka");
		
	}
		else
			define('PageTitle', "Pustaka");
	
}
if(!defined('PageTitle')) define('PageTitle', "Pustaka");
$lang = siteConfig('lang');
require_once("lang/$lang.php");