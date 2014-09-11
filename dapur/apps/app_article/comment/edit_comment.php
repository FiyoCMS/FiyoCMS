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

$id = $_REQUEST['id'];
$sql= $db->select(FDBPrefix.'comment','*','id='.$id);
$qr	= mysql_fetch_array($sql);

if($qr['status']==1) {$status1="checked";}
else { $status2="checked";}

$link = str_replace(FUrl,"",make_permalink($qr['link']));
$link = "<a href='".make_permalink($qr['link'])."#comment-$qr[id]' target='_blank' class='tips outlink' title='click to see comment'>$link</a> ";


?>
<form method="post">
<input value="<?php echo $qr['id'];?>" type="hidden" name="id">
	<div id="app_header">
		<div class="warp_app_header">		
			<div class="app_title">Comment Manager</div>			
			<div class="app_link">				
				<button type="submit" class="delete btn btn-success" title="<?php echo Save; ?>" value="<?php echo Save; ?>" name="apply_comment"><i class="icon-ok"></i> <?php echo Save; ?></button>	
				<button type="submit" class="delete btn btn-metis-2 " title="<?php echo Save_and_Quit; ?>" name="save_comment"><i class="icon-ok-sign"></i> <?php echo Save_and_Quit; ?></button>		
				<a class="danger btn btn-default" href="?app=article&view=comment" title="<?php echo Cancel; ?>"><i class="icon-remove-sign"></i> <?php echo Cancel; ?></a>
				<?php printAlert(); ?>
				
			</div>
		 </div>			 
	</div>
	
	<div class="panel box"> 		
		<header>
			<h5>Comment Details</h5>
		</header>
		<div>
			<table>					
				<tr>
					<td class="row-title">Comment link</td>
					<td><?php echo $link;?></td>
				</tr>	
				<tr>
					<td class="row-title"><?php echo Status; ?></td>
					<td>				
						<?php 
							if($qr['status']){$s1="selected checked"; $s0 = "";}
							else {$s0="selected checked"; $s1= "";}
						?>
						<p class="switch">
							<input id="radio1"  value="1" name="status" type="radio" <?php echo $s1;?> class="invisible">
							<input id="radio2"  value="0" name="status" type="radio" <?php echo $s0;?> class="invisible">
							<label for="radio1" class="cb-enable <?php echo $s1;?>"><span><?php echo Enable; ?></span></label>
							<label for="radio2" class="cb-disable <?php echo $s0;?>"><span><?php echo Disable; ?></span></label>
						</p>
					</td>
				</tr>		
				<tr>
					<td class="row-title"><?php echo Name; ?></td>
					<td><input value="<?php echo $qr['name'];?>" type="text" name="name" size="25" required></td>
				</tr>
				<tr>
					<td class="row-title">Email</td>
					<td><input value="<?php echo $qr['email'];?>" type="text" name="email" size="25" id="link"required></td>
				</tr>				
				
				
				<tr>
					<td class="row-title" >Website</td>
					<td><input value="<?php echo $qr['website'];?>" type="text" name="web" size="35" id="order"></td>
				</tr>
				<tr>
					<td class="row-title"><?php echo Comment; ?></td>
					<td><textarea name="comment" cols="50" rows="6" style="min-width:50%; max-width: 100%;"><?php echo $qr['comment'];?></textarea></td>
				</tr>	
			</table>
		</div>
	</div>
</form>