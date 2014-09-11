<?php
/**
* @version		1.5.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2012 Fiyo CMS.
* @license		GNU/GPL, see license.txt
* @description	
**/

defined('_FINDEX_') or die('Access Denied');
printAlert();
?>	
<script type="text/javascript" charset="utf-8">
		$(document).ready(function() {
			loadTable();
			$('#checkall').click(function () {
		        $(this).parents('form:eq(0)').find(':checkbox').attr('checked', this.checked);
			});
		});
</script>
<form method="post">
	<div id="app_header">
	 <div class="warp_app_header">
		
		<div class="app_title"><?=Group_Contact;?></div>
	
		<div class="app_link">
			<a class="btn add btn-primary" href="?app=contact&view=group&act=add" title="<?php echo Add_new_group; ?>"><i class="icon-plus"></i> <?php echo New_Group; ?></a> <button type="submit" class="delete btn btn-danger" title="<?php echo Delete; ?>" value="<?php echo Delete; ?>" name="delete_group"><i class="icon-trash"></i> &nbsp;<?php echo Delete; ?></button>
		</div> 	
	 </div>
	</div>
	
	<table cellpadding="4" class="data">
		<thead>
			<tr>								  
				<th width="3%" class="no" colspan="0" id="ck">  
					<input type="checkbox" id="checkall"></th>				
				<th style="width:20% !important;">Group Name</th>
				<th style="width:60% !important;"><?php echo Description; ?></th>
				<th style="width:15% !important; text-align: center;" class=''>Contact</th>
				<th style="width:2% !important;">ID</th>
			</tr>
		</thead>
		<tbody>
			<?php
			$db = new FQuery();  
			$db->connect(); 
			$sql = $db->select(FDBPrefix.'contact_group'); 
			$no = 1; 
			while($qr=mysql_fetch_array($sql)){
				$qr2=$db->select(FDBPrefix.'contact','*',"group_id='$qr[id]'"); 
				$jml2= mysql_affected_rows();						
				$checkbox ="<input type='checkbox' name='check[]' value='$qr[id]'>";	
				$name ="<a class='tips' title='".Edit."' href='?app=contact&view=group&act=edit&id=$qr[id]'>$qr[name]</a>";
				echo "<tr>";
				echo "<td align='center'>$checkbox</td><td>$name</td><td>$qr[description]</td><td align='center'>$jml2</td><td align='center'>$qr[id]</td>";
				echo "</tr>";
				$no++;	
			}
			?>
        </tbody>			
	</table>
</form>


<div class="app_link tabs" style="text-align: center;width: 90%;">	
	<a class="btn apps " href="?app=contact" title="<?php echo Manage_Apps; ?>"><i class="icon-user"></i> Personal</a>		
	<a class="btn module active" href="?app=contact&view=group" title="<?php echo Manage_Modules; ?>"><i class="icon-group"></i> Group</a>	
</div>