<?php
/**
* @name			Search Module
* @version		1.5.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2012 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.txt
*/

defined('_FINDEX_') or die('Access Denied');

$link = make_permalink('?app=search');

?>
<form class="search-form" action="<?php echo $link; ?>" method="post">
	<input class="search-field" type="text" placeholder="Search..."  name="q">
	<input class="search-button btn" type="submit" value="Go"  name="search">
</form>