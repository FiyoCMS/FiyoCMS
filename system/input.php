<?php
/* 
 * @version	2.0
 * @package	Fiyo CMS
 * @copyright	Copyright (C) 2016 Fiyo CMS.
 * @license	GNU/GPL, see LICENSE.
 */


class Input  {
    static public function get($var,$strip = false) {
        if(isset($_GET[$var]))   {
            $get = $_GET[$var];
            if($strip) 
                return stripTags ($get);
            else 
                return $get;
        }
        else 
            return false;
    }  
    
    static public function post($var,$strip = false) {
        if(isset($_POST[$var]))   {
            $get = $_POST[$var];
            if($strip) 
                return stripTags ($get);
            else 
                return $get;
        }
        else 
            return false;
    } 
}


foreach($_GET as $key => $val) {
        if(isset($_GET[$key])){
         if(strpos($key,"entities"))
            $_GET[$key] = htmlentities($_GET[$key], ENT_QUOTES);
        else  if(strpos($key,"unstrip")  or count($_GET[$key]))
            $_GET[$key] = $_GET[$key];
        else
            $_GET[$key] = strip_tags($_GET[$key]);
    }
}

foreach($_POST as $key => $val) {
    if(isset($_POST[$key])){
        if(strpos($key,"entities"))
            $_POST[$key] = htmlentities($_POST[$key], ENT_QUOTES);
        else  if(strpos($key,"unstrip") or count($_POST[$key]))
         $_POST[$key] = $_POST[$key];
        else
            $_POST[$key] = strip_tags($_POST[$key]);
    }
}