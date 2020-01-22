<?php 
	include_once 'database.php';
	$db=new Database();
	try {
		$sql="select * from site_info where site_info_id='1'";
		 $query = $db->conn->prepare($sql);
	     $query->execute();
	     $result=$query->fetch(PDO::FETCH_ASSOC);
	} catch (PDOException $e) {
		die("somthing wrong ".$e->getMessage());
	}
?>
<nav class="navbar py-4 navbar-expand-lg ftco_navbar navbar-light bg-light flex-row">
    	<div class="container">
    		<div class="row no-gutters d-flex align-items-start align-items-center px-3 px-md-0">
    			<div class="col-lg-2 pr-4 align-items-center">
		    		<a class="navbar-brand" href="index.php"><?php echo $result['institute_name']?></a>
	    		</div>
	    		<div class="col-lg-10 d-none d-md-block">
		    		<div class="row d-flex">
			    		<div class="col-md-4 pr-4 d-flex topper align-items-center">
			    			<div class="icon bg-white mr-2 d-flex justify-content-center align-items-center"><span class="icon-map"></span></div>
						    <span class="text">Address: <?php echo $result['adress']?></span>
					    </div>
					    <div class="col-md pr-4 d-flex topper align-items-center">
					    	<div class="icon bg-white mr-2 d-flex justify-content-center align-items-center"><span class="icon-paper-plane"></span></div>
						    <span class="text">Email: <?php echo $result['email']?></span>
					    </div>
					    <div class="col-md pr-4 d-flex topper align-items-center">
					    	<div class="icon bg-white mr-2 d-flex justify-content-center align-items-center"><span class="icon-phone2"></span></div>
						    <span class="text">Phone: <?php echo $result['phone']?></span>
					    </div>
				    </div>
			    </div>
		    </div>
		  </div>
    </nav>