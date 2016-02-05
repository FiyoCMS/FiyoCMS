<?php 
/**
* @version		2.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2014 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.txt
**/

session_start();
if(!isset($_SESSION['USER_ID']) or !isset($_SESSION['USER_ID']) or $_SESSION['USER_LEVEL'] > 4 or !isset($_GET['url'])) die();
define('_FINDEX_','BACK');

require_once ('../../../system/jscore.php');
?>
<table class="table  tools">
  <tbody>
	<?php	
		$sql = $db->select(FDBPrefix."article","*,DATE_FORMAT(date,'%W, %b %d %Y') as dates","",'date DESC LIMIT 10'); 
		$no = 0;		
		foreach($sql as $row) {
			$no++;			
			$read = check_permalink("link","?app=article&view=item&id=$row[id]","permalink");
			if($read) $read = $_GET['url'].$read; else $read = $_GET['url']."?app=article&view=item&id=$row[id]";
			$edit = "?app=article&act=edit&id=$row[id]";						
			$auth = userInfo("name","$row[author_id]");
			$info = "$row[date]";
			$read_article = Read;
			$edit_article = Edit;
			echo "<tr><td class='no-tabs'>#$no</td><td width='100%'>$row[title] <a class='tooltips icon-time' title='$info' data-placement='right'></a> 
			<div class='tool-box'>
				<a href='$read' target='_blank'  class='btn btn-tools tips' title='$read_article'>$read_article</a>";				
			$editor_level 	= mod_param('editor_level',$row['parameter']);
			if($editor_level >= USER_LEVEL or empty($editor_level)) echo "<a href='$edit' class='btn btn-tools tips' title='$edit_article'>$edit_article</a>";
			echo "</div>			
			</td></tr>";
		}	
		if($no == 0) { 
			echo "<tr><td style='text-align:center; padding: 40px 0; color: #ccc; font-size: 1.5em'>".No_Article."</td></tr>";
		}				
		?>				
       </tbody>			
</table>
<script>$(function() {$('.tooltips').tooltip();});</script>