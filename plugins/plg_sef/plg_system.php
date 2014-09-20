<?php
/**
* @name			Plugin SEF
* @version		2.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2014 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.txt
*/

defined('_FINDEX_') or die('Access Denied');
/************* SEF PAGINATION FUNCTION *****************/
function redirect_www() {
	if($_SERVER['SERVER_ADDR'] != '127.0.0.1' AND $_SERVER['SERVER_ADDR'] != '::1' AND $_SERVER['SERVER_ADDR'] != $_SERVER['HTTP_HOST'] ) {
		if(siteConfig('sef_www')) {
			if(!strpos(getUrl(),"//www.")) {
				$link = getUrl();
				$link = str_replace("http://","http://www.",$link);
				redirect($link);
			}
		}
		else {
			if(strpos(getUrl(),"//www.")) {
				$link = getUrl();
				$link = str_replace("http://www.","http://",$link);
				redirect($link);
			}
		}
	}
}

function redirect_link(){
	if(!checkHomePage()){
		$app = app_param('app');	
		if(SEF_URL) {	
			if(_Page == 1) {
				if(strpos(getUrl(),"&page="))
					redirect(str_replace("&page="._Page,"",getUrl()));
			}
			if(empty($app)) {
			//redirect for 404 page
				$link = str_replace(FUrl,"",getUrl());
				$linl = strlen($link);
				$max = 0;
				while($linl) {	
					if(substr($link,$linl-1) == "/") {					
						$link = substr($link,0, $linl-1);
					}					
					$got = FQuery("permalink","permalink LIKE '$link%'");
					$linl = strlen($link);
					if($linl < 4 or $max == 20 ){
						$fail_url = getUrl();
						break;
					}
					else if($got) {
						$link = FQuery("permalink","permalink LIKE '$link%'","permalink");
						break;
					}
					$link = substr($link,0, $linl-1);
					$max++;
				}
				if($got AND !isset($fail_url))
					redirect(FUrl.$link);
			}
			else if(!empty($app)) {	
				// nothing :D
			}
			else if(SEF_EXT == 0 or SEF_EXT == '') {
				$sum = strlen(getUrl());
				$rev = strrev(getUrl());
				if(!strpos(getUrl(),'?')) {
					$pos = substr(getUrl(),$sum-1);
					if($pos == "/")
						redirect(substr(getUrl(),0,$sum-1));
				}
			}
		}
		else {
			$direct = check_permalink('link',$_SERVER['REQUEST_URI'],'permalink');
			$xurl =  'http://'.$_SERVER["HTTP_HOST"].$_SERVER['REQUEST_URI'];
			$gurl = str_replace(FUrl,'',$xurl);
			$strt = strlen($gurl);
			$x = 1;
			while($strt) {
				$val =  substr($gurl,0,$strt);
				if(check_permalink('permalink',$val,'link')) {
					if(str_replace($val.SEF_EXT,'',$xurl) != FUrl)
						if(_Page == 0)
					break;				
				}				
				$strt -= 1;
				$x++;			
			}
			$url =  check_permalink('permalink',$val,'link');
			$pid =  check_permalink('permalink',$val,'pid');
			//echo FUrl.$url;//redirect(FUrl.$url.SEF_EXT);
		}
	}
	else {
		if(isset($_GET['page']) AND _Page == 1)
		redirect(FUrl);
	}	
}

