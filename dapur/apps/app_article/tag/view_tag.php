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
			var checked = $('input[name="check_tag[]"]:checked').length > 0;
			if(checked) {	
				e.preventDefault();
				$('#confirmDelete').modal('show');	
				$('#confirm').on('click', function(){
				ff.submit();
			});		
		} else {
			noticeabs("<?php echo alert('error',Please_Select_Item); ?>");
			$('input[name="check_tag[]"]').next().addClass('input-error');
			return false;
		}
	});
	loadTable();
});
</script>
<form method="post" id="form">
	<div id="app_header">
		<div class="warp_app_header">		
		  <div class="app_title"><?php echo Article_Tags; ?></div>
		  <div class="app_link">			
			<a class="add btn btn-primary btn-sm btn-grad" href="?app=article&view=tag&act=add"><i class="icon-plus"></i> <?php echo New_Tag; ?></a>
			<button type="submit" class="delete btn btn-danger btn-sm btn-grad" title="<?php echo Delete; ?>" value="<?php echo Delete; ?>" name="delete_tag"><i class="icon-trash"></i> &nbsp;<?php echo Delete; ?></button>
		  </div> 
		  <?php printAlert(); ?>		  
		</div>
	</div>
	<table class="data">
		<thead>
			<tr>								  	
				<th style="width:1% !important;" class="no" colspan="0" id="ck">  
					<input type="checkbox" id="checkall" target="check_tag[]"></th>		
				<th style="width:89% !important;"><?php echo Tags; ?></th>	
				<th style="width:10% !important; text-align:center"><?php echo Hits; ?></th>
			</tr>
		</thead>
		<tbody>
			<?php		
			$db = new FQuery();  
			$db->connect(); 
			$sql= $db->select(FDBPrefix.'article_tags');
			$no=1;
			while($qr=mysql_fetch_array($sql)){
				$checkbox ="<input type='checkbox' data-name='rad-$qr[id]' sub-target='.sub-menu' name='check_tag[]' value='$qr[id]' rel='ck'>";
				$name ="<a class='tips' title='".Edit."' data-placement='right'  href='?app=article&view=tag&act=edit&id=$qr[id]'>$qr[name]</a>";
				echo "<tr>";
				echo "<td align='center'>$checkbox</td><td>$name</td><td align='center'>$qr[hits]</td>";
				echo"</tr>";
				$no++;	
				
			}					
			?>
        </tbody>			
	</table>
</form>