<?php
/**
* @version		2.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2014 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.
**/

defined('_FINDEX_') or die('Access Denied');

$db = new FQuery() or die;  
$db ->connect();  
$sql= $db->select(FDBPrefix."user","*","id=$_REQUEST[id]"); 
$qr	= mysql_fetch_array($sql); 
/*
if($_SESSION['USER_LEVEL'] >= $qr['level'] AND $_SESSION['USER_ID'] != $qr['id']){
	alert('info','Redirecting...');
	alert('loading');
	htmlRedirect('?app=user');
}*/
if($qr['status']==1) $ck="checked";
if($qr['status']==0) $ck2="checked";
?>

<form method="post" action="">
	<div id="app_header">
		<div class="warp_app_header">
			<div class="app_title"><?php echo Edit_User; ?></div>
			<div class="app_link">
				<button type="submit" class="btn btn-success" title="<?php echo Delete; ?>" value="Next" name="applyedit"><i class="icon-ok"></i> <?php echo Save; ?></button>				
				<button type="submit" class="btn btn-metis-2" title="<?php echo Delete; ?>" value="Next" name="edit"><i class="icon-ok-sign"></i>  <?php echo Save_and_Quit; ?></button>
				</button>	
				<a class="danger btn btn-default" href="?app=user" title="<?php echo Cancel; ?>"><i class="icon-remove-sign"></i> <?php echo Cancel; ?></a>
				<?php printAlert(); ?>
			</div>
		</div>			 
	</div>
<?php require('field_user.php'); ?>	
</form>
