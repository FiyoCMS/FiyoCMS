<?php
/**
* @name			User
* @version		1.5.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2012 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.txt
*/

defined('_FINDEX_') or die('Access Denied');

if(siteConfig('member_registration'))
	$new = "<a class='register' href='".make_permalink('?app=user&view=register')."'>Register</a>";
	$key = $_GET['key'];
	$sql = $db->select(FDBPrefix."user","*","status=0 AND about='$key'");
	$qrs = mysql_fetch_array($sql);
	$id  = $qrs['id'];
	$time  = $qrs['time_reg'];
	if(isset($_GET['key']) AND !empty($_GET['key'])) {		 
		if(!empty($id))  {
			$linkLogin = make_permalink('?app=user&view=login');
			$webmail = siteConfig('site_mail'); 
			$webmail = siteConfig('site_mail'); 
			$domain  = str_replace("/","",FUrl()); 
			if(empty($webmail)) $webmail = "no-reply@$domain";
			
			$email = userInfo('email',$id);
			$user = userInfo('user',$id);
			$name = userInfo('name',$id);
			$pass = userInfo('password',$id);
			$to  = "$email" ;
			if(siteConfig('lang') == 'id') {
				$subject = 'Informasi Data Akun';
				$message = "<font color='#333'>
				<p>Halo, $name</p> 
				<p>Selamat, akun Anda telah aktif dan bisa digunakan.</p>
				<p>Berikut adalah detil data akun Anda :</p>
				<p>&nbsp;</p>
				<p>Username = $user</p>
				<p>Password = $pass</p>
				<p>&nbsp;</p>
				<p>URL login : $linkLogin</p>
				<p>&nbsp;</p>
				<p>Jaga selalu kerahasiaan akun Anda untuk mencegah hal yang tidak diinginkan.</p>
				<p>Terimakasih.</p>
				<p>&nbsp;</p>
				<p>&nbsp;</p>
				<p><b>".SiteTitle."</b>".FUrl."</p></font>";
			}
			else {			
				$subject = 'New Account Information';
				$message = "<font color='#333'>
				<p>Hello, $name</p> 
				<p>Congratulations, your account has been activated and you can login now.</p>
				<p>Here are the details of your account data :</p>
				<p>&nbsp;</p>
				<p>Username = $user</p>
				<p>Password = $pass</p>
				<p>&nbsp;</p>
				<p>URL login : $linkLogin</p>
				<p>&nbsp;</p>
				<p>Please always keep the confidentiality of your account to prevent unwanted crimes.</p>
				<p>Thankyou.</p>
				<p>&nbsp;</p>
				<p>&nbsp;</p>
				<p><b>".SiteTitle."</b><br>".FUrl."</p></font>";			
			}	
		// To send HTML mail, the Content-type header must be set
			$headers  = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

		// Additional headers
			$headers .= "To: $name <$email>" . "\r\n";
			
			$headers .= 'From: '.SiteTitle. "<$webmail>" ."\r\n";
			$headers .= 'cc :' . "\r\n";
			$headers .= 'Bcc :' . "\r\n";

		// Mail it
			$mail = @mail($to,$subject,$message,$headers);
			if($mail)  {
				$qr = $db->update(FDBPrefix.'user',array("status"=>"1","about"=>"","time_reg" => "$time","password" => md5($pass)),"id = $id");			
				$notice = alert("info",user_Password_Activation_Sent,true);
				$notice2 = user_Password_Activation_Sent2;
			}
			else {		
				$notice = alert("error","Error, Server failed to send email.",true);
			}
		}
		else
			$notice = alert("error",user_Password_Activation_Fail,true);
	}
	else {
		$notice = alert("error",user_Password_Activation_Fail,true);
	}
?>
<div id="user">
	<h1>User Activation</h1>
	<?php echo $notice; ?>
	<form action="" method="post">
		<div>
			<?php echo @$notice2; ?>
		</div>
		<div style="padding: 5px 0;">
			<a href="<?php echo make_permalink('?app=user&view=login') ?>" class="button btn login">Login</a> <?php echo @$new; ?>
		</div>
	</form>
</div>