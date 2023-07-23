<?php

session_start(); // Don't forget to start the session to use session variables.

include 'functions.php';

if (isset($_POST['bookbtn'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $mobile = $_POST['mobile'];
    $location = $_POST['location'];
    $visitdate = $_POST['visitdate'];

    // Validate if all fields are filled
    if ($name == "" || $email == "" || $mobile == "" || $location == "" || $visitdate == "") {
        $status = "All fields are required";
    } else {
        // Convert current date and time to a timestamp
        $current_timestamp = time();

        // Convert the selected visit date to a timestamp
        $selected_timestamp = strtotime($visitdate);

        // Check if the selected visit date is in the past or too far in the future (e.g., 7 days from now)
        $valid_range = 7 * 24 * 60 * 60; // 7 days in seconds
        if ($selected_timestamp < $current_timestamp || ($selected_timestamp - $current_timestamp) > $valid_range) {
            $status = "Invalid visit date. Please select a date within the next 7 days.";
        } else {
            $status = placeBooking($name, $email, $mobile, $location, $visitdate);

            $_SESSION['booking_time'] = time();

            header("Location: payment.php");
            exit;
        }
    }
}

// Check if there is a booking time set in the session
if (isset($_SESSION['booking_time'])) {
    // Calculate the elapsed time in seconds since the booking
    $elapsed_time = time() - $_SESSION['booking_time'];

    // Check if 2 hours (7200 seconds) have passed since the booking
    if ($elapsed_time >= 7200) {
        // Cancel the booking
        $status = "Booking canceled due to non-payment.";
        unset($_SESSION['booking_time']); // Remove the booking time session variable
    }
}

?>


<!doctype html>
<html lang="en">
<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="styles.css">
	<!-- Bootstrap CSS -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

	<title>Booking</title>
</head>
<body>
	<?php
		if(isset($status)){
			echo "<div class='alert alert-primary'>".$status."</div>";
		}

	?>

	<form method="post">
		<h4>Reserve your place</h4>
		<div class="mb-3">
			<label for="exampleInputEmail1" class="form-label">Customer name</label>
			<input type="text" class="form-control" name="name" aria-describedby="emailHelp">
		</div>
		<div class="mb-3">
			<label for="exampleInputPassword1" class="form-label">Email</label>
			<input type="email" class="form-control" name="email">
		</div>
		<div class="mb-3">
			<label for="exampleInputPassword1" class="form-label">Mobile</label>
			<input type="text" class="form-control" name="mobile">
		</div>
		<div class="mb-3">
			<label for="exampleInputPassword1" class="form-label">Location</label>
			<select class="form-select" name="location" aria-label="Default select example">
			<option value="Ampara">Ampara</option>
				<option value="Anuradhapura">Anuradhapura</option>
				<option value="Badulla">Badulla</option>
				<option value="Batticaloa">Batticaloa</option>
				<option value="Colombo">Colombo</option>
				<option value="Galle">Galle</option>
				<option value="Gampaha">Gampaha</option>
				<option value="Hambantota">Hambantota</option>
				<option value="Jaffna">Jaffna</option>
				<option value="Kalutara">Kalutara</option>
				<option value="Kandy">Kandy</option>
				<option value="Kegalle">Kegalle</option>
				<option value="Kilinochchi">Kilinochchi</option>
				<option value="Kurunegala">Kurunegala</option>
				<option value="Mannar">Mannar</option>
				<option value="Matale">Matale</option>
				<option value="Matara">Matara</option>
				<option value="Moneragala">Moneragala</option>
				<option value="Mullaitivu">Mullaitivu</option>
				<option value="Nuwara Eliya">Nuwara Eliya</option>
				<option value="Polonnaruwa">Polonnaruwa</option>
				<option value="Puttalam">Puttalam</option>
				<option value="Ratnapura">Ratnapura</option>
				<option value="Trincomalee">Trincomalee</option>
				<option value="Vavuniya">Vavuniya</option>
			</select>
		</div>
		<div class="mb-3">
			<label for="exampleInputPassword1" class="form-label">Visit date</label>
			<input type="datetime-local" class="form-control" name="visitdate" step="3600">
		</div>

		<button type="submit" name="bookbtn" class="btn btn-primary">Submit</button>
	</form>

	<div class="modal fade" id="bookingConfirmationModal" tabindex="-1" aria-labelledby="bookingConfirmationModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="bookingConfirmationModalLabel">Booking Confirmed</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p>Please pay half payment to continue your registration.</p>
        <p>If payment is not made within 2 hours, your booking will be removed.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
	<!-- Optional JavaScript; choose one of the two! -->

	<!-- Option 1: Bootstrap Bundle with Popper -->
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

	<!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
-->
</body>
</html>