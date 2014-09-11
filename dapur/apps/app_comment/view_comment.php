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
$(function() {		
	$("#form").submit(function(e){
		e.preventDefault();
		var ff = this;
		var checked = $('input[name="check_comment[]"]:checked').length > 0;
		if(checked) {	
			$('#confirmDelete').modal('show');	
			$('#confirm').on('click', function(){
				ff.submit();
			});		
		} else {
			noticeabs("<?php echo alert('error',Please_Select_Delete); ?>");
			$('input[name="check_comment[]"]').next().addClass('input-error');
			return false;
		}
	});
	
	if ($.isFunction($.fn.dataTable)) {		
		$('table.data').show();
		oTable = $('table.data').dataTable({
			"bProcessing": true,
			"bServerSide": true,
			"sAjaxSource": "apps/app_comment/controller/list_comment.php",
			"bJQueryUI": true,
			"sPaginationType": "full_numbers",
			"fnDrawCallback": function( oSettings ) {	
				$("tr").click(function(e){
					var i =$("td:first-child",this).find("input[type='checkbox']");					
					var c = i.is(':checked');
					selectCheck();
					if($(e.target).is('.switch *, a[href]')) {					   
					} else {
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
				$('[data-toggle=tooltip]').tooltip();
				$('[data-tooltip=tooltip]').tooltip();
				$('.tips').tooltip();
				
				$(".activator label").click(function(){ 
					var parent = $(this).parents('.switch');
					var id = $('.number',parent).attr('value');	
					var value = $('.type',parent).attr('value');
					if(value == 1) value = 0; else value = 1;
					$.ajax({
						url: "apps/app_comment/controller/comment_status.php",
						data: "stat="+value+"&id="+id,
						success: function(data){
							$('.type',parent).attr('value',0);					
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
});
</script>
<div id="stat"></div>
<form method="post" id="form">
	<div id="app_header">
		<div class="warp_app_header">		
		  <div class="app_title"><?php echo Article_Comments; ?></div>
		  <div class="app_link">			
			<!--button type="submit" class="btn btn-success" title="<?php echo Save; ?>" value="<?php echo Approve; ?>" name="approve_comment"><i class="icon-ok"></i> <?php echo Approve; ?></button-->	
			<button type="submit" class="delete btn btn-danger btn-sm btn-grad" title="<?php echo Delete; ?>" value="<?php echo Delete; ?>" name="delete_category"><i class="icon-trash"></i> &nbsp;<?php echo Delete; ?></button>
			<a class="lbt setting tooltip link" href="?app=comment&act=config" title="<?php echo Configuration; ?>"></a>
		  </div> 	
		  <?php printAlert('NOTICE_REF'); ?>
		</div>
	</div>
	<table class="data">
		<thead>
			<tr>								  	
				<th style="width:1% !important;" class="no" colspan="0" id="ck">  
					<input type="checkbox" id="checkall" target="check_comment[]"></th>		
				<th style="width:18% !important;"><?php echo Author; ?></th>
				<th style="width:5% !important;" class="no"><?php echo Status; ?></th>
				<th style="width:30% !important;"><?php echo Comment; ?></th>
				<th style="width:30% !important;" ><?php echo Article_Title; ?></th>
				<th style="width:15% !important;text-align:center" ><?php echo Date; ?></th>
			</tr>
		</thead>		
		<tbody>
			<tr><td colspan="6" align="center">Loading...</td></tr>	
        </tbody>			
	</table>
</form>

<div class="modal fade" id="confirmDelete" role="dialog" aria-labelledby="confirmDeleteLabel" aria-hidden="true" style="display:none">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header"><h4 class="modal-title"><?php echo Delete_Confirmation; ?></h4>
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
      </div>
      <div class="modal-body">
        <p class="question"><?php echo Sure_want_delete; ?></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo Cancel; ?></button>
        <button type="button" class="btn btn-danger btn-grad" id="confirm" name="delete_comment"><?php echo Delete; ?></button>	
      </div>
    </div>
  </div>
</div>