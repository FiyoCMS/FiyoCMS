<?php
/** 
 * Adds a custom validation rule using a callback function.
 * @version	2.5 / 3.0
 * @package	Fiyo CMS
 * @copyright	Copyright (C) 2016 Fiyo CMS.
 * @license	GNU/GPL, see LICENSE.
 */

include_once 'libs/gump.class.php';

class Input extends GUMP {
    
    static public function get($var,$strip = true) { 
        if(isset($_GET[$var]))   {
            $get = $_GET[$var];
            if(is_array($get) or is_object($get))
                return $get;
            else if ($strip !== true AND $strip !== false) {  
                return $strip($get, ENT_QUOTES);
            }
            else if ($strip === true) {
                return strip_tags($get);
            } else {
                return $get;
            }
        }
        else 
            return false;
    }  
   
    static public function post($var, $strip = true) {
        if(isset($_POST[$var]))   {
            $post = $_POST[$var];
             if(is_array($post) or is_object($post))
                return $post;
            else if ($strip !== true AND $strip !== false) {   
                return $strip($post, ENT_QUOTES);
            }
            if($strip) 
                return strip_tags($post);
            else 
                return $post;
        }
        else 
            return false;
    }
    
    static public function session($var, $strip = true) {
        if(isset($_SESSION[$var]))   {
            $sess = $_SESSION[$var];
            if(is_array($sess) or is_object($sess))
                return $sess;
            else if ($strip !== true AND $strip !== false) {      
                return $strip($sess, ENT_QUOTES);
            }
            if($strip)
                return strip_tags ($post);
            else 
                return $post;
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
