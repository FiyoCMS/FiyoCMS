<?php
/**
* @version		2.0
* @package		Fiyo Contact
* @copyright	Copyright (C) 2014 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.txt
* @description	
**/

defined('_FINDEX_') or die('Access Denied');

$view = app_param('view');
$app = app_param('app');

echo "<div id='contact'>";
switch($view)
{
	default :
		require("view/office.php");
	break;
	case 'group':		
		require("view/group.php");
	break;
	case 'person':		
		require("view/personal.php");
	break;
	
}
echo "</div>";
?>