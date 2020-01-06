<?php
include_once 'database.php';
include('session.php');
if (isset($_GET['department'])) {
  $department=$_GET['department'];
}
class Doctor{
  
 public function __call($name,$arg){
  if($name == 'getDoctor'){
    switch(count($arg)){
      case 1 :
        $query = $arg[0]->conn->prepare("select * from doctor_info");
        $query->execute();
        return $query->rowCount();
      case 2 :
        $query = $arg[0]->conn->prepare("select * from doctor_info where department='$arg[1]'");
        $query->execute();
        return $query->rowCount();
    }
  }
 }
}

$db=new Database();
$getInfo=new Doctor();

Session::init();
$id=Session::get("id");

if (isset($_GET['action']) && $_GET['action']=="logout") {
  Session::destroy();
}

if (isset($department)) {
  $department=strtoupper($department);
  $totalfile=$getInfo->getDoctor($db,$department);
}else{
  $totalfile=$getInfo->getDoctor($db);
}

$result_per_page=12;
$number_of_page=ceil($totalfile/$result_per_page);
if (!isset($_GET['page'])) {
  $page=1;
}else{
  $page=$_GET['page'];
}
$this_page_first_result=($page-1)*$result_per_page;
if (isset($department)) {
 try {
  $sql="select * from doctor_info where department='$department' order by doctor_info_id desc
  limit ".$this_page_first_result .",".$result_per_page." ";
  $query = $db->conn->prepare($sql);
  $query->execute();
} catch (PDOException $e) {
  die("somthing wrong " .$e->getMessage());
}
}else{
  try {
  $sql="select * from doctor_info order by doctor_info_id desc
  limit ".$this_page_first_result .",".$result_per_page;
  $query = $db->conn->prepare($sql);
  $query->execute();
} catch (PDOException $e) {
  die("somthing wrong " .$e->getMessage());
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

    
    <link rel="stylesheet" href="css/flaticon.css">
    <link rel="stylesheet" href="css/icomoon.css">
    <link rel="stylesheet" href="css/style.css">
    <style type="text/css">
      .btn.active {
        background-color: #666;
        color: white;
      }
      .filter{
        margin-bottom: 20px;
      }
    </style>
  </head>
  <body>
    <?php
    include 'topHeader.php';
    ?>
    <?php
      $page1="doctor";
     include 'navbar.php';
    ?>
    <!-- END nav -->
    
    <section class="hero-wrap hero-wrap-2" style="background-image: url('images/bg_1.jpg');" data-stellar-background-ratio="0.5">
      <div class="overlay"></div>
      <div class="container">
        <div class="row no-gutters slider-text align-items-center justify-content-center">
          <div class="col-md-9 ftco-animate text-center">
            <h1 class="mb-2 bread">Qualified Doctors</h1>
            <p class="breadcrumbs"><span class="mr-2"><a href="index.html">Home <i class="ion-ios-arrow-forward"></i></a></span> <span>Doctor <i class="ion-ios-arrow-forward"></i></span></p>
          </div>
        </div>
      </div>
    </section>
		
		<section class="ftco-section">
			<div class="container">
        <div class="filter">
           <p>Department:</p>
        <a href="doctor.php" class="btn btn-outline-primary <?php if(!isset($department))echo "active";?>">All</a>
        <a href="doctor.php?department=Neurology" class="btn btn-outline-primary <?php if($_GET['department']==Neurology)echo "active";?>">Neurology</a>
        <a href="doctor.php?department=Cardiology" class="btn btn-outline-primary <?php if($_GET['department']==Cardiology)echo "active";?>">Cardiology</a>
        <a href="doctor.php?department=Surgery" class="btn btn-outline-primary <?php if($_GET['department']==Surgery)echo "active";?>">Surgery</a>
         <a href="doctor.php?department=Dental" class="btn btn-outline-primary <?php if($_GET['department']==Dental)echo "active";?>">Dental</a>
          <a href="doctor.php?department=Ophthalmology" class="btn btn-outline-primary <?php if($_GET['department']==Ophthalmology)echo "active";?>">Ophthalmology</a>
        </div>
       
				  <?php
          $count=1;
          if ($totalfile==0) {
            ?>
            <p class="text-center">no doctor found</p>
            <div class="message" data-flashdata="<?php echo $totalfile;?>"></div>
            <?php
          }
            if ($query) {
             while ($doctor = $query->fetch(PDO::FETCH_ASSOC)) {
                if($count %4 == 1){
                  ?>
             <div class="row">
              <?php
            }
              ?>
					<div class="col-md-6 col-lg-3 ftco-animate">
						<div class="staff">
							<div class="img-wrap d-flex align-items-stretch">
								<div class="img align-self-stretch" style="background-image: url(<?php echo $doctor['pro_pic']?>);"></div>
							</div>
							<div class="text pt-3 text-center">
								<h3><?php echo $doctor['doctor_name']?></h3>
								<span class="position mb-2 "><?php echo $doctor['department']?></span>
								<div class="faded">
									<p>Edication: <?php echo $doctor['education_background']?></p>
									<p>Working Experience: <?php echo $doctor['experience']?> years</p>
                  <p><a href="doctor-single.php?id=<?php echo $doctor['doctor_info_id']?>">View profile</a></P>
									<ul class="ftco-social text-center">
		               	<li class="ftco-animate"><a href="appointment.php?doctor=<?php echo $doctor['doctor_name']?>">Make An Appointment </a></li>
		             	</ul>
	              </div>
							</div>
						</div>
					</div>
				 <?php
             if($count %4 == 0){
              ?>
            </div>
            <?php
            }
            $count++;
            }
          }
          ?>
          </div>
          <?php
              if ($totalfile > $result_per_page) {
                ?>
                <ul class="pagination justify-content-center">
                <?php
                if ($page==1) {
                  echo "<li class=\"page-item disabled\"><a class=\"page-link\" href=\"doctor.php?page=".($page-1)."\">Previous</a></li>";
                }else{
                  if (isset($department)) {
                    echo "<li class=\"page-item\"><a class=\"page-link\" href=\"doctor.php?department=".$department."&page=".($page-1)."\">Previous</a></li>";
                  }else{
                    echo "<li class=\"page-item\"><a class=\"page-link\" href=\"doctor.php?page=".($page-1)."\">Previous</a></li>";
                  }
                
                }
                for ($i=1; $i <=$number_of_page ; $i++) { 
                  if ($i==$page) {
                    if (isset($department)) {
                    echo "<li class=\"page-item active\"><a class=\"page-link\" href=\"doctor.php?page=".$i."&department=".$department."\">".$i."</a></li>";
                  }else{
                    echo "<li class=\"page-item active\"><a class=\"page-link\" href=\"doctor.php?page=".$i."\">".$i."</a></li>";
                  }
                    
                  }else{
                    if (isset($department)) {
                    echo "<li class=\"page-item \"><a class=\"page-link\" href=\"doctor.php?page=".$i."&department=".$department."\">".$i."</a></li>";
                  }else{
                    echo "<li class=\"page-item\"><a class=\"page-link\" href=\"doctor.php?page=".$i."\">".$i."</a></li>";
                  }
                  }
                }
                if ($page==$number_of_page) {
                  echo "<li class=\"page-item disabled\"><a class=\"page-link\" href=\"doctor.php?page=".($page+1)."\">Next</a></li>";
                }else{
                  if (isset($department)) {
                    echo "<li class=\"page-item\"><a class=\"page-link\" href=\"doctor.php?department=".$department."&page=".($page+1)."\">Next</a></li>";
                  }else{
                    echo "<li class=\"page-item\"><a class=\"page-link\" href=\"doctor.php?page=".($page+1)."\">Next</a></li>";
                  }
                }
                ?>
                </ul>
                <?php
              }
              ?>
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
  if (flashdata==0) {
    swal("Sorry!", "No Doctor Available", "error");
  }
</script>

</body>
</html>