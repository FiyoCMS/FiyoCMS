<?php
/**
* @version		2.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2014 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.
**/

defined('_FINDEX_') or die('Access Denied');

$db = new FQuery(); 
$db->connect();

printAlert();

?>
<script type="text/javascript">	
if (!$.isFunction($.fn.dataTable) ) {
	var script = '../plugins/plg_jquery_ui/datatables.js';
	document.write('<'+'script src="'+script+'" type="text/javascript"><' + '/script>');
}	
$(function() {	
	$(".activator label").click(function(){ 
		var parent = $(this).parents('.switch');
		var id = $('#id',parent).attr('value');	
		var value = $('#type',parent).attr('value');
		if(value == 1) value = 0; else value = 1;
		$.ajax({
			url: "apps/app_menu/controller/status.php",
			data: "stat="+value+"&id="+id,
			success: function(data){
				if(value == 1)
					$('.type',parent).val("1");
				else 
					$('.type',parent).val("0");				
				notice(data);		
			}
		});
	});
			
	$(".star label.cb-enable").click(function(){
		$('.star label').removeClass('selected');
		$('.star label.cb-disable').addClass('selected');
		var parent = $(this).parents('.switch');
		var id = $('#id',parent).attr('value');
		var type = $('#type',parent).attr('value');	
		$.ajax({
			url: "apps/app_menu/controller/status.php",
			data: "default=1&id="+id,
			success: function(data){
				notice(data);
				$('star .cb-enable').addClass('selected');
			}
		});			
	}); 
			
	$(".home label.cb-enable").click(function(){
		$('.home label').addClass('selected');
		$('.home label.cb-enable').removeClass('selected');
		var parent = $(this).parents('.switch');
		var id = $('#id',parent).attr('value');
		var cat = $('#id',parent).data('category');	
		var type = $('#type',parent).attr('value');			
		$.ajax({
			url: "apps/app_menu/controller/status.php",
			data: "home=1&id="+id,
			success: function(data){						
				$('.home-label').remove();
				$('.menu .menu-'+cat+' a').append("<span class='label label-danger home-label'>home</span>");
				notice(data);		
				$(this +'.cb-disable').addClass('selected');				
			}
		});			
	});
		
	$(".cb-enable").click(function(){		
		var parent = $(this).parents('.switch');
		$('.cb-disable',parent).removeClass('selected');
		$(this).addClass('selected');
		$('.checkbox',parent).attr('checked', false);	
	});
	$(".activator .cb-disable").click(function(){		
		var parent = $(this).parents('.switch');
		$('.cb-enable',parent).removeClass('selected');
		$(this).addClass('selected');
		$('.checkbox',parent).attr('checked', false);	
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
			<div class="app_title">Menu Manager</div>
			<div class="app_link">			
				<a class="add btn btn-primary btn-sm btn-grad" href="?app=menu&view=add" title="<?php echo Add_New_Menu; ?>"><i class="icon-plus"></i> <?php echo New_Menu; ?></a>
				<button type="submit" class="delete btn btn-danger btn-sm btn-grad" title="<?php echo Delete; ?>" value="<?php echo Delete; ?>" name="delete"><i class="icon-trash"></i> &nbsp;<?php echo Delete; ?></button>
				<input type="hidden" value="true" name="delete_confirm" style="display:none" />				
		 </div> 	
		</div>
	</div>
    <table class="data">
		<thead>
			<tr>								 
				<th style="width:1% !important;" class="no" colspan="0" id="ck" align="center">
				<input type="checkbox" class="checkall" target='check[]'></th>		
				<th style="width:30% !important;"><?php echo Name; ?></th>
				<th style="width:15% !important;" class="no hidden-xs hidden-sm" align="center">Status</th>
				<th style="width:13% !important;" class='hidden-xs'><?php echo Category; ?></th>
				<th style="width:13% !important;" class='hidden-xs'><?php echo Type; ?></th>
				<th style="width:5% !important; text-align: center;" class='hidden-xs hidden-sm'><?php echo Short; ?></th>
				<th style="width:15% !important; text-align: center;" class='hidden-xs'><?php echo Access_Level; ?></th>
				<th style="width:6% !important; text-align: center;">ID</th>
			</tr>
		</thead>		
		<tbody>
			<?php			
			//start query to get home page value.
			$cat_default = oneQuery('menu','home',1,'category');
			if(!empty($cat_default)) $cat_default =" AND category='$cat_default'"; 
			if(isset($_REQUEST['cat'])) {
				$cat = $_REQUEST['cat'];
				$sql = $db->select(FDBPrefix.'menu','*',"parent_id=0 AND category='$cat'","short ASC");					
				}
			else {
				$cat = $_REQUEST['cat'] = null;				 				
				$sql = $db->select(FDBPrefix.'menu','*',"parent_id=0 $cat_default","short ASC");		
			}
			$no=1;				
			while($qr=mysql_fetch_array($sql)){
				if($qr['status']==1)
				{ $stat1 ="selected"; $stat2 =""; $enable = ' enable';}							
				else
				{ $stat2 ="selected";$stat1 =""; $enable = 'disable';}
				
				$status ="<span class='invisible'>$enable</span>
					<div class='switch s-icon activator'>
					<label class='cb-enable tips $stat1' data-placement='right' title='".Disable."'><span>
					<i class='icon-remove-sign'></i></span></label>
					<label class='cb-disable tips $stat2' data-placement='right' title='".Enable."'><span>
					<i class='icon-ok-sign'></i></span></label>
					<input type='hidden' value='$qr[id]' id='id' class='invisible'>
					<input type='hidden' value='$qr[status]' id='type' class='invisible'>
				</div>";					
				
				/* change home page */
				if($qr['home']==1)
				{ $hm = "selected"; $hms = ""; }							
				else
				{ $hm = ""; $hms = "selected"; }		
				$home ="
				<div class='switch s-icon home'>
					<label class='cb-enable tips $hm' data-placement='left' title='".Set_as_home_page."'><span>
					<i class='icon-home'></i></span></label>
					<label class='cb-disable tips $hms' data-placement='left' title='".As_home_page."'><span>
					<i class='icon-home'></i></span></label>
					<input type='hidden' value='$qr[id]' id='id' data-category='$qr[category]' class='invisible'>
					<input type='hidden' value='stat' id='type' class='invisible'>
				</div>";		
				/* change default page */				
				if($qr['global']==1)
				{ $dm = "selected"; $dms = ""; }							
				else
				{ $dm = ""; $dms = "selected"; }		

				$default ="
					<div class='switch s-icon star'>
						<label class='cb-enable tips $dm' title='".Set_as_default_page."'><span>
						<i class='icon-star'></i>
						</span></label>
						<label class='cb-disable tips $dms' title='".As_default_page."'><span>
						<i class='icon-star'></i></span></label>
						<input type='hidden' value='$qr[id]' class='invisible' id='id'>
						<input type='hidden' value='fp' id='type' class='invisible'>
					</div>";		

				
				$name ="<a class='tips' title='".Edit."' data-placement='right' href='?app=menu&view=edit&id=$qr[id]'>$qr[name]</a>";
				
				$checkbox ="<input type='checkbox' data-name='rad-$qr[id]' sub-target='.sub-menu' name='check[]' value='$qr[id]' rel='ck'>";
				$tools = '<div class="tool-box visible-xs">
				<a class="btn-tools btn btn-danger btn-sm btn-grad" title="Non-aktifkan">Non-aktifkan</a>
				<a href="?app=user&amp;act=edit&amp;id=18" class="btn btn-tools tips" title="Edit">Edit</a>
			</div>';		

				//creat user group values	
				$sql2=$db->select(FDBPrefix.'user_group','*',"level=$qr[level]"); 
				$level=mysql_fetch_array($sql2);				
				if($qr['level']==99) $level = _Public;
				else $level = $level['group_name'];
								
				echo "<tr>";
				echo "<td align='center'>$checkbox</td><td>$name $tools</td><td align='center' class='hidden-xs hidden-sm'><div class='switch-group'>$home$default$status</div></td><td class='hidden-xs'>$qr[category]</td><td class='hidden-xs'>$qr[app]</td><td align='center' class='hidden-xs hidden-sm'>$qr[short]</td><td align='center' class=''>$level</td><td align='center' class=''>$qr[id]</td>";
				echo "</tr>";
				sub_menu($qr['id'],'',$no);
			$no++;	
			}			
			?>
    </tbody>			
	</table>
</form>