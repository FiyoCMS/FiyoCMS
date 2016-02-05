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
set_time_limit(10);
?>
<table class="table table-striped tools">
<tbody>
<?php
$url = 'http://www.fiyo.org/blog.xml';
$xml = @simplexml_load_file($url);

function articleImage($article) {
	$opentag = strpos($article,"<img");
	if($opentag) {
		$closetag = substr($article,$opentag);
		$closetag = strpos($closetag,">");
		$image = substr($article,$opentag,$opentag+$closetag);
		$a = strpos($image,'src="');
		
		if(empty($a)) 
			$a = strpos($image,"src='");
			
		$b = substr($image,$a+5);					
		$c = strpos($b,'"');
		if(empty($c))$c = strpos($b,"'");
		return  substr($image,$a+5,$c);					
	}	
	else return false;
}

if($xml) {
	function getFirstPara($string){
		return substr($string, 0, strpos($string, ' ', 200));
    }
	$i = 1; $files = null;
	foreach($xml->channel->item as $child){	
				
		$c = str_replace("/media","http://www.fiyo.org/media/.thumbs",$child -> description);
		$img = articleImage($c);
		$c = preg_replace("/<img[^>]+\>/i", "", $c); 
		$c = stripTags($c);
		$c = getFirstPara($c);
		echo "<tr><td style='padding: 8px 10px;'><b>".$child -> title."</b><a data-toggle='tooltip' data-placement='right' title='".$child -> pubDate."' class='icon-time tooltips'></a>
			<div style=' display: inline-block;'><img src='$img' align='left'>".$c."...</div>
			<div class='tool-box'>
				<a href='".$child -> link."' target='_blank'  class='btn btn-tools tips' title=''>Selengkapnya</a>
			</div>
		</td></tr>";
		if($i == 5) break;	
		$i++;	
	}	
}
else {
	echo "<tr><td style='text-align:center; padding: 40px 0; color: #ccc; font-size: 1.5em'>".Failed_to_connect_server."</td></tr>";
}
?></tbody>			
</table>
<script>$(function() {$('.tooltips').tooltip();});</script>