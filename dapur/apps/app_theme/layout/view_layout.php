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
			var checked = $('input[name="check_layout[]"]:checked').length > 0;
			if(checked) {	
				e.preventDefault();
				$('#confirmDelete').modal('show');	
				$('#confirm').on('click', function(){
				ff.submit();
			});		
		} else {
			noticeabs("<?php echo alert('error',Please_Select_Item); ?>");
			$('input[name="check_layout[]"]').next().addClass('input-error');
			return false;
		}
	});
	loadTable();
});
</script>
<form method="post" id="form">
	<div id="app_header">
		<div class="warp_app_header">		
		  <div class="app_title"><?php echo Layout_List; ?></div>
		  <div class="app_link">			
			<a class="add btn btn-primary btn-sm btn-grad" href="?app=theme&view=layout&act=add"><i class="icon-plus"></i> <?php echo Add; ?></a>
			<button type="submit" class="delete btn btn-danger btn-sm btn-grad" title="<?php echo Delete; ?>" value="<?php echo Delete; ?>" name="delete_layout"><i class="icon-trash"></i> &nbsp;<?php echo Delete; ?></button>
		  </div> 
		  <?php printAlert(); ?>		  
		</div>
	</div>
	<table class="data">
		<thead>
			<tr>								  	
				<th style="width:1% !important;" class="no" colspan="0" id="ck">  
					<input type="checkbox" id="checkall" target="check_layout[]">
                                </th>		
				<th style="width:20% !important;"><?php echo Name; ?></th>	
				<th style="width:70% !important; text-align:center">
                                    <?php echo Description; ?>
                                </th>
                                <th style="width:10% !important; text-align:right">
                                    <?php echo Theme; ?></th>
			</tr>
		</thead>
		<tbody>
			<?php		
			$db = new FQuery();  
			$db->connect(); 
			$sql= $db->select(FDBPrefix.'theme_layout');
			$no=1;
			foreach($sql as $row){
                            if($no == 1) 
				$checkbox ="<span class='icon lock'></span>";
                            else
				$checkbox ="<input type='checkbox' data-name='rad-$row[id]' sub-target='.sub-menu' name='check_layout[]' value='$row[id]' rel='ck'>";
				$name ="<a class='tips' title='".Edit."' data-placement='right'  href='?app=theme&view=layout&act=edit&id=$row[id]'>$row[name]</a>";
				echo "<tr>";
				echo "<td align='center'>$checkbox</td><td>$name</td><td align='center'>$row[desc]</td><td align='right'>$row[theme]</td>";
				echo"</tr>";
				$no++;	
				
			}					
			?>
        </tbody>			
	</table>
</form>