<!-- payment.php -->

<!doctype html>
<html lang="en">
<head>
    <!-- ... Your payment page head section ... -->
    <title>Payment</title>
    <style>
        /* styles.css */

/* Container styling */
body {
  font-family: Arial, sans-serif;
  background-color: #f7f7f7;
  margin: 0;
  padding: 100px;
  min-height: 100vh;
}

.container {
  max-width: 500px;
  padding: 20px;
  background-color: #ffffff;
  border: 1px solid #ccc;
  border-radius: 8px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

/* Form styling */
form {
  margin-top: 20px;
}

h2 {
  text-align: center;
}

label {
  display: block;
  font-weight: bold;
  margin-bottom: 5px;
}

input[type="text"] {
  width: 100%;
  padding: 10px;
  border: 1px solid #ccc;
  border-radius: 4px;
  margin-bottom: 10px;
}

button {
  display: block;
  width: 100%;
  padding: 12px;
  background-color: #007bff;
  color: #fff;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}

button:hover {
  background-color: #0056b3;
}

/* Responsive styles */
@media (max-width: 480px) {
  .container {
    max-width: 100%;
  }
}

    </style>
</head>
<body>
    <h2>Make Half Payment here to Confirm Your Booking</h2>
    <form method="post" action="process_payment.php" onsubmit="return validateForm()">
        <label for="card_number">Card Number (Format: 1234 1234 1234 1234)</label>
        <input type="text" name="card_number" id="card_number" pattern="\d{4} \d{4} \d{4} \d{4}" placeholder="Enter card number" required>
        <label for="expiry">Expiry Date</label>
        <input type="text" name="expiry" id="expiry" pattern="\d\d/\d\d" placeholder="MM/YY" required>
        <label for="cvv">CVV (3 digits)</label>
        <input type="text" name="cvv" id="cvv" pattern="\d{3}" placeholder="CVV" required>
        <button type="submit" name="paybtn">Pay</button>
    </form>


    <script>
        // payment.js

function validateForm() {
  // Get the card number and CVV input elements
  var cardNumberInput = document.getElementById('card_number');
  var cvvInput = document.getElementById('cvv');

  // Check if the card number and CVV match the required format
  var cardNumberPattern = /^\d{4} \d{4} \d{4} \d{4}$/;
  var cvvPattern = /^\d{3}$/;

  if (!cardNumberPattern.test(cardNumberInput.value)) {
    alert('Please enter a valid card number in the format "1234 1234 1234 1234".');
    cardNumberInput.focus();
    return false;
  }

  if (!cvvPattern.test(cvvInput.value)) {
    alert('Please enter a valid CVV consisting of 3 digits.');
    cvvInput.focus();
    return false;
  }

  // Return true to submit the form if the validation passes
  return true;
}

    </script>
</body>
</html>
