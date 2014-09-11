<?php
/**
* @name			User
* @version		2.0
* @package		Fiyo CMS 
* @copyright	Copyright (C) 2014 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.txt
**/

defined('_FINDEX_') or die('Access Denied');

$db = new FQuery();  
loadLang(__dir__);

$view = app_param('view');
$key = @mysql_real_escape_string($_GET['key']);
$res = @mysql_real_escape_string($_GET['res']);

$linkLogin = make_permalink('?app=user&view=login');
$linkUser = make_permalink('?app=user');
$btnClass = 'style="text-align: center;  font-size: 11px;  font-family: arial,sans-serif;  color: white;  font-weight: bold;  border-color: #3079ed;  background-color: #4d90fe;  background-image: linear-gradient(top,#4d90fe,#4787ed);  text-decoration: none;  display: inline-block;  min-height: 27px;  padding-left: 8px;  padding-right: 8px;  line-height: 27px;  border-radius: 2px;  border-width: 1px;
"';
if($view == 'register' or $view == 'login' or $view == 'forgot' ){
	if(!empty($_SESSION['USER_ID']))
		redirect($linkUser);
	else if(!siteConfig('member_registration') AND $view == 'register')
		redirect($linkLogin);
}
else if($view == 'profile' or $view == 'logout' or $view == 'edit' or empty($view)) {
	if(empty($_SESSION['USER_ID']) AND empty($key) AND empty($res)) redirect($linkLogin);
}
if(isset($_POST['register']) AND siteConfig('member_registration')) {
	$us=strlen("$_POST[user]");
	$ps=strlen("$_POST[password]");	
	$user = $_POST['user'];	
	preg_match('/[^a-zA-Z0-9]+/', $user, $matches);
	if(	!empty($_POST['password']) AND 
		!empty($_POST['user'])AND 
		!empty($_POST['capthca'])AND 
		!empty($_POST['email'])AND 
		$_POST['password']==$_POST['kpassword'] AND 
		$us>2 AND $ps>3 AND !$matches) {
		if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
			define("userNotice", alert("error",user_Email_Invalid));
		}
		else if($_POST['capthca'] == $_SESSION['captcha']) {
			$group = siteConfig('member_group');
			if(empty($group)) $group = 5;
			$activator	= siteConfig('member_activation');
			$siteName	= siteConfig('site_name');
			$siteLang	= siteConfig('lang');
		
			$key = md5($_POST['email']+randomString(6)+$_POST['user']);
			$keys = "app=user&key=$key";
			if($activator == 0) $key = 'Waiting for activation...';
			else if($activator == 1) $key = null;
			$webmail = siteConfig('site_mail'); 
			$domain  = substr(FUrl(),0,strpos(FUrl(),"/")); 
			if(empty($webmail)); $webmail = "noreply@$domain";
			
			if($activator == 0) { 
				$pass = MD5($_POST['password']);
				$s = 0;
			} else if($activator == 1) { 
				$pass = MD5($_POST['password']);
				$s = 1;			
			} else if($activator == 2) { 
				$pass = MD5($_POST['password']);
				$s = 0;			
			}
			$qr=$db->insert(FDBPrefix.'user',array("","$_POST[user]","$_POST[user]",$pass,"$_POST[email]","$s","$group",date('Y-m-d H:i:s'),date('Y-m-d H:i:s'),"$key"));
			if($qr) {
				if($activator == 2) {
					if($siteLang == 'id') {
					$subject = "Aktifasi Akun Baru";
					$message = "<p>Hi, $_POST[user],</p> 
						<p>Terimakasih sudah bergabung bersama kami di $siteName.</p>
						<p>Kami perlu melakukan konfirmasi untuk mengaktifkan akun Anda.<br>Klik link berikut untuk mengaktifkan akun Anda. :</p>
						<p><a href='".FUrl."?$keys' $btnClass> Aktifasi Akun </a></p>
						<p>Jaga selalu data Anda dari segala sesuatu yang tidak diinginkan.<br>Terimakasih.</p>
						<p>&nbsp;</p>
						<p><b>$siteName.</b><br>
						".FUrl."</p>";		
					}
					else {
					$subject = "New Account Activation";
					$message = "<p>Hi, $_POST[user],</p>
						<p>Thank you, you have to register and join us on $siteName.</p>
						<p>We need to confirm to activate your account.<br>Click the following link to activate your account:</p>
						<p><a href='".FUrl."?$keys' $btnClass> Account Activation </a></p>
						<p>Please save your data account carefully.<br>Thankyou.</p>
						<p>&nbsp;</p>
						<p><b>$siteName.</b><br>
						".FUrl."</p>";
					}
				}
				else {
					if($siteLang == 'id') {
					$subject = "Informasi Data Login";
					$message = "<p>Hi, $_POST[user],</p> 
						<p>Terimakasih sudah bergabung bersama kami di $siteName.</p>";
						
					if($activator == 0)
					$message = $message . "<p>Akun anda masih menunggu persetujuan untuk diaktifkan.</p>";
						
					$message = $message . "			
						<p>&nbsp;</p>			
						<p>Berikut adalah data login Anda :</p><p>&nbsp;</p>
						<p>Username : $_POST[user]</p>
						<p>Password : $_POST[password]</p><p>&nbsp;</p>
						<p>&nbsp;</p>
						<p>URL login : $linkLogin</p>
						<p>&nbsp;</p>
						<p>Jaga selalu data Anda dari segala sesuatu yang tidak diinginkan.</p>
						<p>Terimakasih.</p>
						<p>&nbsp;</p><p>&nbsp;</p>
						<p><b>$siteName.</b><br>
						".FUrl."</p>";		
					}
					else {
					$subject = "Account Login Information";
					$message = "<p>Hi, $_POST[user],</p>
						<p>Thank you, you have to register and join us on $siteName.</p>";
					if($activator == 0)
					$message = $message . "<p>Your account is still waiting for approval to be activated.</p>";
						
					$message = $message . "			
						<p>&nbsp;</p>	
						<p>Here are details of your account :</p><p>&nbsp;</p>
						<p>Username : $_POST[user]<br>Password : $_POST[password]</p>
						<p>URL login : $linkLogin</p>
						<p>&nbsp;</p>
						<p>Take good care of your accounts from any forms of crime.<br>Thankyou.</p>
						<p>&nbsp;</p><p>&nbsp;</p>
						<p><b>$siteName.</b><br>
						".FUrl."</p>";
					}
				}
				$to  = "$_POST[email]" ;
				$headers  = 'MIME-Version: 1.0' . "\r\n";
				$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
				$headers .= "To: $_POST[user] <$_POST[email]>"."\r\n";
				$headers .= "From: ".SiteName." <$webmail>" . "\r\n";
				$email = @mail($to,$subject,$message,$headers);	
				
				if($activator == 0) {
					define("userNotice","need_admin_activation");
				}
				else if($activator == 1) {
					$db->insert(FDBPrefix."session_login",array("$qr[id]","$qr[user]","$qr[level]",date('Y-m-d H:i:s')));
					
					$sql = $db->select(FDBPrefix."user","*","status=1 AND user='$_POST[user]' AND password='".MD5($_POST['password'])."'");
					$qr = mysql_fetch_array($sql);
					$_SESSION['USER_ID']  	= $qr['id'];
					$_SESSION['USER'] 		= $qr['USER'];
					$_SESSION['USER_NAME']  = $qr['name'];
					$_SESSION['USER_EMAIL']	= $qr['email'];	
					$_SESSION['USER_LEVEL']	= $qr['level'];	
					$_SESSION['USER_LOG'] 	= date('Y-m-d H:i:s');
					redirect($linkUser);
				}		
				else if($activator == 2 AND $email) {	
					define("userNotice","need_email_activation");
				}		
				else if(!$email) {		
					$db->delete(FDBPrefix."user","user = '$_POST[user]'");
					define("userNotice",alert("error","Sorry, mail server error :("));
				}
			}
			else 
				define("userNotice",alert("error",user_Registration_Exists));
		} else 
			define("userNotice",alert("error",user_Security_Invalid));
	}
	else  {						
		define("userNotice",alert("error",user_Please_Complete_Fields));
	}
}
		
