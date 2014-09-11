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
<form method="post" id="form">
	<div id="app_header">
		<div class="warp_app_header">
			<div class="app_title"><?php echo New_Category; ?></div>
			<div class="app_link">
				<button class="btn save" title="<?php echo Save; ?>" name="add_category" type="submit" value="Save" ><?php echo Save; ?></button>					
				<button type="submit" class="save_quit btn btn-metis-2" title="<?php echo Save_and_Quit; ?>" value="<?php echo Save_and_Quit; ?>" name="save_category"><i class="icon-ok-sign"></i> <?php echo Save_and_Quit; ?></button>
				<a class="danger btn btn-default btn-sm btn-grad" href="?app=menu&view=category" title="<?php echo Cancel; ?>"><i class="icon-remove-sign"></i> <?php echo Cancel; ?></a>
			</div><?php printAlert(); ?>
		</div>
	</div> 
 	
	<div class="col-lg-12">
		<div class="box">								
			<header class="dark">
				<h5>Menu Details</h5>
			</header>								
			<div>	
				<table>
					<tr>
						<td class="row-title"><span class="tips"  title="<?php echo Category_Title_tip; ?>"><?php echo Category_Title; ?></span></td>
						<td><input type="text" name="title" size="20" required <?php formRefill('title');?> /></td>
					</tr>
					<tr>
						<td class="row-title"><span class="tips"  title="<?php echo Category_Name_tip; ?>"><?php echo Category_Name; ?></span></td>
						<td><input type="text" name="cat" size="20" class="alphanumeric" required <?php formRefill('cat');?> /><span  id="pesan"></span></td>
					</tr>						
					<tr>
						<td class="row-title"><span class="tips" title="<?php echo Category_level; ?>"><?php echo Access_Level; ?></span></td>
						<td><select name="level" >
							 <?php
								$sql2 = $db->select(FDBPrefix.'user_group');
								while($user=mysql_fetch_array($sql2)){
								
										echo "<option value='$user[level]'>$user[group_name] </option>";
								}
								echo "<option value='99' selected>"._Public."</option>"
								?>
							</select>
						</td>
					</tr>
					<tr>
						<td class="row-title"><span class="tips"  title="<?php echo Description; ?>"><?php echo Description; ?></span></td>
						<td><input type="text" name="desc" size="70"/></td>
					</tr>
				</table>
			</div>
		</div>
	</div>
</form>	
