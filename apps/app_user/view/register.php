<?php
/**
* @name			User
* @version		2.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2014 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.txt
*/


defined('_FINDEX_') or die('Access Denied');

if(!siteConfig('member_registration')) : ?>

<h1>User Registration</h1>
<p><?php echo RegisterNotAllowed__; ?></p>

<?php else :?>

<script> 
function reloadCaptcha() {
	document.getElementById('captcha').src = document.getElementById('captcha').src+ '?' +new Date();
}
</script>
<div id="user">
	<h1>User Registration</h1>	
	<form method="post" action="">	
	<input type="hidden" id="url" value="<?php echo FUrl; ?>" />
		<?php if(userNotice != 'need_admin_activation' AND userNotice != 'need_email_activation') : ?>	
		<?php echo userNotice; ?>	
		<?php if($_SESSION['num']) echo $_SESSION['num']; ?>		
		<div>
			<span>Username</span><input <?php formRefill('user'); ?> type="text" autocomplete="off" name="user" placeholder="Username"/> min.3 character
		</div>
		<div>
			<span>Password</span> <input type="password" autocomplete="off"  name="password" placeholder="&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;"/> min.4 character
		</div>
		<div>
			<span>Confirm Password</span> <input type="password" name="kpassword" placeholder="&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;"/>
		</div>
		<div>
			<span>Email</span><input type="text" <?php formRefill('email'); ?>name="email" placeholder="Email"/>
		</div>
		<div>
			<span>Security Code</span><div><img src="<?php echo FUrl; ?>/plugins/plg_mathcaptcha/image.php" alt="Click to reload image" title="Click to reload image" id="captcha" onclick="javascript:reloadCaptcha()" /><input type="text" name="capthca" placeholder="What the result?" class="security" /></div>
		</div>
		<div class="user-link">
			<span>&nbsp;</span><input type="submit" name="register" value="Register" class="button btn login"/> <a href="<?php echo make_permalink('?app=user&view=login') ?>">Login</a> <a href="<?php echo make_permalink('?app=user&view=lost_password') ?>">Lost Password?</a>
		</div>
		<?php elseif(userNotice != 'need_email_activation') : ?>
			<?php alert("info",user_Registration_Success, true); ?>
			<div>			
				<?php echo user_Email_Activation; ?>
				<?php loadModule('user-register'); ?>
			</div>
		<?php elseif(userNotice == 'need_admin_activation') : ?>
			<?php alert("info",user_Registration_Success, true); ?>
			<div>			
				<?php echo user_Admin_Activation; ?>
				<?php loadModule('user-register'); ?>
			</div>
		<?php endif; ?>
		
	</form>
</div> 
<?php endif ?>