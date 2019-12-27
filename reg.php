<?php
include('database.php');
include('user.php');

$user=new User();

if(isset($_POST['register'] ) && $_SERVER['REQUEST_METHOD'] === 'POST'){
	$user_Reg=$user->userReg($_POST);
}
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Sign up</title>
	<!-- Mobile Specific Metas -->
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<!-- Font-->
	<link rel="stylesheet" type="text/css" href="css/montserrat-font.css">
	<link rel="stylesheet" type="text/css" href="fonts/material-design-iconic-font/css/material-design-iconic-font.min.css">
	<!--bootstarp-->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
	<!-- Main Style Css -->
    <link rel="stylesheet" href="css/style_reg.css"/>
</head>
<body class="form-v10">
	<div class="page-content">
		<div class="form-v10-content">
			<form class="form-detail" action="" method="post" id="myform" name="reg" onsubmit="return validation()" enctype="multipart/form-data">
				<div class="form-left">
					<h2>General Infomation</h2>
					<div class="form-row">
						<?php
						if (isset($user_Reg)) {
							?>
							 <div class="message" data-flashdata="<?php echo $user_Reg;?>"></div>
						<?php
						}
						?>
					</div>
					<div class="form-row">
						<input type="text" name="uname" id="uname" class="input-text" placeholder="User Name">
					</div>
					<div class="form-row">
						<input type="text" name="fname" id="fname" class="input-text" placeholder="Full Name" >
					</div>
				
					<div class="form-row">
						<input type="password" name="pass" id="pass" placeholder="Password" >
					</div>
					<div class="form-row">
						<input type="password" name="repass" id="repass" placeholder="Repeat Password" >
					</div>
					<div class="form-row">
					<div class="custom-file mb-3">
     	 				<input type="file" class="custom-file-input" id="customFile" name="myfile" accept="image/*">
     					 <label class="custom-file-label" for="customFile">Profile Picture</label>
   					 </div>
   					</div>

				</div>
				<div class="form-right">
					<h2>Contact Details</h2>
					<div class="form-row">
						<input type="text" name="address" class="address" id="address" placeholder="Address" >
					</div>
					<div class="form-row">
						<input type="text" name="age" class="age" id="age" placeholder="Age" >
					</div>
					<div class="form-row">
						<select name="gender">
						    <option value="gender">Gender</option>
						    <option value="male">Male</option>
						    <option value="female">Female</option>
						    <option value="other">other</option>
						</select>
						<span class="select-btn">
						  	<i class="zmdi zmdi-chevron-down"></i>
						</span>
					</div>
					<div class="form-row">
						<input type="tel" name="phone" pattern="01[0-9]{9}" class="phone" id="phone" placeholder="Phone Number" >
					</div>
					<div class="form-row">
						<input type="text" name="email" id="email" class="input-text" pattern="[^@]+@[^@]+.[a-zA-Z]{2,6}" placeholder="Email">
					</div>
					<div class="form-checkbox">
						<label class="container"><p>I do accept the <a href="#" class="text">Terms and Conditions</a></p>
						  	<input type="checkbox" name="checkbox" id="checkedTerm">
						  	<span class="checkmark"></span>
						</label>
					</div>
					<input type="hidden" name="user_type" value="normal">
					<div class="form-row-last">
						<input type="submit" name="register" class="register" value="Sign up">
					</div>
				</div>
			</form>
		</div>
	</div>
	<script type="text/javascript" src="js/validation.js"></script>
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
	<script>
		$(".custom-file-input").on("change", function() {
  		var fileName = $(this).val().split("\\").pop();
  		$(this).siblings(".custom-file-label").addClass("selected").html(fileName);
		});
		const flashdata=$('.message').data('flashdata');
		if (flashdata==1) {
  			swal("Error!", "Username already taken!", "error");
		}
		if (flashdata==2) {
  			swal("Success!", "Registation Complete!", "success");
		}
	</script>
</body>
</html>