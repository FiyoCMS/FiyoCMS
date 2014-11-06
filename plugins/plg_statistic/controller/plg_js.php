<?php
/**
* @version		2.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2014 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.txt
* @description	Statistic
**/

defined('_FINDEX_') or die('Access Denied');
?>
<script>
var xmlhttp;
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
}
else
{// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
}
xmlhttp.onreadystatechange=function() {
if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
	var json = xmlhttp.responseText;
   }
}
xmlhttp.open("POST","<?php echo FUrl?>plugins/plg_statistic/controller/s.php?d=<?php echo MD5(__dir__).MD5(getUrl()).MD5(FUrl); ?>",true);
xmlhttp.send();

</script>
