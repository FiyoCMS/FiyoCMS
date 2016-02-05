<?php
/**
* @name			Module Menu
* @version		2.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2015 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.txt
*/

defined('_FINDEX_') or die('Access Denied');

define('_Mod_SubTitle_',$sub_title);
define('_Mod_SubMenu_',$sub_menu);

function sub_menu($parent_id){
	$db = new FQuery();  
	$qr = $db->select(FDBPrefix."menu","*","parent_id=$parent_id AND status=1","short ASC"); 
    $sum = count($qr);	
    $no = 1;
	if($sum)
		echo "<ul class=\"sub-menu\">";
    foreach($qr as $menu) {
			if(defined('SEF_URL'))
				$link = make_permalink($menu['link'],$menu['id']);
			else
			{
				if(empty($menu['id'])) $menu['id'] = Page_ID;
				$link = "$menu[link]";
			}
			
			$sub_title 	= _Mod_SubTitle_;
			if($sub_title == 1) 
				$subtitle="<span>$menu[sub_name]</span>";
			else 
				$subtitle="";
			
			if($menu['id']==Page_ID)
				$a=" active"; 
			else 
				$a="";
			
			/* draw menu child */
			if($no==1) $post = ' first'; else if($no==$sum) $post = ' last'; else $post = '';
			if ($menu['home']==0){
				if ($menu['app']=="sperator"){
					echo "<li class=\"menu$menu[class]$a$post\"><a href='#'>$menu[name]$subtitle</a>";
					if(_Mod_SubMenu_==1) sub_menu($menu['id']);
					echo "</li>";
				}
				elseif ($menu['app']=="link"){
					echo "<li class=\"menu$menu[class]$a$post\" style=\"$menu[style]\"><a href=\"$link\">$menu[name]$subtitle</a>";
					if(_Mod_SubMenu_==1) sub_menu($menu['id']);
					echo "</li>";
				}
				else { 
					if(empty($menu['link']))$menu['link']="#";
					echo "<li class=\"menu$menu[class]$a$post\" style=\"$menu[style]\"><a href=\"$link\">$menu[name]$subtitle</a>";
					if(_Mod_SubMenu_ == 1) sub_menu($menu['id']);
					echo "</li>";
				}	
			}
			else {
				echo "<li class=\"menu$menu[class]$a$pos\" style=\"$menu[style]\"><a href=\"".FUrl."\">$menu[name]$subtitle</a>";
					if(_Mod_SubMenu_ == 1) sub_menu($menu['id']);
					echo "</li>";
			}
			$no++;
	}
	if($sum) {
		echo "</ul>";
	}
}	
