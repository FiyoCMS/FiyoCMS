<?php
/**
* @version		2.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2012 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.txt
* @description	
**/

defined('_FINDEX_') or die('Access Denied');		
	if(isset($_POST['upload'])) {		
		$path_file = $_FILES['zip']['tmp_name'];
		$type_file = $_FILES['zip']['type'];
		$name_file = $_FILES['zip']['name'];
		$_SESSION['file'] = $path_file;
		
		if(!empty($path_file)) {	
			if(extractZip($path_file,'tmp')) {
				$dir=opendir("tmp"); 
				while($folder=readdir($dir)){ 
					if($folder=="." or $folder=="..")continue; 
					if(!preg_match ( "/[\.]/i" , $folder))
					{
						$atm = "tmp/$folder/atheme_installer.php";
						$plg = "tmp/$folder/plugin_installer.php";
						$thm = "tmp/$folder/theme_installer.php";
						$mod = "tmp/$folder/mod_installer.php";
						$app = "tmp/$folder/app_installer.php";
						$apf = "tmp/$folder/front_apps";
						$folback = siteConfig('backend_folder');
						
						//Modules Installer
						if(file_exists($mod)) {
							extractZip($path_file,'../modules');
							include($mod);
							alert('info',AddOns_installed);
							if(isset($module_info))
							echo "<div class='install_info'>$module_info</div>";
							
						}
						//Plugins Installer
						else if(file_exists($plg)){					
							extractZip($path_file,'../plugins');
							include($plg);
							alert('info',AddOns_installed);
							if(isset($plugin_info))
							echo "<div class='install_info'>$plugin_info</div>";
							
						}
						//Apps Installer
						else if(file_exists($app)){	
							extractZip($path_file,"../$folback/apps");
							include($app);
							$insser_apps_data = insert_new_apps($apps_name,$apps_folder,$apps_author,$apps_type);
							if($apps_type==1) {
								copy_directory($apf,"../apps/$folder");
								delete_directory("../$folback/apps/$folder/$folder");
							}
							alert('info',AddOns_installed);
							if(isset($apps_info))
							echo "<div class='install_info'>$apps_info</div>";
						}
						//Themes Installer
						else if(file_exists($thm)){					
							extractZip($path_file,'../themes');
							include($thm);
							alert('info',AddOns_installed);
							echo "<div class='install_info'>$theme_info</div>";
						}
						//adminThemes Installer
						else if(file_exists($atm)){					
							extractZip($path_file,"../$folback/themes");
							include($atm);
							alert('info',AddOns_installed);
							if(isset($theme_info))
							echo "<div class='install_info'>$theme_info</div>";
						}
						else
							alert('error',File_uploaded_not_valid);
						$opendir = $folder;				
					}
				}
				$opendir = "tmp/$opendir";
				$dir= @opendir($opendir); 
				while($folder= @readdir($dir)){
					@unlink ("$opendir/$folder");					
				}
				@closedir($dir);
			}
			else{
					alert('error',File_not_support);
			}
		}
		else {
			alert('error',Please_choose_file);
		}
	
	}
	delete_directory('tmp');
	
	if(isset($_POST['backup_all'])) {
		$c = backup_tables('*');
			if($c) alert('success',Success_backup_database,true);
	
	} else if(isset($_POST['backup_choose'])) {
		if(!empty($_POST['table'])) {
			$c = backup_tables($_POST['table']);
			if($c) alert('success',Success_backup_database,true);
		}
		else 
			alert('error',Please_choose_table,true);
	}

    $SIZE_LIMIT = siteConfig('disk_space')*1024*1024; // 5 GB
    $disk_used = folder_size("../");
	$disk_remaining = $SIZE_LIMIT - $disk_used;
	
	

