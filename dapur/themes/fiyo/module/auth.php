<?php
/**
* @version		2.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2014 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.txt
* @description	
**/

defined('_FINDEX_') or die('Access Denied');

if(isset($_GET['platform'])) { 
?>
<script>	
		function UrlExists(url)
		{
			var http = new XMLHttpRequest();
			http.open('HEAD', url, false);
			http.send();
			return http.status!=404;
		}
		var url = '<?php echo AdminPath; ?>/js/jquery.min.js';
		if(!UrlExists(url))
		window.location.replace('<?php echo FAdmin; ?>?clear=all');
</script>
<?php }else if(isset($_GET['clear'])) {  if($_GET['clear'] == 'all') session_destroy(); redirect(FAdmin); ?>
<script>window.location.replace('<?php echo FAdmin; ?>');</script>

<?php } ?>