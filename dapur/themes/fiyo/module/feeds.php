<?php 
/**
* @version		2.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2014 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.txt
**/

session_start();
if(!isset($_SESSION['USER_ID']) or !isset($_SESSION['USER_ID']) or $_SESSION['USER_LEVEL'] > 5 ) die();
define('_FINDEX_','BACK');

require_once ('../../../system/jscore.php');
?>
<table class="table table-striped tools">
<tbody>
<?php
$url = 'http://update.fiyo.org/';
$xml = @simplexml_load_file($url);
$site_version	= siteConfig('version');
if($xml) {
	$latest_version = $xml-> version -> number ;
	$latest_date = $xml-> version -> date;
	$patch = array();
	$i = 1; $files = null;
	foreach($xml->children() as $child){
		
		echo "<tr><td style='padding: 8px 10px;'><b>".$child -> title."</b><a data-toggle='tooltip' data-placement='right' title='".$child -> date."' class='icon-time tooltips'></a>
			<br/><span>".$child -> content."</span><br/>
			<div class='tool-box tool-$i'>
				<a href='".$child -> link."' target='_blank'  class='btn btn-tools tips' title=''>Selengkapnya</a>
			</div>
		</td></tr>";
		$i++;	
	}	
}
else {
	echo "<tr><td style='text-align:center; padding: 40px 0; color: #ccc; font-size: 1.5em'>".Failed_to_connect_server."</td></tr>";
}
?></tbody>			
</table>
<script>$(function() {$('.tooltips').tooltip();});</script>