<?php
/**
* @version		1.5.0
* @package		Article Archive
* @copyright	Copyright (C) 2012 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.txt
**/

defined('_FINDEX_') or die('Access Denied');

?>
<script>
	$(function() {
		$('.archive-head .archive-head-a').click(function() {
			$('.archive-list').slideUp();
			$(this).next('ul').slideDown();
			$(this).next('ul').addClass('open');
		});	
	});
</script>