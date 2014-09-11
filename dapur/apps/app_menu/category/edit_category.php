<?php
/**
* @version		2.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2014 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.
**/

defined('_FINDEX_') or die('Access Denied');

$db = new FQuery();  
$db ->connect();  

$level = Level_Access;
$sql=$db->select(FDBPrefix.'menu_category','*',"id=$_REQUEST[id] $level"); 
$qr=mysql_fetch_array($sql);
if(!$qr) redirect('index.php');
	
?>
<form method="post" id="form">
	<div id="app_header">
		<div class="warp_app_header">
			<div class="app_title"><?php echo Edit_Category; ?></div>
			<div class="app_link">
				<button class="btn btn-success save" title="<?php echo Save; ?>" name="apply_category" type="submit" value="Save" ><i class="icon-ok"></i> <?php echo Save; ?></button>					
				<button type="submit" class="delete btn btn-metis-2" title="<?php echo Save_and_Quit; ?>" value="<?php echo Save_and_Quit; ?>" name="edit_category"><i class="icon-ok-sign"></i> <?php echo Save_and_Quit; ?></button>
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
						<td class="row-title"><span class="tips" title="<?php echo Category_Title_tip; ?>"><?php echo Category_Title; ?></span></td>
						<td><input type="hidden" name="id" value="<?php  echo $qr['id'] ?>"><input type="text" name="title" size="20" <?php  echo "value='$qr[title]'" ?> required></td>
					</tr>
					<tr>
						<td class="row-title"><span class="tips" title="<?php echo Category_Name_tip; ?>"><?php echo Category_Name; ?></span></td>
						<td><input type="text" name="cat" size="20" value="<?php echo $qr['category'];?>" class="alphanumeric" required><input type="hidden" name="cats" size="20" value="<?php echo $qr['category'];?>"></td>
					</tr>
					<tr>
						<td class="row-title"><span class="tips" title="<?php echo Category_level; ?>"><?php echo Access_Level; ?></span></td>
						<td><select name="level" >
						 <?php
							$sql2 = $db->select(FDBPrefix.'user_group');
							while($user=mysql_fetch_array($sql2)){
							
							if($_SESSION['USER_LEVEL'] <= $user['level'])
								if($user['level']==$qr['level']){
									echo "<option value='$user[level]' selected>$user[group_name]</option>";}
								else {
									echo "<option value='$user[level]'>$user[group_name] </option>";
								}
							}
							if($qr['level']==99) $s="selected";else $s="";
							echo "<option value='99' $s>"._Public."</option>"
							?>
						</select>
					</td>
				</tr>
					<tr>
						<td class="row-title"><span class="tips" title="<?php echo Description; ?>"><?php echo Description; ?></span></td>
						<td><input type="text" name="desc"  value="<?php echo $qr['description'];?>" style=' min-width: 60%; max-width:100%;'></td>
					</tr>
				</table>
			</div> 
		</div>
	</div>
</form>	
