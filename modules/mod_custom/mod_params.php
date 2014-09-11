<?php
/**
* @version		2.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2014 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.txt
*/

defined('_FINDEX_') or die('Access Denied');

$param = $qr['parameter'];
if(checkLocalhost()) {
	$param = str_replace("media/",FLocal."media/",$param);			
}

?>
<input type="hidden" value="0" name="totalParam" />
<div class="panel box">							
	<header>
		<a data-parent="#accordion" class="accordion-toggle" data-toggle="collapse" href="#custom">
			<h5>Custom Module</h5>
		</a>
	</header>					
	<div id="custom" class="in" style="margin:-1px">
	<textarea id="editor" id="editor" name="editor" rows="10" cols="100"><?php formRefill('editor',$param,'textarea'); ?></textarea>
	</div>
</div>
<script type="text/javascript">
$(document).ready(function() {	
	CKEDITOR.replace( 'editor', {
		toolbar : 'Minify',
	});
});
</script>	