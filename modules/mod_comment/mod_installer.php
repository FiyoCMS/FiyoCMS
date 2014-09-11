<?php
/**
* @version		v.1.2.3
* @package		Fi Comments
* @copyright	Copyright (C) 2012 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.txt
* @description	
**/

$module_info='<img src="../modules/mod_comment/style/img/logo.png" align="left" /><h1>Fi Comments successfuly installed</h1>Fi-Comment dapat membantu anda untuk mengetahui komentar terakhir di wabsite.<br>Anda bisa mengaktifkan dan melakukan konfigurasi melaui <a href="?app=module" class="link">Module Manager</a>';
$module_info .= "<br>Instaler information : <i> ";
if(com_query('comment')) $module_info .= "Apps Fi-Comment Instaled</i>";
else  $$module_info .= "Plase install Fi-Comment to use this module</i>";
?>