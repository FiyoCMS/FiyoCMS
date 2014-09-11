<?php
/**
* @version		2.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2014 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.
**/

session_start();

if(isset($_SESSION['USER_LEVEL']) AND $_SESSION['USER_LEVEL'] < 3 AND isset($_GET['access'])) :
define('_FINDEX_',1);
require('../../../system/jscore.php');
addJs('../plugins/plg_jquery_ui/datatables.js');
?>
<script type="text/javascript">
$(document).ready(function() {
	$(".ctselect").click(function() {
		$("#selectArticle").modal('hide');
        var id = $(this).attr('rel');	
        var name = $(this).attr('name');	
		$("#link").val("?app=article&view=item&id="+id);
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
				<th style="width:40% !important;">Article's Title</th>
				<th style="width:15% !important;" class="no">Category</th>
				<th style="width:15% !important;" class="no">Author</th>
				<th style="width:10% !important;" class="no">Date</th>
				<th style="width:4% !important;">ID</th>
			</tr>
		</thead>
		
		<tbody>
		<?php
			$db = new FQuery();  
			$db->connect(); 
			$sql=$db->select(FDBPrefix.'article','*','status=1',"title ASC");
			$qr = $db->getResult();
			$no=1;
			while($qr=mysql_fetch_array($sql)){	
				$sql2 = $db->select(FDBPrefix.'article_category',"name","id=$qr[category]"); 
				$category = mysql_fetch_array($sql2);
				$category = $category['name'];
					
				$sql3 = $db->select(FDBPrefix."user","name","id=$qr[author_id]"); 
				$aut = mysql_fetch_array($sql3);
				$author = $aut['name'];
				if(!empty($qr['author'])) $author=$qr['author'];
					
				$name ="<a class='tips ctselect' title='Click to select article \"$qr[title]\"'  rel='$qr[id]' name='$qr[title]'>$qr[title]</a>";
				$date = substr($qr['date'],0,10);
				echo "<tr><td>$no</td><td>$name</td><td  align='center'>$category</td><td>$author</td><td>$date</td><td align='center'>$qr[id]</td></tr>";
				$no++;	
				}
			?>				
            </tbody>			
		</table>

</form>
<?php endif; ?>