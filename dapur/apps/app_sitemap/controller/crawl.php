<?php
/**
* @version		2.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2014 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.
**/

session_start();
if(@$_SESSION['USER_LEVEL'] > 5 or !isset($_POST['web'])) die ('Access Denied!');
define('_FINDEX_','BACK');
require('../../../system/jscore.php');
$timeout 	= oneQuery("sitemap_setting","name","timeout","value");
set_time_limit($timeout);
function crawl_page($url, $ex = null, $depth = 5)
{
    static $seen = array();
    static $curl = array();
    static $home = false;	
    static $hurl = null;
	
	if(!$hurl)
    $hurl = str_replace("http://","",$url);
    if (isset($seen[$url]) || $depth === 0) {
        return;
    }

    $seen[$url] = true;

    $dom = new DOMDocument('1.0');
    @$dom->loadHTMLFile($url);
    $anchors = $dom->getElementsByTagName('a');
	$no = 1;
	
    foreach ($anchors as $element) {
        $href = $element->getAttribute('href');
        if (0 !== strpos($href, 'http')) {
            $path = '/' . ltrim($href, '/');
            if (extension_loaded('http')) {
                $href = http_build_url($url, array('path' => $path));
            } else {
                $parts = parse_url($url);
                $href = $parts['scheme'] . '://';
                if (isset($parts['user']) && isset($parts['pass'])) {
                    $href .= $parts['user'] . ':' . $parts['pass'] . '@';
                }
                $href .= $parts['host'];
                if (isset($parts['port'])) {
                    $href .= ':' . $parts['port'];
                }
                $href .= $path;
            }
        }
		
		
		$c = explode("\n", $ex);
		$n = false;
		foreach($c as $a) {
			if(empty($a)) continue;
			if(strpos($href,"$a")) {
				$n = true;			
				break;
			}			
		}
		
		if(!array_search($href,$curl) AND strpos($href,"$hurl") AND !strpos($href,"?page=") AND !strpos($href,".rss") AND !strpos($href,"=") AND !strpos($href,"javascript:")AND !strpos($href,"@") AND !strpos($href,".zip") AND !strpos($href,"#") AND $href != $home AND !$n) {
			if(strpos($c = str_replace("http://","",$href),"//")) {
				while(strpos($c,"//")) {					
					$c = str_replace("//","/",$c);
				}
				$href = "http://$c";
			}
			if(!strpos($href,"?"))
				array_push($curl,$href);
			
			if(!$home)
			$home = $href;
		
			sort($curl);
			crawl_page($href, $ex, $depth - 1);
		}
    }
    return $curl;
}

$sql 	= $db->select(FDBPrefix.'sitemap_setting','*'); 
$row 	= $sql[0];
$web 		= oneQuery("sitemap_setting","name","root_url","value");
$ex_dir 	= oneQuery("sitemap_setting","name","ex_dir","value");
$ex_file 	= oneQuery("sitemap_setting","name","ex_file","value");
$xml 		= oneQuery("sitemap_setting","name","xml","value");
$txt 		= oneQuery("sitemap_setting","name","txt","value");

$ex = $ex_dir."\n".$ex_file;
$curl = crawl_page("$web",$ex,20);
$words_so_far = array();
foreach($curl as $k){
    if(in_array($k, $words_so_far)){
    }
    else {
        $words_so_far[] = $k;
    }
}
/*
header('Content-Type: application/json');
echo json_encode($curl);
die();
*/
?>
<table class="data">
<thead>
	<tr>								 
		<th style="width:99% !important;">URL</th>
	</tr>
</thead>		
<tbody>
	<?php			
		$_SESSION['CRAWLER_DATA'] = $curl;
		$no = 1;
		foreach($curl as $r) {
			$no++;
			echo "<tr>
			<td>$r</td></tr>";
		} 
		?>
</tbody>			
</table>