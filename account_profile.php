<?php
  include('database.php');
  include('session.php');

  $db=new Database();

class Accountant{
  
  public function getAccount($db){

    Session::init();
    $id=Session::get("id");
    $login= Session::get("login");
    $type= Session::get("type");

   if ($id != "0" && $type =="accountant") {
      try {
        $sql="select * from accountant where user_id='$id'";
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

  public function getAppointment($db){
     try {
        $sql="select * from appointment where status='done'";
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
  public function updateAppointment($db,$id){
    try {
      $sql="update appointment set status='complete' where Appoinment_id=$id";
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
  $profile = new Accountant();
  $result=$profile->getAccount($db);
  $accountantId=$result['accountant_id'];

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
  </head>
  <body>
    <nav class="navbar py-4 navbar-expand-lg ftco_navbar navbar-light bg-light flex-row">
      <div class="container">
        <div class="row no-gutters d-flex align-items-start align-items-center px-3 px-md-0">
          <div class="col-lg-2 pr-4 align-items-center">
            <a class="navbar-brand" href="index.html">Dr.<span>care</span></a>
          </div>
          <div class="col-lg-10 d-none d-md-block">
            <div class="row d-flex">
              <div class="col-md-4 pr-4 d-flex topper align-items-center">
                <div class="icon bg-white mr-2 d-flex justify-content-center align-items-center"><span class="icon-map"></span></div>
                <span class="text">Address: 198 West 21th Street, Suite 721 New York NY 10016</span>
              </div>
              <div class="col-md pr-4 d-flex topper align-items-center">
                <div class="icon bg-white mr-2 d-flex justify-content-center align-items-center"><span class="icon-paper-plane"></span></div>
                <span class="text">Email: youremail@email.com</span>
              </div>
              <div class="col-md pr-4 d-flex topper align-items-center">
                <div class="icon bg-white mr-2 d-flex justify-content-center align-items-center"><span class="icon-phone2"></span></div>
                <span class="text">Phone: + 1235 2355 98</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </nav>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark ftco-navbar-light" id="ftco-navbar">
      <div class="container d-flex align-items-center">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav" aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
          <span class="oi oi-menu"></span> Menu
        </button>
        <p class="button-custom order-lg-last mb-0"><a href="appointment.html" class="btn btn-secondary py-2 px-3">Make An Appointment</a></p>
        <div class="collapse navbar-collapse" id="ftco-nav">
          <ul class="navbar-nav mr-auto">
            <li class="nav-item"><a href="index.php" class="nav-link pl-0">Home</a></li>
            <li class="nav-item"><a href="about.html" class="nav-link">About</a></li>
            <li class="nav-item"><a href="doctor.php" class="nav-link">Doctor</a></li>
            <li class="nav-item"><a href="department.html" class="nav-link">Departments</a></li>
            <li class="nav-item"><a href="pricing.html" class="nav-link">Pricing</a></li>
            <li class="nav-item "><a href="blog.php" class="nav-link">Blog</a></li>
            <li class="nav-item"><a href="contact.html" class="nav-link">Contact</a></li>
            <li class="nav-item "><a href="user_profile.php" class="nav-link">Profile</a></li>
            <li class="nav-item"><a href="?action=logout" class="nav-link">Log out</a></li>
          </ul>
        </div>
      </div>
    </nav>
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
            <img src="<?php echo $result['propic'];?>" class="rounded"style="width:50%">
            <h2 class=""> <?php echo $result['name'];?> </h2>
             <p class=""> <?php echo $result['phone'];?> </p>
              
             <?php
             if (isset($updateAppointment)) {
              ?>
              <div class="flash-data" data-flashdata="<?php echo $updateAppointment;?>"></div>
                <?php
             }
             ?>
             <h2>Appointment</h2>
             
                <?php
                $appointment=$profile->getAppointment($db);
                if ($appointment->rowCount()<1) {
               ?>
               <p>No appointment found</p>
               <?php
               }else{
                ?>
                <table class="table table-hover">
               <thead>
                 <tr>
                   <th>#</th>
                   <th>Patient</th>
                   <th>Date</th>
                   <th>Status</th>
                   <th>Action</th>
                 </tr>
               </thead>
               <tbody>
                <?php
                  while ($info = $appointment->fetch(PDO::FETCH_ASSOC)) {
                    $userId = $info['user_info_id'];
                    ?>
                    <tr>
                    <td><?php echo $info['Appoinment_id'];?></td>
                        <td><?php echo $info['patient_name'];?></td>
                        <td><?php echo $info['Problem'];?></td>
                        <td><?php echo $info['status'];?></td>
                        <td><a href="?Aid=<?php echo $info['Appoinment_id'];  ?>" class="btn btn-outline-success">Mark as Complete</a></td>
                      </tr>
                <?php
                  }
                }
                ?>
               </tbody>
             </table>
          </div> <!-- .col-md-8 -->

          <div class="col-lg-4 sidebar ftco-animate">
            <div class="sidebar-box ftco-animate">
              <h3>Category</h3>
              <ul class="categories">
                <li><a href="#">Neurology <span>(6)</span></a></li>
                <li><a href="#">Cardiology <span>(8)</span></a></li>
                <li><a href="#">Surgery <span>(2)</span></a></li>
                <li><a href="#">Dental <span>(2)</span></a></li>
                <li><a href="#">Ophthalmology <span>(2)</span></a></li>
              </ul>
            </div>

            <div class="sidebar-box ftco-animate">
              <h3>Popular Articles</h3>
              <div class="block-21 mb-4 d-flex">
                <a class="blog-img mr-4" style="background-image: url(images/image_1.jpg);"></a>
                <div class="text">
                  <h3 class="heading"><a href="#">Even the all-powerful Pointing has no control about the blind texts</a></h3>
                  <div class="meta">
                    <div><a href="#"><span class="icon-calendar"></span> Oct. 04, 2018</a></div>
                    <div><a href="#"><span class="icon-person"></span> Dave Lewis</a></div>
                    <div><a href="#"><span class="icon-chat"></span> 19</a></div>
                  </div>
                </div>
              </div>
              <div class="block-21 mb-4 d-flex">
                <a class="blog-img mr-4" style="background-image: url(images/image_2.jpg);"></a>
                <div class="text">
                  <h3 class="heading"><a href="#">Even the all-powerful Pointing has no control about the blind texts</a></h3>
                  <div class="meta">
                    <div><a href="#"><span class="icon-calendar"></span> Oct. 04, 2018</a></div>
                    <div><a href="#"><span class="icon-person"></span> Dave Lewis</a></div>
                    <div><a href="#"><span class="icon-chat"></span> 19</a></div>
                  </div>
                </div>
              </div>
              <div class="block-21 mb-4 d-flex">
                <a class="blog-img mr-4" style="background-image: url(images/image_3.jpg);"></a>
                <div class="text">
                  <h3 class="heading"><a href="#">Even the all-powerful Pointing has no control about the blind texts</a></h3>
                  <div class="meta">
                    <div><a href="#"><span class="icon-calendar"></span> Oct. 04, 2018</a></div>
                    <div><a href="#"><span class="icon-person"></span> Dave Lewis</a></div>
                    <div><a href="#"><span class="icon-chat"></span> 19</a></div>
                  </div>
                </div>
              </div>
            </div>
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
  swal("Success!", "Marked as complete!", "success");
}
</script>

    
  </body>
</html>