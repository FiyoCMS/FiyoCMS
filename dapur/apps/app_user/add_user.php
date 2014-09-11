<?php
/**
* @version		2.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2014 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.
**/

defined('_FINDEX_') or die('Access Denied');

$db = @new FQuery() or die;  
$db->connect(); 
$qr = null;
?>
<form method="post" action="">
	<div id="app_header">
		<div class="warp_app_header">
			<div class="app_title"><?php echo New_User; ?></div>
			<div class="app_link">
				<button type="submit" class="btn btn-success" title="<?php echo Delete; ?>" value="Next" name="apply"><i class="icon-ok"></i> <?php echo Save; ?></button>				
				<button type="submit" class="btn btn-metis-2" title="<?php echo Delete; ?>" value="Next" name="save"><i class="icon-ok-sign"></i>  <?php echo Save_and_Quit; ?></button>
				</button>	
				<a class="danger btn btn-default" href="?app=user" title="<?php echo Cancel; ?>"><i class="icon-remove-sign"></i> <?php echo Cancel; ?></a>
				<?php printAlert(); ?>
			</div>
		</div>			 
	</div>
<?php require('field_user.php'); ?>
</form>
