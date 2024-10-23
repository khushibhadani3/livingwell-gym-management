<?php
session_start(); // Start the session

// Database connection
$host = 'localhost';
$user = 'root';
$password = '';
$dbname = 'gym_management';

$conn = new mysqli($host, $user, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$customerProfile = null; // To hold the customer profile data
$errorMessage = ""; // To hold error messages
$customerAdded = false; // To track if a customer has been added

// Add customer
if (isset($_POST['add'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $age = $_POST['age'];
    $height = $_POST['height'];
    $weight = $_POST['weight'];
    $bloodgroup = $_POST['bloodgroup'];
    $address = $_POST['address'];
    $contact_number = $_POST['contact_number'];

    // Check if customer already exists
    $checkSql = "SELECT * FROM tbl_user WHERE contact_number='$contact_number' OR email='$email'";
    $checkResult = $conn->query($checkSql);

    if ($checkResult->num_rows > 0) {
        $errorMessage = "Customer with this contact number or email already exists.";
    } else {
        $sql = "INSERT INTO tbl_user (name, email, age, height, weight, bloodgroup, address, contact_number) 
                VALUES ('$name', '$email', '$age', '$height', '$weight', '$bloodgroup', '$address', '$contact_number')";

        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('New customer added successfully!');</script>";
            $customer_id = $conn->insert_id; // Store the last inserted ID to show profile
            $sql = "SELECT * FROM tbl_user WHERE id='$customer_id'";
            $profileResult = $conn->query($sql);
            if ($profileResult->num_rows > 0) {
                $customerProfile = $profileResult->fetch_assoc(); // Fetch the newly added customer data
                $customerAdded = true; // Set the flag to true
            }
        } else {
            $errorMessage = "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}

// Fetch customer by contact number for update
if (isset($_POST['fetch'])) {
    $contact_number = $_POST['contact_number'];
    $sql = "SELECT * FROM tbl_user WHERE contact_number='$contact_number'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $customerProfile = $result->fetch_assoc(); // Fetch the customer data
    } else {
        $errorMessage = "Customer not found!";
    }
}

// Update customer
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $age = $_POST['age'];
    $height = $_POST['height'];
    $weight = $_POST['weight'];
    $bloodgroup = $_POST['bloodgroup'];
    $address = $_POST['address'];
    $contact_number = $_POST['contact_number'];

    $sql = "UPDATE tbl_user SET name='$name', email='$email', age='$age', height='$height', weight='$weight', bloodgroup='$bloodgroup', address='$address', contact_number='$contact_number' WHERE id='$id'";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Customer updated successfully!');</script>";
        // Fetch updated profile
        $sql = "SELECT * FROM tbl_user WHERE id='$id'";
        $profileResult = $conn->query($sql);
        if ($profileResult->num_rows > 0) {
            $customerProfile = $profileResult->fetch_assoc(); // Fetch the updated customer data
        }
    } else {
        $errorMessage = "Error updating record: " . $conn->error;
    }
}

// Fetch all customers
$sql = "SELECT * FROM tbl_user";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="icon" href="https://png.pngtree.com/png-clipart/20220603/original/pngtree-fitness-gym-logo-png-image_7902040.png">
    <script language="javascript" type="text/javascript">
        window.history.forward();
  </script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Panel</title>
    <style>
    body {
            font-family: Arial, sans-serif;
            background-color: grey; /* Background color is grey */
            color: black; /* Font color is black */
            background-size: cover;
            
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: flex-start;
            min-height: 100vh;
            overflow-y: auto;
        }

        .container {
            background-color: rgba(255, 255, 255, 0.9); /* Semi-transparent white background */
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            width: 100%;
            margin: 40px auto;
            box-sizing: border-box;
            border: 5px solid black; /* Added border to the container */
        }

        h2, h3 {
            color: #333;
            margin-bottom: 20px;
            text-align: center;
        }

        label {
            display: block;
            margin-bottom: 10px;
            font-weight: bold;
            color: #333;
        }

        input[type="text"], 
        input[type="email"], 
        input[type="number"], 
        textarea {
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
            font-size: 16px;
        }

        textarea {
            resize: none;
            height: 120px;
        }

        input[type="submit"] {
            background-color: #007bff;
            color: #fff;
            padding: 12px 18px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            width: 100%;
            transition: background-color 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        hr {
            margin: 40px 0;
        }

        .profile, .error {
            background-color: #f9f9f9;
            padding: 15px;
            margin-top: 20px;
            border-radius: 5px;
        }

        .profile div {
            margin-bottom: 10px;
        }

        .error {
            color: red;
            background-color: #ffe5e5;
            border: 1px solid #ffcccc;
        }
</style>
</head>
<body>

<div class="container">
        <!-- Welcome message using session data -->
        <?php if (isset($_SESSION['username'])): ?>
            <h2>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h2>
        <?php endif; ?>

        <h2>Customer Panel - LivingWell</h2>

    <!-- Display error message if any -->
    <?php if ($errorMessage): ?>
        <div class="error"><?php echo $errorMessage; ?></div>
    <?php endif; ?>

    <!-- Add Customer Form -->
    <h3>Add Customer</h3>
    <form action="" method="POST">
        <div>
            <label>Name:</label>
            <input type="text" name="name" required>
        </div>
        <div>
            <label>Email:</label>
            <input type="email" name="email" required>
        </div>
        <div>
            <label>Age:</label>
            <input type="number" name="age" required>
        </div>
        <div>
            <label>Height:</label>
            <input type="number" step="0.01" name="height" required>
        </div>
        <div>
            <label>Weight:</label>
            <input type="number" step="0.01" name="weight" required>
        </div>
        <div>
            <label>Blood Group:</label>
            <input type="text" name="bloodgroup" required>
        </div>
        <div>
            <label>Address:</label>
            <textarea name="address" required></textarea>
        </div>
        <div>
            <label>Contact Number:</label>
            <input type="text" name="contact_number" required>
        </div>
        <input type="submit" name="add" value="Add Customer">
    </form>

    <hr>

    <!-- Fetch Customer Form for Update -->
    <h3>Fetch Customer by Contact Number</h3>
    <form action="" method="POST">
        <div>
            <label>Contact Number:</label>
            <input type="text" name="contact_number" required>
        </div>
        <input type="submit" name="fetch" value="Fetch Customer">
    </form>

    <!-- Update Customer Form -->
    <?php if ($customerAdded && $customerProfile): ?>
        <h3>Update Customer</h3>
        <form action="" method="POST">
            <input type="hidden" name="id" value="<?php echo $customerProfile['id']; ?>">
            <div>
                <label>Name:</label>
                <input type="text" name="name" value="<?php echo $customerProfile['name']; ?>" required>
            </div>
            <div>
                <label>Email:</label>
                <input type="email" name="email" value="<?php echo $customerProfile['email']; ?>" required>
            </div>
            <div>
                <label>Age:</label>
                <input type="number" name="age" value="<?php echo $customerProfile['age']; ?>" required>
            </div>
            <div>
                <label>Height:</label>
                <input type="number" step="0.01" name="height" value="<?php echo $customerProfile['height']; ?>" required>
            </div>
            <div>
                <label>Weight:</label>
                <input type="number" step="0.01" name="weight" value="<?php echo $customerProfile['weight']; ?>" required>
            </div>
            <div>
                <label>Blood Group:</label>
                <input type="text" name="bloodgroup" value="<?php echo $customerProfile['bloodgroup']; ?>" required>
            </div>
            <div>
                <label>Address:</label>
                <textarea name="address" required><?php echo $customerProfile['address']; ?></textarea>
            </div>
            <div>
                <label>Contact Number:</label>
                <input type="text" name="contact_number" value="<?php echo $customerProfile['contact_number']; ?>" required>
            </div>
            <input type="submit" name="update" value="Update Customer">
        </form>
    <?php endif; ?>

    <hr>

    <!-- View Customer Profile after Add/Update -->
    <?php if ($customerProfile): ?>
        <h3>Customer Profile</h3>
        <div class="profile">
            <div>Name: <?php echo $customerProfile['name']; ?></div>
            <div>Email: <?php echo $customerProfile['email']; ?></div>
            <div>Age: <?php echo $customerProfile['age']; ?></div>
            <div>Height: <?php echo $customerProfile['height']; ?></div>
            <div>Weight: <?php echo $customerProfile['weight']; ?></div>
            <div>Blood Group: <?php echo $customerProfile['bloodgroup']; ?></div>
            <div>Address: <?php echo $customerProfile['address']; ?></div>
            <div>Contact Number: <?php echo $customerProfile['contact_number']; ?></div>
        </div>
    <?php endif; ?>
    <div class="form-section">
        <button onclick="window.location.href='login.php'">Logout</button>
    </div>
</div>


</body>
</html>
