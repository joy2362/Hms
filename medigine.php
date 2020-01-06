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
    $this->Cell(30,10,'Date: 12/12/2020',0,1);
    // Line break
    $this->Ln(10);
}
    function info(){
        $this->Cell(40,10,'Name:joy',0,0);
        $this->Cell(30,10,'Age:21',0,0);
        $this->Cell(30,10,'Gender:Male',0,0);
        $this->Cell(70,10,'Doctor name: zahid',0,0);
        $this->Ln(20);
       
    }
    function tableHeader(){
        $this->Cell(30);
        $this->Cell(10,10,' #',1,0);
        $this->Cell(40,10,'Medicine name',1,0);
        $this->Cell(30,10,'No. of days',1,0);
        $this->Cell(30,10,'Use pattern',1,0);
    }
    function tableValue(){

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
        $sql="SELECT appointment.*, doctor_info.doctor_name FROM appointment INNER JOIN doctor_info ON appointment.doctor_info_id=doctor_info.doctor_info_id
            where appointment.Appoinment_id='$id'";
        $query = $db->conn->prepare($sql);
        $query->execute();
        $result=$query->fetch(PDO::FETCH_ASSOC);
        return $result;
   } catch (PDOException $e) {
        die("somthing wrong".$e->getMessage());
    }
    }
}

if ($_GET['Aid']!="") {
    $aid=$_GET['Aid'];
    $getInfo=new GetInfo();

    $pdf = new PDF();
    $pdf->AddPage();
    $pdf->SetFont('Times','',14);
    $pdf->info();
    $pdf->tableHeader();
    $pdf->output();
    //$pdf->Output('D','Appointment '.$aid.'.pdf');
}
?>

    
        
        
        
