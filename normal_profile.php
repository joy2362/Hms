<?php
  include('database.php');
  include('session.php');

  //$db=new Database();

class UserProfile{
  private $db;
  
  function __construct(){
    $this->db=new Database();
  }

  public function getUser(){

    Session::init();
    $id=Session::get("id");
    $login= Session::get("login");
    $type= Session::get("type");

   if ($id != "0" && $type == "normal") {
      try {
        $sql="select * from user_info where user_id='$id'";
        $query = $this->db->conn->prepare($sql);
        $query->execute();
        return $query->fetch(PDO::FETCH_ASSOC); 
      } catch (PDOException $e) {
        die("somthing wrong".$e);
      }
      
    }else{
     header("location:index.php");
    }
    
  }
  //get appointment info with different condition
  public function __call($name,$arg){
    if($name == 'getAppointment'){
      switch(count($arg)){
          case 3 :
            try {
              $sql="SELECT appointment.*, doctor_info.doctor_name FROM appointment INNER JOIN doctor_info ON appointment.doctor_info_id=doctor_info.doctor_info_id
              where appointment.user_info_id='$arg[0]' and status='$arg[1]' and date >='$arg[2]' ";
              $query = $this->db->conn->prepare($sql);
              $query->execute();  
              return $query;      
            } catch (PDOException $e) {
              die("somthing wrong".$e);
            };
          case 2 :
            try {
              $sql="SELECT appointment.*, doctor_info.doctor_name FROM appointment INNER JOIN doctor_info ON appointment.doctor_info_id=doctor_info.doctor_info_id
              where appointment.user_info_id='$arg[0]' and not appointment.status='$arg[1]' ";
              $query = $this->db->conn->prepare($sql);
              $query->execute();  
              return $query;      
            } catch (PDOException $e) {
              die("somthing wrong".$e);
            };
    }
    }
  }
   public function expired($userInfoId,$status,$today){

    try {
     $sql="SELECT appointment.*, doctor_info.doctor_name FROM appointment INNER JOIN doctor_info ON appointment.doctor_info_id=doctor_info.doctor_info_id
       where appointment.user_info_id='$userInfoId' and status='$status' and date <'$today' ";
      $query = $this->db->conn->prepare($sql);
      $query->execute();  
      return $query;      
    } catch (PDOException $e) {
      die("somthing wrong".$e);
    }
   
  }

