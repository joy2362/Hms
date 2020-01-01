<?php
	include('database.php');
	$db=new Database();
	try {
		$sql="SELECT payment.*, user_info.* FROM payment INNER JOIN user_info ON payment.phone=user_info.phone";
		$query=$db->conn->prepare($sql);
		$query->execute();
		$result=$query->fetch(PDO::FETCH_ASSOC);		
	} catch (PDOException $e) {
		die($e->getMessage());
	}
	echo $result['amount'];
	echo $result['phone'];
	try {
		$sql="SELECT SUM(amount)as amount FROM payment ";
		$query=$db->conn->prepare($sql);
		$query->execute();
		$result=$query->fetch(PDO::FETCH_ASSOC);		
	} catch (PDOException $e) {
		die($e->getMessage());
	}
	echo "this". $result['amount'];

?>