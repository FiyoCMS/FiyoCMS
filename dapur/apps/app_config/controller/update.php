<?php
/**
* @version		2.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2014 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.
**/

define('_FINDEX_','BACK');
session_start();
if(!isset($_SESSION['USER_LEVEL']) AND $_SESSION['USER_LEVEL'] > 2) die ();

require_once ('../../../system/jscore.php');


$url = 'http://patch.fiyo.org/';
$xml = @simplexml_load_file($url);
$site_version	= siteConfig('version');
if($xml) {
	$latest_version = $xml-> version -> number ;
	$latest_date = $xml-> version -> date;
	$patch = array();
	$i = 1; $files = null;
	foreach($xml->children() as $child){
		if($child -> number <= siteConfig('version')) break;
		$patch[$i]['number'] = $child -> number; 
		$patch[$i]['link'] = $child -> link;
		$i++;	
	}

	ksort($patch);
	foreach($patch as $p){
		$files .= $p['number']."<br>";
	} 
	
	if(!isset($_POST['patching'])) {
		if($site_version < $latest_version)
			echo "<p>".Available_update_to_latest_version."<b>$latest_version</b></p><p>".Complete_information.": <a href='http://www.fiyo.org/updates' target='_blank'>http://www.fiyo.org/updates</a>.</p>";
		else if($site_version >= $latest_version) {			
			echo "<img src='themes/".siteConfig('admin_theme')."/images/success.png' class='update-success' /> ";
			echo Using_latest_version;
			?>
				<script>		
					$(document).ready(function() {		
						$(".try-again").hide();
						$(".update-confirm").hide();
					});		
				</script>
			<?php
		}
	}
	else if($site_version == $latest_version) {
		echo "<img src='themes/".siteConfig('admin_theme')."/images/success.png' class='update-success' /> ";
		echo Update_complete; ?>
				<script>		
					$(document).ready(function() {
						$(".try-again").hide();
						$(".update-confirm").hide();
						$(".modal-footer").show();
					});		
				</script>
		<?php
	} 			
}
else {
	echo 0;
}

	
if(isset($_POST['patching']) AND $_POST['patching'] != false AND $site_version != $latest_version AND $xml) {
	$plink = $p['link'];
	$root =  "../../../../";
	$newfile = "$root/tmp/patch_$p[number].zip";
	if(!file_exists("$root/tmp"))
		mkdir("$root/tmp");		
	
	if (copy($plink, $newfile)) {
		if(extractZip($newfile,"$root")) {
			$dapur = siteConfig('backend_folder');
				if(siteConfig('backend_folder') != 'dapur')		
					copy_directory("$root/dapur","$root/$dapur",true);
				
				$db = new FQuery();  
				$db -> connect();
				$db->update(FDBPrefix.'setting',array('value'=>"$p[number]"),"name='version'");
				$sup = $p['number'];				
				@unlink("$root/installer.php");
				echo "<span class='installing'>".Installing_patch.$p['number']."</span>"; 
				?>
				<script>		
					$(document).ready(function() {	
						$(".installing").LoadingDot({
							"speed": 500,
							"maxDots": 4,
							"word": "<?php echo Installing_patch.$p['number'];?>."
						});
						
						$(".modal-footer").hide();
						$.ajax({
							url: "apps/app_config/controller/update.php",
							data: "patching=true&number=<?php echo $sup;?>",
							method: "POST",
							cache:false,
							timeout: 10000,  // I chose 10 secs for kicks
							error:function(){ 
									$(".update-info").html("Error Connection!") ;
									$(".modal-footer").show();
							},
							success: function(data){
								$(".update-info-update").html(data);
								$(".version-val").html("<?php echo $sup; ?>");	
								$(".update-confirm").hide();
								$(".modal-footer").show();
							}
						});	
					});		
				</script>
			<?php
		}
	}
}
?>	