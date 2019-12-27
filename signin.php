<?php
include('session.php');
include('database.php');
include('user.php');

$user=new User();

if(isset($_POST['register'] ) && $_SERVER['REQUEST_METHOD'] === 'POST'){
	$user_Log=$user->userLog($_POST);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width , initial-scale=1">
	<title>Sign In</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
	<script src="https://kit.fontawesome.com/f717478b5d.js"></script>
	<link rel="stylesheet" type="text/css" href="css/signup_in.css">
</head>
<body>
	<div class="container-fluid">
		<?php
		if (isset($user_Log)) {
		?>
		<div class="message" data-flashdata="<?php echo $user_Log;?>"></div>
		<?php
		}
		?>
		<div class="row">
			<div class="col-sm-4"></div>
			<div class="col-sm-4 log_css">
				<h2 class="text-center">Sign in</h2>
				<form action="" method="POST" >
					<div class="form-group">
						<label for="uname">Username:</label>
						<input type="name" name="uname" class="form-control" id="uname">
					</div>
					<div class="form-group">
						<label for="pass">Password:</label>
						<input type="password" name="pass" class="form-control" id="pass">
					</div>
					<input type="Submit" class="btn btn-outline-primary" name="register" value="Sign In">
					<a href="#" id="forget"class="btn">Forget password</a>
					<a class="btn btn-danger float-right" href="reg.php">Sign up</a>		
				</form>
			</div>
			<div class="col-sm-4"></div>
		</div>
	</div>
	<script src="js/jquery.min.js"></script>
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
	<script type="text/javascript">
		$('#forget').on('click',function(){
			swal("Sorry!!", "This feature not available!", "error");
		})
		const flashdata=$('.message').data('flashdata');
		if (flashdata==1) {
  			swal("Error!", "Fill the username", "error");
		}
		if (flashdata==4) {
  			swal("Error!", "Fill the form first", "error");
		}
		if (flashdata==2) {
  			swal("Error!", "Fill the Password!", "error");
		}
		if (flashdata==3) {
  			swal("Error!", "Username or Password not match!", "error");
		}
	</script>
</body>
</html>