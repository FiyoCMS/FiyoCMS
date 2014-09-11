<?php
/**
* @version		1.5.0
* @package		Breadcrumb
* @copyright	Copyright (C) 2012 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.txt
*/

defined('_FINDEX_') or die('Access Denied');

require_once("mod_system.php");
$bread = new Breadcrumb;
?>

<ul class="mod-breadcrumb breadcrumb">
	<?php echo $bread -> createItem();	?>
</ul>
