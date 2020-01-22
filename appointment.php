<?php
include_once 'database.php';
include('session.php');
include('appointmentHandler.php');
$appointment = new Appointment();
$db=new Database();

Session::init();
$id=Session::get("id");
$type=Session::get("type");
if (isset($_GET['doctor'])) {
  $doctor=$_GET['doctor'];
  try {
   $query = $db->conn->prepare("select * from doctor_info where doctor_name ='$doctor'");
    $query->execute();
    $doctorInfo=$query->fetch(PDO::FETCH_ASSOC);
  
} catch (PDOException $e) {
    die("Somthing is wrong " . $e->getMessage());
}
}else{
	header('location:doctor.php');
}
//this is logout
if (isset($_GET['action']) && $_GET['action']=="logout") {
  $session->destroy();
}

try {
   $query = $db->conn->prepare("select * from user_info where user_id='$id'");
    $query->execute();
    $result=$query->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Somthing is wrong " . $e->getMessage());
}
if($type=='normal'){
	if(isset($_POST['appointment'] ) && $_SERVER['REQUEST_METHOD'] === 'POST'){
  	$confirm = $appointment->setAppointment($_POST);
}
}
 
if($type=='hr'){
	if(isset($_POST['emergency'] ) && $_SERVER['REQUEST_METHOD'] === 'POST'){
	  $confirm = $appointment->emergency($_POST);
	}
}
if(!isset($_POST['type'])){
	if(isset($_POST['emergency'] ) && $_SERVER['REQUEST_METHOD'] === 'POST'){
  		$confirm = $appointment->emergency($_POST);
	}
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Dr.care</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <link href="https://fonts.googleapis.com/css?family=Work+Sans:100,200,300,400,500,600,700,800,900" rel="stylesheet">

    <link rel="stylesheet" href="css/open-iconic-bootstrap.min.css">
    <link rel="stylesheet" href="css/animate.css">
    
    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <link rel="stylesheet" href="css/owl.theme.default.min.css">
    <link rel="stylesheet" href="css/magnific-popup.css">

    <link rel="stylesheet" href="css/aos.css">

    <link rel="stylesheet" href="css/ionicons.min.css">

    <link rel="stylesheet" href="css/bootstrap-datepicker.css">
    <link rel="stylesheet" href="css/jquery.timepicker.css">

    
    <link rel="stylesheet" href="css/flaticon.css">
    <link rel="stylesheet" href="css/icomoon.css">
    <link rel="stylesheet" href="css/style.css">
  </head>
  <body>
   <?php
    include 'topHeader.php';
    ?>
	 <?php
	 include 'navbar.php';
	?>
    <!-- END nav -->
    
    <section class="hero-wrap hero-wrap-2" style="background-image: url('images/bg_1.jpg');" data-stellar-background-ratio="0.5">
      <div class="overlay"></div>
      <div class="container">
        <div class="row no-gutters slider-text align-items-center justify-content-center">
          <div class="col-md-9 ftco-animate text-center">
            <h1 class="mb-2 bread">Appointment</h1>
            <p class="breadcrumbs"><span class="mr-2"><a href="index.html">Home <i class="ion-ios-arrow-forward"></i></a></span> <span>Appointment <i class="ion-ios-arrow-forward"></i></span></p>
          </div>
        </div>
      </div>
    </section>
  				
		<section class="ftco-section ftco-no-pt ftco-no-pb ftco-counter img" id="section-counter" style="background-image: url(images/bg_3.jpg);" data-stellar-background-ratio="0.5">
    	<div class="container">
    		<div class="row">
    			<div class="col-md-6 py-5 pr-md-5">
	          <div class="heading-section heading-section-white ftco-animate mb-5">
	          	<span class="subheading">Consultation</span>
	            <h2 class="mb-4">Free Consultation</h2>
	            <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.</p>
	          </div>
            <?php
              if (isset($confirm)) {
              	?>
                <div class="message" data-flashdata="<?php echo $confirm;?>"></div> 
                <?php
              }
              if ($type == 'normal') {
              	?>
              	<form action="" class="appointment-form ftco-animate" method="post">
	    				<div class="d-md-flex">
		    				<div class="form-group">
		    					<input type="text" class="form-control" name="fname" value="<?php echo $result['full_name']?>" >
		    				</div>
		    				<div class="form-group ml-md-4">
		    					<input type="text" class="form-control" name="email"  value="<?php echo $result['email']?>" >
		    				</div>
	    				</div>
	    				<div class="d-md-flex">
	    					<div class="form-group ">
                  <input type="text" class="form-control" name="phone" value="<?php echo $result['phone']?>" >
                </div>
				<div class="form-group ml-md-4">
					<input type="text" class="form-control" name="gender"  value="<?php echo $result['gender']?>" >
				</div>
			</div>
              <div class="d-md-flex">
                <div class="form-group">
                  <input type="text" class="form-control" name="doctorName" value="<?php echo $doctorInfo['doctor_name']?>" >
                </div>
                <div class="form-group ml-md-4">
                  <input type="text" class="form-control" name="department" value="<?php echo $doctorInfo['department']?>">
                </div>
              </div>
	    		<div class="d-md-flex">
		    		<div class="form-group">
		    			<div class="input-wrap">
		    				<div class="icon"><span class="ion-md-calendar"></span></div>
		            		<input type="text" class="form-control appointment_date" name="appointmentDate" value="<?php echo date("Y-m-d");?>" >
		    				<!--            		
		            		<input type="date" class="form-control"  name="appointmentDate"
      						 value="<?php //echo date("Y-m-d");?>"
       						min="date('m-01-Y')" >
       					-->
	            		</div>
		    				</div>
		    				<div class="form-group ml-md-4">
		    					<div class="input-wrap">
		            		<div class="icon"><span class="ion-ios-clock"></span></div>
		            		<input type="text" name="appointmentTime" class="form-control appointment_time" placeholder="Time">
	            		</div>
		    				</div>
	    				</div>
	    				<div class="d-md-flex">
	    					<div class="form-group">
		              <textarea  cols="30" rows="2" name="Prob" class="form-control" placeholder="Problem"></textarea>
		            </div>

                <input type="hidden" name="status" value="pending">
                <input type="hidden" name="user_id" value="<?php echo $result['user_info_id']?>">

		            <div class="form-group ml-md-4">
		              <input type="submit" name="appointment" class="btn btn-secondary py-3 px-4">
		            </div>
	    				</div>
	    			</form>
              <?php
              }else{
              	?>
				<form action="" class="appointment-form ftco-animate" method="post">
	    			<div class="d-md-flex">
		    			<div class="form-group">
		    				<input type="text" class="form-control" name="fname" placeholder="Full name">
		    			</div>	
	    			</div>
	    				<div class="d-md-flex">
	    					<div class="form-group ">
                  <input type="text" class="form-control" name="phone" placeholder="Phone"> 
                </div>
	    					<div class="form-group ml-md-4">
		    					<input type="text" class="form-control" name="gender" placeholder="Gender" >
		    				</div>
	    				</div>
              <div class="d-md-flex">
                <div class="form-group">
                  <input type="text" class="form-control" name="doctorName" value="<?php echo $doctorInfo['doctor_name']?>" >
                </div>
                <div class="form-group ml-md-4">
                  <input type="text" class="form-control" name="department" value="<?php echo $doctorInfo['department']?>">
                </div>
              </div>
	    		<div class="d-md-flex">
		    		<div class="form-group">
		    			<div class="input-wrap">
		            		<div class="icon"><span class="ion-md-calendar"></span></div>
		            		<input type="text" class="form-control appointment_date" name="appointmentDate" value="<?php echo date("Y-m-d");?>" >
	            		</div>
		    				</div>
		    				<div class="form-group ml-md-4">
		    					<div class="input-wrap">
		            		<div class="icon"><span class="ion-ios-clock"></span></div>
		            		<input type="text" name="appointmentTime" class="form-control appointment_time" placeholder="Time">
	            		</div>
		    				</div>
	    				</div>
	    				<div class="d-md-flex">
	    					<div class="form-group">
		              <textarea  cols="30" rows="2" name="Prob" class="form-control" placeholder="Problem"></textarea>
		            </div>

               		 <input type="hidden" name="status" value="pending">
           	
		            <div class="form-group ml-md-4">
		              <input type="submit" name="emergency" class="btn btn-secondary py-3 px-4">
		            </div>
	    				</div>
	    			</form>
				<?php
              }
              ?>
	          


    			</div>
    			<div class="col-lg-6 p-5 bg-counter aside-stretch">
						<h3 class="vr">About Dr.Care Facts</h3>
    				<div class="row pt-4 mt-1">
		          <div class="col-md-6 d-flex justify-content-center counter-wrap ftco-animate">
		            <div class="block-18 p-5 bg-light">
		              <div class="text">
		                <strong class="number" data-number="30">0</strong>
		                <span>Years of Experienced</span>
		              </div>
		            </div>
		          </div>
		          <div class="col-md-6 d-flex justify-content-center counter-wrap ftco-animate">
		            <div class="block-18 p-5 bg-light">
		              <div class="text">
		                <strong class="number" data-number="4500">0</strong>
		                <span>Happy Patients</span>
		              </div>
		            </div>
		          </div>
		          <div class="col-md-6 d-flex justify-content-center counter-wrap ftco-animate">
		            <div class="block-18 p-5 bg-light">
		              <div class="text">
		                <strong class="number" data-number="84">0</strong>
		                <span>Number of Doctors</span>
		              </div>
		            </div>
		          </div>
		          <div class="col-md-6 d-flex justify-content-center counter-wrap ftco-animate">
		            <div class="block-18 p-5 bg-light">
		              <div class="text">
		                <strong class="number" data-number="300">0</strong>
		                <span>Number of Staffs</span>
		              </div>
		            </div>
		          </div>
	          </div>
          </div>
        </div>
    	</div>
    </section>

   
<?php
  include('footer.php');
?> 

  <!-- loader -->
  <div id="ftco-loader" class="show fullscreen"><svg class="circular" width="48px" height="48px"><circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke="#eeeeee"/><circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke-miterlimit="10" stroke="#F96D00"/></svg></div>

<?php
  include('javascriptLink.php');
?>
<script type="text/javascript">
	const flashdata=$('.message').data('flashdata');
		if (flashdata==1) {
  			swal("Error!", "Phone number already exist please log in frist", "error");
		}
		if (flashdata==0) {
  			swal("Sorry!", "Doctor name is not vailed", "error");
		}
		if (flashdata==2) {
  			swal("Success!", "Appointment Booked Successfully!!!", "success");
		}
		if (flashdata==3) {
  			swal("Error!", "Describe the problem frist!!!", "error");
		}
		if (flashdata==4) {
  			swal("Error!", "Select the time frist!!!", "error");
		}
</script>
  </body>
</html>