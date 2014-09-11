<?php
/**
* @name			User
* @version		1.5.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2012 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.txt
*/

defined('_FINDEX_') or die('Access Denied');


?>
<div id="user">
	<input type="hidden" id="url" value="<?php echo FUrl; ?>" />
	<form method="post" action="">	
		<h1><?php echo Edit_Profile; ?></h1>
		<?php echo userNotice; ?>	
		<div>
			<span>Username</span><input type="text" disabled autocomplete="off" name="user" placeholder="Username" value="<?php echo $_SESSION['USER']; ?>"/>
			min.3 character
		</div>
		<div>
			<span><?php echo New_Password; ?></span> <input type="password" autocomplete="off"  name="password" placeholder="&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;"/> min.4 character
		</div>
		<div>
			<span><?php echo Confirm_Password; ?></span> <input type="password" name="kpassword" placeholder="&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;"/>
		</div>
		
		<div>
			&nbsp;
		</div>
		<div>
			<span><?php echo Name; ?></span><input type="text" name="name" placeholder="<?php echo Name; ?>" value="<?php echo $_SESSION['USER_NAME']; ?>"/>
		</div>
		<div>
			<span>Email</span><input type="text" name="email" placeholder="Email"  value="<?php echo $_SESSION['USER_EMAIL']; ?>"/>
		</div>
		<div>
			<span>Bio</span><textarea name="bio"rows="7"><?php echo userInfo('about',$_SESSION['USER_ID']); ?></textarea>
		</div>
		<div class="user-link">
			<input type="submit" name="edit" value="<?php echo Save; ?>" class="button login btn"/>
		</div>
		<div>
		<br>
		<br>
		</div>
		<div>
			<a href="<?php echo make_permalink('?app=user') ?>" class="button btn"><?php echo Back; ?></a>
			<a href="<?php echo make_permalink('?app=user&view=logout'); ?>" class="button btn"><?php echo Logout; ?></a>
		</div>
		<p>&nbsp;</p>
		
	</form>
</div> 