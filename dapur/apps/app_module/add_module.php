<?php
/**
* @version		2.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2014 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.
**/

defined('_FINDEX_') or die('Access Denied');

if(isset($_POST['next']) or isset($_POST['folder'])) {
	if(empty($_POST['folder'])) {
		alert('error',Please_select_modul_first);
		addModuleStep1();
	}
	else {			
		addModuleStep2();
	}
}
else { 
	addModuleStep1();
}

function addModuleStep1() {
?>
<script type="text/javascript" charset="utf-8">
if (!$.isFunction($.fn.dataTable) ) {
	var script = '../plugins/plg_jquery_ui/datatables.js';
	document.write('<'+'script src="'+script+'" type="text/javascript"><' + '/script>');	
}	
$(function() {		
	$("form").submit(function(e){
		var ff = this;
		var checked = $('input:checked').length > 0;
		if(checked) {	
				ff.submit();
		} else {
			noticeabs("<?php echo alert('error',Please_Select_Item); ?>");
			$('input').next().addClass('input-error');
			return false;
		}
	});
	loadTable();
});
</script>
<form method="post">
	<div id="app_header">
		<div class="warp_app_header">
			<div class="app_title"><?php echo Installed_Module; ?></div>			
			<div class="app_link">
				<a class="delete btn btn-default btn-sm btn-grad" href="?app=module" title="<?php echo Back; ?>"><i class="icon-arrow-left"></i>&nbsp;<?php echo Prev; ?></a>
				<button type="submit" class="btn btn-success  btn-sm btn-grad" title="<?php echo Delete; ?>" value="Next" name="next"><?php echo Next; ?> &nbsp;<i class="icon-arrow-right"></i></button>
			</div>
			<?php printAlert(); ?>
		</div>			 
	</div>			
		
	<table class="data">
		<thead>
			<tr>
				<th style="width:2% !important;" class="no"></th>
				<th style="width:17% !important;"><?php echo Module_Name; ?></th>
				<th style="width:16% !important;"><?php echo AddOns_Author; ?></th>
				<th style="width:65% !important;"><?php echo Description; ?></th>
			</tr>
		</thead>
				
		<?php
			if(file_exists("../modules")) {
			$dir=opendir("../modules"); 
			while($folder=readdir($dir)){ 
				if($folder=="." or $folder=="..")continue; 
				if(is_dir("../modules/$folder")){
					include("../modules/$folder/mod_details.php");
					echo "<tr target-radio='$folder'>
						<td align=\"center\"><input type=\"radio\" name=\"folder\" data-name='$folder' target-radio='$folder'  value=\"$folder\"></td>
						<td><a title=\"Select\" class=\"tips\">$module_name</a></td>
						<td>$module_author</td>
						<td>$module_desc</td>
					</tr>";
				}
			} 
			closedir($dir);
			}
		?> 
	</table>
</form>
<?php 
}

function addModuleStep2() {
?>
<form method="post">
	<div id="app_header">
		<div class="warp_app_header">
			<div class="app_title"><?php echo New_Module; ?></div>			
			<div class="app_link">	
				<a class="btn btn-default" href="?app=module&act=add" title="<?php echo Back; ?>"><i class="icon-arrow-left"></i> <?php echo Prev; ?></a>											
				<button type="submit" class="btn btn-success" title="<?php echo Delete; ?>" value="Next" name="apply_add"><i class="icon-ok"></i> <?php echo Save; ?></button>				
				<button type="submit" class="btn btn-metis-2" title="<?php echo Delete; ?>" value="Next" name="save_add"><i class="icon-ok-sign"></i>  <?php echo Save_and_Quit; ?></button>
				</button>				
				<a class="danger btn btn-default" href="?app=module" title="<?php echo Cancel; ?>"><i class="icon-remove-sign"></i> <?php echo Cancel; ?></a>
			</div>
			<?php printAlert(); ?>
		</div>			 
	</div>		
	<?php 
		require('field_module.php');
	?>			
</form>
<?php 
}
?>