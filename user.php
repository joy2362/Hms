<?php

class User 
{
	private $db;
	
	public function __construct(){
		$this->db =new Database();
	}

	public function userReg($data){
		//assign form data in variables
		$username = $data['uname'];
		$fullname = $data['fname'];
		$password = md5($data['pass']);
		//$repass = md5($data['repass']);
		$address =$data['address'];
		$age = $data['age']; 
		$gender = $data['gender']; 
		$phone = $data['phone'];
		$email = $data['email'];
		$pic = $_FILES['myfile']['name'];
		$user_type=$data['user_type'];

		//check user name 
		$userCheck=$this->checkUsername($username);

		//send error message 
		if($userCheck==1){
			return "1";
		}

		#store the information and complete registation
		try{
			$sql = "insert into user (uname,password,user_type) values ('$username','$password','$user_type')";
			$query = $this->db->conn->prepare($sql);

			//$query->bindValue(':id',$id);
			//$query->bindValue(':uname',$username, PDO::PARAM_STR);
			//$query->bindValue(':Pass',$password, PDO::PARAM_STR);
			$result=$query->execute();

			//get user id
			$user_id= $this->db->conn->lastInsertId('$username');
			if($result){
				//set profile picture if user not set then set default profile pic 
				if ($pic == "") {			
					if ($gender == "male") {
						$folder="profile_picture/male.png";
					}else{
						$folder="profile_picture/female.png";
					}
				}else{
					$temp_name= $_FILES["myfile"]["tmp_name"];
					$folder="profile_picture/".$pic;
					move_uploaded_file($temp_name, $folder);			
				}							
				try {
					//store user basic information in user_info table
					$sql = "insert into user_info (full_name,email,gender,propic,age,address,phone,user_id) values ('$fullname','$email','$gender','$folder','$age','$address','$phone','$user_id')";

					$query = $this->db->conn->prepare($sql);
					$com=$query->execute();
					//if data store then show success message
					if ($com) {
						return "2";
					}
					//handle exception error
				} catch (PDOException $e) {
					die("somthing wrong " .$e->getMessage());
				}
				
			}else{
				return "1";
			}
			//handle exception error
		}catch(PDOException $e){
			die("somthing wrong " .$e->getMessage());
		}
	}
	//check username exist or not
	private function checkUsername($user){
		try {
			$sql="select uname from user where uname=:username";
			$query = $this->db->conn->prepare($sql);
			$query->bindValue(':username',$user);
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


	public function userLog($data){
		//assign form data in variable
		$username = $data['uname'];
		$password= md5($data['pass']);
		if ($username == "" && $data['pass'] == "") {
			return "4";
		}elseif ($username == "") {
			return "1";
		}elseif ($data['pass'] == "") {
			return "2";
		}
		//match username and password with database 
		try {
			$sql="select * from user where uname=:username and password=:password";
			$query = $this->db->conn->prepare($sql);
			$query->bindValue(':username',$username);
			$query->bindValue(':password',$password);
			$query->execute();
			if($query->rowCount()==1){
				//if match then start seassion
				$result=$query->fetch(PDO::FETCH_ASSOC);
				Session::init();
				Session::set("login",1);
				Session::set("id" , $result['user_id']);
				Session::set("type" , $result['user_type']);
				
					//redirect to profile
					header('location:'.$result['user_type'].'_profile.php');
								
			 //if user or password not match then show error
			}else{
				return "3";
			}	
			//handle exception error
		} catch (PDOException $e) {
			die("somthing wrong " .$e->getMessage());
		}
	}
}
?>