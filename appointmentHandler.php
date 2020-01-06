<?php

class Appointment 
{
	private $db;
	
	public function __construct(){
		$this->db =new Database();
	}

	public function setAppointment($data){
		//assign form data in variables
		$patientId = $data['user_id'];
		$patientName = $data['fname'];
		$patientPhone = $data['phone'];

		$doctorName = $data['doctorName'];
		$department = $data['department'];

		$appointmentDate = $data['appointmentDate'];
		$appointmentTime = $data['appointmentTime'];

		$problem = $data['Prob'];
		$status = $data['status'];
		//check problem if empty or not
		if ($problem =="" ) {
			return "3";
		}
		if ($appointmentTime =="" ) {
			return "4";
		}
		//check doctor name  & time
		$doctorValidation=$this->doctorValidation($doctorName,$department);
		if($doctorValidation==0){
			return "0";
		}
		$timecheck=$this->checkappointmentTime($appointmentTime,$appointmentDate,$doctorValidation);

		//send error message 
		if($timecheck==1){
			return "<div class=\"alert alert-danger\"><strong>Error </strong> Time already taken!!!</div>";
		}
		
		#store the information and complete registation
		try{
			$sql = "insert into appointment 
			(
				patient_name , Phone , Doctor_info_id , Problem , time	, date , status , user_info_id
			)
			values
			(
				'$patientName','$patientPhone','$doctorValidation','$problem','$appointmentTime' , '$appointmentDate','$status' ,'$patientId'
			  
			)";
			$query = $this->db->conn->prepare($sql);
			$result=$query->execute();
			return "2";
			//handle exception error
		}catch(PDOException $e){
			die("somthing wrong " .$e->getMessage());
		}
	}
	//check time booked or not
	private function checkappointmentTime($time, $date,$docId){
		try {
			$sql="select * from appointment where date='$date' and time='$time' and doctor_info_id='$docId'";
			$query = $this->db->conn->prepare($sql);
			$query->execute();
			if($query->rowCount()>0){
				return 1;
			}else{
				return 0;
			}	
			//handle exception error
		} catch (PDOException $e) {
			die("somthing wrong " .$e->getMessage());
		}
	}
	private function doctorValidation($name, $department){
		try {
			$sql="select * from doctor_info where doctor_name='$name' and department='$department'";
			$query = $this->db->conn->prepare($sql);
			$query->execute();
			if($query->rowCount()==1){
				$result = $query->fetch(PDO::FETCH_ASSOC);
				return $result['doctor_info_id'];
			}else{
				return 0;
			}	
			//handle exception error
		} catch (PDOException $e) {
			die("somthing wrong " .$e->getMessage());
		}
	}

	public function emergency($data){
		//assign form data in variables
		$patientName = $data['fname'];
		$patientPhone = $data['phone'];
		$gender = $data['gender'];

		$doctorName = $data['doctorName'];
		$department = $data['department'];

		$appointmentDate = $data['appointmentDate'];
		$appointmentTime = $data['appointmentTime'];

		$problem = $data['Prob'];
		$status = $data['status'];
		//number check
		$phoneValidation=$this->checkPhone($patientPhone);
		if ($phoneValidation==0) {
			//reg user
			$userReg=$this->userReg($patientPhone,$patientName,$gender);
			//doctor check
			$doctorValidation=$this->doctorValidation($doctorName, $department);
			if($doctorValidation==0){
			return "0";
		}else{
			try{
				$sql = "insert into appointment 
				(
					patient_name , Phone , Doctor_info_id , Problem , time	, date , status , user_info_id
				)
				values
				(
					'$patientName','$patientPhone','$doctorValidation','$problem','$appointmentTime' , '$appointmentDate','$status' ,'$userReg'
				  
				)";
			$query = $this->db->conn->prepare($sql);
			$result=$query->execute();
			return "2";
			//handle exception error
		}catch(PDOException $e){
			die("somthing wrong " .$e->getMessage());
		}
		}
			
		}else{
			return "1";
		}
	}
	//check phnoe number already exits or not
	private function checkPhone($phone){
		try {
			$sql="select * from user_info where phone='$phone'";
			$query = $this->db->conn->prepare($sql);
			$query->execute();
			if($query->rowCount()>0){
				return 1;
			}else{
				return 0;
			}	
			//handle exception error
		} catch (PDOException $e) {
			die("somthing wrong " .$e->getMessage());
		}
	}

	private function userReg($Phone,$Name,$gender){
		//use user phone number as password
		$password=md5($Phone);
		try{
			$sql = "insert into user (uname,password,user_type) values ('$Phone','$password','normal')";
			$query = $this->db->conn->prepare($sql);
			$result=$query->execute();
			$user_id= $this->db->conn->lastInsertId('$Phone');
			if ($gender == "male") {
				$folder="profile_picture/male.png";
			}else{
				$folder="profile_picture/female.png";
			}
			try {
				//store user basic information in user_info table
				$sql = "insert into user_info (full_name,gender,propic,phone,user_id) values ('$Name','$gender','$folder','$Phone','$user_id')";
				$query = $this->db->conn->prepare($sql);
				$com=$query->execute();
				$user_id= $this->db->conn->lastInsertId('$Phone');
				return $user_id;
				//handle exception error
			} catch (PDOException $e) {
					die("somthing wrong " .$e->getMessage());
			}
		}catch (PDOException $e) {
			die("somthing wrong " .$e->getMessage());
		}
}
}
?>