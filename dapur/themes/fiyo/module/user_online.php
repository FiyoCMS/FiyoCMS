<?php 
/**
* @version		2.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2014 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.txt
**/

define('_FINDEX_',1);
session_start();
if(!isset($_SESSION['USER_ID']) or !isset($_SESSION['USER_ID']) or $_SESSION['USER_LEVEL'] > 9 or !isset($_POST['url'])) die();

require_once ('../../../system/jscore.php');
?>
<table class="table table-striped tools">
  <tbody>
	<?php	
		$db = new FQuery();  
		$db->connect(); 
		$sql = $db->select(FDBPrefix."session_login","*,DATE_FORMAT(time,'%Y-%m-%d') as date","",'time DESC LIMIT 5'); 
		$no = 1;
		while($qr=mysql_fetch_array($sql)) {
			$id = $qr['user_id'];
			$edit = Edit;
			$read = Read;
			$kick = Kickout;
			$hide = Set_disable;	
			$delete = Delete;
			$approve = Set_enable;		
			$ledit = "?app=user&act=edit&id=$id";	
			$sql2 = $db->select(FDBPrefix."user_group","*","level=$qr[level]"); 
			$group = mysql_fetch_array($sql2);
			$group = $group['group_name'];	
			$name = userInfo('name',$id);
			$mail = userInfo('email',$id);
			echo "<tr><td>$name <span>($qr[session_id])</span>
			<a data-toggle='tooltip' data-placement='right' title='Online' class=' icon-circle blink icon-mini tooltips'></a><br/>
			<div class='tool-box'>
				<a class='btn-tools btn btn-danger btn-sm btn-grad kick' title='$kick' data-id='$id'>$kick</a>
				<a href='$ledit' class='btn btn-tools tips' title='$edit'>$edit</a>
			</div>
			</td>
			</tr>";
			$no++;	
		}					
		?>			

       </tbody>			
</table>
<script>
$(function() { 
	$('.kick').click(function() {
		var is = $(this);
		var id = $(this).data('id');
		$.ajax({
			url: "apps/app_user/controller/status.php",
			data: "stat=kick&id="+id,
			success: function(data){
			}
		});	
	});
	$('.tooltips').tooltip();
}); </script>