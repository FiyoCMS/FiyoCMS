<?php
/**
* @version		1.5.0
* @package		Breadcrumb
* @copyright	Copyright (C) 2012 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.txt
*/

defined('_FINDEX_') or die('Access Denied');

class Breadcrumb {
	public function catLink($output) {
		if(app_param('view') == 'category')
			$id = categoryInfo('id');
		else	
			$id = articleInfo('category');
		$result = FQuery("menu","link LIKE '?app=article&view=category&id=$id&type=%' AND home != 1","id");
		return $result;
	}

	public function artLink($output) {
		$id = articleInfo('id');
		$result = menuInfo("$output","?app=article&view=item&id=$id");
		return $result;
	}

	public function creatLink($id,$item = null) {	
		$link = null;
		if(isset($item)) {
			do {
				$name = menuInfo('name','',$id);
				$url  = menuInfo('link','',$id);
				$url  = make_permalink($url);
				$link = "<li><span></span><a href='$url'>$name</a></li> $link";
			} while($id = menuInfo('parent_id','',$id));
		
		} 
		else {
			while($id = menuInfo('parent_id','',$id)) {
				$name = menuInfo('name','',$id);
				$url  = menuInfo('link','',$id);
				$url  = make_permalink($url);
				$link = "<li><span></span><a href='$url'>$name</a></li>  $link";
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
						return $this -> creatLink($result, 1);
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