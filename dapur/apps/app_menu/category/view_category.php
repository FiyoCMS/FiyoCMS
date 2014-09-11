<?php
/**
* @version		2.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2014 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.
**/

defined('_FINDEX_') or die('Access Denied');

?>	
<script type="text/javascript">
if (!$.isFunction($.fn.dataTable) ) {
	var script = '../plugins/plg_jquery_ui/datatables.js';
	document.write('<'+'script src="'+script+'" type="text/javascript"><' + '/script>');	
}	
$(function() {
	$("#form").submit(function(e){
			var ff = this;
			var checked = $('input[name="check[]"]:checked').length > 0;
			if(checked) {	
				e.preventDefault();
				$('#confirmDelete').modal('show');	
				$('#confirm').on('click', function(){
				ff.submit();
			});		
		} else {
			noticeabs("<?php echo alert('error',Please_Select_Delete); ?>");
			$('input[name="check[]"]').next().addClass('input-error');
			return false;
		}
	});
	loadTable();
});
</script>
<div id="stat"></div>
<form method="post" id="form">
	<div id="app_header">
		<div class="warp_app_header">		
			<div class="app_title"><?php echo Menu_Category; ?></div>	
			<div class="app_link">
				<a class="add btn btn-primary btn-sm btn-grad" href="?app=menu&view=add_category" title="<?php echo Add_new_category; ?>"><i class="icon-plus"></i> <?php echo New_Category; ?></a>
				<button type="submit" class="delete btn btn-danger btn-sm btn-grad" title="<?php echo Delete; ?>" value="<?php echo Delete; ?>" name="delete_category"><i class="icon-trash"></i> &nbsp;<?php echo Delete; ?></button>		
			</div> 	
		</div>
		<?php printAlert(); ?>
	</div>
	
	<table cellpadding="4" class="data">
		<thead>
			<tr>								  
				<th style="width:1% !important;" class="no" colspan="0" id="ck">  
					<input type="checkbox" target="check[]"></th>				
				<th style="width:18% !important;"><?php echo Category_Title; ?></th>
				<th style="width:18% !important;"class='hidden-xs hidden-sm'><?php echo Category_Name; ?></th>
				<th style="width:40% !important;"class='hidden-xs'><?php echo Description; ?></th>
				<th style="width:15% !important;text-align: center;" class='hidden-xs'>Total <?php echo Menu; ?></th>
				<th style="width:5% !important; text-align: center;" class='hidden-xs' >ID</th>
			</tr>
		</thead>
		<tbody>
			<?php
			$db = new FQuery();  
			$db->connect(); 
			$level = Level_Access;
			$sql = $db->select(FDBPrefix.'menu_category','*',SQL_USER_LEVEL); 
			$no = 1; 
			while($qr=mysql_fetch_array($sql)){
				$qr2=$db->select(FDBPrefix.'menu','*',"category='$qr[category]'"); 
				$jml2= mysql_affected_rows();						
				$checkbox ="<input type='checkbox' name='check[]' value='$qr[category]' rel='ck'>";	
				$name ="<a data-placement='right' class='tips' title='".Edit."' href='?app=menu&view=edit_category&id=$qr[id]'>$qr[title]</a>";
				echo "<tr>";
				echo "<td align='center'>$checkbox</td><td><span class='visible-xs right'>$jml2 item</span>$name</td><td class='hidden-xs hidden-sm'>$qr[category]</td><td class='hidden-xs'>$qr[description]</td><td align='center' class='hidden-xs'>$jml2</td><td align='center' class='hidden-xs'>$qr[id]</td>";
				echo "</tr>";
				$no++;	
			}
			?>
        </tbody>			
	</table>
</form>