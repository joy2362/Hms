<?php
  include('database.php');
  include('session.php');

  $db=new Database();

class NurseProfile{
  
  public function getNurse($db){
    Session::init();
    $id=Session::get("id");
    $login= Session::get("login");
    $type= Session::get("type");

   if ($id != "0" && $type == "nurse") {
      try {
        $sql="select * from nurse where user_id='$id'";
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
  public function getDoctor($db,$id){
    try {
        $sql="select * from doctor_info where doctor_info_id='$id'";
        $query = $db->conn->prepare($sql);
        $query->execute();
        $result=$query->fetch(PDO::FETCH_ASSOC); 
        return $result['doctor_name'];
      } catch (PDOException $e) {
        die("somthing wrong".$e);
      }
  }
  public function updateNurse($db,$id,$doctor){
    try {
      $sql="update nurse set status='free', doctor_info_id='$doctor' where Nurse_id='$id'";
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
  $profile = new NurseProfile();
  $result=$profile->getNurse($db);
  $NurseId=$result['Nurse_id'];
  if (isset($_GET['id'])) {
  $id=$_GET['id'];
  $updateNurse=$profile->updateNurse($db,$id,0);
}  
  $doctorName=$profile->getDoctor($db,$result['doctor_info_id']);
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
             <?php
             if (isset($updateNurse)) {
              ?>
              <div class="flash-data" data-flashdata="<?php echo $updateNurse;?>"></div>
                <?php
             }
             ?>ss
    <section class="ftco-section">
      <div class="container">
        <div class="row text-center">
          <div class="col-lg-8 ftco-animate">
            <img src="<?php echo $result['propic'];?>" class="rounded"style="width:50%">
            <h2 class=""> <?php echo $result['name'];?> </h2>
            <p class=""> Phone: <?php echo $result['phone'];?> </p>
            <p class=""> Email: <?php echo $result['email'];?> </p>
            <p class="">Salary: <?php echo $result['salary'];?> tk</p>
            <p class="">Status: <?php echo $result['status'];?> </p>
            <?php
              if ( $result['doctor_info_id']!=0 ){
                ?>
                <p class="">Working with: <?php echo $doctorName;?> </p>
            <a href="?id=<?php echo $result['Nurse_id'];?>" class="btn btn-outline-success">Mark as free</a>
            <?php
              }else{
                ?>
                <p>Wait for the doctor's call</p>
                <?php
              }
            ?>
            
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
  const flashdata=$('.flash-data').data('flashdata');
if (flashdata) {
  swal("Success!", "Wait for next call!", "success");
}
}

</script>

    
  </body>
</html>