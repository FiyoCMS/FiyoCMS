<?php
/**
* @name			Fi User
* @version		2.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2012 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.txt
*/

defined('_FINDEX_') or die('Access Denied');

if(siteConfig('member_registration'))
	$new = "<a class='register' href='".make_permalink('?app=user&view=register')."'>Register</a>";
?>
<div id="user">
<h1>Password Reminder</h1>
	<form action="" method="post">
	<?php echo userNotice; ?>
		<p class="user-desc"><?php echo user_Password_Reminder; ?></p>
		<div>
			<span>Email</span>  <input type="text" name="email" /></div>
		<div class="user-link">
			<span>&nbsp;</span>
			<input type="submit" name="forgot" value="<?php echo Send; ?>" class="button btn login"/>
			<a href="<?php echo make_permalink('?app=user&view=login') ?>">Login</a> <?php echo @$new; ?>
		</div>
	</form>
</div>