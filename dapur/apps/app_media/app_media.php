<?php 
/**
* @version		2.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2012 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.txt
* @description	
**/

defined('_FINDEX_') or die('Access Denied');
$a = $b = $c = '';
if(isset($_REQUEST['type'])) {
	$type=$_REQUEST['type'];
	if($_REQUEST['type'] == 'files')
		$c='active';
	else
		$b = 'active';
}
else {
	$type = 'images';
	$a = 'active';
}
	
?>
<div id="app_header" class="media">
	 <div class="warp_app_header">		
		<div class="app_title">Media Manager</div>	
	 </div>
</div>
<iframe src="../plugins/plg_kcfinder/browse.php?type=<?php echo $type; ?>" width="99.65%" height="550" style="border:solid 1px #ccc; -moz-border-radius:3px;-webkit-border-radius:3px;border-radius:3px; padding: 0" class="fg-toolbar"></iframe>

<div class="app_link tabs">		
	<div class="app_link">		
		<a class="add btn btn-default <?php echo $a; ?>" href="?app=media"><i class="icon-picture"></i> Images</a>		
		<a class="add btn btn-default <?php echo $b; ?>" href="?app=media&type=flash"><i class="icon-camera-retro"></i> Flash</a>		
		<a class="add btn btn-default <?php echo $c; ?>" href="?app=media&type=files"><i class="icon-file-text-alt"></i> Files</a>			
	</div>		
</div>	