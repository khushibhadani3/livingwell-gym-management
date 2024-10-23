<?php 
session_start(); 
include './connection.php';

if (!isset($_SESSION['username']) || empty($_SESSION['username'])) {
    header('Location: login.php');
    exit;
}

$username = $_SESSION['username'];

// Fetch user data from the database
$query = "SELECT * FROM tbl_register WHERE name = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Prepare the update statement
    $reg_email = $_POST['reg_email'];
    $reg_name = $_POST['reg_name'];
    $reg_age = $_POST['reg_age'];
    $height = $_POST['height'];
    $weight = $_POST['weight'];
    $bloodgroup = $_POST['bloodgroup'];
    $contact = $_POST['contact'];
    $address = $_POST['address'];

    // Update query including email
    $updateQuery = "UPDATE tbl_register SET email=?, name=?, age=?, height=?, weight=?, bloodgroup=?, address=?, contact=? WHERE name=?";
    $updateStmt = $conn->prepare($updateQuery);
    $updateStmt->bind_param("ssiisssss", $reg_email, $reg_name, $reg_age, $height, $weight, $bloodgroup, $address, $contact, $username);
    
    if ($updateStmt->execute()) {
        echo "Profile updated successfully.";
    } else {
        echo "Error updating profile: " . $conn->error;
    }
}

// Close the statement and connection
$stmt->close();
$conn->close();
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
    <title>livingWell</title>

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
    <?php include './header.php'; ?>  
<form name="frmreg" method="POST">
    <div class="wrapper">
        <h2>User Profile</h2>
        <div class="input-field">
            <input type="email" name="reg_email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
            <label>Enter your email</label>
        </div>
        <div class="input-field">
            <input type="text" name="reg_name" value="<?php echo htmlspecialchars($user['name']); ?>" required>
            <label>Enter your name</label>
        </div>
        <div class="input-field">
            <input type="number" min="1" name="reg_age" value="<?php echo htmlspecialchars($user['age']); ?>" required>
            <label>Enter your Age</label>
        </div>
        <div class="input-field">
            <input type="number" min="1" name="height" value="<?php echo htmlspecialchars($user['height']); ?>" required>
            <label>Enter your height</label>
        </div>
        <div class="input-field">
            <input type="number" min="1" name="weight" value="<?php echo htmlspecialchars($user['weight']); ?>" required>
            <label>Enter your weight</label>
        </div>
        <div class="input-field">
            <select name="bloodgroup" id="bloodgroup" required>
                <option value="" disabled>Select your blood group</option>
                <option value="A+" <?php if($user['bloodgroup'] == 'A+') echo 'selected'; ?>>A+</option>
                <option value="A-" <?php if($user['bloodgroup'] == 'A-') echo 'selected'; ?>>A-</option>
                <option value="B+" <?php if($user['bloodgroup'] == 'B+') echo 'selected'; ?>>B+</option>
                <option value="B-" <?php if($user['bloodgroup'] == 'B-') echo 'selected'; ?>>B-</option>
                <option value="AB+" <? php if($user['bloodgroup'] == 'AB+') echo 'selected'; ?>>AB+</option>
                <option value="AB-" <?php if($user['bloodgroup'] == 'AB-') echo 'selected'; ?>>AB-</option>
                <option value="O+" <?php if($user['bloodgroup'] == 'O+') echo 'selected'; ?>>O+</option>
                <option value="O-" <?php if($user['bloodgroup'] == 'O-') echo 'selected'; ?>>O-</option>
            </select>
        </div>
        <div class="input-field">
            <input type="number" name="contact" value="<?php echo htmlspecialchars($user['contact']); ?>" required>
            <label>Enter your contact</label>
        </div>
        <div class="input-field">
            <input type="text" name="address" value="<?php echo htmlspecialchars($user['address']); ?>" required>
            <label>Enter your address</label>
        </div>
        <button type="submit" name="submit">Update Profile</button>
    </div>
</form>
    

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