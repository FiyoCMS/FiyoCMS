<?php
/**
* @name			Comment
* @version		2.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2014 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.txt
* @description	
**/

defined('_FINDEX_') or die('Access Denied');

?>
<script>
	function reloadCaptcha() {
		document.getElementById('captcha').src = document.getElementById('captcha').src+ '?' +new Date();
	}
	function validateEmail(email) { 
		var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
		return re.test(email);
	} 
	function is_valid_url(url)
	{
		 return url.match(/^(ht|f)tps?:\/\/[a-z0-9-\.]+\.[a-z]{2,4}\/?([^\s<>\#%"\,\{\}\\|\\\^\[\]`]+)?$/);
	}
	$(function() {
		$('.send_comment').click(function() {
			var name = $("#comment-name").val();
			var email = $("#comment-email").val();
			var text = $("#comment-text").val();
			var web = $("#comment-url").val();
			var link = "<?php echo $link;?>";
			var captcha = $("#comment-captcha").val();
			var t = $(this);
			if(!text || !email || !name) {
				if(!name)
				$("#comment-name").focus();
				else if(!email || !validateEmail(email))
				$("#comment-email").focus();
				else if(!text)
				$("#comment-text").focus();
			} 
			else if (url && !is_valid_url(url)) {
				$("#comment-url").focus();
			}			
			else {
			var url = "<?php echo FUrl;?>apps/app_comment/controller/insert.php";
			t.html("Loading...").attr('disabled','');
			$.ajax({
				type : "POST",
				data: "send=true&name="+name+"&email="+email+"&url="+web+"&text="+encodeURIComponent(text)+"&captcha="+captcha+"&link="+encodeURIComponent(link),
				url: url,
				timeout:5000, 
				error:function(data){ 
					alert("Something wrong, please refresh page! "+url);
					t.html("<?php echo Send_Comment;?>").removeAttr('disabled');
				},
				success: function(data){
					$(".notice-comment").remove();
					var json = $.parseJSON(data);
					$("#comments").after("<div class='alert notice-comment alert-"+json.status+"'>"+json.notice+"<\/div>");
					if(json.redirect == 1)
					$("#comments").after("<meta http-equiv='REFRESH' content='3; url=<?php echo getUrl();?>#comment-"+json.id+"'>");
					else if(json.status == 'success' || json.status == 'info')
						$("#comment-text").val("");
					t.html("<?php echo Send_Comment;?>").removeAttr('disabled');
				}
			});
			
			}
		});
	});	
</script>

<h3 id="comments" ><?php echo comment_Leave_Comment; ?></h3>
<?php echo @$notice; ?>
<form method="post" action="#comments" class="form-comment">
	<div id="input-personal-comment">
		<div>
		<label>
			<span><?php echo comment_Name; ?> *</span>
			<div>
				<input type='text' name='name' id="comment-name" value ="<?php echo @$name; ?>" <?php if(!empty($name)) echo "readonly"; ?>  class=" form-control input required" placeholder="Name" required></label>
			</div>
		</div>
		<div>
			<label><span><?php echo comment_Email; ?> *</span>
			<div>
				<input class="input required email  form-control" id="comment-email" type='email' name='email' value ="<?php echo @$email; ?>" <?php if(!empty($email)) echo "readonly"; ?> placeholder="name@email.com" required></label>
			</div>
		</div>
		<div>
			<label><span><?php echo comment_Website; ?> </span>
			<div>
				<input type="url" class="input  form-control" id="comment-url" name="web" value="<?php echo @$_POST['web']; ?>" placeholder="www.yoursite.com" /></label>
			</div>
		</div>	
	</div>	
	<div id="input-text-comment">
		<label><span><?php echo comment_Comment; ?> *</span>
		<div>
			<textarea class="input required form-control" id="comment-text" name='com' style='width:100%; max-width : 100%;' rows="8" required data-placeholder="<?php echo leave_a_comment; ?>" placeholder="<?php echo leave_a_comment; ?>"><?php echo @$_POST['com']; ?></textarea></label>
		</div>
	</div>
	<?php if(empty($privatekey) or empty($publickey )) : ?>
	<!-- div><span><?php echo comment_Security_Code; ?>  * </span> <div><img src="<?php echo FUrl; ?>/plugins/plg_mathcaptcha/image.php" alt="Click to reload image" title="Click to reload image" id="captcha" onclick="javascript:reloadCaptcha()" class="captcha-image" /></div><input type="text" name="secure" placeholder="What's the result?" onclick="this.value=''" id="comment-captcha"  class="input required numeric" required /></div -->
	<?php else : ?>
	<div>
		<span>ReCaptcha *</span>
			<div>
				<script type="text/javascript">
					 var RecaptchaOptions = {
						theme : 'clean'
					};
				</script>
				<?php echo recaptcha_get_html($publickey);?>
			</div>
	</div>
	<?php endif; ?>
	<div style="overflow: visible;">
		<button type='button' name='send-comment' class='comment-button button btn send_comment' value="Send"><?php echo Send_Comment;?></button>
	</div>
</form>