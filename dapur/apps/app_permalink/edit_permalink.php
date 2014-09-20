<?php
/**
* @version		2.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2014 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.txt
**/

defined('_FINDEX_') or die('Access Denied');

$db = @new FQuery() or die;  
$db->connect(); 
 
$sql=$db->select(FDBPrefix."permalink","*","id=$_REQUEST[id]"); 
$qr = mysql_fetch_array($sql); 
if($qr['status']==1) {$ck="checked";}
if($qr['status']==0) {$ck2="checked";}

?>
<form method="post" action="">
<input type="hidden" name="id" value="<?php echo $qr['id']; ?>">
	<div id="app_header">
		<div class="warp_app_header">		
			<div class="app_title"><?php echo Edit_Permalink;?></div>
			<div class="app_link">
				<button type="submit" class="delete btn btn-success" title="<?php echo Save; ?>" value="<?php echo Save; ?>" name="apply"><i class="icon-ok"></i> <?php echo Save; ?></button>	
				<button type="submit" class="delete btn btn-metis-2 " title="<?php echo Save_and_Quit; ?>" name="save"><i class="icon-ok-sign"></i> <?php echo Save_and_Quit; ?></button>				
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
						<input type="text" name="permalink" size="50" autocomplete="off" value="<?php echo $qr['permalink']; ?>" required></td>
					</tr>
				
					<tr>
						<td class="row-title"><span class="tips" title="<?php echo original_link_tip; ?>">Original Link</span></td>
						<td><input type="text" name="link" size="50"  autocomplete="off" value="<?php echo $qr['link']; ?>" required></td>
					</tr>
					<tr>
						<td class="row-title"><span class="tips" title="<?php echo lock_permalink_tip; ?>">Lock Permalink </span></td>
							<td><?php 
					if($qr['locker'] or $act == 'add'){$f1="selected checked"; $f0 = "";}
					else {$f0="selected checked"; $f1= "";}
					?>
					<p class="switch">
						<input id="radio1"  value="1" name="lock" type="radio" <?php echo $f1;?> class="invisible">
						<input id="radio2"  value="0" name="lock" type="radio" <?php echo $f0;?> class="invisible">
						<label for="radio1" class="cb-enable <?php echo $f1;?>"><span>On</span></label>
						<label for="radio2" class="cb-disable <?php echo $f0;?>"><span>Off</span></label>
					</p></td>
					</tr>
					<tr>
						<td class="row-title"><span class="tips" title="<?php echo permalink_status_tip; ?>">Enable permalink</span></td>
						<td>	<?php 
					if($qr['status'] or $act == 'add'){$f1="selected checked"; $f0 = "";}
					else {$f0="selected checked"; $f1= "";}
					?>
					<p class="switch">
						<input id="radio3"  value="1" name="status" type="radio" <?php echo $f1;?> class="invisible">
						<input id="radio4"  value="0" name="status" type="radio" <?php echo $f0;?> class="invisible">
						<label for="radio3" class="cb-enable <?php echo $f1;?>"><span>On</span></label>
						<label for="radio4" class="cb-disable <?php echo $f0;?>"><span>Off</span></label>
					</p></td>
					</tr>
					<tr>
						<td class="row-title"><span class="tips" title="<?php echo references_page_tip; ?>">References Page</span></td>
						<td><input type="number" name="page" size="4" class="numeric spinner" value="<?php echo $qr['pid']; ?>">
						</td>
					</tr>					
				</table>			
			</div>  
		</div> 
	</div>  	
</form>

