<?php
/**
* @version		2.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2014 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.
**/

defined('_FINDEX_') or die('Access Denied');
?>
<form method="post" id="form">
	<div id="app_header">
		<div class="warp_app_header">		
			<div class="app_title"><?php echo Edit_Menu; ?></div>			
			<div class="app_link">	
				<button type="submit" class="delete btn btn-success" title="<?php echo Save; ?>" value="<?php echo Save; ?>" name="apply_edit"><i class="icon-ok"></i> <?php echo Save; ?></button>	
				<button type="submit" class="delete btn btn-metis-2" title="<?php echo Save_and_Quit; ?>" value="<?php echo Save_and_Quit; ?>" name="save_edit"><i class="icon-ok-sign"></i> <?php echo Save_and_Quit; ?></button>				
				<a class="danger btn btn-default btn-sm btn-grad" href="?app=menu&cat=<?php echo oneQuery('menu','id',$_GET['id'],'category'); ?>" title="<?php echo Cancel; ?>"><i class="icon-remove-sign"></i> <?php echo Cancel; ?></a>				
			</div><?php printAlert(); ?>
		 </div>			 
	</div>
	
		
	<?php 
		require('field_menu.php');
	?>	
</form>