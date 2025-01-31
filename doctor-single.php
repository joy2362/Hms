<?php
//include necessary file
include('database.php');
include('session.php');
//create database connection
$db=new Database();

class DoctorProfile{
  
  public function getDoctor($db,$id){
    try {
      $sql="select * from doctor_info where doctor_info_id='$id'";
        $query = $db->conn->prepare($sql);
        $query->execute();
        return $query->fetch(PDO::FETCH_ASSOC);
      } catch (PDOException $e) {
        die("somthing wrong".$e);
      }    
  }

  public function getAppointment($db,$id){
     try {
        $sql="select * from appointment where doctor_info_id='$id' and status='complete'";
        $query = $db->conn->prepare($sql);
        $query->execute();
        $result=$query->rowCount();
        return $result;
      } catch (PDOException $e) {
        die("somthing wrong".$e->getMessage());
      }
  }
  public function getOtherDocinfo($db,$department,$id){
    try {
      $sql="select * from doctor_info where department='$department' and doctor_info_id!='$id' order by doctor_info_id DESC LIMIT 3";
      $query = $db->conn->prepare($sql);
      $query->execute();
      return $query;
    } catch (PDOException $e) {
      die("somthing wrong " .$e->getMessage());
    }
  }

}
$profile = new DoctorProfile();
if (isset($_GET['id'])) {
  $id=$_GET['id'];
  $result=$profile->getDoctor($db,$id);
  $patient=$profile->getAppointment($db,$id);
}else{
  header('location:index.php');
}   

if (isset($_GET['action']) && $_GET['action']=="logout") {
  Session::destroy();
}    
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Dr.care </title>
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
    <link href="https://fonts.googleapis.com/css?family=Lora&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="css/flaticon.css">
    <link rel="stylesheet" href="css/icomoon.css">
    <link rel="stylesheet" href="css/style.css">    
    <style type="text/css">
      .details{
      font-family: 'Lora', serif;
      font-size: 20px;
      }
      .other{
        font-size: 25px;
      }
    </style>
  </head>
  <body>
    <?php
    //top header
    include 'topHeader.php';
    ?>
    <?php
    //navbar
    $page="doctor";
     include 'navbar.php';
    ?>
    <!-- END nav -->
    
    <section class="hero-wrap hero-wrap-2" style="background-image: url('images/bg_1.jpg');" data-stellar-background-ratio="0.5">
      <div class="overlay"></div>
      <div class="container">
        <div class="row no-gutters slider-text align-items-center justify-content-center">
          <div class="col-md-9 ftco-animate text-center">
            <h1 class="mb-2 bread">Profile</h1>
            <p class="breadcrumbs"><span class="mr-2"><a href="index.php">Home <i class="ion-ios-arrow-forward"></i></a></span> <span class="mr-2"><a href="user_profile.php">Profile <i class="ion-ios-arrow-forward"></i></a></span> </p>
          </div>
        </div>
      </div>
    </section>
    <section class="ftco-section">
       <div class="container">
      <div class="card mt-5">
        <h5 class="card-header text-center">Doctor Profile Info</h5>
        <div class="card-body">
          <div class="row">
            <div class="col-md-3 pt-4">
              <div class="profile-pic text-center">
                <img src="<?php echo $result['pro_pic'];?>" alt="Profile Image" style="height: 250px; width: 250px;  border-radius: 50%; border: 4px solid green;">
                <br>
                <a href="appointment.php?doctor=<?php echo $result['doctor_name']?>" class="btn btn-info btn-sm mt-4">Make An Appointment </a>
              </div>
            </div>
            <div class="col-md-7 offset-1 pt-4">
              <div class="profile-info">
                <!-- User's info Table -->
                <table class="table table-hover">
                  <thead>
                    <tr>
                      <th scope="col">Info</th>
                      <th scope="col">Details</th> 
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <th scope="row">Name</th>
                      <td><?php echo $result['doctor_name'];?></td> 
                    </tr> 

                    <tr>
                      <th scope="row">Email</th>
                      <td><?php echo $result['email'];?></td> 
                    </tr> 

                    <tr>
                      <th scope="row">Experience</th>
                      <td><?php echo $result['experience'];?> years</td> 
                    </tr> 

                    <tr>
                      <th scope="row">Education</th>
                      <td><?php echo $result['education_background'];?></td> 
                    </tr>

                    <tr>
                      <th scope="row">Joining Date</th>
                      <td><?php echo $result['join_date'];?></td> 
                    </tr> 

                    <tr>
                      <th scope="row">Department:</th>
                      <td><a href="doctor.php?department=<?php echo $result['department'];?>"><?php echo $result['department'];?></a></td> 
                    </tr> 
                  </tbody>
                </table>
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
 <script>
var acc = document.getElementsByClassName("accordion");
var i;

for (i = 0; i < acc.length; i++) {
  acc[i].addEventListener("click", function() {
    this.classList.toggle("active");
    var panel = this.nextElementSibling;
    if (panel.style.maxHeight) {
      panel.style.maxHeight = null;
    } else {
      panel.style.maxHeight = panel.scrollHeight + "px";
    } 
  });
}
const flashdata=$('.flash-data').data('flashdata');
if (flashdata) {
  swal("Success!", "Nurse is on the way!", "success");
}
</script>

    
  </body>
</html>