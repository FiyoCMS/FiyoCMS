<?php
/**
* @version		2.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2014 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.
**/

define('_FINDEX_',1);
session_start();
if(!isset($_SESSION['USER_LEVEL']) AND $_SESSION['USER_LEVEL'] > 4) die ();
require_once ('../../../system/jscore.php');
$db = new FQuery();  
$db->connect(); 
if(!isset($_POST['url'])) $_POST['url'] = '';
?>
<table class="table table-striped tools">
  <tbody>
	<?php	
		$db = new FQuery();  
		$db->connect(); 
		$user_id = USER_ID;
		if(USER_LEVEL > 3) {
			$sql = $db->select(FDBPrefix."comment","*,DATE_FORMAT(date,'%W, %b %d %Y') as dates","parent_user_id = $user_id OR thread_user_id = $user_id",'date DESC LIMIT 10');
			echo USER_LEVEL;
		}
		else
		$sql = $db->select(FDBPrefix."comment","*,DATE_FORMAT(date,'%W, %b %d %Y') as dates","",'date DESC LIMIT 10'); 
		$no = 0;		
		while($qr=mysql_fetch_array($sql)) {					
			$id = "$qr[id]";
			$auth = "$qr[name]";
			$info = "$qr[date]";
			$imgr = md5("$qr[email]");
			$foto = " <span class='c_gravatar' data-gravatar-hash=\"$imgr\"></span>";
			$comment = cutWords(htmlToText($qr['comment']),10);
			$hide = Hide;
			$cedit = Edit;
			$read = Read;
			$delete = Delete;
			$approve = Approve;
			$app = link_param('app',"$qr[link]");	
			$aid = link_param('id',"$qr[link]");	
			$app = "$qr[apps]";
			if(empty($app)) $app = 'article';
			$lread = $_POST['url'].check_permalink("link","?app=article&view=item&id=$aid","permalink");
			$edit = "?app=$app&view=comment&act=edit&id=$id";			
			$title = oneQuery('article','id',$aid ,'title');
			$red = '';
			if($qr['status']) 
				$approven = "<a class='btn-tools btn btn-danger btn-sm btn-grad disable-user' title='$hide' data-id='$id'>$hide</a><a class='btn-tools btn btn-success btn-sm btn-grad approve-user' title='$approve' style='display:none;' data-id='$id'>$approve</a>";
			else {
				$approven = "<a data-id='$id' class='btn-tools btn btn-success btn-sm btn-grad approve-user' title='$approve'>$approve</a><a data-id='$id' class='btn-tools btn btn-danger btn-sm btn-grad disable-user' title='$hide'  style='display:none;'>$hide</a>";
				$red = "class='unapproved'";
			}
			echo "<tr $red><td style='text-align: center; vertical-align: middle;  padding: 7px 8px 6px 10px;'>$foto</td><td style='width: 97%; padding: 7px 8px 8px 0;'><b>$qr[name]</b> <span>on</span> $title<a data-toggle='tooltip' data-placement='right' title='$info' class='icon-time tooltips'></a><a data-toggle='tooltip' data-placement='left' title='$qr[email]' class='icon-envelope-alt tooltips'></a>
			<br/><span>$comment ...</span><br/>
			<div class='tool-box tool-$no'>
				$approven
				<a href='$edit' class='btn btn-tools tips' title='$cedit'>$cedit</a>
				<a href='$lread#comment-$qr[id]' target='_blank'  class='btn btn-tools tips' title='$read'>$read</a>
				<!--a class='btn btn-tools tips' title='$delete'>$delete</a-->
			</div>
			</td></tr>";
			$no++;	
		}
		if($no < 1) { 
			echo "<tr><td style='text-align:center; padding: 40px 0; color: #ccc; font-size: 1.5em'>".No_Comment."</td></tr>";
		}
	?>
    </tbody>			
</table>
<script language="javascript" type="text/javascript">
$(function() {
	$('.approve-user').click(function() {
		var id = $(this).data('id');
		$.ajax({
			url: "apps/app_article/controller/comment_status.php",
			data: "stat=1&id="+id,
			success: function(data){
				$(this).parents("tr").removeClass('unapproved');
				$(this).hide();
				$(this).parent().find('.disable-user').show();
			}
		});		
	});
	$('.disable-user').click(function() {
		var id = $(this).data('id');
		$.ajax({
			url: "apps/app_article/controller/comment_status.php",
			data: "stat=0&id="+id,
			success: function(data){
				$(this).parents("tr").addClass('unapproved');
				$(this).hide();
				$(this).parent().find('.approve-user').show();
			}
		});
	});
	
	var hash = $('.c_gravatar[data-gravatar-hash]').attr('data-gravatar-hash');
	$.ajax({
		url: 'http://gravatar.com/avatar/'+ hash +'?size=32' ,
		type : 'GET',
		timeout: 5000, 
		error:	function(data){
			$('.c_gravatar[data-gravatar-hash]').prepend(function(){
				var hash = $(this).attr('data-gravatar-hash')
				return '<img width="32" height="32" alt="" src="../apps/app_comment/images/user.png" >'; 
			});	
		},
		success: function(data){
			$('.c_gravatar[data-gravatar-hash]').prepend(function(){
				var hash = $(this).attr('data-gravatar-hash')
				return '<img width="32" height="32" alt="" src="http://gravatar.com/avatar.php?size=36&gravatar_id=' + hash + '">';
			});
		}
	});
});	
</script>
