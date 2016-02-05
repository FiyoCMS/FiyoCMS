<?php 
/**
* @version		2.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2014 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.txt
**/

session_start();
if(!isset($_SESSION['USER_ID']) or !isset($_SESSION['USER_ID']) or $_SESSION['USER_LEVEL'] > 9 or !isset($_GET['url'])) die();
define('_FINDEX_','BACK');

require_once ('../../../system/jscore.php');
?>
<table class="table table-striped tools">
  <tbody>
	<?php	
		$suser = FDBPrefix."user";
		$session = FDBPrefix."session_login";
		$sql = $db->select("$session, $suser","*,DATE_FORMAT(time,'%Y-%m-%d') as date","$suser.level >= $_SESSION[USER_LEVEL] AND $session.user_id = $suser.id",'time DESC LIMIT 5'); 
		$no = 1;
		foreach($sql as $row) {
			$id = $row['user_id'];
			$edit = Edit;
			$read = Read;
			$kick = Kickout;
			$hide = Set_disable;	
			$delete = Delete;
			$approve = Set_enable;		
			$ledit = "?app=user&act=edit&id=$id";	
			$name = $row['name'];
			$mail =  $row['email'];;
			echo "<tr><td>$name <span>($row[session_id])</span>
			<a data-toggle='tooltip' data-placement='right' title='Online' class=' icon-circle blink icon-mini tooltips'></a><br/>
			<div class='tool-box'>
				<a class='btn-tools btn btn-danger btn-sm btn-grad kick' title='$kick' data-id='$id'>$kick</a>
				<a href='$ledit' class='btn btn-tools tips' title='$edit'>$edit</a>
			</div>
			</td>
			</tr>";
			$no++;	
		}					
		?>			

       </tbody>			
</table>
<script>
$(function() { 
	$('.kick').click(function() {
		var is = $(this);
		var id = $(this).data('id');
		$.ajax({
			url: "apps/app_user/controller/status.php",
			data: "stat=kick&id="+id,
			success: function(data){
				if(id == '<?php echo $_SESSION['USER_ID'];?>')
				location.reload();
			}
		});	
	});
	$('.tooltips').tooltip();
}); </script>