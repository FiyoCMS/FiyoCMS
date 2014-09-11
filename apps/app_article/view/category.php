<?php
/**
* @version		2.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2014 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.
**/

defined('_FINDEX_') or die('Access Denied');

$cat_id	= app_param('id');
if(categoryInfo('name', $cat_id)) {
	$article = new Article;
	$article -> category('category',$cat_id,$format);
	require	("apps/app_article/view/format/$format.php");
}
else {
	echo _404_;
}