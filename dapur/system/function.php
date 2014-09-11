<?php
/**
* @version		2.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2012 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.txt
**/

defined('_FINDEX_') or die('Access Denied');
/****************************************/
/*			 Loader Function 			*/
/****************************************/
//memuat admin apps
function baseApps($file){
	require ("apps/$file/$file.php");	
}

//memuat admin system apps
function baseSystem($file){
	$file = "apps/app_$file/sys_$file.php";	
	if(file_exists($file)) include($file);	
}

//memuat fungsi admin apps
function loadSystemApps(){
	include('system/apps.php');		
	if(!empty($_SESSION['USER_ID']) AND $_SESSION['USER_LEVEL'] <= 3 AND userInfo())
	sysAdminApps();
}

/****************************************/
/*			 Check User Login			*/
/****************************************/
//cek status user dalam keadaan login melalui tabel session_login
function check_backend_login() {
	if(!empty($_SESSION['USER_ID']) AND $_SESSION['USER_LEVEL'] <= 3 AND userInfo()){
		load_themes();
	}
	else {
		$_SESSION['USER']		= null ;
		$_SESSION['USER_ID']	= null ;		
		$_SESSION['USER_LOG']	= null ;
		$_SESSION['USER_NAME']	= null ;
		$_SESSION['USER_EMAIL'] = null ;
		$_SESSION['USER_LEVEL'] = null ;		
		load_login();
	}
}

//memanggil template sesuai fungsi select_themes()
function load_themes(){	
	if(isset($_POST['fiyo_logout'])){
		$db = new FQuery();
		$qr = $db->delete(FDBPrefix."session_login","user_id=".$_SESSION['USER_ID']);
		$_SESSION['USER']		= null ;
		$_SESSION['USER_ID']	= null ;		
		$_SESSION['USER_LOG']	= null ;
		$_SESSION['USER_NAME']	= null ;
		$_SESSION['USER_EMAIL'] = null ;
		$_SESSION['USER_LEVEL'] = null ;		
		redirect(getUrl());
	}	
	else {		
		redirect_www();
		select_themes('index');	
	}
}

//memanggil file login jika user belum login
function load_login() {
	if(isset($_POST['fiyo_login']))	{
		$db = new FQuery();  
		$user =  mysql_real_escape_string($_POST['user']);
		$sql = $db->select(FDBPrefix."user","*","status=1 AND user='".$user."' AND password='".MD5($_POST['pass'])."'");
		$qr = mysql_fetch_array($sql);
		$jml = mysql_affected_rows();
		if($jml > 0) {
			$_SESSION['USER_ID']  	= $qr['id'];
			$_SESSION['USER'] 		= $qr['user'];
			$_SESSION['USER_NAME']	= $qr['name'];
			$_SESSION['USER_EMAIL']	= $qr['email'];
			$_SESSION['USER_LEVEL'] = $qr['level'];
			$_SESSION['USER_LOG'] 	= $qr['time_log'];
			
			$time_log = date('Y-m-d H:i:s');
			$db->update(FDBPrefix.'user',array("time_log"=>"$time_log"),"id=$qr[id]"); 
			
			$db->delete(FDBPrefix."session_login","user_id=$qr[id]");			
			$qr = $db->insert(FDBPrefix."session_login",array("$qr[id]","$qr[user]","$qr[level]",date('Y-m-d H:i:s')));
		}		
		if($qr or !empty($_SESSION['USER_ID']) AND $_SESSION['USER_LEVEL'] <= 3 AND userInfo())		
			redirect(getUrl());
		else {
			select_themes('login');
			alert('error',Login_Error);	
		}
	}
	else {
		if(isset($_GET['theme']) AND $_GET['theme'] == 'blank')
			echo "Redirecting...";
		else
			select_themes('login');
	}
}

//memilih tema AdminPanel sesuai dengan nilai admin_theme pada tabel setting
function select_themes($log, $stat = NULL){
	$themePath = siteConfig('admin_theme');
	define("AdminPath","themes/$themePath");		
	if($log=="login") {
		$file =  "themes/$themePath/login.php";
		if(file_exists($file))
			require $file;
		else
			echo "Failed to load AdminTheme";
		forgot_password();
	}
	else if($log=="index" AND $_SESSION['USER_LEVEL'] <= 3) {	
		$file =   "themes/$themePath/index.php";
		if(isset($_GET['theme']) AND $_GET['theme'] =='blank') {
			loadAdminApps();
			$end_time = microtime(TRUE);
			$n = substr($end_time - _START_TIME_,0,7);
			echo "<input type='hidden' value='$n' class='load-time'>";
		}
		else if(file_exists($file)) 
			require $file;
		else
			echo "Failed to load AdminTheme";
	}
	else {		
		redirect(FUrl);		
	}
}

