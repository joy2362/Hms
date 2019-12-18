<?php

class Blog{
	private $db;
	
	public function __construct(){
		$this->db =new Database();
	}
	public function numberOfBlog(){
		try {
			$query = $this->db->conn->prepare("select * from blog");
			$query->execute();
			return $query->rowCount();	
		} catch (PDOException $e) {
			die("Somthing wrong".$e->getMessage());
		}
		
	}
}
?>