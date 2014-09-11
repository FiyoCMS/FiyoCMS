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

$sql=$db->select(FDBPrefix."user_group","*","id=$_REQUEST[id]"); 
$qr = mysql_fetch_array($sql); 
if($qr['id']==1 or $qr['id']==2 or $qr['id']==3) $dis="readonly"; else $dis = null;

?>
<form method="post">
	<div id="app_header">
		<div class="warp_app_header">
			<div class="app_title">User Group</div>
			<div class="app_link">
				<button type="submit" class="btn btn-success" title="<?php echo Save; ?>" value="Next" name="save_group"><i class="icon-ok"></i> <?php echo Save; ?></button>				
				<button type="submit" class="btn btn-metis-2" title="<?php echo Save_and_Quit; ?>" value="Next" name="edit_group"><i class="icon-ok-sign"></i> <?php echo Save_and_Quit; ?></button>
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
			<table class="data2">
				<tr>
					<td class="row-title"><span class="tips" title="<?php echo User_Group_name; ?>">Group Name *</span></td>
				<td>	<input type="hidden" name="id" value="<?php  echo $qr['id'] ?>"><input type="text" name="group" size="20" <?php echo "value='$qr[group_name]' $dis" ?> required></td>
				</tr>
				<tr>
					<td class="row-title"><span class="tips" title="<?php echo User_Group_level; ?>">Level *</span></td>
					<td>	<input class="numeric" type="text" id="level" name="level" size="5" min="3" max="98" <?php echo "value='$qr[level]' $dis" ;?> required>
					
					<input class="numeric" type="hidden"name="levels" <?php echo "value='$qr[level]'" ;?>></td>
				</tr>
				<tr>
					<td class="row-title"><span class="tips" title="<?php echo User_Group_description; ?>">Description</span></td>
				<td>	<input type="text" name="desc" size="50" value="<?php echo $qr['description'];?>"></td>
				</tr>			
			</table>
        </div> 
	</div>
</form>	
