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
	$("#form").submit(function(e){
		e.preventDefault();
		var ff = this;
		var checked = $('input[name="check_group[]"]:checked').length > 0;
		if(checked) {	
			$('#confirmDelete').modal('show');	
			$('#confirm').on('click', function(){
				ff.submit();
			});		
		} else {
			noticeabs("<?php echo alert('error',Please_Select_Delete); ?>");
			$('input[name="check_group[]"]').next().addClass('input-error');
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
		<div class="app_title">User Group</div>	
		<div class="app_link">
			<a class="add btn btn-primary" href="?app=user&view=group&act=add" title="<?php echo New_Group; ?>"><i class="icon-plus"></i> <?php echo New_Group; ?></a>
			<button type="submit" class="delete btn btn-danger" title="<?php echo Delete; ?>" value="<?php echo Delete; ?>" name="delete"><i class="icon-trash"></i> &nbsp;<?php echo Delete; ?></button>
			<?php printAlert(); ?>	
		</div> 	
	 </div>
	</div>
	
	<table cellpadding="4" class="data">
		<thead>
			<tr>								  
				<th style="width:1% !important;" class="no" colspan="0" id="ck">  
					<input type="checkbox" id="checkall" target="check[]"></th>
				<th style="width:30% !important;"><?php echo Group_name; ?></th>
				<th style="width:10% !important; text-align: center;">Level</th>
				<th style="width:60% !important;"  class='hidden-xs'><?php echo Description; ?></th>
				<th style="width:5% !important;text-align: center;"  class='hidden-xs'>ID</th>
			</tr>
		</thead>
		<tbody>
		<?php
			$db = new FQuery();  
			$sql=$db->select(FDBPrefix.'user_group','*','','level ASC'); 		
			$no=1;
			foreach($sql as $row) {
				$checkbox = null;
				if($row['level']!=1 And $row['level']!=2 and $row['level']!=3 )
				$checkbox ="<input type='checkbox' name='check_group[]' value='$row[level]'>";
				else $checkbox = "<span class='icon lock'></lock>";
				$name ="<a class='tips' title='".Edit."' data-placement='right' href='?app=user&view=group&act=edit&id=$row[id]'>$row[group_name]</a>";
				if($_SESSION['USER_LEVEL'] > 2) {
					$checkbox = "<span class='icon lock'></lock>";
					$name ="$row[group_name]";
					}
				echo "<tr>";
				echo "<td align='center'>$checkbox</td><td>$name</td><td align='center'>$row[level]</td><td  class='hidden-xs'>$row[description]</td><td align='center'  class='hidden-xs'>$row[id]</td>";
				echo "</tr>";
				$no++;	
			}					
			?>
        </tbody>			
	</table>
</form>