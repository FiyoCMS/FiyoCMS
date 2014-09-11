<?php
/**
* @name			User
* @version		2.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2014 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.txt
*/

defined('_FINDEX_') or die('Access Denied');


$success = false;
if(siteConfig('member_registration'))
	$new = "<a class='register' href='".make_permalink('?app=user&view=register')."'>Register</a>";		
$key = $_GET['res'];
if(isset($_POST['token']))
	$key = $_POST['key'];
if(isset($_SESSION['USER_REMINDER']) AND !empty($_SESSION['USER_REMINDER']) AND $key == $_SESSION['USER_REMINDER']) {
		$password_n = randomString(8);
		$password_m = md5($password_n);
		$id = $_SESSION['USER_REMINDER_ID'];
		$qr = $db->update(FDBPrefix.'user',array("password"=>"$password_m"),"id=$_SESSION[USER_REMINDER_ID]"); 
		if($qr)  {
			$webmail = siteConfig('site_mail'); 
			$domain  = substr(FUrl(),0,strpos(FUrl(),"/")); 
			if(empty($webmail)); $webmail = "noreply@$domain";
			
			$email = userInfo('email',$id);
			$user = userInfo('user',$id);
			$name = userInfo('name',$id);
			$to  = "$email" ;
			if(siteConfig('lang') == 'id') {
			$subject = 'Informasi Akun Baru';
			$message = "<font color='#333'>
			<p>Hi, $name</p> 
			<p>Password Anda telah diset ulang dan berikut adalah data login akun Anda.</p>
			<p>Username \t= $user<br>Password \t= $password_n</p>
			<p>Jaga selalu kerahasiaan akun Anda untuk mencegah hal yang tidak diinginkan.<br>Terimakasih.</p>
			<p>&nbsp;</p>
			<p><b>".SiteTitle."</b><br>".FUrl."</p></font>";
			}
			else {			
			$subject = 'New Account Information';
			$message = "<font color='#333'>
			<p>Hello, $name</p> 
			<p>Your password has been reset and here are your data account login.</p>
			<p>Username \t= $user<br>
			Password \t= $password_n</p>
			<p>Please always keep the confidentiality of your account to prevent unwanted crimes.<br>Thankyou.</p>
			<p>&nbsp;</p>
			<p><b>".SiteTitle."</b><br>".FUrl."</p></font>";			
			}	
		// To send HTML mail, the Content-type header must be set
			$headers  = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

		// Additional headers
			$headers .= "To: $name <$mail>" . "\r\n";
			
			$headers .= 'From: '.SiteName. "<$webmail>" ."\r\n";
			$headers .= 'cc :' . "\r\n";
			$headers .= 'Bcc :' . "\r\n";

		// Mail it
			$mail = @mail($to,$subject,$message,$headers);
			if($mail)  {
				$_SESSION['USER_REMINDER'] = $_SESSION['USER_REMINDER'] = null;				
				$notice = alert("info",user_Password_Reset_Success);
				$success = true;
			}
			else {		
				$notice = alert("error",user_Password_Reset_Fail);
			}
		}
		else
			$notice = alert("error",user_Password_Reset_Fail);
	}
	else {
		$notice = alert("error",user_Password_Reset_Fail);
	}
?>
<div id="user">
	<h1>Password Reminder</h1>
	<?php echo $notice; ?>
	<?php echo userNotice; ?>
	<form action="" method="post">
		<?php if($success) : ?>		
		<p class="user-desc"><?php echo user_Password_Reset_Success2; ?></p>		
		<?php else : ?>
		<p class="user-desc"><?php echo user_Password_Reset_Key; ?></p>
		<div>
			<span>Key</span>  <input style="width: 300px" type="text" name="key" <?=formRefill('key',$_GET['res']);?> />
		</div>
		<div class="user-link">
			<span>&nbsp;</span>
			<input type="submit" name="token" value="<?php echo Send; ?>" class="button btn login"/>
			<a href="<?php echo make_permalink('?app=user&view=login') ?>">Login</a> <?php echo @$new; ?>
		</div>
		<?php endif;?>
	</form>
</div>