function redirect_www() {
	if($_SERVER['SERVER_ADDR'] != '127.0.0.1' AND $_SERVER['SERVER_ADDR'] != '::1' AND $_SERVER['SERVER_ADDR'] != $_SERVER['HTTP_HOST'] ) {
		if(siteConfig('sef_www')) {
			if(!strpos(getUrl(),"//www.")) {
				$link = getUrl();
				$link = str_replace("http://","http://www.",$link);
				redirect($link);
			}
		}
		else {
			if(strpos(getUrl(),"//www.")) {
				$link = getUrl();
				$link = str_replace("http://www.","http://",$link);
				redirect($link);
			}
		}
	}
}

//fungsi lupa password
function forgot_password(){
	if(isset($_POST['forgot_password'])) {
		$db = new FQuery();  
		$sql = $db->select(FDBPrefix."user","*","status=1 AND email='$_POST[email]'");
		$qr= mysql_affected_rows();
		$qrs = mysql_fetch_array($sql);
		if($qr<1){				
			alert('error',Remember_Error);
		}
		else {		
			$reminder = randomString(32);
			$_SESSION['USER_REMINDER'] = $reminder;
			$_SESSION['USER_REMINDER_ID'] = $qrs['id'];
			$reminder = "app=user&res=$reminder";
			$to  = "$_POST[email]" ;
			$webmail = siteConfig('site_mail'); 
			$domain  = str_replace("/","",FUrl()); 
			if(empty($webmail)) $webmail = "no-reply@$domain";
			if(siteConfig('lang') == 'id') {
			$subject = 'Konfirmasi Reset Password';
			$message = "<font color='#333'>
			<p>Halo, $qrs[name]</p> 
			<p>Anda telah meminta kami untuk mengirimkan password baru.</p>
			<p>Konfirmasi pesan ini dengan klik link konfirmasi berikut.</p>
			<p>&nbsp;</p>
			<p><a href='".FUrl."?$reminder'>".FUrl."?$reminder</a></p>
			<p>&nbsp;</p>
			<p>Pesan ini akan valid dalam 1-2 hari hingga Anda melakukan konfirmasi untuk reset password.</p>
			<p>Jika Anda ingin membatalkan proses ini, abaikan saja email ini hingga kode kadaluarsa dalam 1-2 hari.</p>
			<p>Terimakasih.</p>
			<p>&nbsp;</p>
			<p>&nbsp;</p>
			<p><b>".SiteTitle."</b><br>".FUrl."</p></font>";
			}
			else {
			$subject = 'Password Reset Confirmation';
			$message = "<font color='#333'>
			<p>Hello, $qrs[name]</p> 
			<p>You have asked us to send you a new password.</p>
			<p>Confirm this message by click the following link.</p>
			<p>&nbsp;</p>
			<p><a href='".FUrl."?$reminder'>".FUrl."?$reminder</a></p>
			<p>&nbsp;</p>
			<p>This message will be valid within 1-2 days so you do confirm to reset the password.</p>
			<p>If you want to cancel this process, ignore this letter to Expired code in 1-2 days.</p>
			<p>Thankyou.</p>
			<p>&nbsp;</p>
			<p>&nbsp;</p>
			<p><b>".SiteTitle."</b><br>".FUrl."</p></font>";			
			}
		// To send HTML mail, the Content-type header must be set
			$headers  = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

		// Additional headers
			$headers .= "To: $qrs[name] <$_POST[email]>" . "\r\n";
			
			$headers .= "From: ".SiteTitle. "<$webmail>" ."\r\n";
			$headers .= "cc :" . "\r\n";
			$headers .= "Bcc :" . "\r\n";

		// Mail it
			$mail = @mail($to,$subject,$message,$headers);
			if($mail)  {
				alert('info',Password_sent_to_mail);
				htmlRedirect("index.php",3);	
			}
			else
				alert('error',Failed_send_mail);
		}
	}
}