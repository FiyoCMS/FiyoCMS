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
		<div class="app_title">Modules Manager</div>
	</div>		 
</div>
<table class="data">
	<thead>
	<tr>
		<th style="width:60% !important;"><?php echo Module_Name; ?></th>
		<th style="width:25% !important;"><?php echo AddOns_Author; ?></th>
		<th style="width:15% !important;" class="no"></th>
	</tr>
	</thead>
	<?php	
	$db = new FQuery();  
	
	if(isset($_POST['uninstall']) AND !empty($_POST['id'])) {
		$folder = $_POST['id'];
		$a = $b = 'Null <br>';
		if(delete_directory("../modules/$folder")) 
		$a ="folder <i>folder/$folder</i> ".deleted."!<br>";			
		$qr = $db->delete(FDBPrefix.'modules',"folder='$folder'");
		$b = "table <i>$folder</i> ".deleted."!<br>";	
		alert('info',"$a $b",2);
	}	
	$dir=opendir("../modules"); 
	$no=1;
	while($folder=readdir($dir)){ 
		if($folder=="." or $folder=="..")continue; 
		if(!preg_match ( "/[\.]/i" , $folder))
		{
			$file = "../modules/$folder/mod_details.php";
			if(file_exists($file))	include($file);
			
			if($module_author == 'Fiyo CMS')
			$action ="
				<div class='switch s-icon activator'>
					<label class='cb-default disable'><span>
					<i class='icon-minus-sign'></i> Important</span></label>
				</div>";
			else $action ="
				<div class='switch s-icon uninstall activator' id='$folder'>
					<label class='cb-default red'><span>
					<i class='icon-remove-sign'></i> Uninstall</span></label>				
				</div>";
				
			echo "<tr>
				<td><a title=\"$module_desc\" class=\"help\">$module_name</a></td>
				<td>$module_author</td><td align='right'>$action</td>
			</tr>";
			}
			$no++;
		} 
	closedir($dir);
	?> 
</table>
<div class="app_link tabs">	
	<a class="btn apps " href="?app=config&view=apps" title="<?php echo Manage_Apps; ?>"><i class="icon-star"></i> Apps</a>		
	<a class="btn module active" title="<?php echo Manage_Modules; ?>"><i class="icon-inbox"></i> Modules</a>	
	<a class="btn theme" href="?app=config&view=themes" title="<?php echo Manage_Themes; ?>"><i class="icon-desktop"></i> Themes</a>	
	<a class="btn plugin" href="?app=config&view=plugins" title="<?php echo Manage_Plugins; ?>"><i class="icon-bolt"></i> Plugins</a>
</div>	

<div class="modal fade" id="confirmDelete" role="dialog" aria-labelledby="confirmDeleteLabel" aria-hidden="true" style="display:none">
  <div class="modal-dialog modal-sm">
    <div class="modal-content modal-question">
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