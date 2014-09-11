<?php
/**
* @version		2.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2014 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.txt
**/

defined('_FINDEX_') or die('Access Denied');
$qr = null;
?>

<form method="post" action="">
	<div id="app_header">
		<div class="warp_app_header">		
			<div class="app_title"><?=New_Permalink;?></div>
			<div class="app_link">
				<button type="submit" class="delete btn btn-success" title="<?php echo Save; ?>" value="<?php echo Save; ?>" name="apply_new"><i class="icon-ok"></i> <?php echo Save; ?></button>	
				<button type="submit" class="delete btn btn-metis-2 " title="<?php echo Save_and_Quit; ?>" name="save_new"><i class="icon-ok-sign"></i> <?php echo Save_and_Quit; ?></button>			
				<a class="danger btn btn-default" href="?app=permalink" title="<?php echo Cancel; ?>"><i class="icon-remove-sign"></i> <?php echo Cancel; ?></a>
				<?php printAlert(); ?>
			</div>			
		</div>
	</div>	
	<div class="panel box"> 		
		<header>
			<h5>Permalink Data</h5>
		</header>
		<div>
			<table class="data2">
					<tr>
						<td class="row-title"><span class="tips" title="<?php echo permalink_link_tip; ?>" width="20%">Permalink</span></td>
						<td>
						<input type="text" <?=formRefill('permalink');?>  name="permalink" size="50" autocomplete="off" required></td>
					</tr>
				
					<tr>
						<td class="row-title"><span class="tips" title="<?php echo original_link_tip; ?>. ex:'?app=forum'">Original Link</span></td>
						<td><input type="text" name="link" <?=formRefill('link');?> size="50"  autocomplete="off" required></td>
					</tr>
					<tr>
						<td class="row-title"><span class="tips" title="<?php echo lock_permalink_tip; ?>">Lock Permalink</span></td>
							<td>
						<?php 
					if($qr['status'] or $act == 'add'){$f1="selected checked"; $f0 = "";}
					else {$f0="selected checked"; $f1= "";}
					?>
					<p class="switch">
						<input id="radio1"  value="1" name="lock" type="radio" <?php echo $f1;?> class="invisible">
						<input id="radio2"  value="0" name="lock" type="radio" <?php echo $f0;?> class="invisible">
						<label for="radio1" class="cb-enable <?php echo $f1;?>"><span>On</span></label>
						<label for="radio2" class="cb-disable <?php echo $f0;?>"><span>Off</span></label>
					</p>
					</td>
					</tr>
					<tr>
						<td class="row-title"><span class="tips" title="<?php echo permalink_status_tip; ?>">Enable permalink </span></td>
						<td>
					<p class="switch">
						<input id="radio3"  value="1" name="status" type="radio" <?php echo $f1;?> class="invisible">
						<input id="radio4"  value="0" name="status" type="radio" <?php echo $f0;?> class="invisible">
						<label for="radio3" class="cb-enable <?php echo $f1;?>"><span>On</span></label>
						<label for="radio4" class="cb-disable <?php echo $f0;?>"><span>Off</span></label>
					</p>
					</td>
					</tr>
					<tr>
						<td class="row-title"><span class="tips" title="<?php echo references_page_tip; ?>">References Page</span></td>
						<td><input type="number" name="page" size="4"  min="0" class="spinner numeric"></td>
					</tr>
					
				</table>			
			</div>  
		</div> 
	</div>  	
</form>
