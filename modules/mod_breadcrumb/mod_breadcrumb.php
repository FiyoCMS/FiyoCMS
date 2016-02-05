<?php 
/**
* @version		2.1
* @package		Breadcrumb
* @copyright	Copyright (C) 2015 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.txt
**/

defined('_FINDEX_') or die('Access Denied');

require_once("mod_system.php");
$bread = new Breadcrumb;
?>

<ul class="breadcrumb">
	<?php echo $bread -> createItem();	?>
</ul>
