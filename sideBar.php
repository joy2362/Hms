<?php
  function numberOfDoctor($db,$department){
    try {
      $query = $db->conn->prepare("select * from doctor_info where department='$department'");
      $query->execute();
      return $query->rowCount();
    } catch (PDOException $e) {
      die("somthing wrong " .$e->getMessage());
    }
  }

  function getBlog($db){
    try {
      $sql="select * from blog order by blog_id DESC LIMIT 3";
      $query = $db->conn->prepare($sql);
      $query->execute();
      return $query;
    } catch (PDOException $e) {
      die("somthing wrong " .$e->getMessage());
    }
  }
  $blog=getBlog($db);
?>

<div class="col-lg-4 sidebar ftco-animate">
  <div class="sidebar-box ftco-animate">
    <h3>Category</h3>
    <ul class="categories">
      <li><a href="doctor.php?department=Neurology">Neurology <span>(<?php echo numberOfDoctor($db,"Neurology")?>)</span></a></li>
      <li><a href="doctor.php?department=Cardiology">Cardiology <span>(<?php echo numberOfDoctor($db,"Cardiology")?>)</span></a></li>
      <li><a href="doctor.php?department=Surgery">Surgery <span>(<?php echo numberOfDoctor($db,"Surgery")?>)</span></a></li>
      <li><a href="doctor.php?department=Dental">Dental <span>(<?php echo numberOfDoctor($db,"Dental")?>)</span></a></li>
      <li><a href="doctor.php?department=Ophthalmology">Ophthalmology <span>(<?php echo numberOfDoctor($db,"Ophthalmology")?>)</span></a></li>
    </ul>
  </div>

  <div class="sidebar-box ftco-animate">
    <h3>Popular Articles</h3>
    <?php
      while ($info = $blog->fetch(PDO::FETCH_ASSOC)){        
    ?>
    <div class="block-21 mb-4 d-flex">
      <a class="blog-img mr-4" style="background-image: url(<?php echo $info['picture'];?>);"></a>
      <div class="text">
        <h3 class="heading"><a href="blog-single.php?id=<?php echo $info['blog_id']?>"><?php echo $info['blog_tittle'];?></a></h3>
        <div class="meta">
          <div><a href="#"><span class="icon-calendar"></span> <?php echo $info['publish_date']?></a></div>
          <div><a href="#"><span class="icon-person"></span> Dave Lewis</a></div>
          <div><a href="#"><span class="icon-chat"></span> 19</a></div>
        </div>
      </div>
    </div> 
    <?php
  }
    ?>      
  </div>

</div>