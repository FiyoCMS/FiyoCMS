<?php
/*
 * Website http://www.codehelper.io
 * Author: khoaofgod@yahoo.com
 * Any bugs, question, please visit our forum at http://www.codehelper.io
 */

class ip_codehelper {
    public function getRealIP() {
        $ipaddress = '';
        if(isset($_SERVER['HTTP_CF_CONNECTING_IP'])) {
            $ipaddress =  $_SERVER['HTTP_CF_CONNECTING_IP'];
        } else if (isset($_SERVER['HTTP_X_REAL_IP'])) {
            $ipaddress = $_SERVER['HTTP_X_REAL_IP'];
        }
        else if (isset($_SERVER['HTTP_CLIENT_IP']))
            $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
        else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        else if(isset($_SERVER['HTTP_X_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
        else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
        else if(isset($_SERVER['HTTP_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_FORWARDED'];
        else if(isset($_SERVER['REMOTE_ADDR']))
            $ipaddress = $_SERVER['REMOTE_ADDR'];
        else
            $ipaddress = 'UNKNOWN';

        return $ipaddress;
    }

    public function getLocation($ip="") {
        if($ip == "") {
            $ip = $this->getRealIP();
        }
        if(!class_exists("phpFastCache")) {
            die("<div style='border: 2px solid #09f; font-size: .8em; font-family: Arial;background: #FCF0F0;border: 2px solid #F07272;padding: 10px;'>Please enable plugin <b>Cache</b> to run plugin <b>Statistic</b>!</div>");
        }
        // you should change this to cURL()
        $data = phpFastCache::get("codehelper_ip_".md5($ip));
        // caching 1 week
        if($data == null) {
			$ctx=stream_context_create(array('http'=>
				array(
					'timeout' => 0.5 
				)
			));
            $url = "http://api.codehelper.io/ips/?phpip=".$ip;
            $json = file_get_html($url);
            $data = json_decode($json,true);
            phpFastCache::set("codehelper_ip_".md5($ip),$data,3600*24*7);
        }

        return $data;
    }

    public function SSLForwardJS() {
        $ip = $this->getRealIP();
        if(!class_exists("phpFastCache")) {
            die("<div style='border: 2px solid #09f; font-size: .8em; font-family: Arial;background: #FCF0F0;border: 2px solid #F07272;padding: 10px;'>Please enable plugin <b>Cache</b> to run plugin <b>Statistic</b>!</div>");
        }

        // you should change this to cURL()
        $data = phpFastCache::get("codehelper_ip_ssl".md5($ip));
        // caching 1 week
        if($data == null) {
			$ctx=stream_context_create(array('http'=>
				array(
					'timeout' => 0.5 
				)
			));
            $url = "http://api.codehelper.io/ips/?callback=codehelper_ip_callback&ip=".$ip;
            $json = file_get_html($url);
            phpFastCache::set("codehelper_ip_ssl".md5($ip),$data,3600*24*7);
        }
        return $data;
    }
}