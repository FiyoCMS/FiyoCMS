<?php 
/**
* version   2.5
* package   Fiyo CMS
* copyright Copyright (C) 2012 Fiyo CMS.
* license   GNU/GPL, see LICENSE.txt
**/

/*
* Define database variables
*/ 
define('FDBUser', $DBUser);
define('FDBPass', $DBPass);
define('FDBHost', $DBHost);
define('FDBName', $DBName);
define('FDBPrefix', $DBPrefix);

class FQuery {
    private static $db_host = FDBHost;       // Database Host
    private static $db_user = FDBUser;       // Username
    private static $db_pass = FDBPass;       // Password
    private static $db_name = FDBName; 
        
    public static $db   = false;            // Cek untuk melihat apakah sambungan aktif
    public $result = null;           // Cek untuk melihat apakah sambungan aktif
    public static $last_query;              // Database

    public function connect()
    {        
        static $conn = false;
        if(!$conn) { 
                try{
                        $options = array(
                        PDO::ATTR_PERSISTENT    => false,
                        PDO::ATTR_ERRMODE       => PDO::ERRMODE_EXCEPTION);
                        self::$db = $conn = new PDO("mysql:host=".self::$db_host.";dbname=".self::$db_name.";charset=utf8",self::$db_user, self::$db_pass, $options);
                }
                catch(PDOException $e){				
        alert('error','Unable to connect database!',true,true);
                }
        } else self::$db = $conn;		
    }

    /*
    * Mengolah seluruh query
	* Membuat sebuah definisi singkat query
    */
	public static function query($query, $fetch = false, $error = true){
		static $cons = false;		
		try{
			$result = self::connect();       
			$result = self::$db->prepare($query);
			$result ->execute();
			if($fetch)
				return $result->fetchAll(PDO::FETCH_ASSOC);
			else	
				return $result;
		}
		catch(PDOException $e){
			if(!$cons AND $error) {
				return false;			
				$cons = true;
			}
		}
              self::$last_query = $query;
	}
	
    /*
    * Cek apakah tabel setting ada
	* Sebelum melakukan query lanjutan
    */
    public static function tableExists($table)
    {
		$result = self::query('SHOW TABLES FROM '.self::$db_name.' LIKE "'.$table.'"');
        if($result)
        {
            if(count($result))
            {
                return true;
            }
            else
            {
                return false;
            }
        }
    }
    /*
    * Query select sederhana
    */	
	public static function select($table, $rows = '*', $where = null, $order = null, $limit = null){	
		$sql = 'SELECT '.$rows.' FROM '.$table;
		
        if($where != null)
            $sql .= ' WHERE '.$where;
        if($order != null)
            $sql .= ' ORDER BY '.$order;	
        if($limit != null)
            $sql .= ' LIMIT '.$limit;	
		self::$last_query = $sql;
		static $cons = false;
		try{
			$result = self::connect();       
			$result = self::$db->prepare($sql);
			$result ->execute();
			return $result->fetchAll(PDO::FETCH_ASSOC);
		}
		catch(PDOException $e){if(!$cons) {				
			return false;
			$cons = true;
			}
		}
	}
	
	
	
    /*
    * Insert values into the table
    * Required: table (the name of the table)
    *           values (the values to be inserted)
    * Optional: rows (if values don't match the number of rows)
    */
        
    public static function insert($table,$values,$rows = null)
    {
        $insert = 'INSERT INTO '.$table;
        
        if(isset($values[0])) {
            for($i = 0; $i < count($values); $i++)
            {
                if(is_string($values[$i]))
                    $values[$i] = '"'.$values[$i].'"';
            }
        } else {
            $rows = array_keys($values);
            foreach ($rows as $k => $r)
                $rows[$k] = '`'.$r.'`';
            $rows = implode(',',$rows);
            $insert .= ' ('.$rows. ')';
        }
        foreach ($values as $k => $r)  
           if(strpos('"',$r) === 0  AND strpos("'",$r) === 0)
               $values[$k] = "'".$r."'";
        
        $values = implode(',',$values);
        $insert .= ' VALUES ('.$values.')';
		self::$last_query = $insert;	
		static $cons = false;
		try{
			$result = self::connect();       
			$result = self::$db->prepare($insert);
			$query = $result ->execute();
        }
		catch(PDOException $e){
			if(!$cons) {				
				return false;		
			    $cons = true;
			}
		}
        
		if($query)
        {
            return true;
        } else
        {
            return false;
        }
    }

    /*
    * Deletes table or records where condition is true
    * Required: table (the name of the table)
    * Optional: where (condition [column =  value])
    */
    public static function delete($table,$where = null)
    {
        if($where == null)
            {
            $delete = 'DELETE FROM '.$table;
        }
        else
        {
            $delete = 'DELETE FROM '.$table.' WHERE '.$where;
        }
			
		self::$last_query =  $delete ;	
		static $cons = false;
		try{
			$result = self::connect();       
			$result = self::$db->prepare($delete);
			$query = $result ->execute();
        }
		catch(PDOException $e){
			if(!$cons) {				
                return false;
			    $cons = true;
			}
		}
        
        if(isset($query))
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    /*
     * Updates the database with the values sent
     * Required: table (the name of the table to be updated
     *           rows (the rows/values in a key/value array
     *           where (the row/condition in an array (row,condition) )
     */
    public static function update($table,$rows,$where)
    {
        $update = 'UPDATE '.$table.' SET ';
        $keys = array_keys($rows);
		
        for($i = 0; $i < count($rows); $i++){
            if(is_string($rows[$keys[$i]]) AND $rows[$keys[$i]] !== '+hits')
            {
                $update .= '`'.$keys[$i].'`="'.$rows[$keys[$i]].'"';
            }
            else
            {
				if($rows[$keys[$i]] == '+hits') $rows[$keys[$i]] = $keys[$i] . '+'. 1;
                 $update .= '`'.$keys[$i].'`='.$rows[$keys[$i]];
            }

            // Parse to add commas
            if($i != count($rows)-1)
            {
                $update .= ',';
            }
        }
			
            $update .= ' WHERE '.$where;
          self::$last_query =   $update ;
            
	static $cons = false;
	try{
			$result = self::connect();       
			$result = self::$db->prepare($update);
			$query = $result ->execute();
        }
	catch(PDOException $e){
			if(!$cons) {				
                return false;
			    $cons = true;
			}
	}
		
        if(isset($query))
        {
            return true;
        }
        else
        {
            return false;
        }
    }
}

class DB extends \FQuery {   
}

