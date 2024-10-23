<!DOCTYPE html>
<html>
<head>
    <link rel="icon" href="https://png.pngtree.com/png-clipart/20220603/original/pngtree-fitness-gym-logo-png-image_7902040.png">
    <title>Forgot Password</title>
    <style>
        body {
            background-image: url('https://wallpaperaccess.com/full/4722389.jpg'); /* Replace with the URL of your gym background image */
            background-size: cover; /* Make sure the background covers the entire page */
            background-position: center; /* Center the background image */
            font-family: Arial, sans-serif; /* Set a clean font for your text */
            color: white; /* Set the text color to contrast with the background */
            text-align: center; /* Center the content */
            margin: 0;
            padding: 0;
            height: 100vh; /* Full height of the viewport */
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }

        h2 {
            margin-bottom: 20px;
        }

        form {
            background-color: rgba(0, 0, 0, 0.8); /* Add a semi-transparent background for the form */
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.5); /* Add a subtle shadow to the form */
        }

        input[type="email"], button {
            padding: 10px;
            margin: 5px 0;
            border-radius: 5px;
            border: none;
            width: 100%;
        }

        button {
            background-color: #ffcc00; /* Green color for the button */
            color:black;
            cursor: pointer;
        }

        button:hover {
            background-color: #ffcc00; /* Darker green on hover */
        }

        table {
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <h2>Forgot Password</h2>
    <form method="POST">
        <table>
            <tr>
                <td><label for="email">Email: </label></td>
                <td><input type="email" name="email" required></td>
            </tr>
            <tr>
                <td><br></td>
            </tr>
            <tr>
                <td colspan="2"><button type="submit" name="btnsubmit">Send OTP</button></td>
            </tr>
        </table>
    </form>
    
    <?php
session_start();

// Database connection settings
$host = 'localhost'; // or your database host
$username = 'root'; // or your database username
$password = ''; // or your database password
$database = 'gym_management'; // replace with your database name

// Create connection
$con = mysqli_connect($host, $username, $password, $database);

// Check connection
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_POST['btnsubmit'])) {
    $email = mysqli_real_escape_string($con, $_POST['email']); // Escape email to prevent SQL injection
    
    // Check if the email is registered in the database
    $query = "SELECT * FROM tbl_register WHERE email = '$email'";
    $result = mysqli_query($con, $query);

    if (!$result) {
        die("Query failed: " . mysqli_error($con)); // Better error reporting for failed query
    }

    if (mysqli_num_rows($result) > 0) {
        // Email is registered, proceed with OTP generation and sending
        $otp = rand(100000, 999999);
        $_SESSION['otp'] = $otp;
        $_SESSION['email'] = $email;

        $subject = "Your OTP Code";
        $message = "Your OTP code is $otp";
        $headers = "From: 22bmiit188@gmail.com";

        if (mail($email, $subject, $message, $headers)) {
            header('Location: validate_otp.php');
        } else {
            echo "Failed to send OTP. Please try again.";
        }
    } else {
        // Email is not registered
        echo "This email is not registered. Please enter a registered email address.";
    }
}

// Close connection
mysqli_close($con);
?>

</body>
</html>
