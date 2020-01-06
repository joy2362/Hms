<?php
include('database.php');
$db=new Database();
$aid=$_POST['aid'];
$number=count($_POST["mname"]);
if ($number >0) {
	for ($i=0; $i <$number ; $i++) { 
		if (trim($_POST["mname"][$i])!="") {
			$mname=$_POST["mname"][$i];
			$day=$_POST["day"][$i];
			$pattern=$_POST["pattern"][$i];
			try {
				$sql="insert into medicine (mname,days,pattern,Appoinment_id) values ('$mname','$day','$pattern','$aid')";
				$query = $db->conn->prepare($sql);
      			$query->execute();  
				
			} catch (PDException $e) {
				die("somthing wrong ".$e->getMessage());
			}
		}
		echo "insert successfully!!!";
	}

}else{
	echo "enter name";
}
?>