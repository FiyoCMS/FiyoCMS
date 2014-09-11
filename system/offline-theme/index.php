<?php
/**
* @version		Beta 1.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2011 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.php
**/

$OffTheme = FUrl.'/system/offline-theme';;

$db = new FQuery();  
$db->connect(); 
if(isset($_POST['login'])) {	
	$qr = $db->select(FDBPrefix."user","*","status=1 AND user='$_POST[user]' AND password='".MD5($_POST['pass'])."'"); 
	$qr = mysql_fetch_array($qr);
	$jml = mysql_affected_rows();
	if($jml > 0) {
		$_SESSION['USER_ID']  	= $qr['id'];
		$_SESSION['USER'] 		= $qr['user'];
		$_SESSION['USER_NAME']  = $qr['name'];
		$_SESSION['USER_EMAIL']	= $qr['email'];	
		$_SESSION['USER_LEVEL'] = $qr['level'];
		$_SESSION['USER_LOG'] 	= date('Y-m-d H:i:s');
		$db->select(FDBPrefix."session_login","*","user_id=$qr[id]");
		if($qr['id'] > 0) {
			$db->delete(FDBPrefix."session_login","id=$qr[id]");
			$qrs=$db->insert(FDBPrefix."session_login",array("$qr[id]","$qr[user]","$qr[level]",date('Y-m-d H:i:s')));  
		}	
	if(isset($qrs))
		redirect(getUrl());
	}
	else $failed = "Username or password is incorrect!";
}
?>

<html>

<head>
	<title>Website Maintenance</title>
	<link rel="shortcut icon" href="favicon.png" />
	<link rel="stylesheet" href="<?php echo $OffTheme; ?>/css/login.css" type="text/css">
	<script type="text/javascript" src="<?php echo $OffTheme; ?>/js/jquery.min.js"></script>
	<script type="text/javascript">
	$(function() {	
		$(".submit").click(function(e) {	
			var name = $(".name").val();
			var pass = $(".pass").val();
			if(pass !== '' && name !== '') {
				$(this).html("Loading...");	
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
		
		$(".notice").click(function() {	
			$(this).fadeOut();
		});
		setTimeout(function(){
			$('.notice').fadeOut(2000, function() {
			});				
		}, 3000);	
	});	
	</script>		
</head>

<body>        
	<div id="content">
        <div id="steps">
	<?php if(isset($failed )) : ?>
		<div class="notice error"><?php echo $failed; ?></div>
	<?php endif; ?>
             <form id="formElem" method="post">
                <fieldset class="step">
                    <p class="legend"><img src="<?php echo $OffTheme; ?>/images/fiyo.png" width="50"><br>Website Maintenance</p>
                    <p>
                       <input name="user" autocomplete="OFF" type="text" class="name" placeholder="Username" />
                   	</p>
                    <p>
                        <input name="pass" autocomplete="OFF" type="password" class="pass" placeholder="&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;" /> 						
					</p>
                    <p class="button">
                        <button type="submit" name="login" class="submit">Login</button>
                    </p>
                      </fieldset>
				</form>	
                    
         </div>
    </div>
</body>
</html>
      