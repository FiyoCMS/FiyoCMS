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

printAlert('NOTICE');

$_GET['cat'] = $_GET['level'] = $_GET['user'] = '';
?>
<script type="text/javascript">	
$(function() {		
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
	
function iniTable () {
	if ($.isFunction($.fn.dataTable)) {	
		$('table.data').show();	
		var cat = $('.category').val();
		var user = $('.user').val();
		var level = $('.level').val();
		
		oTable = $('table.data').dataTable({
			"bProcessing": true,
			"bServerSide": true,
			"sAjaxSource": "apps/app_article/controller/article_list.php?cat="+cat+"&user="+user+"&level="+level,
			"bJQueryUI": true,  
			"sPaginationType": "full_numbers",
			"fnDrawCallback": function( oSettings ) {
				selectCheck();
				$('[data-toggle=tooltip]').tooltip();
				$('[data-tooltip=tooltip]').tooltip();
				$('.tips').tooltip();			
				$("tr").click(function(e){
					var i =$("td:first-child",this).find("input[type='checkbox']");					
					var c = i.is(':checked');
					if($(e.target).is('.switch *, a[href]')) {					   
					} else if(i.length){
						if(c) {
							i.prop('checked', 0);		
							$(this).removeClass('active');			
						}
						else {
							i.prop('checked', 1);
							$(this).addClass('active');
						}
					}
				});			
				$(".editor.activator label").click(function(){
					var parent = $(this).parents('.switch');
					var id = $('.number',parent).attr('value');	
					var value = $('.type',parent).attr('value');
					if(value == 1) value = 0; else value = 1;
					$.ajax({
						url: "apps/app_article/controller/article_status.php",
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
				
				$(".editor.featured label").click(function(){
					var parent = $(this).parents('.switch');
					var id = $('.number',parent).attr('value');	
					var value = $('.type',parent).attr('value');
					if(value == 1) value = 0; else value = 1;
					$.ajax({
						url: "apps/app_article/controller/article_status.php",
						data: "fp="+value+"&id="+id,
						success: function(data){
						if(value == 1)
							$('.type',parent).val("1");
						else 
							$('.type',parent).val("0");					
							notice(data);		
						}
					});
				});
							
				$(".editor .cb-enable").click(function(){		
					var parent = $(this).parents('.switch');
					$('.cb-disable',parent).removeClass('selected');
					$(this).addClass('selected');
					$('.checkbox',parent).attr('checked', false);	
				});
				$(".editor .cb-disable").click(function(){		
					var parent = $(this).parents('.switch');
					$('.cb-enable',parent).removeClass('selected');
					$(this).addClass('selected');
					$('.checkbox',parent).attr('checked', false);	
				});
		
				
				$('input[type="checkbox"],input[type="radio"]').wrap("<label>");
				$('input[type="checkbox"],input[type="radio"]').after("<span class='input-check'>");
				$('table.data tbody a[href]').on('click', function(e){
				   if ($(this).attr('target') !== '_blank'){
					e.preventDefault();	
					loadUrl(this);
				   }				
				});
			}
			
		});
		
		
		$('table.data th input[type="checkbox"]').parents('th').unbind('click.DT');
		if ($.isFunction($.fn.chosen) ) {
			$("select").chosen({disable_search_threshold: 10});
		}
	}
}
	$('.filter').change(function () {
		oTable.fnDestroy();
		iniTable();		
	});
	
	iniTable();
});
</script>
<form method="post" id="form">
	<div id="app_header">
		<div class="warp_app_header">				
			<div class="app_title"><?php echo Article_Manager; ?></div>
			<div class="app_link">			
				<a class="add btn btn-primary" Value="Create" href="?app=article&act=add" title="<?php echo Add_new_article; ?>"><i class="icon-plus"></i> <?php echo New_Article; ?></a>
				<button type="submit" class="delete btn btn-danger btn-sm btn-grad" title="<?php echo Delete; ?>" value="<?php echo Delete; ?>" name="delete"><i class="icon-trash"></i> &nbsp;<?php echo Delete; ?></button>
				<input type="hidden" value="true" name="delete_confirm"  style="display:none" />
						
				<span class="filter-table">
				<?php echo Category; ?>:
				<select name="cat" class="category filter" chosen-select" data-placeholder="<?php echo Choose_category; ?>" style="min-width:120px;">
				<option value="">All</option>
					<?php	
						$_GET['id']=0;
						$db = new FQuery(); 
						$db->connect(); 
						$sql = $db->select(FDBPrefix.'article_category','*','parent_id=0'); 
						while($qrs=mysql_fetch_array($sql)){
							if($qrs['level'] >= $_SESSION['USER_LEVEL']){
								if($_GET['cat']==$qrs['id']) $s="selected";else$s="";
								echo "<option value='$qrs[id]' $s>$qrs[name]</option>";
								option_sub_cat($qrs['id'],'');
							}
						}						
					?>
				</select>
				<?php echo Author; ?>:
				<select name="user"  class="user filter"  placeholder="">
				<option value="">All</option>
					<?php
						$db = new FQuery(); 
						$db->connect(); 
						$sql = $db->select(FDBPrefix.'user');
						while($qrs=mysql_fetch_array($sql)){
							if($qrs['level']==$_GET['user']){
								echo "<option value='$qrs[id]' selected>$qrs[name]</option>";}
							else {
								echo "<option value='$qrs[id]'>$qrs[name]</option>";
							}
						}
					?>
					</select>
				<?php echo Access_Level; ?>:
				<select name="level" class="level filter" placeholder="">
				<option value="">All</option>
					<?php
						$db = new FQuery(); 
						$db->connect(); 
						$sql = $db->select(FDBPrefix.'user_group');
						while($qrs=mysql_fetch_array($sql)){
							if($qrs['level']==$qr['level']){
								echo "<option value='$qrs[level]' selected>$qrs[group_name]</option>";}
							else {
								echo "<option value='$qrs[level]'>$qrs[group_name]</option>";
							}
						}
						if($qr['level']==99 AND !$_GET['level'] == '99') $s="selected"; else $s="";
						echo "<option value='99' $s>"._Public."</option>"
					?>
					</select>
				</span>
		  </div> 	
		</div>
	</div>
	
	<!-- div class="category-table-option">
	<?php echo Category; ?>:
	<select class="data-table-option">
		<option value="2" id="">All Aasdasdas asd asd</option>
	</select>
	<?php echo Author; ?>:
	<select class="data-table-option">
		<option value="2" id="">All</option>
	</select>
	<?php echo Access_Level; ?>:
	<select class="data-table-option">
		<option value="2" id="">All</option>
	</select>
	</div-->
	
	<table class="data">
		<thead>
			<tr>							
				<th style="width:1% !important;" class="no" colspan="0">  
					<input type="checkbox" id="checkall" target="check[]"></th>		
				<th style="width:30% !important;"><?php echo Article_Title; ?></th>
				<th style="width:8% !important;text-align:center" class="no" >Status</th>
				<th style="width:15% !important;text-align:center" class='hidden-xs'><?php echo Category; ?></th>
				<th style="width:12% !important;text-align:center" class='hidden-xs'><?php echo Author; ?></th>
				<th style="width:12% !important;text-align:center" class='hidden-xs'><?php echo Access_Level; ?></th>
				<th style="width:15% !important;text-align:center" class='hidden-xs'><?php echo Date; ?></th>
			</tr>
		</thead>		
		<tbody>
			<tr><td colspan="8" align="center">Loading...</td></tr>	
        </tbody>			
	</table>
</form>
