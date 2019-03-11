<?php

require_once("db.php");

function secure_session_start() {
	$cookieParams=session_get_cookie_params();
	session_set_cookie_params($cookieParams["lifetime"], $cookieParams["path"], $cookieParams["domain"], false, true);
	session_start();
	session_regenerate_id();

}

class DBConnection {
	private $connection=false;
	private static $_instance=false;
	private $error=0;
	private $result=false;
	
	private $host;
	private $username;
	private $password;
	private $database;

	public static function connect($s1, $s2, $s3, $s4) {
		if(!self::$_instance) {
			
			self::$_instance = new self($s1,$s2,$s3,$s4);
		}
		
		return self::$_instance;
	}
	
	private function __construct($s1,$s2, $s3, $s4) {
			$this->host=$s1;
			$this->username=$s2;
			$this->password=$s3;
			$this->database=$s4;
			
		$this->connection = mysqli_connect($this->host, $this->username, 
			$this->password, $this->database);
	
		// Error handling
		if(mysqli_connect_error()) {
			$this->error=1;
		}
	}
	
	function error()
	{
	return $this->error;
	}

	function query($str="")
	{
		if($this->error)
			return;
		if(empty($str))
		return;
		if($this->connection==false)
			return;

		//echo $str;

		$this->result=mysqli_query($this->connection, $str);
		if($this->connection && $v=mysqli_errno($this->connection))
		{
		$this->error=$v;
		}
		
		
	}

	function result()
	{
	
	if($this->error==0)
	return $this->result;
	else
		echo $this->error;
	return false;
	}

	function link()	
	{
	return $this->connection;
	}

	function close()
	{	
		if($this->connection)
		mysqli_close($this->connection);
	}

}


?>