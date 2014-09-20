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
$folder = $_REQUEST['folder'];
$a = $b = $c = '';
if(isset($_REQUEST['type'])) {
	$type=$_REQUEST['type'];
	if($_REQUEST['type'] == 'file') {
		$c='active';
		include('libs/edit_default.php');
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

$spot_file = "../themes/$folder/theme_details.php";
if(file_exists($spot_file)) include("$spot_file");
		
$params = "../themes/$folder/theme_params.php";

if($a) :
?>
<div class="<?php if(file_exists($params) AND isset($theme_params)) echo "box-left col-lg-6 "; else echo "panel box"?>">
	<div class="panel box"> 		
		<header>
			<h5><?php echo General; ?></h5>
		</header>
		<div>
			<table class="data2">
				<tr>
					<td><?php echo Name; ?></td>
					<td><?php echo @$theme_name; ?></td>
				</tr>
				<tr>
					<td><?php echo Creator; ?></td>
					<td><?php echo @$theme_author; ?></td>
				</tr>				
				<tr>
					<td>Preview</td>
					<td><img src='../themes/<?php echo $folder; ?>/<?php echo @$theme_image; ?>' style='max-width: 100%' ></td>
				</tr>
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
if(file_exists($params) AND isset($theme_params)) include("$params");
endif;
?>
	
	
<div class="app_link tabs">		
	<div class="app_link">		
		<a class="add btn btn-default <?php echo $a; ?>" href="?app=theme&folder=<?php echo $folder;?>"><i class="icon-magic"></i> <?php echo Information; ?></a>
		<?php if(USER_LEVEL == 1) : ?>
		<a class="add btn btn-default <?php echo $b; ?>" href="?app=theme&folder=<?php echo $folder;?>&type=files"><i class="icon-file-text-alt"></i> Files</a>		
		<?php endif; ?>	
		<a class="back-theme" href="?app=theme"><i class="icon-reply" style="padding: 2px;" ></i><?php echo Back;?></a>	
	</div>		
</div>