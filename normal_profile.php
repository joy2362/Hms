<?php
  include('database.php');
  include('session.php');

  $db=new Database();

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
  public function __call($name,$arg){
    if($name == 'getAppointment')
      switch(count($arg)){
        case 0 : return 0 ;
          case 3 :
            try {
              $sql="select * from appointment where user_info_id='$arg[0]' and status='$arg[1]' and date >='$arg[2]'";
              $query = $this->db->conn->prepare($sql);
              $query->execute();  
              return $query;      
            } catch (PDOException $e) {
              die("somthing wrong".$e);
            };
          case 2 :
            try {
              $sql="select * from appointment where user_info_id='$arg[0]' and status='$arg[1]'";
              $query = $this->db->conn->prepare($sql);
              $query->execute();  
              return $query;      
            } catch (PDOException $e) {
              die("somthing wrong".$e);
            };
    }
  }

  public function getDoctorName($id){
    try {
        $sql="select * from doctor_info where doctor_info_id='$id'";
        $query = $this->db->conn->prepare($sql);
        $query->execute();  
        if ($query->rowCount()==1) {
          $result=$query->fetch(PDO::FETCH_ASSOC);

          return $result['doctor_name'];
        }     
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

  public function CheckTime($time){
    $dateTime = new DateTime($time);
    if ($dateTime->diff(new DateTime)->format('%R') == '+') {
      return 0;
    }else{
      return 1;
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
            <img src="<?php echo $result['propic'];?>" style="width:300px;height:300px;border-radius: 50%;">
            <h2 class=""> <?php echo $result['full_name'];?> </h2>
             <p class="details">Age: <?php echo $result['age'];?> </br>
            Phone: <?php echo $result['phone'];?> </br>
             Email: <?php echo $result['email'];?> </br>
             Address: <?php echo $result['address'];?> <br>
             Total appointment: <?php  echo $totalAppointment;?> </p>
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
                    <th>Action</th>
                  </tr>
                </thead>
              <?php
                while ($info = $appointment->fetch(PDO::FETCH_ASSOC)) {
                    $docId = $info['doctor_info_id'];
                    $appointmentTime=$info['date']." ".$info['time'];
                    $docName=$profile->getDoctorName($docId);                     
                  ?>
                    <tbody>
                      <tr>
                        <td>
                          <?php echo $info['Appoinment_id']; ?>
                        </td>
                        <td>
                          <?php   echo $docName; ?>
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
              $status="complete";
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
                  </tr>
                </thead>
              <?php
                while ($info = $appointment->fetch(PDO::FETCH_ASSOC)) {
                    $docId = $info['doctor_info_id'];
                    $docName=$profile->getDoctorName($docId);
                    $CheckTime=$profile->CheckTime($appointmentTime);
                    if ($info['status']==="complete") {
                  ?>
                    <tbody>
                      <tr>
                        <td>
                          <?php echo $info['Appoinment_id']; ?>
                        </td>
                        <td>
                          <?php   echo $docName; ?>
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
          </div> <!-- .col-md-8 -->
            <?php
              include ('sideBar.php');
            ?>
          </div><!-- END COL -->
        </div>
      </div>
    </section>
    <footer class="ftco-footer ftco-bg-dark ftco-section">
      <div class="container">
        <div class="row mb-5">
          <div class="col-md">
            <div class="ftco-footer-widget mb-5">
              <h2 class="ftco-heading-2 logo">Dr.<span>care</span></h2>
              <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.</p>
            </div>
            <div class="ftco-footer-widget mb-5">
              <h2 class="ftco-heading-2">Have a Questions?</h2>
              <div class="block-23 mb-3">
                <ul>
                  <li><span class="icon icon-map-marker"></span><span class="text">203 Fake St. Mountain View, San Francisco, California, USA</span></li>
                  <li><a href="#"><span class="icon icon-phone"></span><span class="text">+2 392 3929 210</span></a></li>
                  <li><a href="#"><span class="icon icon-envelope"></span><span class="text">info@yourdomain.com</span></a></li>
                </ul>
              </div>

              <ul class="ftco-footer-social list-unstyled float-md-left float-lft mt-3">
                <li class="ftco-animate"><a href="#"><span class="icon-twitter"></span></a></li>
                <li class="ftco-animate"><a href="#"><span class="icon-facebook"></span></a></li>
                <li class="ftco-animate"><a href="#"><span class="icon-instagram"></span></a></li>
              </ul>
            </div>
          </div>
          <div class="col-md">
            <div class="ftco-footer-widget mb-5 ml-md-4">
              <h2 class="ftco-heading-2">Links</h2>
              <ul class="list-unstyled">
                <li><a href="#"><span class="ion-ios-arrow-round-forward mr-2"></span>Home</a></li>
                <li><a href="#"><span class="ion-ios-arrow-round-forward mr-2"></span>About</a></li>
                <li><a href="#"><span class="ion-ios-arrow-round-forward mr-2"></span>Services</a></li>
                <li><a href="#"><span class="ion-ios-arrow-round-forward mr-2"></span>Deparments</a></li>
                <li><a href="#"><span class="ion-ios-arrow-round-forward mr-2"></span>Contact</a></li>
              </ul>
            </div>
            <div class="ftco-footer-widget mb-5 ml-md-4">
              <h2 class="ftco-heading-2">Services</h2>
              <ul class="list-unstyled">
                <li><a href="#"><span class="ion-ios-arrow-round-forward mr-2"></span>Neurolgy</a></li>
                <li><a href="#"><span class="ion-ios-arrow-round-forward mr-2"></span>Dentist</a></li>
                <li><a href="#"><span class="ion-ios-arrow-round-forward mr-2"></span>Ophthalmology</a></li>
                <li><a href="#"><span class="ion-ios-arrow-round-forward mr-2"></span>Cardiology</a></li>
                <li><a href="#"><span class="ion-ios-arrow-round-forward mr-2"></span>Surgery</a></li>
              </ul>
            </div>
          </div>
          <div class="col-md">
            <div class="ftco-footer-widget mb-5">
              <h2 class="ftco-heading-2">Recent Blog</h2>
              <div class="block-21 mb-4 d-flex">
                <a class="blog-img mr-4" style="background-image: url(images/image_1.jpg);"></a>
                <div class="text">
                  <h3 class="heading"><a href="#">Even the all-powerful Pointing has no control about</a></h3>
                  <div class="meta">
                    <div><a href="#"><span class="icon-calendar"></span> Dec 25, 2018</a></div>
                    <div><a href="#"><span class="icon-person"></span> Admin</a></div>
                    <div><a href="#"><span class="icon-chat"></span> 19</a></div>
                  </div>
                </div>
              </div>
              <div class="block-21 mb-5 d-flex">
                <a class="blog-img mr-4" style="background-image: url(images/image_2.jpg);"></a>
                <div class="text">
                  <h3 class="heading"><a href="#">Even the all-powerful Pointing has no control about</a></h3>
                  <div class="meta">
                    <div><a href="#"><span class="icon-calendar"></span> Dec 25, 2018</a></div>
                    <div><a href="#"><span class="icon-person"></span> Admin</a></div>
                    <div><a href="#"><span class="icon-chat"></span> 19</a></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md">
            <div class="ftco-footer-widget mb-5">
              <h2 class="ftco-heading-2">Opening Hours</h2>
              <h3 class="open-hours pl-4"><span class="ion-ios-time mr-3"></span>We are open 24/7</h3>
            </div>
            <div class="ftco-footer-widget mb-5">
              <h2 class="ftco-heading-2">Subscribe Us!</h2>
              <form action="#" class="subscribe-form">
                <div class="form-group">
                  <input type="text" class="form-control mb-2 text-center" placeholder="Enter email address">
                  <input type="submit" value="Subscribe" class="form-control submit px-3">
                </div>
              </form>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12 text-center">

            <p><!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
  Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | This template is made with <i class="icon-heart" aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank">Colorlib</a>
  <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. --></p>
          </div>
        </div>
      </div>
    </footer>
    
  

  <!-- loader -->
  <div id="ftco-loader" class="show fullscreen"><svg class="circular" width="48px" height="48px"><circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke="#eeeeee"/><circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke-miterlimit="10" stroke="#F96D00"/></svg></div>

<?php
  include('javascriptLink.php');
?>
  <script>
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
</script>
   
    
  </body>
</html>