function add_permalink($title, $cat = NULL, $pid = null, $ext = null, $next = null) {
	$page = _Page;
	if(!preg_match("/[0-9]/",$page))
		$page = null;
	if(SEF_URL AND !checkHomePage() AND !$page)
	{
		$db = new FQuery();  
		$db->connect(); 		
		$eqpos = strpos($_SERVER['REQUEST_URI'],"=");
		$tapos = strpos($_SERVER['REQUEST_URI'],"?");
		if($eqpos >0 AND $tapos>0 AND empty($_GET['page'])){		
			$permalink = str_replace(" ","-",strtolower($title));		
			if(app_param('app') == 'article' AND app_param('view') == 'item' ) {	
				while(substr_count($permalink,'/'))
				{
					$permalink = str_replace("/","-",$permalink);
				}
			}
			
			$category = str_replace(" ","-",strtolower($cat));
			
			if(!empty($cat))
				$permalink = strtolower($category)."/".$permalink;
			else
				$permalink = $permalink;				
		
			
			while(substr_count($permalink,"["))
			{
				$permalink = str_replace("[","",$permalink);
			}
			
			while(substr_count($permalink,"]"))
			{
				$permalink = str_replace("]","",$permalink);
			}
			
			while(substr_count($permalink,"("))
			{
				$permalink = str_replace("(","",$permalink);
			}
			
			while(substr_count($permalink,")"))
			{
				$permalink = str_replace(")","",$permalink);
			}
			
			while(substr_count($permalink,"{"))
			{
				$permalink = str_replace("{","",$permalink);
			}
			
			while(substr_count($permalink,"}"))
			{
				$permalink = str_replace("}","",$permalink);
			}
			
			while(substr_count($permalink,"&amp;"))
			{
				$permalink = str_replace("&amp;","",$permalink);
			}
			
			while(substr_count($permalink,"&"))
			{
				$permalink = str_replace("&","",$permalink);
			}
			
			/************ ? removal **************/
			while(substr_count($permalink,"?"))
			{
				$permalink = str_replace("?","",$permalink);
			}
			
			/************ + removal **************/
			while(substr_count($permalink,"+"))
			{
				$permalink = str_replace("+","",$permalink);
			}/************ # removal **************/
			while(substr_count($permalink,"#"))
			{
				$permalink = str_replace("#","",$permalink);
			}
			/************ & removal **************/
			while(substr_count($permalink,"\&"))
			{
				$permalink = str_replace("\&","",$permalink);
			}
			
			/************ . removal **************/
			while(substr_count($permalink,"."))
			{
				$permalink = str_replace(".","-",$permalink);
			}
			
			/************ ! removal **************/
			while(substr_count($permalink,"!"))
			{
				$permalink = str_replace("!","",$permalink);
			}
			
			/************ ` removal **************/
			while(substr_count($permalink,"`"))
			{
				$permalink = str_replace("`","",$permalink);
			}
			
			/************ ' removal **************/
			while(substr_count($permalink,"'"))
			{
				$permalink = str_replace("'","",$permalink);
			}
			
			/************ " removal **************/
			while(substr_count($permalink,"\""))
			{
				$permalink = str_replace('"',"",$permalink);
			}
			
			/************ ; removal **************/
			while(substr_count($permalink,";"))
			{
				$permalink = str_replace(';',"",$permalink);
			}
			/************ " removal **************/
			while(substr_count($permalink,'|'))
			{
				$permalink = str_replace('|',"",$permalink);
			}
			/************ % removal **************/
			while(substr_count($permalink,'%'))
			{
				$permalink = str_replace('%',"",$permalink);
			}
			/************ * removal **************/
			while(substr_count($permalink,'*'))
			{
				$permalink = str_replace('*',"",$permalink);
			}/************ ^ removal **************/
			while(substr_count($permalink,'^'))
			{
				$permalink = str_replace('^',"",$permalink);
			}	
			/************ \ removal **************/
			while(substr_count($permalink,'\\'))
			{
				$permalink = str_replace("\\","",$permalink);
			}/************ \ removal **************/
				
			/************ , removal **************/
			while(substr_count($permalink,','))
			{
				$permalink = str_replace(",","",$permalink);
			}
			
			/************ $ removal **************/
			while(substr_count($permalink,'$'))
			{
				$permalink = str_replace("$","",$permalink);
			}
			
			/************ @ removal **************/
			while(substr_count($permalink,'@'))
			{
				$permalink = str_replace("@","",$permalink);
			}
			while(substr_count($permalink,"--"))
			{
				$permalink = str_replace("--","-",$permalink);
			}
										
			if(empty($pid)) $pid = Page_ID;
			$link = getLink();
			
			
			if(!empty($category) AND empty($ext)) 
				$permalink = $permalink.SEF_EXT;
			else if(!empty($ext)) {
				$ext = str_replace(".","",$ext);
				$permalink = "$permalink.$ext";
			}
			
			if(check_permalink('link',$link))
				redirect(FUrl.$permalink);
			else if(!empty($permalink)){
				if($c = check_permalink('permalink',$permalink)) {
					$x = 2;
					$permalink = str_replace(SEF_EXT,"",$permalink);
					while($c) {
						$p = "$permalink-$x";
						$c = check_permalink('permalink',$p.SEF_EXT);
						$x++;				
						
					}
					$permalink = $p.SEF_EXT;
				}
				if(!empty($permalink) AND $permalink != "-" AND !empty($link))
					$qr=$db->insert(FDBPrefix.'permalink',array("","$link","$permalink",$pid,1,0)); 
				if(isset($qr))
					redirect(FUrl.$permalink);
			}			
		}	
	}	
}

function delete_permalink($link) {
	$db = new FQuery();  
	$db -> connect(); 
	$db->delete(FDBPrefix.'permalink',"permalink='$link'");
}

