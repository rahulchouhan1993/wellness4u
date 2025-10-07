<?php 
//global $link;
class mysqlConnection
{
	var $host, $dbuser, $dbpass, $db, $DBH ,$STH;
	
	function __construct() 
	{
        global $db,$dbuser,$dbpass,$dbhost;
        $this->host = 'localhost';
        $this->dbuser = 'root';
        $this->dbpass = '';
        $this->db = 'wellness';
    }

    function connect() 
	{
        if ($this->DBH != null)
            return;
        try {
            $this->DBH = new PDO("mysql:host=$this->host;dbname=$this->db", $this->dbuser, $this->dbpass);
            $this->DBH->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            throw $e;
        }
    }
    
	function query($sql)
	{
        $this->connect();
        if ($this->DBH == null)
            throw new Exception("Database connection error");
        try {
            $STH=$this->DBH->prepare($sql);
            $STH->execute();
            return $STH;
        } catch (Exception $e) {
            throw $e;
        }
    }
    
	function execute($sql,$params)
	{
        $this->connect();
        if ($this->DBH == null) 
		{
            throw new Exception("Database connection error");
        }
        try {
            $STH=$this->DBH->prepare($sql);
            $STH->execute($params);  
            return $STH;
        } catch (Exception $e) {
            throw $e;
        }
    }
    
    function raw_handle()
	{
        $this->connect();
        if ($this->DBH == null) 
		{
            throw new Exception("Database connection error");
        }
        return $this->DBH;
    }

    function disconnect() 
	{
        $this->DBH = null;
    }
}
/*
global $link;

$link = mysql_connect(DB_HOST, DB_USERNAME, DB_PASSWORD);
if(!$link) 
{
    die('Could not connect: ' . mysql_error());
}

$db_selected = mysql_select_db(DB_NAME, $link);
if (!$db_selected) 
{
    die ('Can\'t use DB : ' . mysql_error());
}
*/
?>