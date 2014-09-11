<?php
/**
* @version		1.4.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2012 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.txt
* @description	
**/

defined('_FINDEX_') or die('Access Denied');

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
				url: "apps/app_comment/controller/status.php",
				data: type+"=1&id="+id,
				success: function(data){
				$("#stat").html(data);
				var loadings = $("#stat");
				loadings.hide();
				loadings.fadeIn();	
				setTimeout(function(){
					$('#stat').fadeOut(1000, function() {
					});				
				}, 3000);
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
				url: "apps/app_comment/controller/status.php",
				data: type+"=0&id="+id,
				success: function(data){
				$("#stat").html(data);
				var loadings = $("#stat");
				loadings.hide();
				loadings.fadeIn();	
				setTimeout(function(){
					$('#stat').fadeOut(1000, function() {
					});				
				}, 3000);
				
				}
			});
		});
	
		oTable = $('table').dataTable({	
			"bJQueryUI": true,
			"sPaginationType": "full_numbers",
			"aaSorting": [[1, "asc" ]]	
		});
		
		$('#checkall').click(function(){
		        $(this).parents('form:eq(0)').find(':checkbox').attr('checked', this.checked);
		});
		
		$("#form").submit(function(e){
		if (!confirm("Are you sure want to delete selected item(s)?"))
			{
				e.preventDefault();
				return;
			} 
		});
	});

</script>
<div id="stat"></div>
<form method="post" id="form">
	<div id="app_header">
		<div class="warp_app_header">		
		  <div class="app_title">Comment Manager</div>
		  <div class="app_link">			
			<input type="submit" class="lbt delete tooltip" title="<?php echo Delete; ?>" value="ok" name="delete"/>	
			<a class="lbt setting tooltip link" href="?app=comment&act=config" title="<?php echo Configuration; ?>"></a>
			<hr class="lbt sparator tooltip">
			<a class="lbt help popup tooltip" href="#helper" title="<?php echo Help; ?>"></a>	
			<div id="helper"><?php echo Comment_help; ?></div>
		  </div> 	
		</div>
	</div>
	<table class="data">
		<thead>
			<tr>								  
				<th width="3%" class="no">#</th>	
				<th width="3%" class="no" colspan="0" id="ck">  
					<input type="checkbox" id="checkall"></th>		
				<th style="width:20% !important;"><?php echo Name; ?></th>
				<th style="width:20% !important;">Email</th>
				<th style="width:11% !important;" class="no" align='center'>Status</th>
				<th style="width:50% !important;" class="no"><?php echo Comment; ?></th>
			</tr>
		</thead>		
		<tbody>
			<?php
			$db = new FQuery();  
			$db->connect(); 				
			$no=1;				
			$sql = $db->select(FDBPrefix.'comment','*','',"id DESC");while($qr=mysql_fetch_array($sql)){

				/* logika status aktif atau tidak */
				if($qr['status']==1)
				{ $stat1 ="selected"; $stat2 ="";}							
				else
				{ $stat2 ="selected";$stat1 ="";}
						
				$status ="
				<p class='switch'>
					<label class='cb-enable $stat1'><span>Show</span></label>
					<label class='cb-disable $stat2'><span>Hide</span></label>
					<input type='text' value='$qr[id]' id='id' class='invisible'><input type='text' value='stat' id='type' class='invisible'>
				</p>";						
							
				$name ="<a class='tooltip ctedit' title='".Click_to_edit."' href='?app=comment&act=edit&id=$qr[id]'>$qr[name]</a>";
				
				$check ="<input type='checkbox' name='check[]' value='$qr[id]' rel='ck'>";
				$link = str_replace("http://".FUrl,"",make_permalink($qr['link']));
				$comm = htmlentities(htmlToText($qr['comment']));
				$comm = substr($comm,0,60);
				
				$comm = "<a href='".make_permalink($qr['link'])."#comment-$qr[clink]' target='_blank' class='tooltip outlink' title='".See_comments."'>$comm . . .</a> ";
				echo "<tr>";
				echo "<td>$no</td><td align='center'>$check</td><td>$name</td><td>$qr[email]</td><td align='center'>$status</td><td>$comm</td>";
				echo "</tr>";
			$no++;	
			}			
			?>
        </tbody>			
	</table>
</form>