   public function getTotalAppointment($id){
     try {
      $sql="select * from appointment where user_info_id='$id'";
      $query = $this->db->conn->prepare($sql);
      $query->execute();  
      $result=$query->rowCount();
      return $result;
    } catch (PDOException $e) {
      die("somthing wrong".$e);
    }
  }
  public function appointmentCancle($id){
    try {
      $sql="DELETE FROM appointment where Appoinment_id='$id'";
      $query = $this->db->conn->prepare($sql);
      $query->execute();
      if ($query) {
        return 1;
      }
      return $query;
    } catch (PDOException $e) {
      die("somthing wrong".$e);
    }
  }
}
  $profile = new UserProfile();
  $result=$profile->getUser();
  $userInfoId=$result['user_info_id'];
  $totalAppointment=$profile->getTotalAppointment($userInfoId);
  if (isset($_GET['action']) && $_GET['action']=="logout") {
    Session::destroy();
}  
 if (isset($_GET['appointmentid']) && $_GET['appointmentid']!="") {
    $id=$_GET['appointmentid'];
    $cancle=$profile->appointmentCancle($id);
    if (isset($cancle)) {
     header("location:normal_profile.php");
    }
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
      .tab {
        overflow: hidden;
        border: 1px solid #ccc;
        background-color: #f1f1f1;
        }
      .tab button {
        background-color: inherit;
        float: left;
        border: none;
        outline: none;
        cursor: pointer;
        padding: 14px 16px;
        transition: 0.3s;
        font-size: 17px;
      }
      .tab button:hover {
        background-color: #ddd;
      }

      .tab button.active {
        background-color: #ccc;
      }
      .tabcontent {
        display: none;
        padding: 6px 12px;
        border: 1px solid #ccc;
        border-top: none;
      }
      .details{
      font-family: 'Lora', serif;
      font-size: 20px;
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
    <?php
    if (isset($cancle)) {
    ?>
    <div class="message" data-flashdata="<?php echo $cancle;?>"></div>
    <?php
    }
    ?>
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
        <h5 class="card-header text-center">User Profile Info</h5>
        <div class="card-body">
          <div class="row">
            <div class="col-md-3 pt-4">
              <div class="profile-pic text-center">
                <img src="<?php echo $result['propic'];?>" alt="Profile Picture" style="height: 250px; width: 250px;  border-radius: 50%; border: 4px solid green;">
                <br>
                <button type="submit" class="btn btn-info btn-sm mt-4" id="update">Update Profile</button>
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
                      <td><?php echo $result['user_info_id'];?></td> 
                    </tr> 

                    <tr>
                      <th scope="row">Email</th>
                      <td><?php echo $result['email'];?></td> 
                    </tr> 

                    <tr>
                      <th scope="row">Gender</th>
                      <td><?php echo $result['gender'];?></td> 
                    </tr> 

                    <tr>
                      <th scope="row">Age</th>
                      <td><?php echo $result['age'];?></td> 
                    </tr>

                    <tr>
                      <th scope="row">Number of appointment</th>
                      <td><?php  echo $totalAppointment;?></td> 
                    </tr> 

                    <tr>
                      <th scope="row">Address</th>
                      <td><?php echo $result['address'];?></td> 
                    </tr> 

                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
        <h5 class="card-header text-center">Appointment Info</h5>
      <div class="tab">
        <button class="tablinks" onclick="openCity(event, 'upcoming')" id="defaultOpen">Upcoming Appoinment</button>
        <button class="tablinks" onclick="openCity(event, 'previous')">Previous Appoinment</button>
      </div>
      <div id="upcoming" class="tabcontent">
            <?php
              $today=date("Y-m-d");
              $appointment=$profile->getAppointment($userInfoId,"pending",$today);
             if ($appointment->rowCount()<1) {
               ?>
               <p>No appointment found</p>
               <?php
             }else{
              ?>
              <table class="table">
                <thead class="thead-light"> 
                  <tr>
                    <th>#</th>
                    <th>Doctor</th>
                    <th>Problem</th>
                    <th>time</th>
                    <th>Status</th>
                    <th colspan="2" class="text-center">Action</th>
                  </tr>
                </thead>
              <?php
                while ($info = $appointment->fetch(PDO::FETCH_ASSOC)) {
                    $appointmentTime=$info['date']." ".$info['time'];                 
                  ?>
                    <tbody>
                      <tr>
                        <td>
                          <?php echo $info['Appoinment_id']; ?>
                        </td>
                        <td>
                          <?php echo $info['doctor_name']; ?>
                        </td>
                         <td>
                          <?php echo $info['Problem']; ?>
                        </td>
                        <td>
                          <?php  echo $appointmentTime; ?>
                        </td>
                        <td>
                          <?php echo $info['status']; ?>
                        </td>
                        <td>
                          <a href="pdfCreator.php?Aid=<?php echo $info['Appoinment_id']; ?>" class="btn btn-outline-primary" download target="_blank">Download</a>
                        </td>
                        <td>
                          <a href="?appointmentid=<?php echo $info['Appoinment_id']; ?>" class="btn btn-outline-danger">Cancle</a>
                        </td>
                      </tr>
                    </tbody>
                  <?php
                }
                ?>
                </table>
                <?php
             } 
            ?>
          </div>
          <div id="previous" class="tabcontent">
             <?php
              $status="pending";
              $appointment=$profile->getAppointment($userInfoId,$status);
            if ($appointment->rowCount()<1) {
               ?>
               <p>No appointment found</p>
               <?php
             }else{
              ?>
              <table class="table">
                <thead class="thead-light"> 
                  <tr>
                    <th>#</th>
                    <th>Doctor</th>
                    <th>Problem</th>
                    <th>time</th>
                    <th>Status</th>
                    <th>Action</th>
                  </tr>
                </thead>
              <?php
                while ($info = $appointment->fetch(PDO::FETCH_ASSOC)) {
                  ?>
                    <tbody>
                      <tr>
                        <td>
                          <?php echo $info['Appoinment_id']; ?>
                        </td>
                        <td>
                            <?php echo $info['doctor_name']; ?>
                        </td>
                         <td>
                          <?php echo $info['Problem']; ?>
                        </td>
                        <td>
                          <?php echo $info['date']." ".$info['time']; ?>
                        </td>
                        <td>
                          <?php echo $info['status']; ?>
                        </td>
                        <td>
                          <a href="prescription.php?Aid=<?php echo $info['Appoinment_id']; ?>" class="btn btn-outline-primary" download target="_blank">Download</a>
                        </td>
                      </tr>
                    </tbody>

                  <?php
              }
                ?>
                </table>
                <?php
             } 
            ?>

          </div>
          <!--
          <h5 class="card-header text-center">Account Info</h5>
        -->
    </div>
    </section>
    
    <?php
      include_once 'footer.php';
    ?>

  <!-- loader -->
  <div id="ftco-loader" class="show fullscreen"><svg class="circular" width="48px" height="48px"><circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke="#eeeeee"/><circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke-miterlimit="10" stroke="#F96D00"/></svg></div>

<?php
  include('javascriptLink.php');
?>
  <script>
    //show message
        function openCity(evt, cityName) {
          var i, tabcontent, tablinks;
          tabcontent = document.getElementsByClassName("tabcontent");
          for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = "none";
          }
          tablinks = document.getElementsByClassName("tablinks");
          for (i = 0; i < tablinks.length; i++) {
            tablinks[i].className = tablinks[i].className.replace(" active", "");
          }
          document.getElementById(cityName).style.display = "block";
          evt.currentTarget.className += " active";
        }

          // Get the element with id="defaultOpen" and click on it
        document.getElementById("defaultOpen").click();
        
        $("#update").click(function(){
          swal("Sorry!", "This feature not available now!", "error");
        });
        const flashdata=$('.message').data('flashdata');
    if (flashdata==1) {
        swal("Success!", "Appointment Cancle successfully", "success");
    }
</script>
  </body>
</html>