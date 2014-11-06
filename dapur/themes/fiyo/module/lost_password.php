<?php
/**
* @version		2.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2014 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.
**/

if(!isset($_GET['email'])) die('Access Denied!');
session_start();
define('_FINDEX_','BACK');

require('../../../system/jscore.php');
if(!filter_var($_GET['email'], FILTER_VALIDATE_EMAIL)){		
	echo "{ \"status\":\"0\" , \"alert\":\"".alert('error',Email_Invalid)."\"}";
} 
else {
	$qr = $db->select(FDBPrefix."user","*","status=1 AND email='$_GET[email]'"); 
	$qr = mysql_fetch_array($qr);
	$jml = mysql_affected_rows();
	define('FUrl',$_GET['url']);
	if($jml) {
		$btnClass = 'style="text-align: center;  font-size: 11px;  font-family: arial,sans-serif;  color: white;  font-weight: bold;  border-color: #3079ed;  background-color: #4d90fe;  background-image: linear-gradient(top,#4d90fe,#4787ed);  text-decoration: none;  display: inline-block;  min-height: 27px;  padding-left: 8px;  padding-right: 8px;  line-height: 27px;  border-radius: 2px;  border-width: 1px;
		"';
			$reminder = randomString(32);
			$_SESSION['USER_REMINDER'] = $reminder;
			$_SESSION['USER_REMINDER_ID'] = $qr['id'];
			$reminder = "app=user&res=$reminder";
			$to  = "$_GET[email]" ;
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
				<p><b>".siteConfig('site_title')."</b><br>".FUrl."</p></font>";
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
				<p><b>".siteConfig('site_title')."</b><br>".FUrl."</p></font>";			
			}
		// To send HTML mail, the Content-type header must be set
			$headers  = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

		// Additional headers
			$headers .= "To: $qr[name] <$_GET[email]>" . "\r\n";
			
			$headers .= "From: ".siteConfig('site_name'). "<$webmail>" ."\r\n";
			$headers .= "cc :" . "\r\n";
			$headers .= "Bcc :" . "\r\n";
		// Mail it
			$mail = @mail($to,$subject,$message,$headers);
			if($mail) {
				echo "{ \"status\":\"1\" , \"alert\":\"".alert('success',Password_Reset_Sent)."\"}";	
			}
			else
				echo "{ \"status\":\"0\" , \"alert\":\"".alert('error',"System error : function mail() can not executed.")."\"}";	
		}
		else {
			echo "{ \"status\":\"0\" , \"alert\":\"".alert('error',Email_Not_Registered)."\"}";	
		}
}	