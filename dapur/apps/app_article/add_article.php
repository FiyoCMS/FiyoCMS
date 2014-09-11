<?php
/**
* @version		2.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2014 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.
**/

defined('_FINDEX_') or die('Access Denied');

?>
<form method="post">
	<div id="app_header">
		<div class="warp_app_header">		
		<div class="app_title"><?php echo New_Article; ?></div>
			<div class="app_link">						
				<button type="submit" class="delete btn btn-success" title="<?php echo Save; ?>" value="<?php echo Save; ?>" name="apply_add"><i class="icon-ok"></i> <?php echo Save; ?></button>	
				<button type="submit" class="delete btn btn-metis-2 " title="<?php echo Save_and_Quit; ?>" value="<?php echo Save_and_Quit; ?>" name="save_add"><i class="icon-ok-sign"></i> <?php echo Save_and_Quit; ?></button>
				<button type="submit" class="btn btn-default btn-grad" title="<?php echo Save_add_new; ?>" value="<?php echo Save_add_new; ?>" name="add_new"><i class="icon-ok-circle"></i> <?php echo Save_Add_New; ?></button>
				<a class="danger btn btn-default btn-sm btn-grad" href="?app=article" title="<?php echo Cancel; ?>"><i class="icon-remove-sign"></i> <?php echo Cancel; ?></a>
				<?=printAlert()?>
			</div>
		</div>
	</div>			
	<?php 
		
		require('field_article.php');
	?>		
</form>		
