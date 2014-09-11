<?php 
/**
* @version		1.5.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2012 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.txt
* @description	
**/

defined('_FINDEX_') or die('Access Denied');

$db = @new FQuery() or die;  
$db->connect(); 

$auto 	= oneQuery('comment_setting','name',"'auto_submit'",'value');
$name   = oneQuery('comment_setting','name',"'name_filter'",'value');
$email  = oneQuery('comment_setting','name',"'email_filter'",'value');
$filter = oneQuery('comment_setting','name',"'word_filter'",'value');
$public_key = oneQuery('comment_setting','name',"'recaptcha_publickey'",'value');
$private_key = oneQuery('comment_setting','name',"'recaptcha_privatekey'",'value');

?>

<script type="text/javascript">
	$(function() {
		$(".cb-enable").click(function(){
			var parent = $(this).parents('.switch');
			$('.cb-disable',parent).removeClass('selected');
			$(this).addClass('selected');
		});
		$(".cb-disable").click(function(){
			var parent = $(this).parents('.switch');
			$('.cb-enable',parent).removeClass('selected');
			$(this).addClass('selected');
		});	
	});
</script>	
<form method="post">
<input value="<?php echo $qr[id];?>" type="hidden" name="id">
	<div id="app_header">
		<div class="warp_app_header">		
			<div class="app_title"><?php echo Comment_Configuration; ?></div>			
			<div class="app_link">	
			<input type="submit" class="lbt save tooltip" title="<?php echo Save; ?>" name="save_config"/>
			<hr class="lbt sparator tooltip">
			<a class="lbt cancel tooltip link" href="?app=comment" title="<?php echo Prev; ?>"></a>
			</div>
		 </div>			 
	</div>
	
	<div class="cols">
		<div class="col first full">
			<h3>Comment Details</h3>
			<div class="isi">
			<table class="data2">				
				
				<tr>
					<td class="djudul tooltip" title="<?php echo Auto_Submit_tip; ?>">Auto Publish</td>
					<td>
					<?php 
							if($auto){$f1="selected checked"; $f0 = "";}
							else {$f0="selected checked"; $f1= "";}
						?>
						<p class="switch">
							<input id="radio17"  value="1" name="auto" type="radio" <?php echo $f1;?> class="invisible">
							<input id="radio18"  value="0" name="auto" type="radio" <?php echo $f0;?> class="invisible">
							<label for="radio17" class="cb-enable <?php echo $f1;?>"><span>Yes</span></label>
							<label for="radio18" class="cb-disable <?php echo $f0;?>"><span>No</span></label>
						</p></td>
				</tr>		
				<tr>
					<td class="djudul tooltip" title="<?php echo Name_Filter_tip; ?>">Name Filter</td>
					<td><textarea name="name"cols="40" rows="3"><?php formRefill('name',"$name",'textarea');?></textarea></td>
				</tr>
				<tr>
					<td class="djudul tooltip" title="<?php echo Email_Filter_tip; ?>">Email Filter</td>
					
					<td><textarea name="email" cols="40" rows="3"><?php formRefill('email',"$email",'textarea');?></textarea></td>
				</tr>	
				<tr>
					<td class="djudul tooltip" title="<?php echo Word_Filter_tip; ?>"><?php echo Word_Filter; ?></td>
					<td><textarea name="word" cols="40" rows="3"><?php formRefill('word',"$filter",'textarea');?></textarea></td>
				</tr>	
				<tr>
					<td class="djudul tooltip" title="<?php echo Recaptcha_tip; ?>">ReCaptcha Public Key</td>
					
					<td><input type="text" name="public" size="50" <?php formRefill('public',"$public_key");?>/></td>
				</tr>	
				<tr>
					<td class="djudul tooltip" title="<?php echo Recaptcha_tip; ?>">ReCaptcha Private Key</td>
					<td><input type="text" name="private" size="50"<?php formRefill('private',"$private_key");?> /></td>
				</tr>	
			</table>
			</div>
		</div>
		
	</div>
</form>