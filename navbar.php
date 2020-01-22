  <nav class="navbar navbar-expand-lg navbar-dark bg-dark ftco-navbar-light" id="ftco-navbar">
    <div class="container d-flex align-items-center">
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav" aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="oi oi-menu"></span> Menu
      </button>
      <p class="button-custom order-lg-last mb-0"><a href="doctor.php" class="btn btn-secondary py-2 px-3">Make An Appointment</a></p>
      <div class="collapse navbar-collapse" id="ftco-nav">
        <ul class="navbar-nav mr-auto">
        	<li class="nav-item <?php if($page=="index"){echo "active";}?>"><a href="index.php" class="nav-link pl-0">Home</a></li>
        	<li class="nav-item <?php if($page=="about"){echo "active";}?>"><a href="about.php" class="nav-link">About</a></li>
        	<li class="nav-item <?php if($page1=="doctor"){echo "active";}?>"><a href="doctor.php" class="nav-link">Doctor</a></li>
        	<li class="nav-item <?php if($page=="department"){echo "active";}?>"><a href="department.php" class="nav-link">Departments</a></li>
        	<li class="nav-item <?php if($page=="pricing"){echo "active";}?>"><a href="pricing.php" class="nav-link">Pricing</a></li>
        	<li class="nav-item <?php if($page1=="blog"){echo "active";}?>"><a href="blog.php" class="nav-link">Blog</a></li>
          <li class="nav-item <?php if($page=="contract"){echo "active";}?>"><a href="contact.php" class="nav-link">Contact</a></li>
           <?php
          	$login=Session::get("login");
          	if ($login==0) {
          		?>
          		<li class="nav-item "><a href="signin.php" class="nav-link">Login</a></li>
          		<li class="nav-item"><a href="reg.php" class="nav-link">Registation</a></li>
          	<?php	
          	}else{
          	?>
          		<li class="nav-item <?php if($page=="profile"){echo "active";}?>"><a href="<?php echo $type;?>_profile.php" class="nav-link">Profile</a></li>
				    <li class="nav-item "><a href="?action=logout" class="nav-link">Log out</a></li>
          	<?php
          	}
          ?>
        </ul>
      </div>
    </div>
  </nav>