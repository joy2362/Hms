<?php
include_once 'database.php';
include_once 'session.php';
$db=new Database();

class Medicine{
  
 public function getAppointment($db,$aid){
     try {
        $sql=" SELECT c.* , d.*,o.doctor_name FROM appointment c,user_info d,doctor_info o WHERE c.user_info_id=d.user_info_id and c.doctor_info_id=o.doctor_info_id and c.Appoinment_id='$aid' ";
        $query = $db->conn->prepare($sql);
        $query->execute();
        $result=$query->fetch(PDO::FETCH_ASSOC);
        return $result;
      } catch (PDOException $e) {
        die("somthing wrong".$e->getMessage());
      }
  }
}
Session::init();
$type = Session::get("type");
if (!isset($_GET['Aid']) && $type!='doctor') {
  header("location:index.php");
}else{
  $aid=$_GET['Aid'];
  $medicine=new Medicine();
  $appointment=$medicine->getAppointment($db,$aid);
}

?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
  <style type="text/css">
  .about{
  text-align: center;
  margin-top: 25px;
}
.about h2{
  display: inline-block;
  padding:5px; 
  border: 1px solid black;
  font-family: 'Fjalla One', sans-serif;
}
.details{
  margin: 10px;
  font-size: 20px;
}
#submit{
  margin-left: 10px;
}
  </style>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
</head>
<body>
 <div class="about">
    <h2>Prescription</h2>
</div>
<div class="container-fluid">
<div class="row">
  <div class="col-sm-3">
   <p class="details">Patient name: <?php echo $appointment['full_name']?></p>
  </div>
  <div class="col-sm-2">
   <p class="details">Age: <?php echo $appointment['age']?></p>
  </div>
  <div class="col-sm-2">
   <p class="details">Gender: <?php echo $appointment['gender']?></p>
  </div>
  <div class="col-sm-3">
   <p class="details">Doctor name: <?php echo $appointment['doctor_name']?></p>
  </div>
  <div class="col-sm-2">
   <p class="details">Date: <?php echo $appointment['date']?></p>
  </div>
</div>
</div>
	<form method="post" id="prescription">
		<div class="table-responsive">
			<table class="table table-bordered" id="item-table">        
				<tr>
					<td><input type="text" name="mname[]" placeholder="Medicine name" id="mname" class="form-control mname_list"></td>
					<td><input type="text" name="day[]" placeholder="no. of days" id="day" class="form-control day_list"></td>
					<td><input type="text" name="pattern[]" placeholder="use pattern" id="pattern" class="form-control pattern_list"></td>
          <td><button type="button" class="btn btn-info font-weight-bold" name="add" id="add" data-toggle="tooltip" data-placement="top" title="add more medicine">+</button></td>			
				</tr>
			</table>
		</div>
    <input type="hidden" name="aid" value="<?php echo  $aid?>">
		<input type="submit" name="submit" id="submit" class="btn btn-outline-success" value="Save">
	</form>
	<script src="js/jquery.min.js"></script>
  <script src="js/jquery-migrate-3.0.1.min.js"></script>
  <script type="text/javascript">
  	$(document).ready(function(){
  		var i=1;
  		$('#add').click(function(){
  			i++;
  			$('#item-table').append('<tr id="row'+i+'"><td><input type="text" name="mname[]"placeholder="Medicine name" id="mname"class="form-control mname_list"></td><td><input type="text" name="day[]" placeholder="no. of days" id="day" class="form-control day_list"></td><td><input type="text" name="pattern[]" placeholder="use pattern" id="pattern" class="form-control pattern_list"></td><td><button type="button" class="btn btn-danger btn_remove" name="remove" data-toggle="tooltip" data-placement="top" title="removed" id="'+i+'">X</button></td></tr>');
  		});
  		$(document).on('click','.btn_remove',function(){
  			var btn=$(this).attr("id");
  			//console.log(btn);
  			$('#row'+btn+'').remove();
  		});
  		$('#submit').click(function(){
  			$.ajax({
  				url:'medicine.php',
  				method:"POST",
  				data:$('#prescription').serialize(),
  				success:function(data){
            alert(data);
  					$('#prescription')[0].reset();
  				}
  			});
  		});
  	})
  </script>
  <!-- Popper JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<!-- jQuery library -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
</body>
</html>