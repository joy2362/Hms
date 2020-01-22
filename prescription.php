<?php
include('database.php');
require('fpdf/fpdf.php');
$db=new Database();

class PDF extends FPDF
{
// Page header
function Header()
{
    // Arial bold 15
    $this->SetFont('Arial','B',15);
    // Move to the right
    $this->Cell(60);
    // Title
    $this->Cell(70,10,'prescription',1,0,'C');
    $this->Cell(20);
    $this->SetFont('Arial','B',10);
    $this->Cell(30,10,'Date:'.date("d-m-Y"),0,1);
    // Line break
    $this->Ln(15);
}
    function info($data){
        $this->Cell(60,10,'Name:'.$data['full_name'],0,0);
        $this->Cell(20,10,'Age:'.$data['age'],0,0);
        $this->Cell(30,10,'Gender:'.$data['gender'],0,0);
        $this->Cell(70,10,'Doctor name:'.$data['doctor_name'],0,0);
        $this->Ln(20);
       
    }

    function tableHeader(){
        $this->Cell(30);
        $this->Cell(10,10,' #',1,0);
        $this->Cell(40,10,'Medicine name',1,0);
        $this->Cell(30,10,'No. of days',1,0);
        $this->Cell(30,10,'Use pattern',1,1);

    }
    function tableValue($data){
        while ($row=$data->fetch(PDO::FETCH_ASSOC)) {
        $this->Cell(30);
        $this->Cell(10,10,$row['medicine_id'],1,0);
        $this->Cell(40,10,$row['mname'],1,0);
        $this->Cell(30,10,$row['days'],1,0);
        $this->Cell(30,10,$row['pattern'],1,1);
        }
    }
// Page footer
function Footer()
{
    // Position at 1.5 cm from bottom
    $this->SetY(-15);
    // Arial italic 8
    $this->SetFont('Arial','I',8);
    // Page number
    $this->Cell(0,10,'Page '.$this->PageNo(),0,0,'C');
}
}

class GetInfo 
{
    public function getAppointment($db,$id){
        try {
        $sql="SELECT appointment.*, doctor_info.doctor_name,user_info.* FROM appointment ,doctor_info ,user_info  where appointment.doctor_info_id=doctor_info.doctor_info_id and appointment.user_info_id=user_info.user_info_id
            and appointment.Appoinment_id='$id'";
        $query = $db->conn->prepare($sql);
        $query->execute();
        $result=$query->fetch(PDO::FETCH_ASSOC);
        return $result;
   } catch (PDOException $e) {
        die("somthing wrong".$e->getMessage());
    }
    }
    public function medicine($db,$id){
         try {
        $sql="SELECT * FROM medicine where Appoinment_id='$id'";
        $query = $db->conn->prepare($sql);
        $query->execute();
        return $query;
        return $result;
   } catch (PDOException $e) {
        die("somthing wrong".$e->getMessage());
    }
    }
}
if ($_GET['Aid']!="") {
    $aid=$_GET['Aid'];
    $getInfo=new GetInfo();
    $result=$getInfo->getAppointment($db,$aid);
    $medicine=$getInfo->medicine($db,$aid);
    $pdf = new PDF();
    $pdf->AddPage();
    $pdf->SetFont('Times','',14);
    $pdf->info($result);
    $pdf->tableHeader();
    $pdf->tableValue($medicine);
    $pdf->Output('D','prescription '.$aid.'.pdf');
}
?>

    
        
        
        
