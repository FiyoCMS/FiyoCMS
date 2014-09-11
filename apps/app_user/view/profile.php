<?php
/**
* @name			User Profile
* @version		1.5.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2012 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.txt
*/


defined('_FINDEX_') or die('Access Denied');

?>
<form action="<?php echo make_permalink('?app=user&view=logout'); ?>" method="post">
	<div class="user-profile">
		<h1><?php echo Welcome; ?>, <?php echo USER_NAME; ?></h1>
		<p>
			<?php echo user_Login_Success; ?>
		</p>
		<p>
			<a href="<?php echo make_permalink('?app=user&view=edit'); ?>" class="button btn"><?php echo Edit_Profile; ?></a>
			<button class="button btn"><?php echo Logout; ?></button>
		</p>
		<?php loadModule('user-profile'); ?>
	</div>
</form>