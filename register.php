<?php
session_start(); // Start the session at the beginning

$servername = "localhost";
$username = "root";
$password = "";
$database = "gym_management";

// Create connection
$con = mysqli_connect($servername, $username, $password, $database);

// Check connection
if (!$con) {
    die("ERROR!!" . mysqli_error($con));
}

$message = ""; // Initialize the message variable
$success_message = ""; // Initialize the success message variable

if (isset($_POST['submit'])) {
    $email = $_POST['reg_email'];
    $password = $_POST['reg_password'];
    $name = $_POST['reg_name'];
    $age = $_POST['reg_age'];

    // Check if email is already registered
    $check_email_query = "SELECT * FROM tbl_register WHERE email = '$email'";
    $check_email_result = mysqli_query($con, $check_email_query);

    if (mysqli_num_rows($check_email_result) > 0) {
        $message = "Error: This email is already registered. Please use a different email.";
    } else {
        // Password validation using preg_match (at least 8 characters, one letter, one number)
        if (preg_match('/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/', $password)) {
            // Store the password directly without hashing
            $plain_password = $password;

            // SQL query to insert user data
            $sql = "INSERT INTO tbl_register (email, password, name, age) VALUES ('$email', '$plain_password', '$name', '$age')";

            if (mysqli_query($con, $sql)) {
              $_SESSION['username'] = $name; // Store the name in session for later use in customer panel
              $success_message = "Registration successful!";
              header('Location: customer_panel.php'); // Redirect to customer panel
              exit(); // Exit after redirect to prevent further code execution
          }
          else {
                $message = "Error: " . mysqli_error($con);
            }
        } else {
            $message = "Error: Password must be at least 8 characters long and include at least one letter and one number.";
        }
    }

    mysqli_close($con);
}
?>


<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <link rel="icon" href="https://png.pngtree.com/png-clipart/20220603/original/pngtree-fitness-gym-logo-png-image_7902040.png">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>LivingWell - Register</title>
  <link rel="stylesheet" href="style.css">
  <script>
  function showMessage() {
      var message = <?php echo json_encode($message); ?>;
      var successMessage = <?php echo json_encode($success_message); ?>;
      
      if (message) {
          alert(message);
      }
      if (successMessage) {
          alert(successMessage);
      }
  }
  window.onload = showMessage;
  </script>
</head>
<body>
  <form name="frmreg" method="POST">
    <div class="wrapper">
      <h2>Register</h2>
      <div class="input-field">
        <input type="email" name="reg_email" required>
        <label>Enter your email</label>
      </div>
      <div class="input-field">
        <input type="password" name="reg_password" required>
        <label>Enter your password</label>
      </div>
      <div class="input-field">
        <input type="text" name="reg_name" required>
        <label>Enter your name</label>
      </div>
      <div class="input-field">
        <input type="number" min="1" name="reg_age" required>
        <label>Enter your Age</label>
      </div>
      <button type="submit" name="submit">Register</button>
    </div>
  </form>
</body>
</html>
