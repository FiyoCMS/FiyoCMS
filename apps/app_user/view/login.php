<?php
/**
* @name			Fi User
* @version		1.5.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2012 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.txt
*/

defined('_FINDEX_') or die('Access Denied');

if(siteConfig('member_registration'))
	$new = "<a class='register' href='".make_permalink('?app=user&view=register')."'>Register</a>";
?>
<div id="user">
<h1>User Login</h1>
	<form action="" method="POST">
	<?php echo userNotice; ?>
		<div>
			<span>Username</span> <input type="text" autocomplete="off" name="user" placeholder="e.g. User"/>
		</div>
		<div>
			<span>Password</span> <input type="password" name="pass" placeholder="&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;"/>
		</div>
		<div class="user-link">
			<span>&nbsp;</span><input type="submit" name="login" value="Login" class="button btn login"/> <?php echo @$new; ?> <a href="<?php echo make_permalink('?app=user&view=lost_password') ?>"><?php echo Lost_Password; ?>?</a>
		</div>
	</form>
</div>