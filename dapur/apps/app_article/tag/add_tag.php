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
?>
<form method="post">
	<div id="app_header">
		<div class="warp_app_header">		
			<div class="app_title"><?php echo New_Tag; ?></div>
			<div class="app_link">
				<button type="submit" class="delete btn btn-success" title="<?php echo Save; ?>" value="<?php echo Save; ?>" name="add_tag"><i class="icon-ok"></i> <?php echo Save; ?></button>	
				<button type="submit" class="delete btn btn-metis-2 " title="<?php echo Save_and_Quit; ?>" name="save_tag"><i class="icon-ok-sign"></i> <?php echo Save_and_Quit; ?></button>
				
				<a class="danger btn btn-default" href="?app=article&view=tag" title="<?php echo Cancel; ?>"><i class="icon-remove-sign"></i> <?php echo Cancel; ?></a>
			</div>	<?php printAlert(); ?>		
		</div>
	</div>	   	
	<div class="panel box"> 		
		<header>
			<h5>Umum</h5>
		</header>
		<div>
			<table>
				<tr>
					<td class="row-title"><?php echo Tag_Title; ?></td>
					<td><input type="hidden" name="id" value=""><input type="text" name="name" size="30" <?php formRefill('name'); ?> required></td>
				</tr>
				<tr>
					<td class="row-title"><?php echo Tag_Desc; ?></td>
					<td><textarea type="hidden" name="desc" rows="4" cols="50"><?php formRefill('desc','','textarea'); ?></textarea></td>
				</tr>
			</table>
		</div> 
    </div> 
</form>	
