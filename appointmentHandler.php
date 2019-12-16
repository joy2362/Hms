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
			return "<div class=\"alert alert-danger\"><strong>Error </strong> Describe problem frist!!!</div>";
		}
		if ($appointmentTime =="" ) {
			return "<div class=\"alert alert-danger\"><strong>Error </strong> Choice the time first!!!</div>";
		}
		//check doctor name  & time
		$doctorValidation=$this->doctorValidation($doctorName,$department);
		$timecheck=$this->checkappointmentTime($appointmentTime,$appointmentDate);

		//send error message 
		if($timecheck==1){
			return "<div class=\"alert alert-danger\"><strong>Error </strong> Time already taken!!!</div>";
		}
		if($doctorValidation==0){
			return "<div class=\"alert alert-danger\"><strong>Error </strong> Doctor name not vailed!!!</div>";
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

			if($result){	
				return "<div class=\"alert alert-success\"><strong>Success </strong> Appointment Booked Successfully!!!</div>";
			}else{
				return "<div class=\"alert alert-warning\"><strong>Error </strong> Somthing wrong try again</div>";
			}
			//handle exception error
		}catch(PDOException $e){
			die("somthing wrong " .$e->getMessage());
		}
	}
	//check time booked or not
	private function checkappointmentTime($time, $date){
		try {
			$sql="select * from appointment where date='$date' and time='$time'";
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

}
?>