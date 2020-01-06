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

if (isset($_GET['action']) && $_GET['action']=="logout") {
    Session::destroy();
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
                   
                    <div class="header__tool">
                        <div class="header-button-item has-noti js-item-menu">
                            <i class="zmdi zmdi-notifications"></i>
                            <div class="notifi-dropdown notifi-dropdown--no-bor js-dropdown">
                                <div class="notifi__title">
                                    <p>You have 3 Notifications</p>
                                </div>
                                <div class="notifi__item">
                                    <div class="bg-c1 img-cir img-40">
                                        <i class="zmdi zmdi-email-open"></i>
                                    </div>
                                    <div class="content">
                                        <p>You got a email notification</p>
                                        <span class="date">April 12, 2018 06:50</span>
                                    </div>
                                </div>
                                <div class="notifi__item">
                                    <div class="bg-c2 img-cir img-40">
                                        <i class="zmdi zmdi-account-box"></i>
                                    </div>
                                    <div class="content">
                                        <p>Your account has been blocked</p>
                                        <span class="date">April 12, 2018 06:50</span>
                                    </div>
                                </div>
                                <div class="notifi__item">
                                    <div class="bg-c3 img-cir img-40">
                                        <i class="zmdi zmdi-file-text"></i>
                                    </div>
                                    <div class="content">
                                        <p>You got a new file</p>
                                        <span class="date">April 12, 2018 06:50</span>
                                    </div>
                                </div>
                                <div class="notifi__footer">
                                    <a href="#">All notifications</a>
                                </div>
                            </div>
                        </div>
                        <div class="header-button-item js-item-menu">
                            <i class="zmdi zmdi-settings"></i>
                            <div class="setting-dropdown js-dropdown">
                                <div class="account-dropdown__body">
                                    <div class="account-dropdown__item">
                                        <a href="#">
                                            <i class="zmdi zmdi-account"></i>Account</a>
                                    </div>
                                    <div class="account-dropdown__item">
                                        <a href="#">
                                            <i class="zmdi zmdi-settings"></i>Setting</a>
                                    </div>
                                    <div class="account-dropdown__item">
                                        <a href="#">
                                            <i class="zmdi zmdi-money-box"></i>Billing</a>
                                    </div>
                                </div>
                                <div class="account-dropdown__body">
                                    <div class="account-dropdown__item">
                                        <a href="#">
                                            <i class="zmdi zmdi-globe"></i>Language</a>
                                    </div>
                                    <div class="account-dropdown__item">
                                        <a href="#">
                                            <i class="zmdi zmdi-pin"></i>Location</a>
                                    </div>
                                    <div class="account-dropdown__item">
                                        <a href="#">
                                            <i class="zmdi zmdi-email"></i>Email</a>
                                    </div>
                                    <div class="account-dropdown__item">
                                        <a href="#">
                                            <i class="zmdi zmdi-notifications"></i>Notifications</a>
                                    </div>
                                </div>
                            </div>
                        </div>
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
                                        <div class="account-dropdown__item">
                                            <a href="#">
                                                <i class="zmdi zmdi-money-box"></i>Billing</a>
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
                        <a class="logo" href="index.html">
                            <img src="images/icon/logo-white.png" alt="CoolAdmin" />
                        </a>
                        <button class="hamburger hamburger--slider" type="button">
                            <span class="hamburger-box">
                                <span class="hamburger-inner"></span>
                            </span>
                        </button>
                    </div>
                </div>
            </div>
            <nav class="navbar-mobile">
                <div class="container-fluid">
                    <ul class="navbar-mobile__list list-unstyled">
                        <li>
                            <a  href="index.html">
                            <i class="fas fa-tachometer-alt"></i>Dashboard</a>
                        </li>
                        <li>
                            <a href="chart.html">
                                <i class="fas fa-chart-bar"></i>Charts</a>
                        </li>
                        <li>
                            <a href="table.html">
                                <i class="fas fa-table"></i>Tables</a>
                        </li>
                        <li>
                            <a href="form.html">
                                <i class="far fa-check-square"></i>Forms</a>
                        </li>
                        <li>
                            <a href="calendar.html">
                                <i class="fas fa-calendar-alt"></i>Calendar</a>
                        </li>
                        <li>
                            <a href="map.html">
                                <i class="fas fa-map-marker-alt"></i>Maps</a>
                        </li>
                        <li class="has-sub">
                            <a class="js-arrow" href="#">
                                <i class="fas fa-copy"></i>Pages</a>
                            <ul class="navbar-mobile-sub__list list-unstyled js-sub-list">
                                <li>
                                    <a href="login.html">Login</a>
                                </li>
                                <li>
                                    <a href="register.html">Register</a>
                                </li>
                                <li>
                                    <a href="forget-pass.html">Forget Password</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>
        <div class="sub-header-mobile-2 d-block d-lg-none">
            <div class="header__tool">
                <div class="header-button-item has-noti js-item-menu">
                    <i class="zmdi zmdi-notifications"></i>
                    <div class="notifi-dropdown notifi-dropdown--no-bor js-dropdown">
                        <div class="notifi__title">
                            <p>You have 3 Notifications</p>
                        </div>
                        <div class="notifi__item">
                            <div class="bg-c1 img-cir img-40">
                                <i class="zmdi zmdi-email-open"></i>
                            </div>
                            <div class="content">
                                <p>You got a email notification</p>
                                <span class="date">April 12, 2018 06:50</span>
                            </div>
                        </div>
                        <div class="notifi__item">
                            <div class="bg-c2 img-cir img-40">
                                <i class="zmdi zmdi-account-box"></i>
                            </div>
                            <div class="content">
                                <p>Your account has been blocked</p>
                                <span class="date">April 12, 2018 06:50</span>
                            </div>
                        </div>
                        <div class="notifi__item">
                            <div class="bg-c3 img-cir img-40">
                                <i class="zmdi zmdi-file-text"></i>
                            </div>
                            <div class="content">
                                <p>You got a new file</p>
                                <span class="date">April 12, 2018 06:50</span>
                            </div>
                        </div>
                        <div class="notifi__footer">
                            <a href="#">All notifications</a>
                        </div>
                    </div>
                </div>
                <div class="header-button-item js-item-menu">
                    <i class="zmdi zmdi-settings"></i>
                    <div class="setting-dropdown js-dropdown">
                        <div class="account-dropdown__body">
                            <div class="account-dropdown__item">
                                <a href="#">
                                    <i class="zmdi zmdi-account"></i>Account</a>
                            </div>
                            <div class="account-dropdown__item">
                                <a href="#">
                                    <i class="zmdi zmdi-settings"></i>Setting</a>
                            </div>
                            <div class="account-dropdown__item">
                                <a href="#">
                                    <i class="zmdi zmdi-money-box"></i>Billing</a>
                            </div>
                        </div>
                        <div class="account-dropdown__body">
                            <div class="account-dropdown__item">
                                <a href="#">
                                    <i class="zmdi zmdi-globe"></i>Language</a>
                            </div>
                            <div class="account-dropdown__item">
                                <a href="#">
                                    <i class="zmdi zmdi-pin"></i>Location</a>
                            </div>
                            <div class="account-dropdown__item">
                                <a href="#">
                                    <i class="zmdi zmdi-email"></i>Email</a>
                            </div>
                            <div class="account-dropdown__item">
                                <a href="#">
                                    <i class="zmdi zmdi-notifications"></i>Notifications</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="account-wrap">
                    <div class="account-item account-item--style2 clearfix js-item-menu">
                        <div class="image">
                            <img src="images/icon/avatar-01.jpg" alt="John Doe" />
                        </div>
                        <div class="content">
                            <a class="js-acc-btn" href="#">john doe</a>
                        </div>
                        <div class="account-dropdown js-dropdown">
                            <div class="info clearfix">
                                <div class="image">
                                    <a href="#">
                                        <img src="images/icon/avatar-01.jpg" alt="John Doe" />
                                    </a>
                                </div>
                                <div class="content">
                                    <h5 class="name">
                                        <a href="#">john doe</a>
                                    </h5>
                                    <span class="email">johndoe@example.com</span>
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
                                <div class="account-dropdown__item">
                                    <a href="#">
                                        <i class="zmdi zmdi-money-box"></i>Billing</a>
                                </div>
                            </div>
                            <div class="account-dropdown__footer">
                                <a href="#">
                                    <i class="zmdi zmdi-power"></i>Logout</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END HEADER MOBILE -->

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
                                            <a href="index.php">Home</a>
                                        </li>
                                        <li class="list-inline-item seprate">
                                            <span>/</span>
                                        </li>
                                        <li class="list-inline-item">Profile</li>
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
            <div class="container">
                <div class="row">
                    
                </div>
            </div>
   

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
    <script src="vendor/select2/select2.min.js">
    </script>

    <!-- Main JS-->
    <script src="js/main_auth.js"></script>

</body>

</html>
<!-- end document-->
