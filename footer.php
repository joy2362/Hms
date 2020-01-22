  <?php
  try {
    $sql="select * from site_info where site_info_id='1'";
     $query = $db->conn->prepare($sql);
       $query->execute();
       $result=$query->fetch(PDO::FETCH_ASSOC);
  } catch (PDOException $e) {
    die("somthing wrong ".$e->getMessage());
  }
  try {
      $sql="select * from blog order by blog_id DESC LIMIT 2";
      $query = $db->conn->prepare($sql);
      $query->execute();
    } catch (PDOException $e) {
      die("somthing wrong " .$e->getMessage());
    }
  
  ?>

  <footer class="ftco-footer ftco-bg-dark ftco-section">
      <div class="container">
        <div class="row mb-5">
          <div class="col-md">
            <div class="ftco-footer-widget mb-5">
              <h2 class="ftco-heading-2 logo"><?php echo $result['institute_name']?></h2>
              <p><?php echo $result['description']?></p>
            </div>
            <div class="ftco-footer-widget mb-5">
              <h2 class="ftco-heading-2">Have a Questions?</h2>
              <div class="block-23 mb-3">
                <ul>
                  <li><span class="icon icon-map-marker"></span><span class="text"><?php echo $result['adress']?></span></li>
                  <li><a href="#"><span class="icon icon-phone"></span><?php echo $result['phone']?></a></li>
                  <li><a href="#"><span class="icon icon-envelope"></span><span class="text"><?php echo $result['email']?></span></a></li>
                </ul>
              </div>

              <ul class="ftco-footer-social list-unstyled float-md-left float-lft mt-3">
                <li class="ftco-animate"><a href="<?php echo $result['facebook_link']?>"><span class="icon-facebook"></span></a></li>
                <li class="ftco-animate"><a href="<?php echo $result['twitter_link']?>"><span class="icon-twitter"></span></a></li>
                <li class="ftco-animate"><a href="<?php echo $result['instagram_link']?>"><span class="icon-instagram"></span></a></li>
              </ul>
            </div>
          </div>
          <div class="col-md">
            <div class="ftco-footer-widget mb-5 ml-md-4">
              <h2 class="ftco-heading-2">Links</h2>
              <ul class="list-unstyled">
                <li><a href="index.php"><span class="ion-ios-arrow-round-forward mr-2"></span>Home</a></li>
                <li><a href="#"><span class="ion-ios-arrow-round-forward mr-2"></span>About</a></li>
                <li><a href="#"><span class="ion-ios-arrow-round-forward mr-2"></span>Services</a></li>
                <li><a href="#"><span class="ion-ios-arrow-round-forward mr-2"></span>Deparments</a></li>
                <li><a href="#"><span class="ion-ios-arrow-round-forward mr-2"></span>Contact</a></li>
              </ul>
            </div>
            <div class="ftco-footer-widget mb-5 ml-md-4">
              <h2 class="ftco-heading-2">Services</h2>
              <ul class="list-unstyled">
                <li><a href="doctor.php?department=Neurology"><span class="ion-ios-arrow-round-forward mr-2"></span>Neurolgy</a></li>
                <li><a href="doctor.php?department=Dental"><span class="ion-ios-arrow-round-forward mr-2"></span>Dentist</a></li>
                <li><a href="doctor.php?department=Ophthalmology"><span class="ion-ios-arrow-round-forward mr-2"></span>Ophthalmology</a></li>
                <li><a href="doctor.php?department=Cardiology"><span class="ion-ios-arrow-round-forward mr-2"></span>Cardiology</a></li>
                <li><a href="doctor.php?department=Surgery"><span class="ion-ios-arrow-round-forward mr-2"></span>Surgery</a></li>
              </ul>
            </div>
          </div>
          <div class="col-md">
            <div class="ftco-footer-widget mb-5">
              <h2 class="ftco-heading-2">Recent Blog</h2>
              <?php
              while ($info = $query->fetch(PDO::FETCH_ASSOC)){
                ?>
              <div class="block-21 mb-4 d-flex">
                <a class="blog-img mr-4" style="background-image: url(<?php echo $info['picture'];?>);"></a>
                <div class="text">
                  <h3 class="heading"><a href="blog-single.php?id=<?php echo $info['blog_id']?>"><?php echo $info['blog_tittle'];?></a></h3>
                  <div class="meta">
                    <div><a href="blog-single.php?id=<?php echo $info['blog_id']?>"><span class="icon-calendar"></span> <?php echo $info['publish_date']?></a></div>
                    <div><a href="blog-single.php?id=<?php echo $info['blog_id']?>"><span class="icon-person"></span> <?php echo $info['user_id'];?></a></div>
                    <div><a href="blog-single.php?id=<?php echo $info['blog_id']?>"><span class="icon-chat"></span> 19</a></div>
                  </div>
                </div>
              </div>
              <?php
              }
                ?>

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

            <p>Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | This template is made with <i class="icon-heart" aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank">Colorlib</a></p>

          </div>
        </div>
      </div>
    </footer>