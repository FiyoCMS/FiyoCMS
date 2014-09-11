<?php
/**
* @version		2.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2014 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.txt
**/

defined('_FINDEX_') or die('Access Denied');

$db = new FQuery();  
$db->connect();
printAlert();
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
				url: "apps/app_contact/controller/status.php",
				data: type+"=1&id="+id,
				success: function(data){				
					notice(data);
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
				url: "apps/app_contact/controller/status.php",
				data: type+"=0&id="+id,
				success: function(data){
					notice(data);				
				}
			});
		});
		
		$("#form").submit(function(e){
			e.preventDefault();
			var ff = this;
			var checked = $('input[name="check[]"]:checked').length > 0;
			if(checked) {	
				$('#confirmDelete').modal('show');	
				$('#confirm').on('click', function(){
					ff.submit();
				});		
			} else {
				noticeabs("<?php echo alert('error',Please_Select_Menu); ?>");
				$('input[name="check[]"]').next().addClass('input-error');
				return false;
			}
		});		
		loadTable();
		
	});

</script>
<form method="post" id="form">
	<div id="app_header">
		<div class="warp_app_header">				
			<div class="app_title"><?php echo Contact_Manager; ?></div>
			<div class="app_link">			
				<a class="add btn btn-primary" Value="Create" href="?app=contact&act=add" title="<?php echo Add_New_Contact; ?>"><i class="icon-plus"></i> <?php echo New_Contact; ?></a>
				<button type="submit" class="delete btn btn-danger btn-sm btn-grad" title="<?php echo Delete; ?>" value="<?php echo Delete; ?>" name="delete"><i class="icon-trash"></i> &nbsp;<?php echo Delete; ?></button>
			<a class="lbt group tooltip link" href="?app=contact&act=group" title="Change to Group View"></a>	
				<input type="hidden" value="true" name="delete_confirm"  style="display:none" />
		  </div> 	
		</div>
	</div>
	<table class="data">
		<thead>
			<tr>								  
				<th width="3%" class="no" colspan="0" id="ck">  
				<input type="checkbox" class="checkall" target='check[]'></th>		
				<th style="width:20% !important;"><?php echo Name; ?></th>
				<th style="width:10% !important;" >Gender</th>
				<th style="width:8% !important;" class="no" align="center">Status</th>
				<th style="width:20% !important;" >Group</th>
				<th style="width:20% !important;" >Email</th>
				<th style="width:20% !important;" >Phone</th>
			</tr>
		</thead>		
		<tbody>
			<?php	
			$sql = $db->select(FDBPrefix.'contact','*',"","name ASC");
			$no=1;				
			while($qr=mysql_fetch_array($sql)){
				/* logika status aktif atau tidak */
				if($qr['status']==1)
				{ $stat1 ="selected"; $stat2 ="";}							
				else
				{ $stat2 ="selected";$stat1 ="";}
				
				$status ="
				<p class='switch'>
					<label class='cb-enable $stat1'><span>On</span></label>
					<label class='cb-disable $stat2'><span>Off</span></label>
					<input type='text' value='$qr[id]' id='id' class='invisible'><input type='text' value='stat' id='type' class='invisible'>
				</p>";
				
				/* logika halaman depan */
				$group = oneQuery('contact_group','id',$qr['group_id'],'name');
				$name ="<a class='edit tips link' data-placement='right' title='".Edit."' href='?app=contact&act=edit&id=$qr[id]'>$qr[name]</a>";
				
				$checkbox ="<input type='checkbox' data-name='rad-$qr[id]' sub-target='.sub-menu' name='check[]' value='$qr[id]' rel='ck'>";
				if($qr['gender'] == 1) $gender = Man; else $gender = Woman; 
				echo "<tr>";
				echo "<td align='center'>$checkbox</td><td>$name</td><td>$gender</td><td  align='center'>$status</td><td>$group</td><td>$qr[email]</td><td>$qr[phone]</td>";
				echo "</tr>";
			$no++;	
			}			
			?>
        </tbody>			
	</table>
</form>

<div class="app_link tabs" style="text-align: center;width: 90%;">	
	<a class="btn apps active" href="?app=contact" title="<?php echo Manage_Apps; ?>"><i class="icon-user"></i> Personal</a>		
	<a class="btn module " href="?app=contact&view=group" title="<?php echo Manage_Modules; ?>"><i class="icon-group"></i> Group</a>	
</div>
