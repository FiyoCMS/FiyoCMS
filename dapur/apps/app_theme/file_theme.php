<?php
/**
* @version		2.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2014 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.
**/

defined('_FINDEX_') or die('Access Denied');

if(USER_LEVEL != 1)
redirect("http://localhost/fiyo/dapur/?app=theme&folder=$_GET[folder]");

include("libs/php_file_tree.php");
$spot_file = "../themes/$folder/theme_details.php";
if(file_exists($spot_file)) include("$spot_file");
addCss("apps/app_theme/libs/styles/default/default.css");
?>
<?php 
 ?>
<script language="javascript" type="text/javascript">
  $(document).ready(function() {	
		$("#tree-theme").find("ul").hide();	
		$(".pft-directory a").click(function(){	
			$(this).parent().toggleClass('active');
		});
		$(".thmfile").click(function(){
			var name = $(this).html();
			var src = $(this).attr('src');
			 $('.file-title').html(": " + name);
			$("#save-file").attr('name',"../../../"+src+"/"+name);
			$("#editor").html("<div style='padding: 26px;font-size: 3em;color: #ccc;'>Loading...</div>");
			$.ajax({
				url: "apps/app_theme/libs/check_file.php",
				data: "src="+src+"&name="+name,
				success: function(data){				
					$("#editor").html(data); 
				}
			});
		});
		
		$("#save-file").click(function(){
			var content =  encodeURIComponent(editAreaLoader.getValue("text")) ;
			var btn = $(this);			
			$(this).html("Loading...");			
			$.ajax({
				type: 'POST',
				url: "apps/app_theme/libs/save_file.php",
				data: "src="+btn.attr('name')+"&content="+content,
				success: function(data){							
				notice("<?php alert("success",File_Saved,true); ?>");		
				btn.html('<i class="icon-check-circle"></i> <?php echo Save; ?>');
				}
			});
		});
		var btn = $("#save-file");
		btn.hide();
	});
</script>
<div class="box-left full first">
	<div class="panel box"> 		
		<header>
			<h5><?php echo @$theme_name; ?>
			<span class='file-title'></span></h5><button type="submit" class="btn top-btn-file save-file-theme  btn-metis-2" id="save-file"><i class="icon-check-circle"></i> <?php echo Save; ?></button>
		</header>
		<div class="box-theme">
		<div class="tree-theme scrolling">
	<?php
			$target = "../themes/$_GET[folder]";
		echo php_file_tree("$target", "#");
	?>
		</div>
		<div class="inn-theme">			
			<div class="col full first" style=" width: 100% !important;  ">	
			<div id="editor" style="margin-bottom: -6px;"><div style="padding: 30px; font-size: 3em; color: #ccc">
			<?php echo Choose_file_on_left_side; ?>			
			</div></div>
			</div>
		</div>
		</div>
	</div>
</div>
