<?php
/**
* @version		2.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2014 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.txt
* @description	
**/

defined('_FINDEX_') or die('Access Denied');		
?>
<script type="text/javascript">
$(document).ready(function() {
	$(".upload").click(function(e){	
		
		var filename = $(".zip").val();
		var extension = filename.replace(/^.*\./, '');
        if (extension == filename) {
            extension = '';
        } else {
            extension = extension.toLowerCase();
        }
		
		
		if(extension == 'zip') {
			var size = $(".zip")[0].files[0].size;
			var maxsize = "<?php echo format_byte(ini_get("upload_max_filesize")); ?>";
			size = size / 1024;
			if(size < maxsize) 				
				$('.zip_error').hide();
			else {			
                e.preventDefault();
				$('.zip_error').removeClass('invisible');
				$('.zip_error').show().html("<?php echo Max_upload_file_not_allowed; ?>");
			
			}
		} else {
                e.preventDefault();
				$('.zip_error').removeClass('invisible');
				$('.zip_error').show().html("<?php echo Please_choose_zip_file; ?>");
		}
	});
	
	$(".copy").click(function(e){
		var filename = $(".url").val();
		
		if(filename == '') {	
                e.preventDefault();
				$('.url_error').show();
				$('.url_error').removeClass('invisible');
		} else {		
				$('.url_error').show();
				$('.url_error').hide();
		}
	});
	
	$(".url").click(function(e){
				$('.url_error').hide();
			});
	$(".zip").change(function(e){
		$('.zip_error').hide();
	});
	
	$(".updater").click(function(e){
		$('#modal-update').modal({
		  backdrop: 'static',
		  keyboard: false,
		  show : true
		});
		e.preventDefault();
		$(".update-info-update").LoadingDot({
			"speed": 500,
			"maxDots": 4,
			"word": "Connecting to update server."
		});
		$(".modal-footer-update").hide();
		$(".update-confirm").html("<?php echo Update; ?>");
		$.ajax({
			url: "apps/app_config/controller/update.php",
			data: "update=true",
			method: "POST",
			timeout: 10000, 
			error:function(){ 
					$(".update-info-update").html("<p><img src='themes/<?php echo siteConfig('admin_theme');?>/images/stop.png' style='margin: 4px 9px 0 0; float: left'>Failed to connect to the update server.</p><p>Check your internet connection / firewall<br>or update manually through <a href='http://www.fiyo.org/updates' target='_blank'>this link</a>.</p>");
				$(".modal-footer-update").show();
				$(".update-confirm").hide();
			},
			success: function(data){
				if(data == 0) {
					$(".update-info-update").html("<p><img src='themes/<?php echo siteConfig('admin_theme');?>/images/stop.png' style='margin: 4px 9px 0 0; float: left'>Failed to connect to the update server.</p><p>Check your internet connection / firewall<br>or update manually through <a href='http://www.fiyo.org/updates' target='_blank'>this link</a>.</p>");
					$(".try-again").show();
					$(".update-confirm").hide();		
					$(".modal-footer-update").show();	
				}
				else {
					$(".try-again").hide();
					$(".update-confirm").show();
					$(".modal-footer-update").show();
					$(".update-info-update").html(data);
				}
			}
		});	
	}); 
	
	$(".update-confirm").click(function(e){	
		e.preventDefault();		
		$(".update-info-update").LoadingDot({
			"speed": 500,
			"maxDots": 4,
			"word": "<?php echo Downloading_file_updates; ?>"
		});
		$(".modal-footer-update").hide();	
		$('#modal').modal('show');	
		
		$.ajax({
			url: "apps/app_config/controller/update.php",
			data: "patching=true",
			method: "POST",
			cache:false,
			timeout: 10000,  
			error:function(){ 
				$(".update-info-update").html("Error!") ;
				$(".modal-footer-update").show();
			},
			success: function(data){
				if(data == '') {
					$(".update-info-update").html("<p><img src='themes/<?php echo siteConfig('admin_theme');?>/images/stop.png' style='margin: 4px 9px 0 0; float: left'>Failed to connect to the update server.</p><p>Check your internet connection / firewall<br>or update manually through <a href=''>this link</a>.</p>");
					$(".try-again").show();
					$(".update-confirm").hide();
					$(".update-confirm").html("<?php echo Try_Again; ?>");				
				}
				else {
					$(".try-again").hide();
					$(".update-confirm").show();
					$(".modal-footer-update").show();
					$(".update-info-update").html(data);
				}
			}
		});	
	}); 
});
</script>
<form method="post" id="form" enctype="multipart/form-data" target="">
	<div id="app_header">
		<div class="warp_app_header">		
			<div class="app_title">Install & Update</div>
			<div class="app_link">
				<?php printAlert(); ?>
			</div>			
		</div>
	</div>	   	
	<?php 
		if(isset($_SESSION['INSTALL_NOTICE'])) {
			$_SESSION['INSTALL_NOTICE'][0] -= 1;
			if($_SESSION['INSTALL_NOTICE'][0] == 1) {
				echo $_SESSION['INSTALL_NOTICE'][1];
				$_SESSION['INSTALL_NOTICE'] = null;
			}
		}	
	?>
	<div class="panel box"> 		
		<header>
			<h5>Install</h5>
		</header>
		<div>
			<table>
				<tr>
					<td class="row-title">Install from PC</td>
					<td><div><span class="form-file form-control" style="width:50%">
					<input type="file" name="zip" style="width:150%" title="Choose file installer" class="form-control zip"></span><label for="sql" class="error invisible zip_error"><?php echo Please_choose_zip_file; ?></label>
					<button class="btn btn-primary btn-sm btn-grad upload" name="upload">Install</button></div></td>
				</tr>
				<tr>
					<td class="row-title" title="Tampilkan judul  halaman">Install from URL</td>
					<td><div>
					<input type="text" name="url" style="width:50%" class="form-control url" placeholder="http://domain/addons-file.zip">
					<label for="sql" class="error invisible url_error"><?php echo Enter_valid_url; ?></label>
					<button class="btn btn-primary btn-sm btn-grad copy" name="copy">Install</button></div>
					</td>
				</tr>	
			</table>
		</div> 
    </div> <div class="panel box"> 		
		<header>
			<h5>Update</h5>
		</header>
		<div>
			<table>
				<tr>
					<td class="row-title"><span class="tips"  title="<?php echo Fiyo_Version_tip; ?>"><?php echo Fiyo_Version; ?><i class="global-version"></td>
					<td><b class="version-val"><?php echo siteConfig('version'); ?></b> <a type="button" value="Check Update" class="btn btn-metis-2 updater" href="#update">Check Update</a></td>
				</tr>
			</table>
		</div> 
    </div> 
</form>	

<div class="modal fade" id="modal-update" role="dialog" style="display:none">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header"><h4 class="modal-title">Sistem Update</h4>
      </div>
      <div class="modal-body">
        <div class="update-info-update"><?php echo Sure_want_update; ?></div>
      </div>
      <div class="modal-footer modal-footer-update">
        <button type="button" class="btn btn-default btn-close" data-dismiss="modal"><?php echo Close; ?></button><button type="button" class="btn btn-primary btn-grad updater try-again"><?php echo Try_Again; ?></button><button type="button" class="btn btn-metis-2 btn-grad update-confirm" id="confirm"><?php echo Update; ?></button>
      </div>
    </div>
  </div>
</div>