<?php
/**
* @version		2.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2014 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.
**/

defined('_FINDEX_') or die('Access Denied');
printAlert();

?>	
<script type="text/javascript" charset="utf-8">
	$(document).ready(function() {
		$(".cb-enable").click(function(){
			var parent = $(this).parents('.switch');
			if($(this).hasClass('selected')) die();
			$('.cb-disable',parent).removeClass('selected');
			$(this).addClass('selected');
			$('.checkbox',parent).attr('checked', true);
			var id = $('#id',parent).attr('value');
			var type = $('#type',parent).attr('value');
			
			$.ajax({
				url: "apps/app_permalink/controller/status.php",
				data: type+"=1&id="+id,
				success: function(data){
					notice(data);
				}
			});
		});
		
		$(".cb-disable").click(function(){
			var parent = $(this).parents('.switch');
			if($(this).hasClass('selected')) die();
			$('.cb-enable',parent).removeClass('selected');
			$(this).addClass('selected');
			$('.checkbox',parent).attr('checked', false);
			var id = $('#id',parent).attr('value');
			var type = $('#type',parent).attr('value');
			
			$.ajax({
				url: "apps/app_permalink/controller/status.php",
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
				noticeabs("<?php echo alert('error',Article_Not_Select); ?>");
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
		
		<div class="app_title">Permalink Manager</div>
	
		<div class="app_link">
			<a class="add btn btn-primary" href="?app=permalink&act=add" title="<?php echo Add_New_Item; ?>"><i class="icon-plus"></i> <?php echo _New; ?></a>
			<button class="delete btn btn-danger" type="submit" name="delete" title="<?php echo Delete; ?>" ><i class="icon-trash"></i> <?php echo Delete; ?></button>
			<input type="hidden" value="true" name="delete_confirm"  style="display:none" />
		</div> 	
	  </div> 
	</div> 	
	
	<table class="data">
		<thead>
			<tr>								  
				<th width="3%" class="no" colspan="0" id="ck">  
					<input type="checkbox" id="checkall" target="check[]"></th>				
				<th style="width:40% !important;">Permalink</th>
				<th style="width:40% !important; ">Link</th>
				<th style="width:15% !important; text-align: center">Lock</th>
				<th style="width:5% !important; text-align: center">PID</th>
			</tr>
		</thead>
		<tbody>
		<?php		
		$db = new FQuery();  
		$db->connect(); 	
		$sql=$db->select(FDBPrefix.'permalink','*','','locker DESC');
		$no=1;
		while($qr=mysql_fetch_array($sql)){	
					
				if($qr['locker']==1)
				{ $stat1 ="selected"; $stat2 ="";}							
				else
				{ $stat2 ="selected";$stat1 ="";}
				
				$status ="
				<p class='switch'>
					<label class='cb-enable $stat1'><span>&nbsp;Lock&nbsp;</span></label>
					<label class='cb-disable $stat2'><span>Unlock</span></label>
					<input type='text' value='$qr[id]' id='id' class='invisible'><input type='text' value='stat' id='type' class='invisible'>
				</p>";
														
				$name ="<a class='tips' data-placement='right' title='".Edit."' href='?app=permalink&act=edit&id=$qr[id]'>$qr[permalink]</a>";
							
				$permalink ="<a class='tips' data-placement='right' title='".Edit."' href='?app=permalink&act=edit&id=$qr[id]'>$qr[link]</a>";						
				
				$check ="<input type='checkbox' name='check[]' value='$qr[id]' rel='ck'>";
				$menu = menuInfo("name",null,"$qr[pid]");
				if(empty($menu)) $menu = "Default";
				echo "<tr>";
				echo "<td align='center'>$check</td><td>$name</td><td>$permalink</td><td align=center>$status</td><td align='center'><span class='tips' data-placement='top' title='$menu'>$qr[pid]</span></td>";
				echo "</tr>";
				$no++;	
			}
		?>
        </tbody>			
	</table>
</form>