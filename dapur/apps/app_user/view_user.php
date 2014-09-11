<?php
/**
* @version		2.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2014 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.
**/

defined('_FINDEX_') or die('Access Denied');

$new_member = siteConfig('new_member');
if($new_member){$enpar1="selected checked"; $dispar1 = "";}
else {$dispar1="selected checked"; $enpar1= "";}

?>	
<script type="text/javascript" charset="utf-8">
$(document).ready(function() {
	$(".activa label").click(function(){ 
		var parent = $(this).parents('.switch');
		var id = $('.number',parent).attr('value');	
		var value = $('.type',parent).attr('value');
		if(value == 1) value = 0; else value = 1;
		$.ajax({
			url: "apps/app_user/controller/status.php",
			data: "stat="+value+"&id="+id,
			success: function(data){
				$('#type',parent).attr('value',0);					
				notice(data);		
			}
		});
	});
	
	$(".cb-enable").click(function(){		
		var parent = $(this).parents('.switch');
		$('.cb-disable',parent).removeClass('selected');
		$(this).addClass('selected');
		$('.checkbox',parent).attr('checked', false);	
	});
	
	$(".cb-disable").click(function(){		
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
			noticeabs("<?php echo alert('error',Please_Select_Delete); ?>");
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
			<div class="app_title"><?php echo User_Manager; ?></div>
			<div class="app_link">			
				<a class="add btn btn-primary" href="?app=user&act=add" title="<?php echo New_User; ?>"><i class="icon-plus"></i> <?php echo New_User; ?></a>
				<button type="submit" class="delete btn btn-danger" title="<?php echo Delete; ?>" value="<?php echo Delete; ?>" name="delete"><i class="icon-trash"></i> &nbsp;<?php echo Delete; ?></button>
				<input type="hidden" value="true" name="delete_confirm"  style="display:none" />
				<?php printAlert(); ?>
			</div>
		</div>		 
	</div>
	<table class="data">
		<thead>
			<tr>								  
				<th width="1%" class="no" colspan="0" id="ck">  
					<input type="checkbox" id="checkall" target="check[]"></th>				
				<th style="width:20% !important;"><?php echo Name; ?></th>
				<th style="width:20% !important;">Username</th>
				<th style="width:5% !important; text-align: center;" class="no">Status</th>
				<th style="width:25% !important; text-align: center;">Group</th>
				<th style="width:25% !important;">Email</th>
				<th style="width:5% !important;text-align: center;">ID</th>
			</tr>
		</thead>
		<tbody>
		<?php		
		$db = new FQuery();  
		$db->connect(); 	
		$UserLevel =  userInfo('level');
		$sql=$db->select(FDBPrefix.'user','*',"level >= $UserLevel","status ASC, ID DESC");
		$no=1;
		while($qr=mysql_fetch_array($sql)){
			$checkbox = null;
			$group = oneQuery("user_group","level",$qr['level'],'group_name');
			if($qr['status']==1)
				{ $stat1 ="selected"; $stat2 ="";}							
			else
				{ $stat2 ="selected";$stat1 ="";}	
					
			$UserId =  userInfo('id');
				
			if($qr['status']==1)
			{ $stat1 ="selected"; $stat2 =""; $enable = ' enable';}							
			else
			{ $stat2 ="selected";$stat1 =""; $enable = 'disable';}
				
			if($qr['level'] != 1 AND $_SESSION['USER_LEVEL'] < $qr['level'] or $_SESSION['USER_LEVEL'] == 1 AND $qr['id'] != $_SESSION['USER_ID'] ){
				
				$status ="<span class='invisible'>$enable</span>
				<div class='switch s-icon activator activa'>
					<label class='cb-enable $stat1 tips' data-placement='right' title='".Disable."'><span>
					<i class='icon-remove-sign'></i></span></label>
					<label class='cb-disable $stat2 tips' data-placement='right' title='".Enable."'><span>
					<i class='icon-ok-sign'></i></span></label>
					<input type='hidden' value='$qr[id]' class='number invisible'>
					<input type='hidden' value='$qr[status]'  class='type invisible'>
				</div>";	
				//checkbox
				$checkbox = "<input type='checkbox' name='check[]' value='$qr[id]' rel='ck'>";
			}
			else  {
				$status ="<span class='invisible'>$enable</span>
					<label class='$stat2 tips icon-active' data-placement='right' title='".Enable."'><span>
					<i class='icon-ok-sign'></i></span></label>
				";
				$checkbox = "<span class='icon lock'></lock>";
			}
			
			if($qr['level'] >= $_SESSION['USER_LEVEL'] or $_SESSION['USER_LEVEL'] == 1) {
				$name ="<a class='tips' data-placement='right' title='".Edit."' href='?app=user&act=edit&id=$qr[id]'>$qr[name]</a>";
				$user ="<a class='tips' data-placement='right' title='".Edit."' href='?app=user&act=edit&id=$qr[id]'>$qr[user]</a>";
			}
			else  {
				$name ="$qr[name]";
				$user ="$qr[user]";
			}
			
			echo "<tr>";
			echo "<td align='center'>$checkbox</td><td>$name</td><td>$user</td><td align=center>$status</td><td align='center'>$group</td><td>$qr[email]</td><td align='center'>$qr[id]</td>";
			echo "</tr>";
			$no++;	
		}
		?>
        </tbody>			
	</table>
</form>