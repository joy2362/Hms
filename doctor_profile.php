<?php
  include('database.php');
  include('session.php');

  $db=new Database();

class DoctorProfile{
  
  public function getDoctor($db){

    Session::init();
    $id=Session::get("id");
    $login= Session::get("login");
    $type= Session::get("type");

   if ($id != "0" && $type == "doctor") {
      try {
        $sql="select * from doctor_info where user_id='$id'";
        $query = $db->conn->prepare($sql);
        $query->execute();
        return $query->fetch(PDO::FETCH_ASSOC); 

      } catch (PDOException $e) {
        die("somthing wrong".$e);
      }
      
    }else{
      header("location:index.php");
    }
    
  }

  public function getAppointment($db,$id){
     try {
        $sql="select * from appointment where doctor_info_id='$id'";
        $query = $db->conn->prepare($sql);
        $query->execute();
        return $query;
      } catch (PDOException $e) {
        die("somthing wrong".$e->getMessage());
      }
  }

  public function getUserName($db,$id){
     try {
      $sql="select * from user_info where user_info_id='$id'";
      $query = $db->conn->prepare($sql);
      $query->execute();
      $query->fetch(PDO::FETCH_ASSOC); 
      if ($query->rowCount()==1) {
        $result=$query->fetch(PDO::FETCH_ASSOC);
        return $result['full_name']; 
      }  
    } catch (PDOException $e) {
      die("somthing wrong".$e->getMessage());
    }
  }
  public function getNurse($db,$status){
     try {
      $sql="select * from nurse where status='$status'";
      $query = $db->conn->prepare($sql);
      $query->execute();
      return $query;
    } catch (PDOException $e) {
      die("somthing wrong".$e->getMessage());
    }
  }

  public function updateNurse($db,$id,$doctor){
    try {
      $sql="update nurse set status='active', doctor_info_id='$doctor' where Nurse_id='$id'";
      $query = $db->conn->prepare($sql);
      $query->execute();
      if ($query) {
        return 1;
      }
    } catch (PDOException $e) {
      die("somthing wrong " .$e->getMessage());
    }
  }

  public function updateAppointment($db,$id){
    try {
      $sql="update appointment set status='done' where Appoinment_id=$id";
      $query = $db->conn->prepare($sql);
      $query->execute();
      if ($query) {
        return 1;
      }
    } catch (PDOException $e) {
      die("somthing wrong " .$e->getMessage());
    }
  }
  
}
  $profile = new DoctorProfile();
  $result=$profile->getDoctor($db);
  $doctorInfoId=$result['doctor_info_id'];
