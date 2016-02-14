<?php
/**
* @version		2.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2014 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.
**/

defined('_FINDEX_') or die('Access Denied');

$db = new FQuery();  
$sql = $db->select(FDBPrefix.'contact_group','*',"group_id=$_REQUEST[id]"); 
$row = $sql[0];
?>

<form method="post">
	<div id="app_header">
		<div class="warp_app_header">
			<div class="app_title"><?php echo Edit_Group;?></div>
			<div class="app_link">
				<button type="submit" class="btn btn-success" title="<?php echo Save; ?>" value="<?php echo Save; ?>" name="apply_group"><i class="icon-check"></i> <?php echo Save; ?></button>	
				<button type="submit" class="btn btn-metis-2 " title="<?php echo Save_and_Quit; ?>" name="edit_group"><i class="icon-check-circle"></i> <?php echo Save_and_Quit; ?></button>			
				<a class="danger btn btn-default" href="?app=contact&view=group" title="<?php echo Cancel; ?>"><i class="icon-remove-sign"></i> <?php echo Cancel; ?></a>
				<?php printAlert(); ?>
			</div>			
		</div>
	</div>	
	<div class="panel box"> 		
		<header>
			<h5>Detail</h5>
		</header>
		<div>
			<table>
				<tr>		
					<td class="row-title"><span title="<?php echo Group_Name; ?>"><?php echo Group_Name; ?></td>
					<td><input type="hidden" name="id" value="<?php  echo $row['group_id'] ?>"><input type="text" name="name" size="20" value="<?php  echo $row['group_name'] ?>" required></td>
				</tr>
				<tr>
					<td class="row-title"><span title="<?php echo Description; ?>"><?php echo Description; ?></td>
					<td>
					<textarea name="desc" rows="3" required cols="50"><?php formRefill('desc',$row['group_desc'],'textarea'); ?></textarea></td>
				</tr>
			</table>
		</div> 
	</div>
</form>	
