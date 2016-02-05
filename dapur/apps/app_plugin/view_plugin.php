<?php
/**
* @version		2.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2014 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.
**/

defined('_FINDEX_') or die('Access Denied');

?>	
<script type="text/javascript" charset="utf-8">	
	$(document).ready(function() {
		$(".cb-enable").click(function(){
			var parent = $(this).parents('.switch');
			$('.cb-disable',parent).removeClass('selected');
			$(this).addClass('selected');
			$('.checkbox',parent).attr('checked', true);
			var id = $('#id',parent).attr('value');
			var type = $('#type',parent).attr('value');
			
			$.ajax({
				url: "apps/app_plugin/controller/status.php",
				data: type+"=1&id="+id,
				success: function(data){
				notice(data);
				var loadings = $("#stat");
				loadings.hide();
				loadings.fadeIn();	
				setTimeout(function(){
					$('#stat').fadeOut(1000, function() {
					});				
				}, 3000);
				}
			});
		});
		
		$(".cb-disable").click(function(){
			var parent = $(this).parents('.switch');
			$('.cb-enable',parent).removeClass('selected');
			$(this).addClass('selected');
			$('.checkbox',parent).attr('checked', false);
			var id = $('#id',parent).attr('value');
			var type = $('#type',parent).attr('value');
			
			$.ajax({
				url: "apps/app_plugin/controller/status.php",
				data: type+"=0&id="+id,
				success: function(data){
				notice(data);
				var loadings = $("#stat");
				loadings.hide();
				loadings.fadeIn();	
				setTimeout(function(){
					$('#stat').fadeOut(1000, function() {
					});				
				}, 3000);
				
				}
			});
		});
	loadTable();		
});
</script>
<form method="post" id="form">
	<div id="app_header">
		<div class="warp_app_header">		
			<div class="app_title"><?php echo Plugins_Manager; ?></div>
			<!--div class="app_link">			
				<a class="add btn btn-primary" href="?app=module&act=add" title="<?php echo Add_new_module; ?>"><i class="icon-plus"></i> <?php echo Add_new_module; ?></a>
				<button type="submit" class="delete btn btn-danger btn-sm btn-grad" title="<?php echo Delete; ?>" value="<?php echo Delete; ?>" name="delete"><i class="icon-trash"></i> &nbsp;<?php echo Delete; ?></button>
				<input type="hidden" value="true" name="delete_confirm"  style="display:none" />
				<?php printAlert('NOTICE_REF'); ?>
			</div-->
		</div>		 
	</div>
	<table class="data">
		<thead>
			<tr>	
				<th style="width:20% !important;"><?php echo Plugin_Name; ?></th>
				<th style="width:15% !important;" class="no" align="center">Status</th>
				<th style="width:15% !important;"><?php echo AddOns_Author; ?></th>
				<th style="width:50% !important;"><?php echo Description; ?></th>
			</tr>
		</thead>
		<tbody>
		<?php	
		$db = new FQuery();  
		
		if(isset($_POST['uninstall']) AND !empty($_POST['folder'])) {
			$folder = $_POST['folder'];
			
			$a = $b = 'Null <br>';
			if(delete_directory("../plugins/$folder")) $a ="folder <i>folder/$folder</i> ".has_ben_deleted.".<br>";			
			
			$qr = $db->delete(FDBPrefix.'plugins',"folder='$folder'");
			$b = "tabel <i>$folder</i> ".has_ben_deleted.".<br>";	
			alert('info',"$a $b");
		}		
		

		$dir=opendir("../plugins"); 
			$no=1;
			while($folder=readdir($dir)){ 
				if($folder=="." or $folder=="..")continue; 
				if(!preg_match ( "/[\.]/i" , $folder))
				{
					$file = "../plugins/$folder/plg_details.php";
					if(file_exists($file))	{ 
					
					$sql = $db->select(FDBPrefix.'plugin','*',"folder = '$folder'");
					$stat = $sql[0]['status'];
					$plgid = $sql[0]['id'];
					
					if($stat == 1)
					{ $stat1 ="selected"; $stat2 ="";}							
					else
					{ $stat2 ="selected";$stat1 ="";}				
					$status ="
					<p class='switch'>
						<label class='cb-enable $stat1'><span>On</span></label>
						<label class='cb-disable $stat2'><span>Off</span></label>
						<input type='text' value='$plgid' id='id' class='invisible'><input type='text' value='stat' id='type' class='invisible'>
					</p>";	
					
						include($file);						
						$file = "../plugins/$folder/plg_params.php";
						$popup = '';
						if(file_exists($file)) {						
							echo "<tr><td><a title=\"".Edit."\" class=\"tips\" href=\"?app=plugin&view=$folder\" data-placement=\"right\" title=\"Edit\" rel=\"width:500;height:400\">$plg_name</a><a class='btn btn-tools btn-primary' href=\"?app=plugin&view=$folder\">".Edit."</a>";
							
						}
						else
						{
							echo "</td><td><a title=\"$plg_desc\" class=\"help plg_prm\" >$plg_name</a>";
						
						}
							
						echo "<td align=center>$status</td></td>
						<td>$plg_author</td><td>$plg_desc</td>
						</tr>";
					}
				}
				$no++;
			} 
			closedir($dir);
		?> 
		</tbody>
	</table>
</form>		