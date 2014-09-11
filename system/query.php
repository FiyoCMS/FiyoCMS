<?php 
/**
* @version		1.5.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2012 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.txt
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
    /*
     * Edit the following variables
     */ 
    private $db_host = FDBHost;       // Database Host
    private $db_user = FDBUser;       // Username
    private $db_pass = FDBPass;       // Password
    private $db_name = FDBName;       // Database
    /*
     * End edit
     */

    private $con = false;              // Cek untuk melihat apakah sambungan aktif
    private $result = array();         // Hasil yang dikembalikan dari query

    public function connect()
    {
        if(!$this->con)
        {
            $myconn = @mysql_connect($this->db_host,$this->db_user,$this->db_pass);
            if($myconn)
            {
                $seldb = @mysql_select_db($this->db_name,$myconn);
                if($seldb)
                {
                    $this->con = true;
                    return true;
                }
                else
                {
                    alert('error','Database name is invalid or not exists!',true);
					die();
                }
            }
            else
            {
                alert('error','Unable to connect database!',true);
				die();
            }
        }
        else
        {
            return true;
        }
    }

    /*
    * Set nama database awal
    */
    public function setDatabase($name)
    {
        if($this->con)
        {
            if(@mysql_close())
            {
                $this->con = false;
                $this->results = null;
                $this->db_name = $name;
                $this->connect();
            }
        }
    }

    /*
    * Cek untuk melihat apakah tabel ada ketika melakukan query
    */
    private function tableExists($table)
    {
        $tablesInDb = @mysql_query('SHOW TABLES FROM '.$this->db_name.' LIKE "'.$table.'"');
        if($tablesInDb)
        {
            if(mysql_num_rows($tablesInDb)==1)
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
    * Memilih informasi dari database.
    * Diperlukan: tabel (nama tabel)
    * Opsional: baris (kolom yang diminta, dipisahkan oleh koma)
    * Mana (kolom = nilai sebagai string)
    * Rangka (kolom ARAH sebagai string)
    */
	
	public function select($table, $rows = '*', $where = null, $order = null){	
		$sql = 'SELECT '.$rows.' FROM '.$table;
        if($where != null)
            $sql .= ' WHERE '.$where;
        if($order != null)
            $sql .= ' ORDER BY '.$order;
			
		$result=mysql_query($sql);
			
		return $result;
	}
	
    /*
    * Mengolah seluruh query
	* Membuat sebuah definisi singkat query
    */
	
	
	public function query($query){	
		$sql = $query;			
		$result=mysql_query($sql);			
		return $result;
	}
	
    /*
    * Insert values into the table
    * Required: table (the name of the table)
    *           values (the values to be inserted)
    * Optional: rows (if values don't match the number of rows)
    */
	
    public function insert($table,$values,$rows = null)
    {
        if($this->tableExists($table))
        {
            $insert = 'INSERT INTO '.$table;
            if($rows != null)
            {
                $insert .= ' ('.$rows.')';
            }

            for($i = 0; $i < count($values); $i++)
            {
                if(is_string($values[$i]))
                    $values[$i] = '"'.$values[$i].'"';
            }
            $values = implode(',',$values);
            $insert .= ' VALUES ('.$values.')';

            $ins = @mysql_query($insert);

            if($ins)
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
    * Deletes table or records where condition is true
    * Required: table (the name of the table)
    * Optional: where (condition [column =  value])
    */
    public function delete($table,$where = null)
    {
        if($this->tableExists($table))
        {
            if($where == null)
            {
                $delete = 'DELETE FROM '.$table;
            }
            else
            {
                $delete = 'DELETE FROM '.$table.' WHERE '.$where;
            }
            $del = @mysql_query($delete);

            if($del)
            {
                return true;
            }
            else
            {
                return false;
            }
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
    public function update($table,$rows,$where)
    {
        if($this->tableExists($table))
        {
            // Parse mana nilai-nilai
            // Bahkan nilai-nilai (termasuk 0) mengandung baris isi
            // Nilai ganjil mengandung klausul untuk setiap baris   

            $update = 'UPDATE '.$table.' SET ';
            $keys = array_keys($rows);
            for($i = 0; $i < count($rows); $i++)
            {
                if(is_string($rows[$keys[$i]]))
                {
                    $update .= $keys[$i].'="'.$rows[$keys[$i]].'"';
                }
                else
                {
                    $update .= $keys[$i].'='.$rows[$keys[$i]];
                }

                // Parse to add commas
                if($i != count($rows)-1)
                {
                    $update .= ',';
                }
            }
            $update .= ' WHERE '.$where;
            $query = @mysql_query($update);
            if($query)
            {
                return true;
            }
            else
            {
                return false;
            }
        }
        else
        {
            return false;
        }
    }

    /*
    * Returns the result set
    */
    public function getResult()
    {
        return $this->result;
    }
}
//auto database query	$db = new FQuery();  