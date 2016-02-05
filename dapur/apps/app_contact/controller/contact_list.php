<?php
/**
* @version		2.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2014 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.
**/

session_start();

if(isset($_SESSION['USER_LEVEL']) AND $_SESSION['USER_LEVEL'] < 3 AND isset($_GET['access'])) :
define('_FINDEX_','BACK');
require('../../../system/jscore.php');
addJs('../plugins/plg_jquery_ui/datatables.js');
?>

<script type="text/javascript">
$(document).ready(function() {
	$(".ctselect").click(function() {
		$("#selectArticle").modal('hide');
        var id = $(this).attr('rel');	
        var name = $(this).attr('name');	
		$("#link").val("?app=contact&view=person&id="+id);
		$("#pg").val(name);
	});
	oTable = $('.data').dataTable({
			"bJQueryUI": true,
			"sPaginationType": "full_numbers", "bLengthChange": false
		});
		if ($.isFunction($.fn.chosen) ) {
			$("select").chosen({disable_search_threshold: 10});
		}
		$("input").addClass('form-control');
});
</script>
<form method="post">	
        <table id="dataTable" class="data table-bordered">
		<thead>
			<tr>								  
				<th style="width:3% !important;" class="no">#</th>	
				<th style="width:10% !important;">Name</th>
				<th style="width:15% !important;" class="no">Group</th>
				<th style="width:15% !important;" class="no">Email</th>
				<th style="width:15% !important;" class="no">Telp.</th>
				<th style="width:30% !important;" class="no">Address</th>
			</tr>
		</thead>
		
		<tbody>
		<?php
			$db = new FQuery();  
			$ctc = FDBPrefix.'contact';
			$ctg = FDBPrefix.'contact_group';
			$sql = $db->select("$ctc, $ctg","*","status=1 AND $ctc.group_id = $ctg.group_id","$ctc.id ASC");
			$no=1;
			foreach($sql as $row){			
					
				$name ="<a class='tips ctselect' title='Click to select article \"$row[name]\"'  rel='$row[id]' name='$row[name]'>$row[name]</a>";
				
				echo "<tr><td align='center'>$no</td><td>$name</td><td  align='center'>$row[group_name]</td><td>$row[email]</td><td align='center'>$row[phone]</td><td>$row[city], $row[state],$row[country]</td></tr>";
				$no++;	
				}
			?>				
            </tbody>			
		</table>

</form>
<?php endif; ?>