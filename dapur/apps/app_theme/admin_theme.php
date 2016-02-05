<?php
/**
* @version		2.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2014 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.
**/

defined('_FINDEX_') or die('Access Denied');

$db = new FQuery();  
$db->connect();  
?>
<script type="text/javascript">	
$(function() {		
	var hash = $('.theme-img[data-img]').attr('data-img');
	$.ajax({
		url: hash ,
		type : 'GET',
		timeout: 5000, 
		error:function(data){
			$('.theme-img[data-img]').prepend(function(){
				var img = $(this).find("img") ;
				if(img.length > 0) img.remove();
				var hash = $(this).attr('data-img')
				return ''; 
			});	
		},
		success: function(data){
			$('.theme-img[data-img]').prepend(function(){
				var img = $(this).find("img").length ;
				if(img.length > 0) img.remove();
				var hash = $(this).attr('data-img')
				return '<img  alt="" src=" '+ hash + '">';
			});
		}
	});	
	$( ".count" ).html($(".col-theme:visible" ).length);
		$("#search").keyup(function(){
		var v = $(this).val().toLowerCase();
		$(".col-theme:contains("+v+")" ).css( "display", "block" );
		$('.col-theme:not(:contains('+v+'))').hide(); 
		$( ".count" ).html($(".col-theme:visible" ).length);
	});
	
  $(".theme-btn.enable").click(function(){
		var vl = $(this);
		var value = vl.data('name');
		$.ajax({
			url: "apps/app_theme/controller/status.php",
			data: "theme="+value+"&type=admin",
			success: function(data){
				$('.col-theme.active').removeClass('active');
				vl.parents('.col-theme').addClass('active');
				notice(data);		
			}
		});
	});  
});
</script>
<div id="app_header">
	<div class="warp_app_header">		
		<div class="app_title">Admin Themes</div>
		<div class="app_link">			
				<input type="text" id="search" class="theme-search" placeholder="<?php echo Search; ?>..." size="40"/>
				<div class="tooltip fade right in theme-count"><div class="tooltip-arrow"></div><div class="tooltip-inner count">View Site</div></div>
				<input type="hidden" value="true" name="delete_confirm" />
		</div>
	</div>		
</div>
<div id="app-theme">
<?php
$thm = $act = '';
$sql=$db->select(FDBPrefix.'setting','*',"name='admin_theme'"); 
$qr_themes = $sql[0]; 
$dir=opendir("themes");  
$no=0;
while($folder=readdir($dir)){ 
	if($folder=="." or $folder=="..")continue; 
	if(is_dir("themes/$folder") AND file_exists("themes/$folder/index.php"))
	{
		$no++;
		$theme_image = '';
		$spot_file = "themes/$folder/theme_details.php";
		if(file_exists($spot_file)) include("$spot_file");
		else {
			$theme_version = "Error :: File <b>theme_details.php</b> not found in <b>$folder</b> ";
			$theme_author = "undefined";
			$theme_date =  "undefined";
			$theme_name =  $folder;
			$theme_name2 =  strtolower($folder);
		}
		$theme_name2 =  strtolower($theme_name);
		$active = 'enable';
		$c = siteConfig('admin_theme');
		$ac = Activate;
		if($c == $folder) { $active = 'active'; $ac = Active;}
		
		if(!empty($theme_image)) {
			if(file_exists("themes/$folder/$theme_image")) 
				$img = "<span class='theme-img' data-img='themes/$folder/$theme_image'></span>"; 	
			else $img ="<span class='no-image'>No Preview<br>Image</span>";	
		}
		else $img ="<span class='no-image'>No Preview<br>Image</span>";
		$isi = "
		<div class='col-theme $active' data-name='$theme_name'>
			<div class='theme-box'>
				<div class='theme-image'>
					<a href='#'>$img					
					<!--div> <span> Details </span></div -->
					</a>
				</div>
				<div class='theme-title'>			
					$theme_name							
					<input type=\"button\" name=\"folder_themes\" data-name=\"$folder\" value=\"$ac\" class=\"theme-btn $active btn btn-success right\">
				</div>
				<span class='invisible'>$theme_name2</span>
			</div>
		</div>";
		if($c == $folder) 		
		$act = $isi;
		else 
		$thm .= $isi;
		
	}
}
echo $act.$thm;
	closedir($dir); 
?>	
<input type="hidden" value="<?php echo $no; ?>" class="number">
</div>