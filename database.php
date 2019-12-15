<?php

class Database{
	//create variable with db info
	private  $host = "localhost";
	private  $dbuser = "root";
	private  $dbpassword = "";
	private  $db = "hospital_management";

	public $conn;

	//connect to database
	public function __construct(){
		if (!isset($this->conn)) {
			try{
				$this->conn = new PDO("mysql:host=".$this->host.";dbname=".$this->db,$this->dbuser,$this->dbpassword);
				$this->conn ->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$this->conn->exec("SET CHARACTER SET utf8");
			}catch(PDOException $e){
				die("database not connect ".$e->getMessage());
			}
			
		}
	}
}
?>

