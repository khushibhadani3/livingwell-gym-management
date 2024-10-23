<?php
session_start();
include './connection.php';

if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$err = array();

if (isset($_POST['logsubmit'])) {
    $email = $_POST['logemail'];
    $pass = $_POST['logpassword'];

    if ($email == "admin@gmail.com" && $pass == "Admin123") {
        $_SESSION["username"] = "Admin";
        $_SESSION['admin_logged_in'] = true;
        header('Location: admin_profile.php');
        exit();
    }
   
    if ($email == "trainer@gmail.com" && $pass == "Trainer123") {
        $_SESSION["username"] = "Trainer";
        $_SESSION['trainer_logged_in'] = true;
        header('Location: trainer_profile.php');
        exit();
    }

    if (preg_match('/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/', $pass)) {
        $stmt = $conn->prepare("SELECT * FROM tbl_register WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();

            echo "<pre>";
            print_r($row);
            echo "</pre>";

            if ($row['password'] == $pass) {
                $_SESSION["username"] = $row['name'];
                $_SESSION['user_logged_in'] = true; 
                echo 'Session set, redirecting to customer panel...';
                header('Location: user_profile.php');
                exit();
            } else {
                $err[] = 'Incorrect password. Please try again.';
            }
        } else {
            $username = "User  " . rand(1000, 9999);

            $insertStmt = $conn->prepare("INSERT INTO tbl_register (email, password, name) VALUES (?, ?, ?)");
            $insertStmt->bind_param("sss", $email, $pass, $username);
            if ($insertStmt->execute()) {
                $_SESSION["name"] = $username;
                $_SESSION['user_logged_in'] = true;
                echo 'User  registered and logged in, redirecting to customer panel...';
                header('Location: user_profile.php');
                exit();
            } else {
                $err[] = 'Error registering user. Please try again.';
            }
            $insertStmt->close();
        }
        $stmt->close();
    } else {
        $err[] = 'Password must be at least 8 characters long and include at least one letter and one number.';
    }
}
?>

<!DOCTYPE html>
<html lang="zxx">

<head>
    <script language="javascript" type="text/javascript">
        window.history.forward();
        </script>
    <meta charset="UTF-8">
    <link rel="icon" href="https://png.pngtree.com/png-clipart/20220603/original/pngtree-fitness-gym-logo-png-image_7902040.png">

    <meta name="description" content="Gym Template">
    <meta name="keywords" content="Gym, unica, creative, html">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login Page</title>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css?family=Muli:300,400,500,600,700,800,900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Oswald:300,400,500,600,700&display=swap" rel="stylesheet">

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
</head>
<body>

<div id="preloder">
        <div class="loader"></div>
    </div>
    <?php
        include './header.php';
    ?> 
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

     <!-- Js Plugins -->
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