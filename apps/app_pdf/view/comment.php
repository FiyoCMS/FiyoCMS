<?php
/**
* @version		1.5.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2012 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.txt
**/

defined('_FINDEX_') or die('Access Denied');

?>

<script language="javascript" type="text/javascript">
$(function() {	
	var hash = $('.cmn-gravatar[data-gravatar-hash]').attr('data-gravatar-hash');
	$.ajax({
		url: 'http://gravatar.com/avatar/'+ hash +'?size=32' ,
		type : 'GET',
		timeout: 5000, 
		error:function(data){
			$('.cmn-gravatar[data-gravatar-hash]').prepend(function(){
				var hash = $(this).attr('data-gravatar-hash')
				return '<img width="34" height="34" alt="" src="<?=FUrl;?>/apps/app_comment/images/user.png" >'; 
			});	
		},
		success: function(data){
			$('.cmn-gravatar[data-gravatar-hash]').prepend(function(){
				var hash = $(this).attr('data-gravatar-hash')
				return '<img width="34" height="34" alt="" src="http://gravatar.com/avatar.php?size=36&gravatar_id=' + hash + '">';
			});
		}
	});
	
});	
</script>
<a id="comments"></a>
<?php
if(USER_LEVEL <= pdfConfig('user_access') AND USER_ID != pdfInfo('author_id')) :
	echo "<div class='comment invalid '><b>Send Feedback and Ratings</b></div>";

	if(isset($_POST['send-comment'])){
		if(checkOnline() AND !empty($privatekey) AND !empty($publickey )) {
			$capthca = recaptcha_check_answer ($privatekey,
				   $_SERVER["REMOTE_ADDR"],
				   $_POST["recaptcha_challenge_field"],
				   $_POST["recaptcha_response_field"]);			
			if($capthca->is_valid AND checkOnline()) 
			$valid = 1;
		}
		
		if(empty($_POST['name']) or empty($_POST['email']) or empty($_POST['com'])) {	
			echo "<div class='comment invalid'>".Please_fill_the_marked_field."</div>";
		}
		else if(!preg_match("/^.+@.+\\..+$/",$_POST['email'])){	
			echo "<div class='comment invalid'>Email not valid !</div>";
		}
		else if($_POST['secure'] == $_SESSION['captcha'] or isset($valid)){
			$name = oneQuery('comment_setting','name',"'name_filter'",'value');
			$name = explode(",",$name);
			foreach($name as $namef) {
				if(strtolower($_POST['name']) == strtolower(trim($namef)))
				$name = 0;
			}		
			$email = oneQuery('comment_setting','name',"'email_filter'",'value');
			$email = explode(",",$email);
			foreach($email as $emailf) {
				if(strtolower($_POST['email']) == strtolower(trim($emailf)))
				$email = 0;
			}		
			$filter = oneQuery('comment_setting','name',"'word_filter'",'value');
			$filter = explode(",",$filter);
			foreach($filter as $filterf) {
				$f = strtolower(trim($filterf));
				$t = strtolower($_POST['com']);
				$s = @strpos($t,$f);
				$s = str_replace(0,1,$s) ;
				if(!empty($s))
				$filter = 0;
			}		
			
			if(!$filter) {			
				echo "<div class='comment invalid'>".Banned_words."</div>";		
			}
			else {			
				$auto = oneQuery('comment_setting','name',"'auto_submit'",'value');
				if($auto == 0) {
					if(User_Level ==1 or User_Level ==2) $auto = 1;
					else $auto = null;
				}			
				
				$com = $db->insert(FDBPrefix.'pdf_comment',array("","$id",USER_ID,"$_POST[title]","$_POST[com]",'',date("Y-m-d"),1));
				
				$rate = pdfInfo('rate');
				if(isset($_POST['rate']) AND $rate != 0 )
					$rate = ($_POST['rate']+$rate) /2;
				else if($rate == 0)
					$rate = $_POST['rate'];
				$qr=$db->update(FDBPrefix.'pdf_file',array("rate"=>"$rate"),
					"id=$id");
				
				if($com)
					echo "<div class='comment valid'>".Your_comment_saved."</div>";
			}
		}
		else {
			echo "<div class='comment invalid'>Security code is wrong!</div>";
		}
	}
	$email = oneQuery('comment_setting','name',"'email_filter'",'value');
