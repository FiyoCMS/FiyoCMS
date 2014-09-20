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
	$(".select").click(function() {
		$("#selectArticle").modal('hide');
        var id = $(this).attr('rel');	
        var name = $(this).attr('name');	
		$("#link").val("?app=article&view=item&id="+id);
		$("#pg").val(name);
	});
	oTable = $('.data').dataTable({
			"bJQueryUI": true,
			"sPaginationType": "full_numbers",
			"bLengthChange": false,			
			"fnDrawCallback": function( oSettings ) {
		$('.tips').tooltip();
			
			}
		});
		if ($.isFunction($.fn.chosen) ) {
			$("select").chosen({disable_search_threshold: 10});
		}
		$("input").addClass('form-control');
});
</script>
<form method="post">	
        <table id="dataTable" class="data">
		<thead>
			<tr>								  
				<th style="width:40% !important;">Article's Title</th>
				<th style="width:15% !important; text-align: center;">Category</th>
				<th style="width:15% !important; text-align: center;">Author</th>
				<th style="width:15% !important; text-align: center;">Date</th>
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
					
				$name ="<a class='tips select' title='".Choose."' data-placement='right' rel='$qr[id]' name='$qr[title]'>$qr[title]</a>";
				$date = substr($qr['date'],0,10);
				echo "<tr><td>$name</td><td  align='center'>$category</td><td align='center'>$author</td><td align='center'>$qr[date]</td></tr>";
				$no++;	
				}
			?>				
            </tbody>			
		</table>

</form>
<?php endif; ?>