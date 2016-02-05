<?php
/**
* @version		2.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2014 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.txt
* @description	
**/

include('theme_data.php');
defined('_FINDEX_') or die('Access Denied');
?>
<!DOCTYPE html>
<html lang="id">
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=0" />
	<title><?php echo SiteTitle; ?> - AdminPanel</title>
	<?php include("module/auth.php"); ?>
	<link rel="shortcut icon" href="<?php echo AdminPath; ?>/images/favicon.png" />
	<link rel="stylesheet" href="<?php echo AdminPath; ?>/css/login.css" type="text/css">
	<script type="text/javascript" src="<?php echo AdminPath; ?>/js/jquery.min.js"></script>	
	<script type="text/javascript">
	<?php if(!isset($_SESSION['USER_ID']) AND isset($_GET['theme'])) : ?>
		location.reload();
	<?php endif; ?>							
	$(function() {
		$(".name").focus();
		$(".submit").click(function(e) {				
			$(".alert").remove();
			var name = $(".name").val();
			var pass = $(".pass").val();
			var url = $(".url").val();
			var t = $(this);
			if(pass !== '' && name !== '') {
				$(this).html("Loading...");	
				$(this).attr("disabled","disabled");	
				e.preventDefault();	
				$.ajax({
					url: "<?php echo FAdminPath; ?>/module/login.php",
					type: "GET",
					data: "user="+name+"&pass="+pass+"&url="+url,
					timeout : 10000,
					error: function(data){	
						alert(data);
						$(t).html("Login");
					},	
					success: function(data){
					try {
						var json = $.parseJSON(data);
						if(json.status == '0') {
							$(t).removeAttr("disabled");			
							$(t).html("Login");		
							$("#content").prepend(json.alert);						
						} else if(json.status == '1') {
							$("#content").prepend(json.alert);	
							location.reload();
						} else {
							$(t).removeAttr("disabled");						
							$(t).html("Login");		
							$("#content").prepend("Login Error!");	
						}
					} catch (e) {
						$("#content").prepend(data);	
						$(t).removeAttr("disabled");			
						$(t).html("Login");		
					}
					setTimeout(function(){
						$(".notice, .alert").fadeOut(function() {
							$(this).remove();
						});
						}, 10000);	
					}
				});						
			} 
			else {	
				if(name === '') {
				$(".name").focus();
				}
				else if(pass === '') {
				$(".pass").focus();
				}
				e.preventDefault();
				return false;
			}
		});
		
		$(".send-mail").click(function(e) {
			$(".notice, .alert").fadeOut('slow');
			var email = $(".email").val();
			var url = $(".url").val();
			if(email !== '' ) {
				var t = $(this).html("Loading...");	
				e.preventDefault();	
				$.ajax({
					url: "<?php echo FAdminPath; ?>/module/lost_password.php",
					type: "GET",
					data: "email="+email+"&url="+url,
					timeout : 10000,
					error: function(data){
						$(t).html("Send");	
					},	
					success: function(data){
						var json = $.parseJSON(data);
							$(t).html("Send");		
							$("#content").prepend(json.alert);			
						if(json.status == '1') {	
							$(".email").val('');			
						} 
						setTimeout(function(){
							$(".notice, .alert").fadeOut('slow');
						}, 10000);	
					}
				});
			}
			else {	
				if(email === '') {
				$(".email").focus();
				}
				e.preventDefault();
				return false;
			}
		});
		
		<?php if(!isset($_POST['forgot_password'])) :  ?>
		$(".femail").hide();
		<?php else : ?>
		$(".flogin").hide();		
		<?php endif; ?>
		
		$(".lost-password").click(function(e) {			
			$(".pass").toggle();			
			$(".name").toggle();			
			$(".email").toggle();			
			$(".back").toggle();			
			$("span").toggle();			
			$("button").toggle();			
		});
		
		$(".notice, .alert").click(function() {	
			alert();
		});
		
	});	
	</script>	
</head>
<?php if(checkMobile()) :?>
<body>
<?php else :?>
<body style="background-image: url(<?php echo $PARAM['background'];?>)";>      
<?php endif;?>  
	<div id="content">
        <div id="steps">
             <form id="formElem" method="post">
                <fieldset class="step">
                    <div class="legend"><img src="<?php echo $PARAM['logo'];?>" width="190"></div>
                    <div><input type="text" name="prevent_autofill" id="prevent_autofill" value="" style="display:none;" /><input type="password" name="password_fake" id="password_fake" value="" style="display:none;" />
                        <input name="user" autocomplete="OFF" type="text" class="name" placeholder="Username" />                    
                        <input name="email" autocomplete="OFF" type="email" class="email femail" placeholder="Email" style="display: none" />
                    </div>
                    <div>
                        <input name="pass" autocomplete="OFF" type="password" class="pass"  placeholder="&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;" />
                        <input name="url" type="hidden" class="url"/>
                    </div>
                    <div class="button">
                        <button id="registerButton" type="submit" name="fiyo_login" class="submit flogin" style="background: <?php echo $PARAM['button_color'];?>">Login</button>
                        <button id="registerButton" type="submit" name="forgot_password" class="send-mail femail" style="background: <?php echo $PARAM['button_color'];?> display: none">Send</button>
                    </div>
					<div style="width: 100%; text-align: center; margin-top: 10px;">
						<span class="lost-password flogin">Lost Password?</span>
						<span class="lost-password femail" style="display: none">User Login</span>
					</div>
                </fieldset>
			</form>	
         </div>
    </div>
	<img src="<?php echo AdminPath; ?>/images/ok.png" style="display: none; "/>
</body>
</html>
      