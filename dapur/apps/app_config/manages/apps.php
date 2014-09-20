<?php
/**
* @version		2.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2014 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.
**/

defined('_FINDEX_') or die('Access Denied');
printAlert();
?>
<script type="text/javascript" charset="utf-8">
$(document).ready(function() {
	loadTable();	
	$(".uninstall").click(function(e){
		e.preventDefault();
		var ff = this;	
			$('#confirmDelete').modal('show');
			$('.number').val($(this).attr('id'));
			$('#confirm').on('click', function(){
				ff.submit();
			});		
		
	});
});
</script>
<div id="app_header">
	<div class="warp_app_header">		
		<div class="app_title">Apps Manager</div>
	</div>		 
</div>
<table class="data">
	<thead>
	<tr>
		<th style="width:60% !important;"><?php echo Apps_Name; ?></th>
		<th style="width:25% !important;"><?php echo AddOns_Author; ?></th>
		<th style="width:15% !important;" class="no"></th>
	</tr>
	</thead>
	<?php	
	$db = new FQuery();  
	$db->connect();
	if(isset($_POST['uninstall']) AND !empty($_POST['id'])) {
		$apps = $_POST['id'];
		$notice = $b = $c = '';
		if(!empty($apps)) {
			$bf = siteConfig('backend_folder');
			if(delete_directory("apps/$apps")) $notice .= "folder <i>$bf/apps/$apps</i> ".deleted."!<br>";		
			if(delete_directory("../apps/$apps")) $notice .= "folder <i>apps/$apps</i> ".deleted."!<br>";	
		}		
		$fl = str_replace("app_","",$apps);
		$db->delete(FDBPrefix.'menu',"category = 'adminpanel' AND link LIKE '%?app=$fl'");
		$qr = $db->delete(FDBPrefix.'apps',"folder='$apps'");
		if($qr) $notice .= "table <i>$apps</i> ".deleted."!<br>";	
		refresh();
		notice('info',"$notice",2);	
	}	
	$sql =	$db->select(FDBPrefix.'apps','*','',"name ASC"); 
	while($qr=mysql_fetch_array($sql)){		
		$file = "../apps/$qr[folder]/app_details.php";
		if(file_exists($file))
			include($file);
		echo "<tr>";
					
		if(!isset($app_desc)) {
			$app_desc = "Error Apps!";
			$qr['name'] ="Error Apps!";
		}
		
		if($qr['author'] == 'Fiyo CMS' AND (($qr['type'] == '0') or ($qr['type'] == '2')))
		$action ="
			<div class='switch s-icon activator'>
				<label class='cb-default disable'><span>
				<i class='icon-minus-sign'></i> Important</span></label>
			</div>";
		else $action ="
			<div class='switch s-icon uninstall activator' id='$qr[folder]'>
				<label class='cb-default red'><span>
				<i class='icon-remove-sign'></i> Uninstall</span></label>				
			</div>";
			
		echo "<td><a class='help' title='$app_desc'>$qr[name]</a></td><td>$qr[author]</td><td align='right'>$action</td>";
		echo "</tr>";
	}
	?> 
</table>
<div class="app_link tabs">	
	<a class="btn apps active" title="<?php echo Manage_Apps; ?>"><i class="icon-star"></i> Apps</a>		
	<a class="btn module" href="?app=config&view=modules" title="<?php echo Manage_Modules; ?>"><i class="icon-inbox"></i> Modules</a>	
	<a class="btn theme" href="?app=config&view=themes" title="<?php echo Manage_Themes; ?>"><i class="icon-desktop"></i> Themes</a>	
	<a class="btn plugin" href="?app=config&view=plugins" title="<?php echo Manage_Plugins; ?>"><i class="icon-bolt"></i> Plugins</a>
</div>	

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
		<form method="post" id="form" enctype="multipart/form-data" typeion="" target="">
			<input type='hidden' value='' class='number' name="id">
			<button type="button" class="btn btn-default" data-dismiss="modal"><?php echo Cancel; ?></button>
			<button type="submit" class="btn btn-danger btn-grad" name="uninstall"><?php echo Delete; ?></button>	
		</form>
      </div>
    </div>
  </div>
</div>
