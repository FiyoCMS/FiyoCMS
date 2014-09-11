<?php
/**
* @version		1.5.0
* @package		Related Article
* @copyright	Copyright (C) 2012 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.txt
**/

defined('_FINDEX_') or die('Access Denied');

$addons['name']		= 'Related Article';
$addons['type']		= 'modules';
$addons['folder'] 	= 'mod_article_related';

if(siteConfig('lang') == 'id') {
	$addons['info']		= '<img src="../modules/mod_article_related/theme/logo.png" align="left" /><h1>Modul Artikel Terkait berhasil diinstal.</h1>Modul ini membantu pengunjung website untuk menemukan artikel atau bacaan terkait.<br>Anda bisa mengaktifkan dan melakukan konfigurasi melaui <a href="?app=module" class="link">Module Manager</a>';
}
else {
	$addons['info']		= '<img src="../modules/mod_article_related/theme/logo.png" align="left" /><h1>Related Article successfuly installed</h1>This module help visitors to find related content ot article.<br>You can enable and configure through <a href="?app=module" class="link">Module Manager</a>';
}