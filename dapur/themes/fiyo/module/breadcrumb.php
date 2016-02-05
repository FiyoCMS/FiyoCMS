<?php
/**
* @version		2.0.2
* @package		Fiyo CMS
* @copyright	Copyright (C) 2015 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.txt
**/

if(isset($_GET['access'])) {	
	session_start();
	if(!isset($_SESSION['USER_ID']) or !isset($_SESSION['USER_ID']) or $_SESSION['USER_LEVEL'] > 3) die();
	
	define('_FINDEX_','BACK');
	require_once ('../../../system/jscore.php');
	$link = getLink();
	$link = substr($link, 1);
	$link = str_replace("&theme=blank&access","",$link);
	$app = link_param('app',$link);
	$url =  parse_url($link);
	$cat = link_param('cat',$link);
	
} else {
	defined('_FINDEX_') or die('Access Denied');
	$link = getLink();
	$app = null;
	
	if(isset($_REQUEST['app']))	
	$app = $_REQUEST['app'];
	if(isset($_REQUEST['cat']))	
	$cat = $_REQUEST['cat'];

}
if(isset($app)) {
	$mns = oneQuery("menu","sub_name","$app","name");
	$md = menuInfo('name',"?app=$app");	
}
$mn = menuInfo('name',$link);
$mp = menuInfo('name',$link,menuInfo('parent_id',$link));
$ml = menuInfo('link',$link,menuInfo('parent_id',$link));
?><ul id="breadcrumbs" class="breadcrumb stats"> 
    <li><a href="index.php"><i class="icon-home"></i>Dashboard</a></li>
	<?php 
	if(!empty($mp) or isset($md) AND !empty($app)) {
		if(!$mn) {
			$mdl = menuInfo('name',"?app=$app",menuInfo('parent_id',"?app=$app"));
			if($mdl)
			echo "<li><a href='#'>$mdl</a></li>";
		
			$mn = $md;
		
		} else if (!empty($mp)) {
			if($mp !== 'Apps') 
				$ml = "?app=$app";
			
			echo "<li><a href='$ml'>$mp</a></li>";
		}	
		if (!empty($cat) && $app == 'menu') {
			echo "<li><a href='#'>".ucfirst($cat)."</a></li>";
		}
		else if(!empty($mn) || !isset($cat)) 
			echo "<li><a href='#'>$mn</a></li>";
		
	} else if(!empty($mns) && !empty($app))  {
		echo "<li><a href='#'>$mns</a></li>";
	} else if(isset($_REQUEST['app'])) {		
		$ml = "?app=$app";		
		$parent = menuInfo('parent_id',"$ml");
		if(!$parent) {			
			$link = menuInfo('id',"$ml");
			$name = menuInfo('name',$link, $link);
			$link = menuInfo('link',$link, $link);
			echo "<li><a href='$link'>$name</a></li>";
		} else {			
			$name = menuInfo('name',$ml);
			$link = menuInfo('link', $ml);
			echo "<li><a href='$link'>$name</a></li>";
		}
	}
	?>

    <!--span>_BREADCRUMB_</span-->
</ul> 