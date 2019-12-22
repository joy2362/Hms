<?php
include_once 'database.php';
include('session.php');

$db=new Database();
  
if (isset($_GET['action']) && $_GET['action']=="logout") {
  $session->destroy();
}
$query = $db->conn->prepare("select * from blog");
$query->execute();
$totalfile=$query->rowCount();
$result_per_page=10;
$number_of_page=ceil($totalfile/$result_per_page);
if (!isset($_GET['page'])) {
  $page=1;
}else{
  $page=$_GET['page'];
}
$this_page_first_result=($page-1)*$result_per_page;
try {
      $sql="select * from blog order by blog_id desc
      limit ".$this_page_first_result .",".$result_per_page;
      $query = $db->conn->prepare($sql);
      $query->execute();
    } catch (PDOException $e) {
      die("somthing wrong " .$e->getMessage());
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
    <nav class="navbar py-4 navbar-expand-lg ftco_navbar navbar-light bg-light flex-row">
    	<div class="container">
    		<div class="row no-gutters d-flex align-items-start align-items-center px-3 px-md-0">
    			<div class="col-lg-2 pr-4 align-items-center">
		    		<a class="navbar-brand" href="index.php">Dr.<span>care</span></a>
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
	        	<li class="nav-item active"><a href="blog.php" class="nav-link">Blog</a></li>
	          <li class="nav-item"><a href="contact.html" class="nav-link">Contact</a></li>
             <?php
              $id=Session::get("id");
              $login=Session::get("login");
              if ($login==0) {
                ?>
                <li class="nav-item"><a href="signin.php" class="nav-link">Login</a></li>
                <li class="nav-item"><a href="reg.php" class="nav-link">Registation</a></li>
              
              <?php 
              }else{
              ?>
                <li class="nav-item"><a href="user_profile.php" class="nav-link">Profile</a></li>
                <li class="nav-item"><a href="?action=logout" class="nav-link">Log out</a></li>
              <?php
              }
            ?>
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
            <h1 class="mb-2 bread">Blog</h1>
            <p class="breadcrumbs"><span class="mr-2"><a href="index.php">Home <i class="ion-ios-arrow-forward"></i></a></span> <span>Blog <i class="ion-ios-arrow-forward"></i></span></p>
          </div>
        </div>
      </div>
    </section>
		
		<section class="ftco-section bg-light">
			<div class="container">
          <?php
          $count=1;
            if ($query) {
             while ($blog = $query->fetch(PDO::FETCH_ASSOC)) {
                if($count %3==1){
             echo "<div class=\"row\">";
            }
              ?>
          <div class="col-md-4 ftco-animate">
            <div class="blog-entry">
              <a href="blog-single.php?id=<?php echo $blog['blog_id']?>" class="block-20" style="background-image: url('<?php echo $blog['picture']?>');">
								<div class="meta-date text-center p-2">
                  <?php
                    $date=explode("-",$blog['publish_date']);
                    $monthName = date('M', mktime(0, 0, 0, $date['1'], 10));
                  ?>
                  <span class="day"><?php echo $date['2']?></span>
                  <span class="mos"><?php echo $monthName?></span>
                  <span class="yr"><?php echo $date['0']?></span>
                </div>
              </a>
              <div class="text bg-white p-4">
                <h3 class="heading"><a href="blog-single.php?id=<?php echo $blog['blog_id']?>"><?php echo$blog['blog_tittle']?></a></h3>
                <p><?php echo$blog['blog_description']?></p>
                <div class="d-flex align-items-center mt-4">
	                <p class="mb-0"><a href="blog-single.php?id=<?php echo $blog['blog_id']?>" class="btn btn-primary">Read More <span class="ion-ios-arrow-round-forward"></span></a></p>
	                <p class="ml-auto mb-0">
	                	<a href="#" class="mr-2"><?php echo $blog['user_id']?></a>
	                	<a href="blog-single.php?id=<?php echo $blog['blog_id']?>" class="meta-chat"><span class="icon-chat"></span> 3</a>
	                </p>
                </div>
              </div>
            </div>
          </div>
          <?php
             if($count %3==0){
            echo "</div>"; 
            }
            $count++;
            }
          }
          ?>
          </div>
          <?php
              if ($totalfile == ($result_per_page+1)) {
                ?>
                <ul class="pagination justify-content-center">
                <?php
                if ($page==1) {
                  echo "<li class=\"page-item disabled\"><a class=\"page-link\" href=\"blog.php?page=".($page-1)."\">Previous</a></li>";
                }else{
                echo "<li class=\"page-item\"><a class=\"page-link\" href=\"blog.php?page=".($page-1)."\">Previous</a></li>";
                }
                for ($i=1; $i <=$number_of_page ; $i++) { 
                  if ($i==$page) {
                    echo "<li class=\"page-item active\"><a class=\"page-link\" href=\"blog.php?page=".$i."\">".$i."</a></li>";
                  }else{
                  echo "<li class=\"page-item\"><a class=\"page-link\" href=\"blog.php?page=".$i."\">".$i."</a></li>";
                  }
                }
                if ($page==$number_of_page) {
                  echo "<li class=\"page-item disabled\"><a class=\"page-link\" href=\"blog.php?page=".($page+1)."\">Next</a></li>";
                }else{
                  echo "<li class=\"page-item\"><a class=\"page-link\" href=\"blog.php?page=".($page+1)."\">Next</a></li>";
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
    
  </body>
</html>