if (isset($_GET['id'])) {
  $id=$_GET['id'];
  $updateNurse=$profile->updateNurse($db,$id,$doctorInfoId);
}  
if (isset($_GET['Aid'])) {
  $id=$_GET['Aid'];
  $updateAppointment=$profile->updateAppointment($db,$id);
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

    
    <link rel="stylesheet" href="css/flaticon.css">
    <link rel="stylesheet" href="css/icomoon.css">
    <link rel="stylesheet" href="css/style.css">
    <style type="text/css">
      .accordion {
        background-color: #eee;
        color: #444;
        cursor: pointer;
        padding: 18px;
        width: 100%;
        border: none;
        text-align: left;
        outline: none;
        font-size: 15px;
        transition: 0.4s;
      }

    .active, .accordion:hover {
      background-color: #ccc;
    }

    .accordion:after {
      content: '\002B';
      color: #777;
      font-weight: bold;
      float: right;
      margin-left: 5px;
    }

    .active:after {
      content: "\2212";
    }

    .panel {
      padding: 0 18px;
      background-color: white;
      max-height: 0;
      overflow: hidden;
      transition: max-height 0.2s ease-out;
    }
    </style>
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
            <h1 class="mb-2 bread">Profile</h1>
            <p class="breadcrumbs"><span class="mr-2"><a href="index.php">Home <i class="ion-ios-arrow-forward"></i></a></span> <span class="mr-2"><a href="user_profile.php">Profile <i class="ion-ios-arrow-forward"></i></a></span> </p>
          </div>
        </div>
      </div>
    </section>

    <section class="ftco-section">
      <div class="container">
        <div class="row text-center">
          <div class="col-lg-8 ftco-animate">
           <img src="<?php echo $result['pro_pic'];?>" style="width:300px;height:300px;border-radius: 50%;">
            <h2 class=""> <?php echo $result['doctor_name'];?> </h2>
             <p class="">Phone: <?php echo $result['phone'];?> </p>
             <p class="">Salary: <?php echo $result['salary'];?> tk</p>
             <p class="">Duty time: <?php echo $result['start_duty_time'];?> - <?php echo $result['end_duty_time'];?></p>
             <?php
             if (isset($updateNurse)) {
              ?>
              <div class="flash-data" data-flashdata="<?php echo $updateNurse;?>"></div>
                <?php
             }
             ?>
              <?php
             if (isset($updateAppointment)) {
              ?>
              <div class="alert alert-success"><strong>Success </strong> Appointment marked as Done!!!</div>
                <?php
             }
             ?>
            <button class="accordion">Today's Appointments</button>
            <div class="panel">
               <table class="table table-hover table-bordered">
                <thead class="thead-light"> 
                  <tr>
                    <th>#</th>
                    <th>Patient</th>
                    <th>Problem</th>
                    <th>time</th>
                    <th>Status</th>
                    <th>Action</th>
                  </tr>
                </thead>
              
              <?php
              $appointment=$profile->getAppointment($db,$doctorInfoId);
              if ($appointment->rowCount()<1) {
               ?>
               <p>No appointment found</p>
               <?php
               }else{
                  while ($info = $appointment->fetch(PDO::FETCH_ASSOC)) {
                    $userId = $info['user_info_id'];
                    $appointmentDate = $info['date'];
                    date_default_timezone_set('Asia/Dhaka');
                    $today=date("Y-m-d");
                   // $userName = $profile->getUserName($db,$userId);
                    //$CheckTime=$profile->CheckTime($appointmentTime);
                    if ($info['status']==="pending" && $info['date']==$today) {
                     ?>
                     <tbody>
                      <tr>
                        <td><?php echo $info['Appoinment_id'];?></td>
                        <td><?php echo $info['patient_name'];?></td>
                        <td><?php echo $info['Problem'];?></td>
                        <td><?php echo $info['time'];?></td>
                        <td><?php echo $info['status'];?></td>
                        <td><a href="?Aid=<?php echo $info['Appoinment_id'];  ?>" class="btn btn-outline-success">Mark as Done</a></td>
                     </tr>
                     </tbody>
                     <?php
                    }
                  }
                  ?>
                  </table>
                  <?php
                }
                  ?>
            </div>
            <button class="accordion">Nurse</button>
            <div class="panel">
              <?php
                $nurse=$profile->getNurse($db,"free");
                 if ($nurse->rowCount()<1) {
                  ?>
                  <h2>Sorry All Nurse busy at this moment</h2>
                  <?php
                 }else{
                  ?>
                  <table class="table table-hover table-bordered">
                <thead class="thead-light"> 
                  <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Experience</th>
                    <th>Status</th>
                    <th>Action</th>
                  </tr>
                </thead>
             
                  <?php
                   while ($info = $nurse->fetch(PDO::FETCH_ASSOC)) {
                    ?>
                    <tr>
                      <td><?php echo $info['Nurse_id'] ?></td>
                      <td><?php echo $info['name'] ?></td>
                      <td><?php echo $info['expeience'] ?></td>
                      <td><?php echo $info['status'] ?></td>
                      <td><a href="?id=<?php echo $info['Nurse_id']; ?>" class="btn btn-outline-success">Call</a>
                      </td>
                    </tr>
                    <?php
                   }
                   ?>
                    </table>
                  <?php
                 }
              ?>
            </div>
          </div> <!-- .col-md-8 -->
            <?php 
              include('sideBar.php');
            ?>
          </div><!-- END COL -->
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