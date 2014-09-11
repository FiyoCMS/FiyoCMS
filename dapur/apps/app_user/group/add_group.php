<?php
/**
* @version		2.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2014 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.
**/

defined('_FINDEX_') or die('Access Denied');

if($_SESSION['USER_LEVEL'] > 2){
	alert('info','Redirecting...');
	alert('loading');
	htmlRedirect('?app=user&view=group');
}
$db = @new FQuery() or die;  
$db->connect(); 
?>
<form method="post">
	<div id="app_header">
	 <div class="warp_app_header">		
		<div class="app_title">User Group</div>
		<div class="app_link">		
			<button type="submit" class="btn btn-success" title="<?php echo Save; ?>" value="Next" name="apply_group"><i class="icon-ok"></i> <?php echo Save; ?></button>				
			<button type="submit" class="btn btn-metis-2" title="<?php echo Save_and_Quit; ?>" value="Next" name="add_group"><i class="icon-ok-sign"></i> <?php echo Save_and_Quit; ?></button>
			</button>	
			<a class="danger btn btn-default" href="?app=user&view=group" title="<?php echo Cancel; ?>"><i class="icon-remove-sign"></i> <?php echo Cancel; ?></a>
			<?php printAlert(); ?>
		</div>	
	  </div>
	</div>
	
	<div class="panel box">								
		<header>
			<h5>User Group</h5>
		</header>								
		<div>
			<table>
				<tr>
					<td class="row-title"><span class="tips" title="<?php echo User_Group_name; ?>">Group Name</span></td>
				<td>	<input type="text" name="group" size="20" required <?=formRefill('group')?>/></td>
				</tr>
				<tr>
					<td class="row-title"><span class="tips" title="<?php echo User_Group_level; ?>">Level</span></td>
				<td>
				<input type="text" id="level" name="level" class="numeric" size="5" min="3" max="98" required <?=formRefill('level')?>/></span></td>
				</tr>
				<tr>
					<td class="row-title"><span class="tips" title="<?php echo User_Group_description; ?>">Description</span></td>
				<td>	<input type="text" name="desc" size="60"></td>
				</tr>
			</table>
		</div>
	</div>
</form>	
