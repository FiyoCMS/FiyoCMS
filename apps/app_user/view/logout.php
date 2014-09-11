<?php
/**
* @name			Logout
* @version		1.5.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2012 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.txt
*/

defined('_FINDEX_') or die('Access Denied');

$link = make_permalink("?app=user");
?>
<form action="" method="post">
	<div class="user-logout">
	<h1>User Logout</h1>
		<p>
			<?php echo Sure2Logout__; ?>
		</p>
		<p>
			<input type="submit" name="logout" value="<?php echo Yes; ?>"  class="button btn" /> <?php echo or_; ?> <a href="<?php echo $link; ?>" class="button btn"><?php echo No; ?></a>	
		</p>
		<?php loadModule('user-logout'); ?>
	</div>
</form>