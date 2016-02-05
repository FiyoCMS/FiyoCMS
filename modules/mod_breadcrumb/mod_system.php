<?php 
/**
* @version		2.1
* @package		Breadcrumb
* @copyright	Copyright (C) 2015 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.txt
**/

defined('_FINDEX_') or die('Access Denied');

class Breadcrumb {
	public function catLink($output) {
		if(app_param('view') == 'category')
			$id = categoryInfo('id');
		else	
			$id = articleInfo('category');
		$cl = "?app=article&view=category&id=$id";
		$result = FQuery("menu","link LIKE '$cl%' AND home != 1","id");
		if(empty($result)) $result = $cl;
		return $result;
	}

	public function artLink($output) {
		$id = articleInfo('id');
		$result = menuInfo("$output","?app=article&view=item&id=$id");
		return $result;
	}

	public function creatLink($id,$item = null, $apps = null) {	
		$link = null;
		if(isset($item)) {
			do {
				if(!empty($apps) && $apps == 'article' && strlen($id) > 3) {					
					$name = categoryInfo('name',articleInfo('category'));	
					$url = make_permalink($id);	
				} 
				else if(!empty($apps) && $apps == 'contact') {					
					$name = groupInfo('group_name',groupInfo('group'));	
					$url  = make_permalink("?app=contact&view=group&id=$id");
				} else {					
					$name = menuInfo('name','',$id);
					$url  = menuInfo('link','',$id);
					$url  = make_permalink($url);
				}
				$link = "<li><span></span><a href='$url'>$name</a></li>$link";
			} while($id = menuInfo('parent_id','',$id));
		
		} 
		else { 
			while($id = menuInfo('parent_id','',$id)) {
				$name = menuInfo('name','',$id);
				$url  = menuInfo('link','',$id);
				$url  = make_permalink($url);
				$link = "<li><span></span><a href='$url'>$name</a></li>$link";
			}
		}	
		$home = "<li><span></span><a href='".FUrl."' class='breadchumb-home'>Home</a></li>";
		if(!checkHomePage())
		return "$home $link <li><span></span>".PageTitle."</li>";
		else
		return "<li><span></span>".PageTitle."</li>";
	}
	
	public function createItem() {
		$apps = app_param('app');
		switch($apps) {
			case 'article' :
				if(app_param('view')=='archive' || app_param('view')=='featured') {
					$result = Page_ID;
					return $this -> creatLink($result);
				}			
				else if(app_param('view') == 'category') {
					$result = $this -> catLink('id');
					return $this -> creatLink($result);
				}				
				else if(app_param('view') == 'item') {	
						$result = $this -> artLink('id');
						if(empty($result))
						$result = $this -> catLink('id');
						return $this -> creatLink($result, 1, 'article');
				}		
				else  {
					$result = Page_ID;
					return $this -> creatLink($result);
				}
			break;
			case 'contact' :
				if(app_param('view')=='persons' || app_param('view')=='item') {
					$result = Page_ID;
					return $this -> creatLink($result);
				}			
				else if(app_param('view') == 'category') {
					$result = $this -> catLink('id');
					return $this -> creatLink($result);
				}			
				else if(app_param('view') == 'person') {
						$result = app_param('id');	
						return $this -> creatLink($result, 1, 'contact');
				}		
				else  {
					$result = Page_ID;
					return $this -> creatLink($result);
				}
			break;
			default : 
				if(!checkHomePage())
				return $this->creatLink(Page_ID);
			break;
		}
	}	
}