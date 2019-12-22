<?php

class Update {
	
	private $db;
	
	public function __construct(){
		$this->db =new Database();
	}

	public function updateNurse($id){
		try {
			$sql="update nurse set status='work' where Nurse_id=$id"
			$query = $db->conn->prepare($sql);
        	$query->execute();
			
		} catch (PDOException $e) {
			die("somthing wrong " .$e->getMessage());
		}

	}
}

?>