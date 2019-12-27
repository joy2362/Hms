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
    $this->Cell(70,10,'Appointment Information',1,0,'C');
    // Line break
    $this->Ln(20);
}

// Page footer
function Footer()
{
    // Position at 1.5 cm from bottom
    $this->SetY(-15);
    // Arial italic 8
    $this->SetFont('Arial','I',8);
    // Page number
    $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
}
}

class GetInfo 
{
    
    public function getAppointment($db,$id){
         try {
        $sql="select * from appointment where Appoinment_id='$id'";
        $query = $db->conn->prepare($sql);
        $query->execute();
        $result=$query->fetch(PDO::FETCH_ASSOC);
        return $result;
   } catch (PDOException $e) {
        die("somthing wrong".$e->getMessage());
    }
    }
    public function getDoctor($db,$id){
         try {
        $sql="select * from doctor_info where doctor_info_id='$id'";
        $query = $db->conn->prepare($sql);
        $query->execute();
        $doctor=$query->fetch(PDO::FETCH_ASSOC); 
        return $doctor;
      } catch (PDOException $e) {
        die("somthing wrong".$e);
      }
    }
     public function getUser($db,$id){
         try {
        $sql="select * from user_info where user_info_id='$id'";
        $query = $db->conn->prepare($sql);
        $query->execute();
        $user=$query->fetch(PDO::FETCH_ASSOC); 
        return $user;
      } catch (PDOException $e) {
        die("somthing wrong".$e);
      }
    }
}

if ($_GET['Aid']!="") {
    $aid=$_GET['Aid'];
    $getInfo=new GetInfo();
    $result=$getInfo->getAppointment($db,$aid);
    $docId=$result['Doctor_info_id'];
    $userId=$result['user_info_id'];
    $doctor=$getInfo->getDoctor($db,$docId);
    $user=$getInfo->getUser($db,$userId);

    $pdf = new PDF();
    //$pdf->AliasNbPages();
    $pdf->AddPage();
    $pdf->SetFont('Times','',12);
    $pdf->SetTopMargin(75);
    $pdf->Cell(90,10,'Name:'.$result['patient_name'],0,0);
    $pdf->Cell(75,10,'Doctor name: '.$doctor['doctor_name'],0,1);

    $pdf->Cell(90,10,'Phone: '.$result['Phone'],0,0);
    $pdf->Cell(75,10,'Department: '.$doctor['department'],0,1);

    $pdf->Cell(90,10,'Address: '.$user['address'],0,0);
    $pdf->Cell(75,10,'Date: '.$result['date'].' '.$result['time'],0,1);
    $pdf->Cell(90,10,'Problem: '.$result['Problem'],0,1);

    $pdf->Output('D','Appointment '.$aid.'.pdf');
}
?>

    
        
        
        
