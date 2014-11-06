<?php
/**
* @version		2.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2014 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.
**/

defined('_FINDEX_') or die('Access Denied');

function loadModule($position) {	
	if(isset($_GET['theme']) AND $_GET['theme'] =='module' AND $_SESSION['USER_LEVEL'] < 3) {
		echo "<div class='theme-module'>$position</div>";
	} 
	else {
		$db = new FQuery();  
		$db ->connect();	
		$qrs = $db->select(FDBPrefix.'module','*',"status=1 AND position='$position'" .Level_Access, 'short ASC');	
		while($qr=mysql_fetch_array($qrs)){
			if(!empty($qr['page'])) {
				$page = explode(",",$qr['page']);
				foreach($page as $val)
				{			
					if(Page_ID == $val)
					{ 	
						$qr['show_title']== 1 ? $title="<h3>$qr[name]</h3>" : $title = "";						
						echo "<div class=\"modules $qr[class]\">$title<div class=\"mod-inner\" style=\"$qr[style]\">";
						$modId = $qr['id'];
						$modParam = $qr['parameter'];
						$modFolder = $qr['folder'];
						$theme = siteConfig('site_theme');
						$tfile = "themes/$theme/modules/$qr[folder]/$qr[folder].php";	
						$file = "modules/$qr[folder]/$qr[folder].php";	
						if(file_exists($tfile))
							include($tfile);
						else if(file_exists($file))
							include($file);
						else
							echo "Module Error : <b>$qr[folder]</b> is not installed!";
						echo"</div></div>";
					}
				}
			}
			
			else if($qr['page']==Page_ID AND FUrl==$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']){
				if($qr['show_title']==1){$title="<h3>$qr[name]</h3>";}
				else {$title="";}
				echo "<div class=\"modules $qr[class]\">$title<div class=\"mod-inner\" style=\"$qr[style]\">";
				$tfile 	= "themes/$theme/modules/$qr[folder]/$qr[folder].php";	
				$file	="modules/$qr[folder]/$qr[folder].php";	
				$modId 	= $qr['id'];
				$modFolder 	= $qr['folder'];
				$modParam 	= $qr['parameter'];
				if(file_exists($tfile))
					include($tfile);
				else if(file_exists($file))
					include($file);
				else
					echo "Module Error : <b>$qr[folder]</b> is not installed!";
				echo"</div></div>";
			}
		}
	}
}

function checkModule($position) {
	if(isset($_GET['theme']) AND $_GET['theme'] =='module' AND $_SESSION['USER_LEVEL'] < 3) {
		return true;
	}
	else {
		$db = new FQuery();  
		$db ->connect();	
		if(!defined('Page_ID') AND $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']==FUrl){
			$sql=$db->select(FDBPrefix.'menu','*','home=1'); 
			$qr = mysql_fetch_array($sql);
			$pid= $qr['id'];
		}
		else{	
			$pid = Page_ID;
			if(empty($pid)) $pid = 0;
		}
		$val = false;
		$qrs = $db->select(FDBPrefix.'module','*',"status=1 AND position = '$position'" .Level_Access, 'short ASC');
		while($qr=mysql_fetch_array($qrs)){
			if(!empty($qr['page'])) {
				$pid = explode(",",$qr['page']);
				foreach($pid as $a) {
					if($a == Page_ID )
					$val = true;
				}
			}		
		}	
		return $val;
	}
}


function loadModuleCss() {
	if(isset($_GET['theme']) AND $_GET['theme'] =='module' AND $_SESSION['USER_LEVEL'] < 3) {
	echo "<style>.theme-module {
		border: 2px solid #e3e3e3; 
		background: rgba(250,250,250,0.8);
		color : #666; 
		padding: 10px;
		margin: 5px 3px;
		font-weight: bold;
		cursor: pointer;
		transition: all .2s ease;
		}
		.theme-module:hover {
		border-color: #ff9000; 
		background: rgba(255, 205, 130,0.15);
		color : #ff6100;
		box-shadow: 0 0 10px #ffcd82;} </style>";
	}
	else {
		$db = new FQuery();  
		$db ->connect();	
		if(!defined('Page_ID') AND $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']==FUrl){
			$sql=$db->select(FDBPrefix.'menu','*','home=1'); 
			$qr = mysql_fetch_array($sql);
			$pid= $qr['id'];
		}
		else{	
			$pid = Page_ID;
			if(empty($pid)) $pid = 0;
		}
		$val = false;
		$no = 1;
		$qrs = $db->select(FDBPrefix.'module','*',"status=1 " .Level_Access, 'short ASC');
		while($qr=mysql_fetch_array($qrs)){
			if(!empty($qr['page'])) {
				$pid = explode(",",$qr['page']);
				foreach($pid as $a) { 
					if($a == Page_ID ) {
						$file	= "modules/$qr[folder]/mod_style.php";
						if(file_exists($file)) {
							require_once ($file);
							$no++;
						}	
					}
				
				}
			}		
		}	
	}
}

