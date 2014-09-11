<script type="text/javascript">
$(function() {	
		$(".ctselect").click(function() {
			$("#easy_popup_content").hide();
			$("#easy_popup").hide();
            var id = $(this).attr('rel');	
            var name = $(this).attr('name');	
			$("#link").val("?app=app_contact&id="+id);
			$("#pg").val(name);
		});
	});	
</script>
<script type="text/javascript" charset="utf-8">
	$(document).ready(function() {
		oTable = $('.data').dataTable({
			
			"aaSorting": false,	
			"bJQueryUI": true,
			"sPaginationType": "full_numbers",
			"aaSorting": [[ 1, "asc" ]]	
		});
		
		$('#checkall').click(function(){
		        $(this).parents('form:eq(0)').find(':checkbox').attr('checked', this.checked);
		});
	});

</script>
<form method="post">	
	
	<table class="data">
		<thead>
			<tr>								  
				<th style="width:3% !important;" class="no">#</th>	
				<th style="width:98% !important;">Name</th>
				<th style="width:3% !important;">ID</th>
			</tr>
		</thead>
		
		<tbody>
				<?php
				
				require('../../config.php');
				require('../../system/query.php');
				$db = new FQuery();  
				$db->connect(); 
				$db->select('contact','*','status=1');
				$qr = $db->getResult(); 
				$jml= mysql_affected_rows();
				if($jml>1){					
					$no=1;
					foreach ($qr as $qr)
						{	
							
					$name ="<a class='tooltip ctselect' title='Click to select article \"$qr[name]\"' href='#' rel='$qr[id]' name='$qr[name]'>$qr[name]</a>";
							
					echo "<tr>";
					echo "<td><b>1</b><td>$name</td><td  align='center'>$qr[id]</td>";
					echo "</tr>";
						$no++;	
					}
					
				}
				elseif($jml==1 AND !empty($qr[name]))
				
				{	
					$name ="<a class='tooltip ctselect' title='Click to select article \"$qr[name]\"' href='#' rel='$qr[id]' name='$qr[name]'>$qr[name]</a>";
							
					echo "<tr>";
					echo "<td><b>1</b><td>$name</td><td  align='center'>$qr[id]</td>";
					echo "</tr>";
				}
				?>
				
            </tbody>			
		</table>

</form>