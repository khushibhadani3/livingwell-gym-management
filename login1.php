<?php
session_start();
$conn = mysqli_connect('localhost', 'root', '', 'gym_management');
if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

// Initialize error array
$err = array();

if (isset($_POST['logsubmit'])) {
  $email = $_POST['logemail'];
  $pass = $_POST['logpassword'];

  // Check if the email and password belong to admin
  if ($email == "admin@gmail.com" && $pass == "Admin187") {
    $_SESSION["name"] = "Admin"; // Set the admin username in the session
    header('Location: admin.php'); // Redirect to the admin panel
    exit();
  }

  // Check if the email and password belong to trainer
  if ($email == "Trainer76@gmail.com" && $pass == "Trainer7670") {
    $_SESSION["name"] = "Trainer"; // Set the trainer username in the session
    header('Location: trainer_panel.php'); // Redirect to the trainer panel
    exit();
  }

  // Password validation using preg_match (at least 8 characters, one letter, one number)
  if (preg_match('/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/', $pass)) {
    // Use prepared statements to avoid SQL injection
    $stmt = $conn->prepare("SELECT * FROM tbl_register WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
      $row = $result->fetch_assoc();

      // Debugging output for password check
      echo "<pre>";
      print_r($row);  // Check if the row is correctly fetched
      echo "</pre>";

      // Debugging: Check if the password matches (assuming plaintext for now)
      if ($row['password'] == $pass) {
        $_SESSION["name"] = $row['username']; // Set the username in the session
        echo 'Session set, redirecting to customer panel...'; // Debug message
        header('Location: customerpanel.php'); // Redirect to customer panel or any other page
        exit();
      } else {
        $err[] = 'Incorrect password. Please try again.';
      }
    } else {
      $err[] = 'Email does not exist.';
    }
    $stmt->close();
  } else {
    $err[] = 'Password must be at least 8 characters long and include at least one letter and one number.';
  }
}
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <link rel="icon" href="https://png.pngtree.com/png-clipart/20220603/original/pngtree-fitness-gym-logo-png-image_7902040.png">
  <script language="javascript" type="text/javascript">
        window.history.forward();
  </script>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>livingWell</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="wrapper">
    <form method="POST">
      <h2>Login</h2>
      <?php
          if (isset($err)) {
            foreach ($err as $errMsg) {
              echo '<span class="err-msg">' . $errMsg . '</span>';
            }
          }
      ?>
      <div class="input-field">
        <input type="email" name="logemail" required>
        <label>Enter your email</label>
      </div>
      <div class="input-field">
        <input type="password" name="logpassword" required>
        <label>Enter your password</label>
      </div>
      <div class="forget">
        <label for="remember">
          <input type="checkbox" id="remember">
          <p>Remember me</p>
        </label>
        <a href="pw.php">Forgot password?</a>
      </div>
      <button type="submit" name="logsubmit">Log In</button>

      <div class="register">
        <p>Don't have an account? <a href="register.php">Register</a></p>
      </div>
    </form>
  </div>
</body>
</html>
