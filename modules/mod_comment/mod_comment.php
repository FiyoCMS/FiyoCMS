<?php 
/**
* @version		2.0
* @package		Comments
* @copyright	Copyright (C) 2014 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.txt
**/

defined('_FINDEX_') or die('Access Denied');

$name = mod_param('name',$modParam);
$date = mod_param('date',$modParam);
$text = mod_param('text',$modParam);
$item = mod_param('item',$modParam);
$title = mod_param('title',$modParam);
$scomment = mod_param('comment',$modParam);
$gravatar = mod_param('gravatar',$modParam);

if($item=="" or empty($item)) $item = 5;
	

$db = new FQuery();  
$db->connect(); 	

$sql = $db->select(FDBPrefix.'comment','*',"status=1","date DESC LIMIT $item");	
$no = 0;
foreach($sql as $com){
	$email = strtolower($com['email']); 
	$email = md5($email );
	
		$img = "<span class='mod-gravatar' data-gravatar-hash='$email'></span>";	
	
	if($com['user_id']==1 or $com['user_id']==2) 
		$s = " admin-comment";
	else
		$s ="";
				
	echo "<div class='mod-inner-comment'>";
	if($gravatar) {
		echo "<div class='mod-avatar-comment'>$img</div>";
		echo "<div class='mod-right-comment'>";
	}
	else {
		echo "<div class='mod-right-comment u3'>";
	}
	
	$ltitle = strpos($com['link'],'id=');
	$ltitle = substr($com['link'],$ltitle+3);
	$ltitle = oneQuery('article','id',$ltitle,'title');
	$ltitle = "<a href='".make_permalink($com['link'])."' title='comment permalink'>$ltitle</a>";
	
	if($name AND $title AND $date) echo "<span>$com[name]</span> <em>$com[date]</em><br/> on $ltitle";
	else if(!$name AND $title AND $date) echo "$ltitle on <em>$com[date]</em>";
	else if($name AND  $title) echo "<span>$com[name]</span> on $ltitle";
	else if($name AND  $date) echo "<span>$com[name]</span> on <em>$com[date]</em>";
	else if($name) echo "<span>$com[name]</span>";
	else if($date) echo "$com[date]";
	else if($title) echo "$ltitle";	
	$comment = substr($com['comment'],0,$text);
	
	if(strlen($com['comment']) > $text) $comment .= "...";
	if($scomment) echo "<div class='mod-comment-detail'>$comment</div>";
	
	echo "</div></div>";
	$no++;
}				
?>

<script>
$(function() {	
	var hash = $('.mod-gravatar[data-gravatar-hash]').attr('data-gravatar-hash');
	$.ajax({
		url: 'http://gravatar.com/avatar/'+ hash +'?size=36' ,
		type : 'GET',
		timeout: 5000, 
		error:function(data){
			$('.mod-gravatar[data-gravatar-hash]').prepend(function(){
				var img = $(this).find("img").length ;
				if(img > 0) img.remove();
				var hash = $(this).attr('data-gravatar-hash')
				return '<img width="36" height="36" alt="" src="<?php echo FUrl;?>/apps/app_comment/images/user.png" >'; 
			});	
		},
		success: function(data){
			$('.mod-gravatar[data-gravatar-hash]').prepend(function(){
				var img = $(this).find("img").length ;
				if(img > 0) img.remove();
				var hash = $(this).attr('data-gravatar-hash')
				return '<img width="36" height="36" alt="" src="http://gravatar.com/avatar/' + hash + '?size=36">';
			});
		}
	});	
});		
</script>