<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $username = $_POST['username'];
  $password = $_POST['password'];

  // Retrieve the user from the database
  $conn = new mysqli('localhost', 'root', '', 'simple_booking_db');
  $stmt = $conn->prepare('SELECT id, password FROM users WHERE username = ?');
  $stmt->bind_param('s', $username);
  $stmt->execute();
  $result = $stmt->get_result();
  $user = $result->fetch_assoc();

  if ($user && password_verify($password, $user['password'])) {
    $_SESSION['loggedIn'] = true;
    $_SESSION['userId'] = $user['id'];

    // Redirect to the authenticated page or perform other actions
    header('Location: index.php');
    exit();
  } else {
    $error = 'Invalid username or password';
  }
}
?>

<!doctype html>
<html lang="en">
<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Login</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f2f2f2;
      margin: 0;
      padding: 0;
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
    }

    .container {
      width: 400px;
      padding: 20px;
      background-color: #fff;
      border-radius: 5px;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    h1 {
      text-align: center;
      margin-top: 0;
    }

    form {
      margin-top: 20px;
    }

    label {
      display: block;
      margin-bottom: 5px;
      font-weight: bold;
    }

    input[type="text"],
    input[type="password"] {
      width: 100%;
      padding: 10px;
      border-radius: 5px;
      border: 1px solid #ccc;
      margin-bottom: 10px;
    }

    button[type="submit"] {
      display: block;
      width: 100%;
      padding: 10px;
      background-color: #4CAF50;
      color: #fff;
      border: none;
      border-radius: 5px;
      cursor: pointer;
    }

    button[type="submit"]:hover {
      background-color: #45a049;
    }

    .error {
      color: #ff0000;
      margin-top: 10px;
    }

    .signup-link {
      text-align: center;
      margin-top: 10px;
    }
  </style>
</head>
<body>

  <?php if (isset($error)) { ?>
    <p><?php echo $error; ?></p>
  <?php } ?>
  
  <form method="post" action="">
  <h1>Dear Admins Log into <br> see your location!</h1>
  <h3>Login</h3>

    <label for="username">Username:</label>
    <input type="text" id="username" name="username" required><br><br>

    <label for="password">Password:</label>
    <input type="password" id="password" name="password" required><br><br>

    <button type="submit">Login</button>
    <p>Don't have an account? <a href="register.php">Create an Account</a></p>
  </form>


</body>
</html>
