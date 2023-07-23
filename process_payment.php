<!-- process_payment.php -->

<?php
if (isset($_POST['paybtn'])) {
    // Here, you can simulate a successful payment.
    // In a real application, this should be handled securely using a payment gateway.
    // For testing purposes only, we'll assume payment is successful.
    $status = "Payment successful. Reservation confirmed!";
    // Clear the booking time session variable after successful payment
} else {
    // If the user accesses this page directly without submitting the payment form,
    // redirect them back to the payment page or somewhere else as needed.
    header("Location: payment.php");
    exit; // Make sure to exit to prevent further script execution
}
?>

<!doctype html>
<html lang="en">
<head>
    <!-- ... Your payment processing result page head section ... -->
    <title>Payment Result</title>

    <style>
        /* Container styling */
        body {
            font-family: Arial, sans-serif;
            background-color: #f7f7f7;
            margin: 0;
            padding: 20px;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .container {
            max-width: 500px;
            padding: 20px;
            background-color: #ffffff;
            border: 1px solid #ccc;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        /* Payment result styling */
        h2 {
            text-align: center;
        }

        p {
            text-align: center;
            font-size: 18px;
            margin-top: 20px;
            color: #007bff;
        }

        /* Responsive styles */
        @media (max-width: 480px) {
            .container {
                max-width: 100%;
            }
        }

        button {
            text-align: center;
            margin-top: 20px;
            padding: 10px;
            font-weight: bold;
            border: none;
            border-radius: 10px;
            background:#ccc;
        }

        button a {
            text-decoration: none;
            color: black;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Payment Result</h2>
        <p><?php echo $status; ?></p>
        <button><a href="index.php">Bookings</a></button>
    </div>
</body>
</html>
