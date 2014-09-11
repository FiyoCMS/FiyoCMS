<?php
/**
* @version		2.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2014 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.
**/

defined('_FINDEX_') or die('Access Denied');

$_REQUEST['id']=0;

if(isset($_POST['next']) or isset($_POST['apps'])) {
	if(empty($_POST['apps'])) {
		echo '<div class="alert error" id="status">'.Please_Select_Apps.'</div>';
		 addappstep1();
	}
	else {			
		addappstep2();
	}
}
else {
	addappstep1();
}
	
function addappstep1() {
?>
<script type="text/javascript" charset="utf-8">
if (!$.isFunction($.fn.dataTable) ) {
	var script = '../plugins/plg_jquery_ui/datatables.js';
	document.write('<'+'script src="'+script+'" type="text/javascript"><' + '/script>');	
}	
$(function() {		
	
		$("input[type='radio']:checked").parents('tr').addClass('active');
	$("input[type='radio']:checked").click(function(e){	
		$("input[type='radio']:checked").parents('tr').addClass('active');
	});
	$("form").submit(function(e){
		var ff = this;
		var checked = $('input:checked').length > 0;
		if(checked) {
				ff.submit();
		} else {
			noticeabs("<?php echo alert('error',Please_Select_Menu); ?>");
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
			<div class="app_title"><?php echo New_Menu; ?></div>			
			<div class="app_link">
				<a class="delete btn btn-default btn-sm btn-grad" href="?app=menu" title="<?php echo Back; ?>"><i class="icon-arrow-left"></i>&nbsp;<?php echo Prev; ?></a>
				<button type="submit" class="btn btn-success  btn-sm btn-grad" title="<?php echo Delete; ?>" value="Next" name="next"><?php echo Next; ?> &nbsp;<i class="icon-arrow-right"></i></button>
			</div>
		</div>			 
	</div>
	<table class="data">
		<thead>
			<tr>
				<th style="width:1%; text-align:center" class="no" ></th>
				<th style="width:18% !important;"><?php echo Menu_Type_or_Apps_Name; ?></th>
				<th style="width:18% !important;"><?php echo AddOns_Author; ?></th>
				<th style="width:65% !important;"><?php echo Description; ?></th>
			</tr>
		</thead>
		</thead>
		<?php
		$db = new FQuery();  
		$db->connect(); 
		$sql =	$db->select(FDBPrefix.'apps','*','type <= 1',"name ASC"); $apps_date = $apps_version = '-';
		while($qr=mysql_fetch_array($sql)){	
				$file = "../apps/$qr[folder]/app_details.php";
				if(file_exists($file))
				include("../apps/$qr[folder]/app_details.php");
				echo "<tr target-radio='$qr[folder]'>";
				echo "<td align='center'><input type=\"radio\" name=\"apps\" value=\"$qr[folder]\" data-name='$qr[folder]' target-radio='$qr[folder]'></td><td><a>$qr[name]</a></td><td>$qr[author]</td>
				<td>$app_desc</td>";
				echo "</tr>";
			}
		?> 
		<tr target-radio="link">
			<td align="center"><input type="radio" name="apps" value="link" target-radio="link" data-name="link"></td>
			<td><a data-placement='right' class='tips' ><?php echo External_Link; ?></a></td>
			<td>Fiyo CMS</td>
			<td><?php echo External_Link_tip; ?></td>
		</tr>
		<tr target-radio="sperator">
			<td align="center"><input type="radio" name="apps" value="sperator" target-radio="link" data-name="sperator"></td>
			<td><a data-placement='right' class='tips' ><?php echo Sperator; ?></a></td>
			<td>Fiyo CMS</td>
			<td><?php echo Sperator_tip; ?></td>
		</tr>
	</table>
</form>			
<?php
}
function addappstep2() { 
?>
<form method="post" id="form">
	<div id="app_header">
		<div class="warp_app_header">
			<div class="app_title"><?php echo New_Menu; ?></div>	
			<div class="app_link">				
				<a class="delete btn btn-default btn-sm btn-grad" href="?app=menu&view=add" title="<?php echo Back; ?>"><i class="icon-arrow-left"></i> <?php echo Prev; ?></a>				
				<span class="lbt sparator"></span>
								
				<button type="submit" class="btn btn-success btn-sm btn-grad" title="<?php echo Delete; ?>" value="Next" name="apply_add"><i class="icon-ok"></i> <?php echo Save; ?></button>
				
				<button type="submit" class="btn btn-metis-2 btn-sm btn-grad" title="<?php echo Delete; ?>" value="Next" name="save_add"><i class="icon-ok-sign"></i>  <?php echo Save_and_Quit; ?></button>
				</button>				
				<a class="danger btn btn-default btn-sm btn-grad" href="?app=menu" title="<?php echo Cancel; ?>"><i class="icon-remove-sign"></i> <?php echo Cancel; ?></a>
				<span class="lbt sparator"></span>
				<a class="lbt help popup  tooltip" href="#helper" title="<?php echo Help; ?>"></a><!--
				<div id="helper"><?php echo Add_Menu_2_help; ?></div>-->
			
			</div>
		</div>
	</div>
	<?php 
		require('field_menu.php');
	?>		
</form>		
<?php
}