<?php
/**
* @version		2.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2014 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.
**/

defined('_FINDEX_') or die('Access Denied');

?>
<div id="app_header" class="theme">
	 <div class="warp_app_header">		
		<div class="app_title">Theme Manager</div>	
	 </div>
</div>
<?php

$spot_file = "../themes/$folder/theme_details.php";
if(file_exists($spot_file)) include("$spot_file");

$params = "../themes/$folder/theme_params.php";

$folder = $_REQUEST['folder'];
$a = $b = $c = '';
if(isset($_REQUEST['type'])) {
	$type=$_REQUEST['type'];
	if($_REQUEST['type'] == 'file') {
		$c='active';
		include('libs/edit_default.php');
	}
	else if($_REQUEST['type'] == 'param') {
		$c='active';
		if(!file_exists($params)) {
			htmlRedirect("?app=theme&folder=$folder");
		}
	}
	else {
		include('file_theme.php');
		$b = 'active';
	}
}
else {
	$type = 'images';
	$a = 'active';
}
$thimage = "No Image";

if(!isset($theme_name)) {
	$theme_name = "$folder";
}
if(isset($theme_image) AND file_exists("../themes/$folder/$theme_image")) {	
	$thimage = "<img src='../themes/$folder/$theme_image' style='max-width: 100%' >";
}
if(isset($theme_logo) AND file_exists("../themes/$folder/$theme_logo")) {
	$logourl = "../themes/$folder/$theme_logo";
	$logo = "<img src='../themes/$folder/$theme_logo' style='max-width: 100%' >";
}
if(isset($theme_logo) AND file_exists("../themes/$folder/$theme_logo.ori")) {
	$logori = true;
}

