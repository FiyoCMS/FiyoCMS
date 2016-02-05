<?php
/**
* @version		2.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2014 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.
**/

defined('_FINDEX_') or die('Access Denied');

$db = new FQuery() or die;  
$sql= $db->select(FDBPrefix."user","*","id=$_REQUEST[id]"); 
$qr	= $sql[0]; 

if($_SESSION['USER_LEVEL'] >= $qr['level'] AND $_SESSION['USER_ID'] != $qr['id'] AND $_SESSION['USER_LEVEL'] != 1) {
	notice('info','Access denied! Redirecting ...',2);
	htmlRedirect('?app=user');
	}
if($qr['status']==1) $ck="checked";
if($qr['status']==0) $ck2="checked";
?>

<form method="post" action="">
	<div id="app_header">
		<div class="warp_app_header">
			<div class="app_title"><?php echo Edit_User; ?></div>
			<div class="app_link">
				<button type="submit" class="btn btn-success" title="<?php echo Delete; ?>" value="Next" name="applyedit"><i class="icon-check"></i> <?php echo Save; ?></button>				
				<button type="submit" class="btn btn-metis-2" title="<?php echo Delete; ?>" value="Next" name="edit"><i class="icon-check-circle"></i>  <?php echo Save_and_Quit; ?></button>
				</button>	
				<a class="danger btn btn-default" href="?app=user" title="<?php echo Cancel; ?>"><i class="icon-remove-sign"></i> <?php echo Cancel; ?></a>
				<?php printAlert(); ?>
			</div>
		</div>			 
	</div>
<?php require('field_user.php'); ?>	
</form>
