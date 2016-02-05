                                <?php
/**
* @version		2.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2012 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.txt
* @description	Article Rating
**/

session_start();
define('_FINDEX_',1);
require('../../../system/jscore.php');
if(!isset($_POST['send'])) { 
	alert('error','Access Denied!',true,true);
	die();
}
else {
	loadLang('../');
	$to = $_POST['to'];
	$name = $_POST['name'];
	$email = $_POST['email'];
	$subject = $_POST['subject'];
	$phone = $_POST['phone'];
	$post = $_POST['text'];
	$captcha = $_POST['captcha'] ;
	$send = $_POST['send'] ;
	
	if(isset($_SESSION['COMMENT_DELAY']) AND ($_SESSION['COMMENT_DELAY'] - time()  > 0))
		echo "{ \"status\":\"0\" , \"alert\":\"".alert('error',You_alreay_sent_message)."\"}";	
	else if(isset($name,$email,$post,$send,$to)) {
		$_SESSION['COMMENT_DELAY'] = 0;
		if(empty($name) or empty($email) or empty($post) or empty($subject ) )
			echo "{ \"status\":\"0\" , \"alert\":\"".alert('error',contact_Error)."\"}";	
		else if(!filter_var($to, FILTER_VALIDATE_EMAIL) or !filter_var($email, FILTER_VALIDATE_EMAIL))	
			echo "{ \"status\":\"0\" , \"alert\":\"".alert('error',contact_Error2)."\"}";	
		else if(strlen($post) < 30 or ($subject == 'undefined'  AND strlen($post) < 150))
			echo "{ \"status\":\"0\" , \"alert\":\"".alert('error',Message_too_short)."\"}";
		else {
			if($subject == 'undefined' ) $subject = 'Penawaran Proyek';
				$post = str_replace("nnn","<br>", $post);
				// multiple recipients
				$site = siteConfig('site_name');
				$to = "$to";
				$subject = "$subject dari $name";
				$message = "$post<p>&nbsp;</p><p>&nbsp;</p><p><small>Sent by <b> $site</b></small></p>";		
				$headers  = 'MIME-Version: 1.0' . "\r\n";
				$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
				$headers .= "To: <$to>\r\n";
				$headers .= "From: $name <$email>" . "\r\n";
				$mail = @mail($to,$subject,$message,$headers);	
				if($mail) {
				echo "{ \"status\":\"1\" , \"alert\":\"".alert('success',contact_Info)."\"}";	
				$_SESSION['COMMENT_DELAY'] = time()+180;
				}
				else {
					echo "{ \"status\":\"0\" , \"alert\":\"".alert('error',contact_Error3)."\"}";	
				}
		}	
	} else {
		echo "{ \"status\":\"0\" , \"alert\":\"".alert('error',contact_Error)."\"}";	
	}
}


                            