?>
<script type="text/javascript">
$(document).ready(function() {
	$(".restore").click(function(e){
		var filename = $(".filesql").val();
		var extension = filename.replace(/^.*\./, '');
        if (extension == filename) {
            extension = '';
        } else {
            extension = extension.toLowerCase();
        }
		if(extension == 'sql') {	
				$('.sql_error').hide();
		} else {		
                e.preventDefault();
				$('.sql_error').removeClass('invisible');
				$('.sql_error').show();
		}
	});
	
	$(".backup_db").click(function(e){
		e.preventDefault();		
		$('#modal_backup').modal({
		  backdrop: 'static',
		  keyboard: false,
		  show : true
		});
		$(".update-info-backup").html("<div class=\"progress progress-striped active\"><div class=\"progress-bar\" role=\"progressbar\" aria-valuenow=\"60\" aria-valuemin=\"0\" aria-valuemax=\"100\" style=\"width: 100%;\" data-original-title=\"\" title=\"\"><span class='loading-text'>Loading</span><span class=\"sr-only\">100% Complete</span></div> </div>");
		$(".loading-text").LoadingDot({
			"speed": 500,
			"maxDots": 4,
			"word": "Loading."
		});
		$(".modal-footer-backup").hide();
		$(".modal-title-backup").html("Backup Database");
		var b = $(this);
		var fl = $(this).attr('file');
		b.html('Loading...');
		
		$.ajax({
			url: "apps/app_config/controller/backuper.php",
			data: "type=database&file="+fl,
			timeout: 10000, 
			error:function(){ 
				$(".update-info-backup").html("Error, connection time out.") ;
				$(".modal-footer-backup").show();
				$(".update-confirm").hide();
				b.html('<?php echo Backup; ?>');
			},
			success: function(data){
				var json = $.parseJSON(data);
				noticeabs("<?php alert('success',Backup_Database_Created,true); ?>");
				$(".data-file-db a").html(json.file);
				$(".data-file-db a").attr('href','../.backup/'+json.file);
				$(".data-file-db i").html("("+json.info+")");
				b.attr('file',json.file);
				b.html('<?php echo Backup; ?>');
				$('#modal_backup').modal('hide');
				$('#delete-database').show();
				$('#delete-database').attr('file','../.backup/'+json.file);
			}
		});	
	}); 
	
	$(".backup_table").click(function(e){
		e.preventDefault();		
		var c = $(".tb-data").val();
		if(c) {
			$('#modal_backup').modal({
			  backdrop: 'static',
			  keyboard: false,
			  show : true
			});
			$(".update-info-backup").html("<div class=\"progress progress-striped active\"><div class=\"progress-bar\" role=\"progressbar\" aria-valuenow=\"60\" aria-valuemin=\"0\" aria-valuemax=\"100\" style=\"width: 100%;\" data-original-title=\"\" title=\"\"><span class='loading-text'>Loading</span><span class=\"sr-only\">100% Complete</span></div> </div>");
			$(".loading-text").LoadingDot({
				"speed": 500,
				"maxDots": 4,
				"word": "Loading."
			});
			$(".modal-footer-backup").hide();
			$(".modal-title-backup").html("Backup Table(s)");
			var b = $(this);
			var fl = $(this).attr('file');
			b.html('Loading...');
			$.ajax({
				url: "apps/app_config/controller/backuper.php",
				data: "type=table&file="+fl+"&table="+c,
				timeout: 10000, 
				error:function(){ 
					$(".update-info-backup").html("Error, connection time out.") ;
					$(".modal-footer-backup").show();
					$(".update-confirm").hide();
					b.html('<?php echo Backup; ?>');
				},
				success: function(data){
					var json = $.parseJSON(data);
					noticeabs("<?php alert('success',Backup_Table_Created,true); ?>");
					$(".data-file-table a").html(json.file);
					$(".data-file-table a").attr('href','../.backup/.table/'+json.file);
					$(".data-file-table i").html("("+json.info+")");
					b.attr('file',json.file);
					b.html('<?php echo Create; ?>');
					$('#modal_backup').modal('hide');
					$('#delete-tables').show();
					$('#delete-tables').attr('file','../.backup/'+json.file);
				}
			});	
		}
	}); 
	
	$(".backup_install").click(function(e){
		e.preventDefault(); 
		$('#modal_backup').modal({
		  backdrop: 'static',
		  keyboard: false,
		  show : true
		});
		$(".update-info-backup").html("<div class=\"progress progress-striped active\"><div class=\"progress-bar\" role=\"progressbar\" aria-valuenow=\"60\" aria-valuemin=\"0\" aria-valuemax=\"100\" style=\"width: 100%;\" data-original-title=\"\" title=\"\"><span class='loading-text'>Loading</span><span class=\"sr-only\">100% Complete</span></div> </div>");
		$(".loading-text").LoadingDot({
			"speed": 500,
			"maxDots": 4,
			"word": "Loading."
		});
		$(".modal-footer-backup").hide();
		$(".modal-title-backup").html("Backup Installer");		
		var b = $(this);
		var fl = $(this).attr('file');
		b.html('Loading...');
		$.ajax({
			url: "apps/app_config/controller/backuper.php",
			data: "type=installer&file="+fl,
			timeout: 10000, 
			error:function(){ 
				$(".update-info-backup").html("Error, connection time out.") ;
				$(".modal-footer-backup").show();
				$(".update-confirm").hide();
				b.html('<?php echo Backup; ?>');
			},
			success: function(data){
                var json = $.parseJSON(data);
				noticeabs("<?php alert('success',Backup_Installer_Created,true); ?>");
				$(".data-file-installer a").html(json.file);
				$(".data-file-installer a").attr('href','../.backup/'+json.file);
				$(".data-file-installer i").html("("+json.info+")");
				b.attr('file',json.file);
				b.html('<?php echo Backup; ?>');
				$('#modal_backup').modal('hide');
				$('#delete-installer').show();
				$('#delete-installer').attr('file','../.backup/'+json.file);
			}
		});			
	}); 
	
	$("#delete-installer").click(function(e){
		e.preventDefault(); 
		var fl = $(this).attr('file');
		$.ajax({
			url: "apps/app_config/controller/backuper.php",
			data: "type=delete&act=installer&file="+fl,
			timeout: 10000, 
			error:function(){ 
				$(".modal-footer-backup").show();
				$('#modal_backup').modal('show');
				$(".update-info-backup").html("Error, connection time out.");
				alert();		
			},
			success: function(data){
				$(".data-file-installer a").attr('href','');
				$(".data-file-installer a").html("");
				$(".data-file-installer i").html("No backup file!");				
				$('#delete-installer').hide();
			}
		});			
	}); 
	
	
	$("#delete-tables").click(function(e){
		e.preventDefault(); 
		var fl = $(this).attr('file');
		$.ajax({
			url: "apps/app_config/controller/backuper.php",
			data: "type=delete&act=tables&file="+fl,
			timeout: 10000, 
			error:function(){ 
				$(".modal-footer-backup").show();
				$('#modal_backup').modal('show');
				$(".update-info-backup").html("Error, connection time out.");
				alert();		
			},
			success: function(data){
				$(".data-file-table a").attr('href','');
				$(".data-file-table a").html("");
				$(".data-file-table i").html("No backup file!");				
				$('#delete-tables').hide();
			}
		});			
	}); 
	
	
	$("#delete-database").click(function(e){
		e.preventDefault(); 
		var fl = $(this).attr('file');
		$.ajax({
			url: "apps/app_config/controller/backuper.php",
			data: "type=delete&act=db&file="+fl,
			timeout: 10000, 
			error:function(){ 
				$(".modal-footer-backup").show();
				$('#modal_backup').modal('show');
				$(".update-info-backup").html("Error, connection time out.");
				alert();		
			},
			success: function(data){
				$(".data-file-db a").attr('href','');
				$(".data-file-db a").html("");
				$(".data-file-db i").html("No backup file!");				
				$('#delete-database').hide();
			}
		});			
	});
});
</script>
<form method="post">
	<div id="app_header">
		<div class="warp_app_header">		
			<div class="app_title">Backup & Restore</div>
			<div class="app_link">	
				<?php printAlert(); ?>
			</div>			
		</div>
	</div>	   	
	<?php
	$dfile = '';
	$dir=@opendir("../.backup"); 
	while($folder=@readdir($dir)){ 
	if($folder == "." or $folder == "..")continue; 
		if(preg_match ( "/[\.]+sql/i" , $folder)){	
			$dfile = str_replace(".php","",$folder);
		}
	} 
	@closedir($dir);
	$delete = "<div class='switch s-icon uninstall activator' style='display:none' id='delete-database' file='$dfile'>
	<label class='cb-default red tips' data-placement='top' title='".Delete_file."'><span><b class='icon-remove-sign'></b></span></label></div>";
	$cfile ="<b><a target='_parent' href='#' data-placement='top' title='Download File' class='tips'></a></b> <small><i>No backup file!</i></small> $delete";
	if(!empty($dfile)) {
		$file = "../.backup/".$dfile;
		if(file_exists($file)) {
			$delete = "<div class='switch s-icon uninstall activator' id='delete-database' file='$dfile'>
			<label class='cb-default red tips' data-placement='top' title='".Delete_file."'><span><b class='icon-remove-sign'></b></span></label></div>";
			$cfile = "<b><a target='_parent' href='../.backup/$file' data-placement='top' title='Download File' class='tips'>$dfile</a></b> <small><i>(".format_size(filesize($file))." - ".date("Y/m/d H:i:s",filemtime($file)).")</i></small> $delete";
			
		}
	}	
	?>
	
	<div class="panel box"> 		
		<header>
			<h5>Backup Database</h5>
		</header>
		<div>
			<table>
				<tr>
					<td class="row-title">Backup Database</td>
					<td>
					<button class="btn btn-success backup_db" type="submit" name="backup_all" file="<?php echo $dfile; ?>">Backup</button></td>
				</tr>	
				<tr>
					<td class="row-title"><?php echo Latest_Database_Backup; ?></td>
					<td class="data-file-db"><?php echo $cfile; ?></td>
				</tr>
				
			</table>
		</div> 
    </div> 
	<?php
	$tfile = '';
	$dir=@opendir("../.backup/.table"); 
	while($folder=@readdir($dir)){ 
	if($folder == "." or $folder == "..")continue; 
		if(preg_match ( "/[\.]+sql/i" , $folder)){	
			$tfile = str_replace(".php","",$folder);
		}
	} 
	@closedir($dir);
	$delete = "<div class='switch s-icon uninstall activator' style='display:none' id='delete-tables' file='$tfile'>
	<label class='cb-default red tips' data-placement='top' title='".Delete_file."'><span><b class='icon-remove-sign'></b></span></label></div>";
	$cfile ="<b><a target='_parent' href='#' data-placement='top' title='Download File' class='tips'></a></b> <small><i>No backup file!</i></small> $delete";
	if(!empty($tfile)) {
		$file = "../.backup/.table/".$tfile;
		if(file_exists($file)) {
			$delete = "<div class='switch s-icon uninstall activator' id='delete-tables' file='$tfile'>
			<label class='cb-default red tips' data-placement='top' title='".Delete_file."'><span><b class='icon-remove-sign'></b></span></label></div>";
			$cfile = "<b><a target='_parent' href='$file' data-placement='top' title='Download File' class='tips'>$tfile</a></b> <small><i>(".format_size(filesize($file))." - ".date("Y/m/d H:i:s",filemtime($file)).")</i></small> $delete";
			
		} 
	}	
	?>
	
	<div class="panel box"> 		
		<header>
			<h5>Backup Tables</h5>
		</header>
		<div>
			<table>				
				<tr>
					<td class="row-title" title="Tampilkan judul  halaman">Backup Specific Tables</td>
					<td><select name="table[]" class="chosen-select tb-data" data-placeholder="<?php echo Choose_table; ?>" style="min-width:150px; width:50%;" multiple>
					<option value=""></option>
						<?php	
							$_GET['id']=0;
							$db = new FQuery(); 
							$db->connect(); 
							$sql = mysql_query("SHOW TABLES FROM ".FDBName);
							while($table = mysql_fetch_array($sql)){
								$tb = str_replace(FDBPrefix,'',$table[0]);
								echo " <option value='$tb'>$tb</option>";
							}						
						?>
					</select>
					<button class="btn btn-success backup_table" type="submit" name="backup_choose" file="<?php echo $tfile; ?>"><?php echo Backup; ?></button>
					</td>
				</tr>		
				<tr>
					<td class="row-title"><?php echo Latest_Table_Backup; ?></td>
					<td class="data-file-table"><?php echo $cfile; ?></td>
				</tr>
			</table>
		</div> 
    </div> 
	<?php
	$nfile = '';
	$dir=@opendir("../.backup"); 
	while($folder=@readdir($dir)){ 
	if($folder == "." or $folder == "..")continue; 
		if(preg_match ( "/[\.]+zip/i" , $folder)){	
			$nfile = str_replace(".php","",$folder);
		}
	} 
	@closedir($dir);
	$delete = "<div class='switch s-icon uninstall activator' style='display:none' id='delete-installer' file='$nfile'>
	<label class='cb-default red tips' data-placement='top' title='".Delete_file."'><span><b class='icon-remove-sign'></b></span></label></div>";
	$cfile ="<b><a target='_parent' href='#' data-placement='top' title='Download File' class='tips'></a></b> <small><i>No backup file!</i></small> $delete ";
	if(!empty($nfile)) {
		$file = "../.backup/".$nfile;
		if(file_exists($file)) {
			$delete = "<div class='switch s-icon uninstall activator' id='delete-installer' file='$nfile'>
			<label class='cb-default red tips' data-placement='top' title='".Delete_file."'><span><b class='icon-remove-sign'></b></span></label></div>";
			$cfile = "<b><a target='_parent' href='../.backup/$file' data-placement='top' title='Download File' class='tips'>$nfile</a></b> <small><i>(".format_size(filesize($file))." - ".date("Y/m/d H:i:s",filemtime($file)).")</i></small> $delete";
			
		}
	}	
	?>
	
	<div class="panel box"> 		
		<header>
			<h5>Backup Installer</h5>
		</header>
		<div>
			<table>				
				<tr>
					<td class="row-title"><?php echo Create; ?> Backup Installer</td>
					<td>
					<button class="btn btn-metis-2 btn-sm btn-grad backup_install" type="submit" name="backup_install" file="<?php echo $nfile; ?>"><?php echo Backup; ?></button></td>
				</tr>		
				<tr>
					<td class="row-title"><?php echo Latest_Data_Backup_Installer; ?></td>
					<td class="data-file-installer"><?php echo $cfile; ?></td>
				</tr>	
			</table>
		</div> 
    </div> 
	<div class="panel box"> 		
		<header>
			<h5>Restore Database</h5>
		</header>
		<div>
			<table>
				<tr>
					<td class="row-title">Restore Database</td>
					<td><div><span class="form-file form-control" style="width:50%">
					<input type="file" name="sql" style="width:150%" title="Choose file installer" class="form-control filesql">
					<label for="sql" class="error invisible sql_error"><?php echo Please_chose_sql_file; ?></label></span>
					<button class="btn btn-primary btn-sm btn-grad restore">Restore</button></div></td>
				</tr>
			</table>
		</div> 
    </div> 	
</form>	

<div class="modal fade" id="modal_backup" role="dialog" style="display:none">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header"><h4 class="modal-title-backup modal-title"></h4>
      </div>
      <div class="modal-body">
        <div class="update-info-backup">Loading...</div>
      </div>
      <div class="modal-footer modal-footer-backup">
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo Close; ?></button>
      </div>
    </div>
  </div>
</div>