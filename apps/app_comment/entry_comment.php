<?php 
/**
* @name			Comment
* @version		2.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2014 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.txt
*/


defined('_FINDEX_') or die('Access Denied');
$db = new FQuery();  
$sql = $db->select(FDBPrefix.'comment','*',"link='$link' AND status=1","date ASC");	
$count	= count($sql);
if($count != 0 ) :
if(siteConfig('lang') == 'id') {
 $count = "$count Komentar";
} else {
if($count < 2) $count = "$count Comment"; else $count = "$count Comments"; 
}

?>

<script>
$(function() {	
	var hash = $('.cmn-gravatar[data-gravatar-hash]').attr('data-gravatar-hash');
	$.ajax({
		url: 'http://gravatar.com/avatar/'+ hash +'?size=48' ,
		type : 'GET',
		timeout: 5000, 
		error:function(data){
			$('.cmn-gravatar[data-gravatar-hash]').prepend(function(){
				var img = $(this).find("img").length ;
				if(img > 0) img.remove();
				var hash = $(this).attr('data-gravatar-hash');
				return '<img width="48" height="48" alt="" src="../apps/app_comment/images/user.png" >'; 
			});	
		},
		success: function(data){
			$('.cmn-gravatar[data-gravatar-hash]').prepend(function(){
				var img = $(this).find("img").length ;
				if(img > 0) img.remove();
				var hash = $(this).attr('data-gravatar-hash');
				return '<img width="48" height="48" alt="" src="http://gravatar.com/avatar.php?size=48&gravatar_id=' + hash + '">';
			});
		}
	});	
});		
</script>

<div class="comment-entry">
<?php
echo "<h3>$count</h3>";	
$no=1;				
foreach($sql as $com){
	$autmail= strtolower($com['email']); 
	$autmail = md5($autmail);
	$img = "<span class='cmn-gravatar' data-gravatar-hash='$autmail'></span>";	
	$uid = $com['user_id'];	
	$level = userInfo('level',$uid);
	if($level == 1 AND $uid > 0)
		$s = " admin-comment";
	else
		$s ="";
	$com['website'] = str_replace("http://","","$com[website]");
	if(empty($com['website'])) 					
		$name = "$com[name]";
	else
		$name = "<a href='http://$com[website]'>$com[name]</a>";
		
	$comment = str_replace("<","&lt;",$com['comment']);
	$comment = str_replace(">","&gt;",$comment);
	$comment = str_replace("\n","<br>",$comment);
	$comment = str_replace("[b]","<b>",$comment);
	$comment = str_replace("[/b]","</b>",$comment);
	$comment = str_replace("[i]","<i>",$comment);
	$comment = str_replace("[/i]","</i>",$comment);
	$comment = str_replace("[u]","<u>",$comment);
	$comment = str_replace("[/u]","</u>",$comment);
	$comment = str_replace("{","&#123;",$comment);
				
	echo "<div class='inner-comment$s' id='comment-$com[id]'>";
	echo "<div class='avatar-comment'>$img</div>";
	echo "<div class='right-comment'><b>$name</b> on $com[date]<div class='main-comment'><span><i><a href='".make_permalink(getLink())."#comment-$com[id]' title='comment permalink'>#$no</a></i></span>$comment </div></div>";	
	echo "</div>";
	$no++;	
}; ?>

</div>
<?php endif; ?>