<?php
/**
* @version		2.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2012 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.txt
**/

defined('_FINDEX_') or die('Access Denied');

$db = @new FQuery() or die;  
$db->connect();  
?>
<script>
$(function() {
	$(".parents").chosen({disable_search_threshold: 10, 
	allow_single_deselect: true});
});
</script>
<form method="post">
	<div id="app_header">
		<div class="warp_app_header">		
			<div class="app_title"><?php echo New_Category; ?></div>
			<div class="app_link">
				<button type="submit" class="delete btn btn-success" title="<?php echo Save; ?>" value="<?php echo Save; ?>" name="save_category"><i class="icon-ok"></i> <?php echo Save; ?></button>	
				<button type="submit" class="delete btn btn-metis-2 " title="<?php echo Save_and_Quit; ?>" name="add_category"><i class="icon-ok-sign"></i> <?php echo Save_and_Quit; ?></button>				
				<a class="danger btn btn-default" href="?app=article&view=category" title="<?php echo Cancel; ?>"><i class="icon-remove-sign"></i> <?php echo Cancel; ?></a>
				<?php printAlert('NOTICE_ERROR'); ?>
			</div>			
		</div>
	</div>	   	
	<div class="panel box"> 		
		<header>
			<h5><?php echo Article_category; ?></h5>
		</header>
		<div>
			<table>
				<tr>
					<td class="row-title"><span class="tips" title="<?php echo Category_Name; ?>"><?php echo Category_Name; ?></span></td>
					<td><input type="hidden" name="id" value="<?php  echo $row['id'] ?>">
					<input type="text" name="name" size="20" <?php formRefill('name'); ?> required></td>
				</tr>
				<tr>
					<td class="row-title"><span class="tips" title="<?php echo Parent_category_tip; ?>"><?php echo Parent_category; ?></span></td>
					<td><select name="parent_id" class="parents" data-placeholder="<?php echo Choose_category; ?>" style="min-width:125px;">
					<option value=''></option>
					<?php			
						$level = $row['level'];	
						$sql2=$db->select(FDBPrefix.'article_category','*','parent_id=0');
						while($row2=mysql_fetch_array($sql2)){	
							echo "<option value='$row2[id]'>$row2[name]</option>";
							option_sub_cat($row2['id'],"");
						}
					?>
					</select></td>
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
					<td class="row-title"><span class="tips" title="<?php echo Description; ?>"><?php echo Description; ?></span></td>
					<td><textarea name="desc" rows="5" cols="50" ><?php formRefill('desc','','textarea'); ?></textarea></td>
				</tr>
				<tr>
					<td class="row-title"><span class="tips" title="<?php echo Keyword; ?>"><?php echo Keyword; ?></span></td>
					<td><textarea name="keys" rows="3" cols="50"><?php formRefill('keys','','textarea'); ?></textarea></td>
				</tr>
			</table>
        </div> 
	  </div>
	</div>
</form>	
