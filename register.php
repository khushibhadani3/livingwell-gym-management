<?php
session_start();

include './connection.php';

$message = "";
$success_message = "";

if (isset($_POST['submit'])) {
    $email = $_POST['reg_email'];
    $password = $_POST['reg_password'];
    $name = $_POST['reg_name'];
    $age = $_POST['reg_age'];

    $check_email_query = "SELECT * FROM tbl_register WHERE email = '$email'";
    $check_email_result = mysqli_query($conn, $check_email_query);

    if (mysqli_num_rows($check_email_result) > 0) {
        $message = "Error: This email is already registered. Please use a different email.";
    } else {
        if (preg_match('/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/', $password)) {
            $plain_password = $password;

            $sql = "INSERT INTO tbl_register (email, password, name, age) VALUES ('$email', '$plain_password', '$name', '$age')";

            if (mysqli_query($conn, $sql)) {
                $_SESSION['username'] = $name;
                $success_message = "Registration successful!";
                
                echo "<script>
                        alert('$success_message');
                        window.location.href = 'login.php';
                      </script>";
                exit();
            } else {
                $message = "Error: " . mysqli_error($conn);
            }
        } else {
            $message = "Error: Password must be at least 8 characters long and include at least one letter and one number.";
        }
    }

    mysqli_close($conn);
}
?>


<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <link rel="icon" href="https://png.pngtree.com/png-clipart/20220603/original/pngtree-fitness-gym-logo-png-image_7902040.png">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>LivingWell - Register</title>
  <!-- Css Styles -->
  <link rel="stylesheet" href="css/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="css/font-awesome.min.css" type="text/css">
    <link rel="stylesheet" href="css/flaticon.css" type="text/css">
    <link rel="stylesheet" href="css/owl.carousel.min.css" type="text/css">
    <link rel="stylesheet" href="css/barfiller.css" type="text/css">
    <link rel="stylesheet" href="css/magnific-popup.css" type="text/css">
    <link rel="stylesheet" href="css/slicknav.min.css" type="text/css">
    <link rel="stylesheet" href="css/style.css" type="text/css">

    <link rel="icon" href="https://png.pngtree.com/png-clipart/20220603/original/pngtree-fitness-gym-logo-png-image_7902040.png">
    <script language="javascript" type="text/javascript">
        window.history.forward();
    </script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>livingWell</title>
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
<div id="preloder">
        <div class="loader"></div>
    </div>
    <?php
        include './header.php';
    ?> 
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
  <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.magnific-popup.min.js"></script>
    <script src="js/masonry.pkgd.min.js"></script>
    <script src="js/jquery.barfiller.js"></script>
    <script src="js/jquery.slicknav.js"></script>
    <script src="js/owl.carousel.min.js"></script>
    <script src="js/main.js"></script>
</body>
</html>