?>

<script language="javascript" type="text/javascript">
$(document).ready(function() {
	$("#comment").validate();
});	
function reloadCaptcha() {
	document.getElementById('captcha').src = document.getElementById('captcha').src+ '?' +new Date();
}
</script>

<form method="post" id="comment" action="#comments">
	<div><label><span>Name *</span><div>
		<input type='text' name='name' value ="<?php echo @$name; ?>" class="input required"></label></div>
	</div>
	<div><label><span>Email *</span><div>
		<input class="input required email" type='text' name='email' value ="<?php echo @$email; ?>"></label></div>
	</div>
	<div><label><span>AddOns Rate * </span><div>
	<?php 
	if(FQuery('pdf_comment',"USER_ID = ".USER_ID." AND file_id = $id")==0) :
	 ?>
		<select name="rate" class="rate">
			<option value='5'>-----</option>
			<option value='4'>----*</option>
			<option value='3'>---**</option>
			<option value='2'>--***</option>
			<option value='1'>-****</option>
		</select>
		<?php else : echo You_already_rate;  endif;?>
		</div>
	</div>
	<div><label><span>Topic *</span><div>
		<input type='text' name='title' value ="<?php echo @$_POST['title']; ?>" class="input required" size="40"></label></div>
	</div>
	<div><label><span>Comment *</span><div>
		<textarea class="input required" name='com' cols="71" rows="6"><?php echo @$_POST['com']; ?></textarea></label></div>
	</div>
	<?php if(empty($privatekey) or empty($publickey )) : ?>
	<div><label><span>Security * </span> <div><img src="<?php echo FUrl; ?>plugins/plg_mathcaptcha/image.php" alt="Click to reload image" title="Click to reload image" id="captcha" onclick="javascript:reloadCaptcha()" /></div><input type="text" name="secure" placeholder="What's the result?" onclick="this.value=''" class="input required numeric" /></div>
	<?php else : ?>
	<div>
		<label><span>ReCaptcha *</span>
			<div>
				<script type="text/javascript">
					 var RecaptchaOptions = {
						theme : 'clean'
					};
				</script>
				<?php echo recaptcha_get_html($publickey);?>
			</div>
		</label>
	</div>
	<?php endif; ?>
	<div>
		<label><input type='submit' name='send-comment' class='commentBtn' value="Send"></label>
	</div>
</form>	

<?php 
elseif (USER_ID == pdfInfo('author_id')) :
	if(isset($_POST['reply'])) {  
		$qr=$db->update(FDBPrefix.'pdf_comment',array("author_reply"=>"$_POST[text]"),"id=$_POST[id]");
		echo "<div class='comment valid'>".Your_comment_saved."</div>";
		}
	else if(isset($_POST['on'])) {  
		$qr=$db->update(FDBPrefix.'pdf_comment',array("status"=>"1"),"id=$_POST[id]");
		echo "<div class='comment valid'>".Your_comment_saved."</div>";
		}
	else if(isset($_POST['off'])) {  
		$qr=$db->update(FDBPrefix.'pdf_comment',array("status"=>"0"),"id=$_POST[id]");
		echo "<div class='comment valid'>".Your_comment_saved."</div>";
		}
	else 
		echo "<div class='comment invalid'>".You_not_allowed_rate_yourself."</div>";
else :
	echo "<div class='comment invalid'>".Please_login_first_before_comment."</div>";
endif; 

if(!defined('SEF_URL')) {	
	$link = check_permalink('link',getLink(),'link');	
	$go_link = FUrl.getLink()."&pid=$_GET[pid]";
	}