if(isset($_POST['login'])) {
	$user = mysql_real_escape_string($_POST['user']);
	$qr = $db->select(FDBPrefix."user","*","status=1 AND user='$user' AND password='".MD5($_POST['pass'])."'"); 
	$qr = mysql_fetch_array($qr);
	$ok = mysql_affected_rows();
	if($ok > 0) {
		$_SESSION['USER_ID']  	= $qr['id'];
		$_SESSION['USER'] 		= $qr['user'];
		$_SESSION['USER_NAME']  = $qr['name'];
		$_SESSION['USER_EMAIL']	= $qr['email'];	
		$_SESSION['USER_LEVEL'] = $qr['level'];
		$_SESSION['USER_LOG'] 	= $qr['time_log'];
		
		$time_log = date('Y-m-d H:i:s');
		$db->update(FDBPrefix.'user',array("time_log"=>"$time_log"),"id=$qr[id]"); 
		
		
		if($qr['id'] > 0) {
			$db->delete(FDBPrefix."session_login","id=$qr[id]");
			$db->insert(FDBPrefix."session_login",array("$qr[id]","$qr[user]","$qr[level]",date('Y-m-d H:i:s')));  
		}	
		if(!isset($_POST['prevpage'])) $_POST['prevpage'] = $linkUser;
		redirect($_POST['prevpage']);
	}
	else {
		define("userNotice",alert("error",user_Login_Error));
	}
}
	
	
if(isset($_POST['edit'])){		
	if(!empty($_POST['email']) AND @ereg("^.+@.+\\..+$",$_POST['email'])) 
	{	
		$qrq = false;
		$_POST['bio']	= htmlentities($_POST['bio']);
		$_POST['name']	= mysql_real_escape_string($_POST['name']);
		if(empty($_POST['password']) AND empty($_POST['kpassword'])){
			$qrq=$db->update(FDBPrefix.'user',array(	
			"name"=>"$_POST[name]",
			"email"=>"$_POST[email]",
			"about"=>"$_POST[bio]"),
			"id=$_SESSION[USER_ID]"); 
		}
		elseif($_POST['password']==$_POST['kpassword']){
			$qrq=$db->update(FDBPrefix.'user',array(
			"name"=>"$_POST[name]",
			"password"=>MD5("$_POST[password]"),
			"email"=>"$_POST[email]",
			"about"=>"$_POST[bio]"),
			"id=$_SESSION[USER_ID]"); 
			}
			
		$qr = $qrq;
		if($qr AND isset($_POST['edit'])){	
			$_SESSION['USER_EMAIL'] = $_POST['email'];
			$_SESSION['USER_NAME'] = $_POST['name'];
			define("userNotice",alert('info',Status_Updated));
		}
		else if($_POST['password']!=$_POST['kpassword']) {			
			define("userNotice",alert("error",user_Password_Not_Match));
		}
		else {				
			define("userNotice",alert("error",Status_Invalid));
		}					
	}
	else {				
		define("userNotice",alert("error",Status_Invalid));
	}
}
	
		
if(isset($_POST['logout'])) {	
	$_SESSION['USER_ID']	= "";
	$_SESSION['USER']		= "";
	$_SESSION['USER_EMAIL']	= "";
	$_SESSION['USER_LEVEL']	= 99;
	$qr = $db->delete(FDBPrefix."session_login","user_id=".$_SESSION['USER_ID']);
	if(!isset($_POST['prevpage'])) $_POST['prevpage'] = $linkLogin;
	redirect($linkLogin);
}	
		