if($a) :
?>
<script type="text/javascript">
$(document).ready(function() {
	$(".delete").click(function(){
		$("#img").hide();
		$(this).hide();
        var imgl = $("#img1").val();
		$(".imgdiv").html('<img id="img" src="' + imgl + '.ori" class="img" title="click to change image"  />');
		$(".image-group").addClass('noimg');	
		$.ajax({
			url: "apps/app_theme/controller/change_logo.php",
			data: "delete=true"+"&ori="+imgl,
			timeout : 10000,
			error: function(data){	
						alert('Change logo : Error!');		
			},	
			success: function(data){				
				notice(data);	
			}
		});
	});	
	
	$(".image-group .imgdiv").hover(function() {
		$(this).toggleClass('selected');		
	});
	
	
	$(".sw-theme").click(function(){
		var vl = $(this);
		var value = vl.data('name');	
		$.ajax({
			url: "apps/app_theme/controller/status.php",
			data: "theme="+value+"&type=site",
			success: function(data){
				vl.addClass('save btn theme-btn');
				vl.removeClass('sw-theme');
				$('.col-theme.active').removeClass('active');
				vl.html("<?php echo Active; ?>");
				notice(data);		
			}
		});
	}); 
});
function openKCFinder(div) {
    window.KCFinder = {
        callBack: function(url) {
            window.KCFinder = 1;
            div.innerHTML = '<div style="margin:5px">Loading...</div>';
            var img = new Image();
            var imgl = $("#img1").val();
            img.src = url;
            img.onload = function() {
				$.ajax({
					url: "apps/app_theme/controller/change_logo.php",
					data: "file="+url+"&ori="+imgl,
					timeout : 10000,
					error: function(data){	
						alert('Change logo : Error!');	
					},	
					success: function(data){				
						notice(data);	
					}
				});
                div.innerHTML = '<img id="img" src="' + url + '" class="img" title="click to change image"  /><input type="hidden" value="' + url + '" class="imgval" name="photo">';
                var img = document.getElementById('img');
                var o_w = img.offsetWidth;
                var o_h = img.offsetHeight;
                var f_w = div.offsetWidth;
                var f_h = div.offsetHeight;
                if ((o_w > f_w) || (o_h > f_h)) {
                    if ((f_w / f_h) > (o_w / o_h))
                        f_w = parseInt((o_w * f_h) / o_h);
                    else if ((f_w / f_h) < (o_w / o_h))
                        f_h = parseInt((o_h * f_w) / o_w);
                    img.style.width = f_w + "px";
                    img.style.height = f_h + "px";
                } else {
                    f_w = o_w;
                    f_h = o_h;
                }
                img.style.visibility = "visible";
				$(".image-group").removeClass('noimg');
				$(".delete").show();
            }
        }
    };
    window.open('../plugins/plg_kcfinder/browse.php',
        'kcfinder_image', 'status=0, toolbar=0, location=0, menubar=0, ' +
        'directories=0, resizable=1, scrollbars=0, width=700, height=400'
    );
}
</script>
<div class="<?php if(file_exists($params) AND isset($theme_params)) echo "box-left col-lg-6 "; else echo "panel box"?>">
	<div class="panel box active"> 		
		<header>
			<h5><?php echo General; ?></h5>
			<?php 
			if($folder == siteConfig('site_theme')) : ?>
			<button type="submit" data-name="<?php echo $folder;?>" class="btn  theme-btn top-btn-file save-file-theme  btn-metis-2 save" id="save-file"><?php echo Active; ?></button> <?php else : ?>
			<button type="submit"  data-name="<?php echo $folder;?>" class="btn sw-theme top-btn-file save-file-theme  btn-metis-2" id="save-file"><i class="icon-check-circle"></i> <?php echo Activate; ?></button> <?php endif; ?>
		</header>
		<div>
			<table>
				<tr>
					<td><?php echo Name; ?></td>
					<td><?php echo @$theme_name; ?></td>
				</tr>
				<tr>
					<td><?php echo Creator; ?></td>
					<td><?php echo @$theme_author; ?></td>
				</tr>			
				<?php if(isset($logo)): ?>
				<tr>
					<td>Logo</td>
					<td>
					<input type="hidden" id="img1" name="photo" value="<?php echo $logourl;?>">
					<div class="image-group <?php if(empty($logo)) echo "noimg"; ?>">
						<div id="image1" class="imgdiv btn" onclick="openKCFinder(this)"><?php if(!empty($logo)) echo "<img id='img' src='$logourl' class='img tips' title='click to change image'>";?><a <?php if(!empty($logo)) echo " style=' display: none';"; ?>>Choose Image</a></div>
						<?php if(isset($logori)) :?>
						<label <?php if(empty($logo)) echo " style=' display: none';"; ?> class=" red tips delete btn" data-placement="top" title="" data-original-title="<?php echo Delete; ?>"><span><b class="icon-remove-sign"></b></span></label>
						<?php endif; ?>
					</div>	
					
					</td>
				</tr>		
				<?php endif; ?>
				<?php if(isset($thimage)): ?>
				<tr>
					<td>Preview</td>
					<td><?php echo $thimage; ?></td>
				</tr>
				<?php endif; ?>
				<?php if(isset($theme_version)) : ?>
				<tr>
					<td><?php echo Version; ?></td>
					<td><?php echo @$theme_version; ?></td>
				</tr>		
				<?php endif; ?>
				<?php if(isset($theme_date)) : ?>
				<tr>
					<td><?php echo Release_date; ?></td>
					<td><?php echo @$theme_date; ?></td>
				</tr>	
				<?php endif; ?>
				<?php if(isset($theme_url)) : ?>
				<tr>
					<td>URL</td>
					<td><?php echo @$theme_url; ?></td>
				</tr>
				<?php endif; ?>
				<?php if(isset($theme_docs)) : ?>
				<tr>	
					<td><?php echo Documentation; ?></td>
					<td><?php echo @$theme_docs; ?></td>
				</tr>
				<?php endif; ?>
			</table>
		</div>
	</div>
</div>
<?php
endif;
if($c) :
?>

<div class="<?php if(file_exists($params) AND isset($theme_params)) echo "box-left col-lg-6 "; else echo "panel box"?>">
	<div class="panel box"> 		
		<header>
			<h5>Parameter<button type="submit" class="btn top-btn-file save-file-theme  btn-metis-2" id="save-file" style="display: block;" name="../../../../themes/bluestrap_theme/index.php"><i class="icon-check-circle"></i> Simpan</button></h5>
		</header>
		<div>
		<?php include($params); ?>
		</div>
	</div>
</div>
<?php
endif;
?>
	
	
<div class="app_link tabs">		
	<div class="app_link">		
		<a class="add btn btn-default <?php echo $a; ?>" href="?app=theme&folder=<?php echo $folder;?>"><i class="icon-magic"></i> <?php echo Information; ?></a>
		<?php if(USER_LEVEL < 3 AND file_exists($params)) : ?>
		<a class="add btn btn-default <?php echo $c; ?>" href="?app=theme&folder=<?php echo $folder;?>&type=param"><i class="icon-cogs"></i> Parameter</a>		
		<?php endif; ?>	
		<?php if(USER_LEVEL == 1) : ?>
		<a class="add btn btn-default <?php echo $b; ?>" href="?app=theme&folder=<?php echo $folder;?>&type=files"><i class="icon-file-text-alt"></i> Files</a>		
		<?php endif; ?>	
		<a class="back-theme" href="?app=theme"><i class="icon-reply" style="padding: 2px;" ></i><?php echo Back;?></a>	
	</div>		
</div>