<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $username = $_POST['username'];
  $password = $_POST['password'];
  $employee_id = $_POST['employee_id'];

  // Perform validation on the input data
  if (!preg_match('/^AB\d{2}$/', $employee_id)) {
    $error = 'Invalid employee ID format';
  } else {
    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Insert the new user into the database
    $conn = new mysqli('localhost', 'root', '', 'simple_booking_db');

    // Check if the employee ID is already registered
    $stmt = $conn->prepare('SELECT COUNT(*) FROM users WHERE employee_id = ?');
    $stmt->bind_param('s', $employee_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $count = $result->fetch_row()[0];

    if ($count >= 20) {
      $error = 'Maximum registration limit reached';
    } elseif ($count > 0) {
      $error = 'Employee ID already registered';
    } else {
      $stmt = $conn->prepare('INSERT INTO users (username, password, employee_id) VALUES (?, ?, ?)');
      $stmt->bind_param('sss', $username, $hashedPassword, $employee_id);
      $stmt->execute();

      header('Location: login.php');
      exit();
    }
  }
}

?>

<!doctype html>
<html lang="en">
<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Registration</title>
  <style>
  body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 20px;
  }
  
  h1 {
    text-align: center;
  }
  
  form {
    max-width: 400px;
    margin: 0 auto;
  }
  
  label {
    display: block;
    margin-bottom: 10px;
    font-weight: bold;
  }
  
  input[type="text"],
  input[type="password"] {
    width: 100%;
    padding: 8px;
    border-radius: 4px;
    border: 1px solid #ccc;
  }
  
  input[type="text"]:focus,
  input[type="password"]:focus {
    outline: none;
    border-color: #888;
  }
  
  button[type="submit"] {
    display: block;
    width: 100%;
    padding: 10px;
    margin-top: 20px;
    background-color: #4CAF50;
    color: white;
    font-size: 16px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
  }
  
  button[type="submit"]:hover {
    background-color: #45a049;
  }
  
  .error-container {
    text-align: center;
    margin-top: 10px;
  }
  
  .error {
    color: red;
    display: block;
    text-align: center;
  }
</style>

 
</head>
<body>
  <h1>Registration</h1>
  
  <?php if (isset($error)) { ?>
    <p style="color: red;"><?php echo $error; ?></p>
  <?php } ?>

  <form method="post" action="">
    <label for="username">Username:</label>
    <input type="text" id="username" name="username" required><br><br>

    <label for="password">Password:</label>
    <input type="password" id="password" name="password" required><br><br>

    <label for="employee_id">Employee ID: (AB01 - AB20)</label>
  <input type="text" id="employee_id" name="employee_id" pattern="AB\d{2}" required><br><br>

    <button type="submit">Register</button>

    <p>Already have an account? <a href="login.php">Let's login</a></p>
  </form>
</body>
</html>
