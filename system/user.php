<?php 
/**
* @version		2.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2012 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.txt
**/

defined('_FINDEX_') or die('Access Denied');
/***********************************************/
/*		  User Constants               */
/***********************************************/
Class User extends DB{
    var $id; 
    var $user; 
    var $email; 
    var $level; 
    var $name;
    static $logged_id = false;
    
    function __construct($uid = null) {
        if (!empty($uid)) {
            $this->id = $uid;
        }
    }    
    
    function register() {
        return $this->logged_id;
    }
    
    function login($user, $password) {
        if (!empty(!$user) AND ! empty($password)) {
            $this->logged_id = true;
        }
    }
     
    
    function logged_id() {
        return $this->logged_id;
    } 
    
    function logout() {
        return $this->logged_id;
    }
    
    function activation($code) {
        if (!empty(!$code)) {
            $this->logged_id = true;
        }
    }
    function forgot($email) {
        if (!empty(!$email)) {
            $this->logged_id = true;
        }
    }
        
    function reset($code) {
        if (!empty(!$code)) {
            $this->logged_id = true;
        }
    }  
   
}

if(empty($_SESSION['USER_LEVEL']) or $_SESSION['USER_LEVEL'] == 0 or $_SESSION['USER_LEVEL'] == 99) {
	$_SESSION['USER_LEVEL']  = 99;
	$_SESSION['USER']  = null;
	$_SESSION['USER_ID']  = null;
	$_SESSION['USER_NAME']  = null;
	$_SESSION['USER_EMAIL']  = null;
}

// user defined
define('USER', $_SESSION['USER']); 
define('USER_ID', $_SESSION['USER_ID']);
define('USER_NAME', $_SESSION['USER_NAME']);
define('USER_LEVEL',$_SESSION['USER_LEVEL']);
define('USER_EMAIL', $_SESSION['USER_EMAIL']);

// Quick sql access level
define('Level_Access',"AND level >= ".USER_LEVEL);
define('SQL_USER_LEVEL',"level >= ".USER_LEVEL);