else {
	$link = @check_permalink('permalink',$_REQUEST['link'],'link');
	$go_link = FUrl.@$_REQUEST['link'].SEF_EXT;
}
$id = pdfInfo('id');
$aid = pdfInfo('author_id');
if($id == USER_ID)
	$sql = $db->select(FDBPrefix.'pustaka_comment','*',"file_id=$id","ID ASC");
else	
	$sql = $db->select(FDBPrefix.'pustaka_comment','*',"file_id=$id AND status=1","ID ASC");	
$o = mysql_affected_rows();
	
$privatekey = pdfCOnfig('recaptcha_privatekey');
$publickey = pdfCOnfig('recaptcha_publickey');

echo "<div class='comment label'>$o Feedback</div>";
$no=1;					
while($com=mysql_fetch_array($sql)){
	$email = strtolower(userInfo($com['user_id'])); 
	$email = md5($email);
	
	$img = "<span class='cmn-gravatar' data-gravatar-hash='$email'></span>";	
	
	if($com['user_id']==1 or $com['user_id']==2) 
		$s = " admin-comment";
	else
		$s ="";
	$ulink = make_permalink('?app=pdf&view=user&id=1'.$com['user_id']);
	$uname = oneQuery('user','id',$com['user_id'],'name');
	$name = "<a href='$ulink'>$uname</a>";
		
	$comment = str_replace("<","&lt;",$com['comment']);
	$comment = str_replace(">","&gt;",$comment);
	$comment = str_replace("\n","<br>",$comment);
	$comment = str_replace("[b]","<b>",$comment);
	$comment = str_replace("[/b]","</b>",$comment);
	$comment = str_replace("[i]","<i>",$comment);
	$comment = str_replace("[/i]","</i>",$comment);
	$comment = str_replace("[u]","<u>",$comment);
	$comment = str_replace("[/u]","</u>",$comment);
	
	
	$author_reply = $com['author_reply'];
	
	$author_reply = str_replace(">","&gt;",$author_reply);
	$author_reply = str_replace("\n","<br>",$author_reply);
	$author_reply = str_replace("[b]","<b>",$author_reply);
	$author_reply = str_replace("[/b]","</b>",$author_reply);
	$author_reply = str_replace("[i]","<i>",$author_reply);
	$author_reply = str_replace("[/i]","</i>",$author_reply);
	$author_reply = str_replace("[u]","<u>",$author_reply);
	$author_reply = str_replace("[/u]","</u>",$author_reply);
	
	if($com['status'] == 0) $sts = 'hidden'; else $sts ='';
	echo "<div class='inner-comment$s $sts'  id='comment-$no'>";
	echo "<div class='avatar-comment'>$img</div>";
	echo "<div class='right-comment'><span class='title'>$com[title]</span> by $name on $com[date]<div class='main-comment'><span><i><a href='".getLink()."#comment-$no' title='comment permalink'>#$no</a></i></span> $comment ";
	
	if(USER_ID == pdfInfo('author_id'))  {
	?><form method="post">
		<input type="hidden" value="<?php echo $com['id']; ?>" name="id">
		<b>Your reply here : </b><br>
		<textarea name="text" rows="4" style="max-width:96.5%; min-width:96.5%" placeholder="Your reply here!"><?php echo $com['author_reply'] ?></textarea>
		<br>
			<input style=" cursor:pointer" type="submit" value="Send Now" class="button" name="reply">
		<?php if($com['status']==1) : ?>
			<input style=" cursor:pointer" type="submit" value="Hide Comment" class="button" name="off">
		<?php else : ?>
			<input style=" cursor:pointer" type="submit" value="Show Comment" class="button" name="on">
		<?php endif; ?>
	</form>
	<?php
	}
	
	else if(!empty($com['author_reply'])) 
		echo "<div class='author reply'><b>Author Reply</b>:<br>$author_reply</div>";
	echo "</div></div></div>";
	$no++;	
}
?>

