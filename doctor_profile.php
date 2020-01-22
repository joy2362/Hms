<?php
include('database.php');
include('session.php');
//create database object and start session
$db=new Database();
Session::init();

class DoctorProfile{
  
  public function getDoctor($db,$id){
    
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
      //if session id and user type doctor not found then move to index
    }else{
      header("location:index.php");
    }
  }
  public function totalAppointment($db,$id){
    try {
        $sql="select * from appointment where doctor_info_id='$id'";
        $query = $db->conn->prepare($sql);
        $query->execute();
        $result=$query->rowCount();
        return $result;
      } catch (PDOException $e) {
        die("somthing wrong".$e->getMessage());
      }
  }
  public function totalMale($db,$id){
    try {
        $sql="SELECT appointment.*, user_info.*
         FROM appointment
          INNER JOIN user_info ON appointment.user_info_id=user_info.user_info_id
        where user_info.gender='male' and appointment.doctor_info_id='$id' ";
        $query = $db->conn->prepare($sql);
        $query->execute();
        $result=$query->rowCount();
        return $result;
      } catch (PDOException $e) {
        die("somthing wrong".$e->getMessage());
      }
  }
   public function totalFemale($db,$id){
    try {
        $sql="SELECT appointment.*, user_info.*
         FROM appointment
          INNER JOIN user_info ON appointment.user_info_id=user_info.user_info_id
        where user_info.gender='female' and appointment.doctor_info_id='$id' ";
        $query = $db->conn->prepare($sql);
        $query->execute();
        $result=$query->rowCount();
        return $result;
      } catch (PDOException $e) {
        die("somthing wrong".$e->getMessage());
      }
  }
  public function getAppointment($db,$id,$this_page_first_result,$result_per_page){
     try {
        $sql="select * from appointment where doctor_info_id='$id' order by Appoinment_id desc
        limit ".$this_page_first_result .",".$result_per_page." ";
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
  public function getWeekTotal($db,$id){
    $yesterday=date('Y/m/d',strtotime("-1 days"));
    $previous=date('Y/m/d',strtotime("-7 days"));
    try {
        $sql="select * from appointment where date BETWEEN '$previous' AND '$yesterday' and doctor_info_id='$id'";
        $query = $db->conn->prepare($sql);
        $query->execute();
        return $query->rowCount();
      } catch (PDOException $e) {
        die("somthing wrong " .$e->getMessage());
      }
  }
  public function geTodayTotal($db,$id){
    $today=date('Y/m/d');
     try {
        $sql="select * from appointment where date='$today' and doctor_info_id='$id'";
        $query = $db->conn->prepare($sql);
        $query->execute();
        return $query->rowCount();
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
//create doctorprofile object
$profile = new DoctorProfile();
//get doctor user id
$id=Session::get("id");
//fatch doctor information
$result=$profile->getDoctor($db,$id);
//set doctor info id
$infoId=$result['doctor_info_id'];
//get total appointment 
$total=$profile->totalAppointment($db,$infoId);
//get week appointment
$weekTotal=$profile->getWeekTotal($db,$infoId);
//get today's appointment
$todaytotal=$profile->geTodayTotal($db,$infoId);
$totalMale=$profile->totalMale($db,$infoId);
$totalFemale=$profile->totalFemale($db,$infoId);
if (isset($_GET['Aid'])) {
  $id=$_GET['Aid'];
  $updateAppointment=$profile->updateAppointment($db,$id);
}  
//unset and destroy session
if (isset($_GET['action']) && $_GET['action']=="logout") {
    Session::destroy();
}  
if (isset($_GET['page'])) {
    $page=$_GET['page'];
}else{
    $page=1;
}

$result_per_page=5;
$number_of_page=ceil($total/$result_per_page);
$this_page_first_result=($page-1)*$result_per_page;

try {
    $sql="select * from appointment where doctor_info_id='$infoId' order by status desc
        limit ".$this_page_first_result .",".$result_per_page." ";
    $appointment = $db->conn->prepare($sql);
    $appointment->execute();
        
    } catch (PDOException $e) {
        die("somthing wrong".$e->getMessage());
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags-->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="au theme template">
    <meta name="author" content="Hau Nguyen">
    <meta name="keywords" content="au theme template">

    <!-- Title Page-->
    <title><?php echo $result['doctor_name'];?></title>

    <!-- Fontfaces CSS-->
    <link href="css/font-face.css" rel="stylesheet" media="all">
    <link href="vendor/font-awesome-4.7/css/font-awesome.min.css" rel="stylesheet" media="all">
    <link href="vendor/font-awesome-5/css/fontawesome-all.min.css" rel="stylesheet" media="all">
    <link href="vendor/mdi-font/css/material-design-iconic-font.min.css" rel="stylesheet" media="all">

    <!-- Bootstrap CSS-->
    <link href="vendor/bootstrap-4.1/bootstrap.min.css" rel="stylesheet" media="all">

    <!-- Vendor CSS-->
    <link href="vendor/animsition/animsition.min.css" rel="stylesheet" media="all">
    <link href="vendor/bootstrap-progressbar/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet" media="all">
    <link href="vendor/wow/animate.css" rel="stylesheet" media="all">
    <link href="vendor/css-hamburgers/hamburgers.min.css" rel="stylesheet" media="all">
    <link href="vendor/slick/slick.css" rel="stylesheet" media="all">
    <link href="vendor/select2/select2.min.css" rel="stylesheet" media="all">
    <link href="vendor/perfect-scrollbar/perfect-scrollbar.css" rel="stylesheet" media="all">

    <!-- Main CSS-->
    <link href="css/theme.css" rel="stylesheet" media="all">

</head>

<body class="animsition">
    <div class="page-wrapper">
        <!-- HEADER DESKTOP-->
        <header class="header-desktop3 d-none d-lg-block">
            <div class="section__content section__content--p35">
                <div class="header3-wrap">
            <div class="logo">
               <div class="col-lg-2 pr-4 align-items-center">
                    <a class="navbar-brand" href="index.php">Dr.<span>care</span></a>
                </div>
            </div>
              <?php
                if (Session::get("success")==1) {
                  $success=Session::get("success");
                ?>
                <div class="message" data-flashdata="<?php echo  $success;?>"></div>
                <?php
                  Session::set("success","");
                }
              ?>
                    <div class="header__tool">
                        <div class="account-wrap">
                            <div class="account-item account-item--style2 clearfix js-item-menu">
                                <div class="image">
                                    <img src="<?php echo $result['pro_pic'];?>" alt="<?php echo $result['doctor_name'];?>" />
                                </div>
                                <div class="content">
                                    <a class="js-acc-btn" href="#"><?php echo $result['doctor_name'];?></a>
                                </div>
                                <div class="account-dropdown js-dropdown">
                                    <div class="info clearfix">
                                        <div class="image">
                                            <a href="#">
                                                <img src="<?php echo $result['pro_pic'];?>" alt="<?php echo $result['doctor_name'];?>" />
                                            </a>
                                        </div>
                                        <div class="content">
                                            <h5 class="name">
                                                <a href="#"><?php echo $result['doctor_name'];?></a>
                                            </h5>
                                            <span class="email"><?php echo $result['email'];?></span>
                                        </div>
                                    </div>
                                    <div class="account-dropdown__body">
                                        <div class="account-dropdown__item">
                                            <a href="#">
                                                <i class="zmdi zmdi-account"></i>Account</a>
                                        </div>
                                        <div class="account-dropdown__item">
                                            <a href="#">
                                                <i class="zmdi zmdi-settings"></i>Setting</a>
                                        </div>
                                    </div>
                                    <div class="account-dropdown__footer">
                                        <a href="?action=logout">
                                        <i class="zmdi zmdi-power"></i>Logout</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <!-- END HEADER DESKTOP-->

        <!-- HEADER MOBILE-->
        <header class="header-mobile header-mobile-2 d-block d-lg-none">
            <div class="header-mobile__bar">
                <div class="container-fluid">
                    <div class="header-mobile-inner">
                        <a class="logo" href="index.php">
                            <img src="images/icon/logo-white.png" alt="CoolAdmin" />
                        </a>
                    </div>
                </div>
            </div>
           
        </header>
        <div class="sub-header-mobile-2 d-block d-lg-none">
            <div class="header__tool">
                <div class="account-wrap">
                    <div class="account-item account-item--style2 clearfix js-item-menu">
                        <div class="image">
                             <img src="<?php echo $result['pro_pic'];?>" alt="<?php echo $result['doctor_name'];?>" />
                        </div>
                        <div class="content">
                            <a href="#"><?php echo $result['doctor_name'];?></a>
                        </div>
                        <div class="account-dropdown js-dropdown">
                            <div class="info clearfix">
                                <div class="image">
                                    <a href="#">
                                         <img src="<?php echo $result['pro_pic'];?>" alt="<?php echo $result['doctor_name'];?>" />
                                    </a>
                                </div>
                                <div class="content">
                                    <h5 class="name">
                                        <a href="#"><?php echo $result['doctor_name'];?></a>
                                    </h5>
                                    <span class="email"><?php echo $result['email'];?></span>
                                </div>
                            </div>
                            <div class="account-dropdown__body">
                                <div class="account-dropdown__item">
                                    <a href="#">
                                        <i class="zmdi zmdi-account"></i>Account</a>
                                </div>
                                <div class="account-dropdown__item">
                                    <a href="#">
                                        <i class="zmdi zmdi-settings"></i>Setting</a>
                                </div>
                               
                            </div>
                            <div class="account-dropdown__footer">
                                <a href="?action=logout">
                                  <i class="zmdi zmdi-power"></i>Logout</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END HEADER MOBILE -->
         <?php
             if (isset($updateAppointment)) {
              ?>
              <div class="flash-data" data-flashdata="<?php echo $updateAppointment;?>"></div>
             
                <?php
             }
             ?>
        <!-- PAGE CONTENT-->
        <div class="page-content--bgf7">
            <!-- BREADCRUMB-->
            <section class="au-breadcrumb2">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="au-breadcrumb-content">
                                <div class="au-breadcrumb-left">
                                    <span class="au-breadcrumb-span">You are here:</span>
                                    <ul class="list-unstyled list-inline au-breadcrumb__list">
                                        <li class="list-inline-item active">
                                            <a href="#">Home</a>
                                        </li>
                                        <li class="list-inline-item seprate">
                                            <span>/</span>
                                        </li>
                                        <li class="list-inline-item">Dashboard</li>
                                    </ul>
                                </div>
                                <form class="au-form-icon--sm" action="" method="post">
                                    <input class="au-input--w300 au-input--style2" type="text" placeholder="Search for datas &amp; reports...">
                                    <button class="au-btn--submit2" type="submit">
                                        <i class="zmdi zmdi-search"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- END BREADCRUMB-->

            <!-- WELCOME
            <section class="welcome p-t-10">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <h1 class="title-4">Welcome back
                                <span>John!</span>
                            </h1>
                            <hr class="line-seprate">
                        </div>
                    </div>
                </div>
            </section>
             END WELCOME-->

            <!-- STATISTIC-->
            <section class="statistic statistic2">
                <div class="container">
                    <div class="row">
                        <div class="col-md-6 col-lg-3">
                            <div class="statistic__item statistic__item--green">
                                <h2 class="number"><?php echo $total?></h2>
                                <span class="desc">Total appointment</span>
                                <div class="icon">
                                    <i class="zmdi zmdi-account-o"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-3">
                            <div class="statistic__item statistic__item--orange">
                                <h2 class="number"><?php echo $todaytotal?></h2>
                                <span class="desc">Today's appointment</span>
                                <div class="icon">
                                    <i class="zmdi zmdi-shopping-cart"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-3">
                            <div class="statistic__item statistic__item--blue">
                                <h2 class="number"><?php echo $weekTotal;?></h2>
                                <span class="desc">this week</span>
                                <div class="icon">
                                    <i class="zmdi zmdi-calendar-note"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-3">
                            <div class="statistic__item statistic__item--red">
                                <h2 class="number">$1,060,386</h2>
                                <span class="desc">total earnings</span>
                                <div class="icon">
                                    <i class="zmdi zmdi-money"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- END STATISTIC-->

            <!-- STATISTIC CHART-->
            <section class="statistic-chart">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <h3 class="title-5 m-b-35">statistics</h3>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-lg-4">
                            <!-- CHART-->
                            <div class="statistic-chart-1">
                                <h3 class="title-3 m-b-30">chart</h3>
                                <div class="chart-wrap">
                                    <canvas id="widgetChart5"></canvas>
                                </div>
                                <div class="statistic-chart-1-note">
                                    <span class="big">10,368</span>
                                    <span>/ 16220 items sold</span>
                                </div>
                            </div>
                            <!-- END CHART-->
                        </div>
                        <div class="col-md-6 col-lg-4">
                            <!-- TOP CAMPAIGN-->
                            <div class="top-campaign">
                                <h3 class="title-3 m-b-30">top campaigns</h3>
                                <div class="table-responsive">
                                    <table class="table table-top-campaign">
                                        <tbody>
                                            <tr>
                                                <td>1. Australia</td>
                                                <td>$70,261.65</td>
                                            </tr>
                                            <tr>
                                                <td>2. United Kingdom</td>
                                                <td>$46,399.22</td>
                                            </tr>
                                            <tr>
                                                <td>3. Turkey</td>
                                                <td>$35,364.90</td>
                                            </tr>
                                            <tr>
                                                <td>4. Germany</td>
                                                <td>$20,366.96</td>
                                            </tr>
                                            <tr>
                                                <td>5. France</td>
                                                <td>$10,366.96</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!-- END TOP CAMPAIGN-->
                        </div>
                        <div class="col-md-6 col-lg-4">
                            <!-- CHART PERCENT-->
                            <div class="chart-percent-2">
                                <h3 class="title-3 m-b-30">patient by gender</h3>
                                <div class="chart-wrap">
                                    <canvas id="percent-chart2"></canvas>
                                    <div id="chartjs-tooltip">
                                        <table></table>
                                    </div>
                                </div>
                                <div class="chart-info">
                                    <div class="chart-note">
                                        <span class="dot dot--blue"></span>
                                        <span>Male</span>
                                    </div>
                                    <div class="chart-note">
                                        <span class="dot dot--red"></span>
                                        <span>Female</span>
                                    </div>
                                </div>
                            </div>
                            <!-- END CHART PERCENT-->
                        </div>
                    </div>
                </div>
            </section>
            <!-- END STATISTIC CHART-->

            <!-- DATA TABLE-->
            <section class="p-t-20">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <h3 class="title-5 m-b-35">Appointment table</h3>
                            <div class="table-data__tool">
                                <div class="table-data__tool-left">
                                    <div class="rs-select2--light rs-select2--md">
                                        <select class="js-select2" name="property">
                                            <option selected="selected">All Properties</option>
                                            <option value="">Option 1</option>
                                            <option value="">Option 2</option>
                                        </select>
                                        <div class="dropDownSelect2"></div>
                                    </div>
                                    <div class="rs-select2--light rs-select2--sm">
                                        <select class="js-select2" name="time">
                                            <option selected="selected">Today</option>
                                            <option value="">3 Days</option>
                                            <option value="">1 Week</option>
                                        </select>
                                        <div class="dropDownSelect2"></div>
                                    </div>
                                    <button class="au-btn-filter">
                                        <i class="zmdi zmdi-filter-list"></i>filters</button>
                                </div>
                               
                            </div>
                            <?php
                            if ($total==0) {
                            ?>
                             <p>No recode found</p>
                            <?php
                             }else{
                               ?> 
                            <div class="table-responsive table-responsive-data2">
                                <table class="table table-data2">
                                    <thead>
                                        <tr>
                                            <th>name</th>
                                            <th>phone</th>
                                            <th>description</th>
                                            <th>date</th>
                                            <th>status</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    while ($query = $appointment->fetch(PDO::FETCH_ASSOC)){                            
                                    ?>
                                    <tr class="tr-shadow">  
                                     <td> <?php echo $query['patient_name']; ?> </td>
                                        <td>
                                            <span class="block-email"><?php echo $query['Phone']; ?></span>
                                        </td>
                                        <td class="desc"><?php echo $query['Problem']; ?></td>
                                        <td><?php echo $query['date']." ".$query['time']; ?></td>
                                        <td>
                                            <span class="status--process"><?php echo $query['status']; ?></span>
                                        </td>
                                        <td>
                                        <div class="table-data-feature">
                                       
                                        <a href="prescription_form.php?Aid=<?php echo $query['Appoinment_id'];?>" class="item" data-toggle="tooltip" data-placement="top" title="prescription">
                                           <i class="zmdi zmdi-mail-send"></i>
                                        </a>
                                        
                                        <a href="?Aid=<?php echo $query['Appoinment_id'];?>" class="item" data-toggle="tooltip" data-placement="top" title="Mark as done"><i class="zmdi zmdi-check"></i></a>
                                       
                                        </div>
                                    </td>
                                </tr>
                                <tr class="spacer"></tr>
                                <?php
                            }
                                ?>
                                    </tbody>
                                </table>
                            </div>
                            <?php
                             }

              if ($total > $result_per_page) {
                ?>
                <ul class="pagination justify-content-center">
                <?php
                if ($page==1) {
                    
                  echo "<li class=\"page-item disabled\"><a class=\"page-link\" href=\"doctor_profile.php?page=".($page-1)."\">Previous</a></li>";
                                  
                }else{
                echo "<li class=\"page-item\"><a class=\"page-link\" href=\"doctor_profile.php?page=".($page-1)."\">Previous</a></li>";
                }
                for ($i=1; $i <=$number_of_page ; $i++) { 
                  if ($i==$page) {
                    echo "<li class=\"page-item active\"><a class=\"page-link\" href=\"doctor_profile.php?page=".$i."\">".$i."</a></li>";
                  }else{
                  echo "<li class=\"page-item\"><a class=\"page-link\" href=\"doctor_profile.php?page=".$i."\">".$i."</a></li>";
                  }
                }
                if ($page==$number_of_page) {
                  echo "<li class=\"page-item disabled\"><a class=\"page-link\" href=\"doctor_profile.php?page=".($page+1)."\">Next</a></li>";
                }else{
                  echo "<li class=\"page-item\"><a class=\"page-link\" href=\"doctor_profile.php?page=".($page+1)."\">Next</a></li>";
                }
                ?>
                </ul>
                <?php
              }
              ?>
                        </div>
                    </div>
                </div>
            </section>
            <!-- END DATA TABLE-->

            <!-- COPYRIGHT-->
            <section class="p-t-60 p-b-20">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="copyright">
                                <p>Copyright © 2018 Colorlib. All rights reserved. Template by <a href="https://colorlib.com">Colorlib</a>.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- END COPYRIGHT-->
        </div>

    </div>

    <!-- Jquery JS-->
    <script src="vendor/jquery-3.2.1.min.js"></script>
    <!-- Bootstrap JS-->
    <script src="vendor/bootstrap-4.1/popper.min.js"></script>
    <script src="vendor/bootstrap-4.1/bootstrap.min.js"></script>
    <!-- Vendor JS       -->
    <script src="vendor/slick/slick.min.js">
    </script>
    <script src="vendor/wow/wow.min.js"></script>
    <script src="vendor/animsition/animsition.min.js"></script>
    <script src="vendor/bootstrap-progressbar/bootstrap-progressbar.min.js">
    </script>
    <script src="vendor/counter-up/jquery.waypoints.min.js"></script>
    <script src="vendor/counter-up/jquery.counterup.min.js">
    </script>
    <script src="vendor/circle-progress/circle-progress.min.js"></script>
    <script src="vendor/perfect-scrollbar/perfect-scrollbar.js"></script>
    <script src="vendor/chartjs/Chart.bundle.min.js"></script>
    <script src="vendor/select2/select2.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>


    <!-- Main JS-->
    <script src="js/main_auth.js"></script>
    <script type="text/javascript">
         try {

    // Percent Chart 2
    var ctx = document.getElementById("percent-chart2");
    if (ctx) {
      ctx.height = 209;
      var myChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
          datasets: [
            {
              label: "chart gender",
              data: [<?php echo $totalMale;?>, <?php echo $totalFemale;?>],
              backgroundColor: [
                '#00b5e9',
                '#fa4251'
              ],
              hoverBackgroundColor: [
                '#00b5e9',
                '#fa4251'
              ],
              borderWidth: [
                0, 0
              ],
              hoverBorderColor: [
                'transparent',
                'transparent'
              ]
            }
          ],
          labels: [
            'male',
            'female'
          ]
        },
        options: {
          maintainAspectRatio: false,
          responsive: true,
          cutoutPercentage: 87,
          animation: {
            animateScale: true,
            animateRotate: true
          },
          legend: {
            display: false,
            position: 'bottom',
            labels: {
              fontSize: 14,
              fontFamily: "Poppins,sans-serif"
            }

          },
          tooltips: {
            titleFontFamily: "Poppins",
            xPadding: 15,
            yPadding: 10,
            caretPadding: 0,
            bodyFontSize: 16,
          }
        }
      });
    }

  } catch (error) {
    console.log(error);
  }
  const flashdata=$('.flash-data').data('flashdata');
if (flashdata) {
  swal("Success!", "Appointment marked as Done!!!", "success");
}           
const flashdata1=$('.message').data('flashdata');
    if (flashdata1==1) {
        swal("Success!", "Prescription added successfully", "success");
    }
    </script>

</body>
</html>
<!-- end document-->
