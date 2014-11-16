<?php 
/**
* @version		2.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2014 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.txt
* @description	
**/

defined('_FINDEX_') or die('Access Denied');
$format = app_param('format');
if($format == 'grid') {
?>
<script>
	$(function() {
		function main() {
		$('.no-image h2.title a').each(function() {
			$(this).parent().css('height',$(this).height()+25);
		});
		$('.article-grid ').each(function() {
			$(this).css('height',$(this).width() * .5);
		});
		var w = $('#article').width();
			
		p = Math.round(w/330);
			$('.article-grid').css('width',  100/p-.3 +'%');
		}

		main();
			$(window).resize(function() {
		main();
		});
	});
</script>
<?php
}

?>