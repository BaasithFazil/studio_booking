<?php

$mysqli = new mysqli("localhost","root","","simple_booking_db");

function placeBooking($name, $email, $mobile, $location, $visit_date){
	
	global $mysqli;

	$t_removed_date = str_replace("T"," ",$visit_date);
	$dateOnly = explode(" ", $t_removed_date);

	$checkExist = mysqli_query($mysqli, "SELECT * FROM tbl_bookings WHERE visit_date LIKE '$dateOnly[0]%' && location = '$location'");
	$checkTime = mysqli_query($mysqli, "SELECT * FROM tbl_bookings WHERE visit_date LIKE '%$dateOnly[1]' && location = '$location'");

	if(mysqli_num_rows($checkExist) >= 3 || mysqli_num_rows($checkTime) > 0){

		$status = "Sorry this slot is not available";

	}else{

		$sql = mysqli_query($mysqli, "INSERT INTO tbl_bookings (name, email, location, mobile, visit_date) VALUES ('$name', '$email', '$location', '$mobile', '$t_removed_date')");

		if($sql == true){

			$status = "Your booking has been placed!";

		}else{

			$status = "Something went wrong";

		}

	}

	return $status;

}

function getAllBookings(){

	global $mysqli;

	$data = [];

	$rest = mysqli_query($mysqli, "SELECT * FROM tbl_bookings ORDER BY id DESC");

	if(mysqli_num_rows($rest) > 0) {

	    while($res = mysqli_fetch_array($rest)){
		   	$id = $res['id'];
		   	$name = $res['name'];
		   	$email = $res['email'];
		   	$mobile = $res['mobile'];
		   	$location = $res['location'];
		   	$visit_date = $res['visit_date'];
		   	$created_at = $res['created_at'];

		   	array_push($data, array(
			   "id"=>$id,
			   "name"=>$name,
			   "email"=>$email,
			   "mobile"=>$mobile,
			   "location"=>$location,
			   "visit_date"=>$visit_date,
			   "created_at"=>$created_at
			));
		}
	}

 	return $data;

}


function generateReport(){

	global $mysqli;

	include 'fpdf/fpdf.php';

	$pdf = new FPDF('L','mm','A4');
	  
	// Add new pages. By default no pages available.
	$pdf->AddPage();

	$pdf->SetFont('Times', 'B', 20);
	$pdf->Cell(250, 5, 'Booking report', 0, 0, 'C');
	$pdf->Ln();
	$pdf->Ln();
	  
	// Set font format and font-size
	$pdf->SetFont('Arial', 'B', 12);
	
	$width_cell=array(50,50,30,40,50,50);

	$pdf->SetFillColor(193,229,252);

	// header starts
	$pdf->Cell($width_cell[0],10,'Name',1,0,'C',true); // First header column 
	$pdf->Cell($width_cell[1],10,'Email',1,0,'C',true); // Second header column
	$pdf->Cell($width_cell[2],10,'Mobile',1,0,'C',true); // Third header column 
	$pdf->Cell($width_cell[3],10,'Location',1,0,'C',true); // Fourth header column
	$pdf->Cell($width_cell[4],10,'Visit Date',1,0,'C',true); // Fourth header column
	$pdf->Cell($width_cell[5],10,'Booking placed',1,1,'C',true); // Fourth header column
	// header is end

	$pdf->SetFont('Arial','',10);

	$rest = mysqli_query($mysqli, "SELECT * FROM tbl_bookings ORDER BY id DESC");

	while($res = mysqli_fetch_array($rest)){
	   	$name = $res['name'];
	   	$email = $res['email'];
	   	$mobile = $res['mobile'];
	   	$location = $res['location'];
	   	$visit_date = $res['visit_date'];
	   	$created_at = $res['created_at'];

	   	// table row loop
		$pdf->Cell($width_cell[0],10,$name,1,0,'C',false); // First column of row 1 
		$pdf->Cell($width_cell[1],10,$email,1,0,'C',false); // Second column of row 1 
		$pdf->Cell($width_cell[2],10,$mobile,1,0,'C',false); // Third column of row 1 
		$pdf->Cell($width_cell[3],10,$location,1,0,'C',false); // Fourth column of row 1 
		$pdf->Cell($width_cell[4],10,$visit_date,1,0,'C',false); // Fourth column of row 1 
		$pdf->Cell($width_cell[5],10,$created_at,1,1,'C',false); // Fourth column of row 1 

	}

	date_default_timezone_set("Asia/Colombo");
	$date = date("Y-m-d h:i:sa");

	$filename = "booking-report-".$date.".pdf";

	$pdf->Output('D',$filename);
	
}











?>