if(isset($_POST['forgot']))	{		
	if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){						
		define("userNotice",alert("error",user_Email_None));
	} 
	else {
	$qr = $db->select(FDBPrefix."user","*","status=1 AND email='$_POST[email]'"); 
	$qr = mysql_fetch_array($qr);
	$jml = mysql_affected_rows();
		if($jml) {
			$reminder = randomString(32);
			$_SESSION['USER_REMINDER'] = $reminder;
			$_SESSION['USER_REMINDER_ID'] = $qr['id'];
			$reminder = "app=user&res=$reminder";
			$to  = "$_POST[email]" ;
			$webmail = siteConfig('site_mail'); 
			$domain  = substr(FUrl(),0,strpos(FUrl(),"/")); 
			if(empty($webmail)); $webmail = "noreply@$domain";
			
			if(siteConfig('lang') == 'id') {
				$subject = 'Konfirmasi Reset Password';
				$message = "<font color='#333'>
				<p>Hi, $qr[name]</p> 
				<p>Anda telah meminta kami untuk mengirimkan password baru.<br>Konfirmasi pesan ini dengan klik link konfirmasi berikut.</p>
				<p><a href='".FUrl."?$reminder' $btnClass> Konfirmasi Reset </a></p>
				<p>Pesan ini akan valid dalam 1-2 hari hingga Anda melakukan konfirmasi untuk reset password.<br>Jika Anda ingin membatalkan proses ini, abaikan saja email ini hingga kode kadaluarsa dalam 1-2 hari.</p>
				<p>Terimakasih.</p>
				<p>&nbsp;</p>
				<p><b>".SiteTitle."</b><br>".FUrl."</p></font>";
			}
			else {
				$subject = 'Password Reset Confirmation';
				$message = "<font color='#333'>
				<p>Hi, $qr[name]</p> 
				<p>You have asked us to send you a new password.<br>Confirm this message by click the following link.</p>
				<p>&nbsp;</p>
				<p><a href='".FUrl."?$reminder' $btnClass> Reset Confirmation </a></p>
				<p>&nbsp;</p>
				<p>This message will be valid within 1-2 days so you do confirm to reset the password.<br>If you want to cancel this process, ignore this letter to Expired code in 1-2 days.</p>
				<p>Thankyou.</p>
				<p>&nbsp;</p>
				<p><b>".SiteTitle."</b><br>".FUrl."</p></font>";			
			}
		// To send HTML mail, the Content-type header must be set
			$headers  = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

		// Additional headers
			$headers .= "To: $qr[name] <$_POST[email]>" . "\r\n";
			
			$headers .= "From: ".SiteName. "<$webmail>" ."\r\n";
			$headers .= "cc :" . "\r\n";
			$headers .= "Bcc :" . "\r\n";
		// Mail it
			$mail = @mail($to,$subject,$message,$headers);
			if($mail) {
				define("userNotice",alert("info",user_Password_Reset_Sent));
			}
			else
				define("userNotice",alert("error","System error : function mail() can not executed."));		
		}
		else {
			define("userNotice",alert("error",user_Email_None));
		}
	}	
}

if(!defined("userNotice")) define("userNotice","");
		

//App User SEF Controller
if('SEF_URL'){
	$view = app_param('view');
	if(!empty($key) or !empty($res)) {
	
	}
	else {
		if($view=='logout') 
			add_permalink('user/logout');
		else if($view=='edit') 
			add_permalink('user/edit');
		else if($view=='login') 
			add_permalink('user/login');
		else if($view=='register') 
			add_permalink('user/register');
		else if($view=='lost_password') 
			add_permalink('user/remember');
		else if(empty($view))
			add_permalink('user');
	}
}


/************* App User Page Title ******************/
if($view == 'register')
	define('PageTitle','User Register');
else if($view == 'login')
	define('PageTitle','User Login');
else if($view == 'lost_password') 
	define('PageTitle','Passowrd Reminder');
else if($view == 'logout') {
	define('PageTitle','Logout Page');
}
else if($view == 'profile') {
	define('PageTitle','User Profile');
}
else  {
	define('PageTitle','User Profile');
}

loadLang(__dir__);