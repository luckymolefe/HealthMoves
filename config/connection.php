<?php

/**
* Database connection script
* @return Object
* Description: initialize database connection then return connection Object.
*/

class DBConnect {
	//initialize DB connection settings
	private static  $host 	   = "localhost"; 	 // Host name 
	private static  $username = "webusers"; 		 // Mysql username 
	private static  $password = "edecobode"; 			 // Mysql password 
	private static  $db_name  = "healthymoves"; // Database name
	private static  $connect = null; 			//set connection variable to null

	private static function initConnection() {
		try {
			self::$connect = new PDO("mysql:host=".self::$host.";dbname=".self::$db_name, self::$username, self::$password); //initialize database connection
		}
		catch(PDOException $e) {
			echo "MYSQL_DB ERROR: ".$e->getMessage(); //throw any error message
		}
		return self::$connect;
	}

	public static function connect() {
		return self::$connect = self::initConnection(); //return connection
	}
}

if(class_exists('DBConnect')) {	//if class exist, 
	$dbObj = new DBConnect(); //then instantiate object class
	if(method_exists($dbObj, 'connect')) { //check if method exists
		$conn = $dbObj::connect(); //then call method
	}
}


?>