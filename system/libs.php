<?php 
/**
* @version		2.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2014 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.txt
**/

/*
* Define database variables
*/ 

class FData extends FQuery {
	public $res;
    private function conf()
    {
		$sql = $this -> select(FDBPrefix."setting","name, value");				
		$val = null;
		while($row=mysql_fetch_row($sql))
			$val[$row[0]] = $row[1];
		if(!empty($type))
		return $val[$type];
		else
		return $val;
    }
	
	public function Config() {
		static $flag ;
		static $result ;
		// Function has already run
		if ( $flag === null ) {
			$flag = true;
			$result = $this -> conf();		
		}
		return $result;
	}
	
}
