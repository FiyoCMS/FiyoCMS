<?php
/** This file is part of KCFinder project
  *
  *      @desc Browser calling script
  *   @package KCFinder
  *   @version 2.51
  *    @author Pavel Tzonkov <pavelc@users.sourceforge.net>
  * @copyright 2010, 2011 KCFinder Project
  *   @license http://www.opensource.org/licenses/gpl-2.0.php GPLv2
  *   @license http://www.opensource.org/licenses/lgpl-2.1.php LGPLv2
  *      @link http://kcfinder.sunhater.com
  */
  
session_start();
if(!empty($_SESSION['USER_ID']) AND $_SESSION['USER_LEVEL'] <= 3) { 

	$c =  dirname(dirname(dirname($_SERVER["PHP_SELF"])));
	if($c == '\\') $c = str_ireplace("\\","",$c);
	$_SERVER["HTTP_HOST"] = "//".$c;
	if(strlen($c) > 1) $c = "$c/"; 
	$_SESSION['media_root'] = $c;

	require "core/autoload.php";
	$browser = new browser();
	$browser->action();
} 
else header("location:../../");
?>