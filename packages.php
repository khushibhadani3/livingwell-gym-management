<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "gym_management";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Insert new package into tbl_packages
if (isset($_POST['add'])) {
    $package_name = $_POST['package_name'];
    $charges = $_POST['charges'];
    $duration = $_POST['duration'];

    $sql = "INSERT INTO tbl_packages (package_name, charges, duration) VALUES ('$package_name', '$charges', '$duration')";
    if ($conn->query($sql) === TRUE) {
        echo "New package added successfully.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Fetch package by name to update
if (isset($_POST['fetch_update'])) {
    $package_name = $_POST['package_name'];

    $result = $conn->query("SELECT * FROM tbl_packages WHERE package_name='$package_name'");
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $package_id = $row['package_id'];
        $charges = $row['charges'];
        $duration = $row['duration'];
        $isFetchedForUpdate = true; // Flag to hide fetch button
    } else {
        echo "Package not found.";
    }
}

// Update package
if (isset($_POST['update'])) {
    $package_id = $_POST['package_id'];
    $package_name = $_POST['package_name'];
    $charges = $_POST['charges'];
    $duration = $_POST['duration'];

    $sql = "UPDATE tbl_packages SET package_name='$package_name', charges='$charges', duration='$duration' WHERE package_id='$package_id'";
    if ($conn->query($sql) === TRUE) {
        echo "Package updated successfully.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Fetch package by name to delete
if (isset($_POST['fetch_delete'])) {
    $package_name = $_POST['package_name'];

    $result = $conn->query("SELECT * FROM tbl_packages WHERE package_name='$package_name'");
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $package_id = $row['package_id'];
        $charges = $row['charges'];
        $duration = $row['duration'];
        $isFetchedForDelete = true; // Flag to hide fetch button
    } else {
        echo "Package not found.";
    }
}

// Delete package
if (isset($_POST['delete'])) {
    $package_id = $_POST['package_id'];

    $sql = "DELETE FROM tbl_packages WHERE package_id='$package_id'";
    if ($conn->query($sql) === TRUE) {
        echo "Package deleted successfully.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Fetch packages to display
$packages = $conn->query("SELECT * FROM tbl_packages");
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
    <title>Package Management</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 20px;
        }
        h2 {
            text-align: center;
            color: #333;
        }
        form {
            background-color: #fff;
            padding: 20px;
            margin: 20px auto;
            border-radius: 8px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            max-width: 500px;
        }
        input, button {
            display: block;
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        button {
            background-color: #4CAF50;
            color: #fff;
            cursor: pointer;
        }
        button:hover {
            background-color: #45a049;
        }
        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid #ddd;
            padding: 8px;
        }
        th {
            background-color: #4CAF50;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        tr:hover {
            background-color: #ddd;
        }
        .logout-btn {
            background-color: #ff4d4d;
            color: #fff;
            padding: 10px 20px;
            margin: 20px auto;
            display: block;
            width: 100px;
            text-align: center;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <h2>Package Management</h2>

    <!-- Form to Add Package -->
    <form action="" method="post">
        <input type="text" name="package_name" placeholder="Package Name" required>
        <input type="number" step="0.01" name="charges" placeholder="Charges" required>
        <input type="number" name="duration" placeholder="Duration (in days)" required>
        <button type="submit" name="add">Add Package</button>
    </form>

    <!-- Form to Fetch and Update Package -->
    <form action="" method="post">
        <?php if (!isset($isFetchedForUpdate)): ?>
            <input type="text" name="package_name" placeholder="Search Package Name for Update" required>
            <button type="submit" name="fetch_update">Fetch Package to Update</button>
        <?php endif; ?>
        <?php if (isset($isFetchedForUpdate) && isset($package_id)): ?>
            <input type="hidden" name="package_id" value="<?php echo $package_id; ?>">
            <input type="text" name="package_name" value="<?php echo $package_name; ?>" required>
            <input type="number" step="0.01" name="charges" value="<?php echo $charges; ?>" required>
            <input type="number" name="duration" value="<?php echo $duration; ?>" required>
            <button type="submit" name="update">Update Package</button>
        <?php endif; ?>
    </form>

    <!-- Form to Fetch and Delete Package -->
    <form action="" method="post">
        <?php if (!isset($isFetchedForDelete)): ?>
            <input type="text" name="package_name" placeholder="Search Package Name for Deletion" required>
            <button type="submit" name="fetch_delete">Fetch Package to Delete</button>
        <?php endif; ?>
        <?php if (isset($isFetchedForDelete) && isset($package_id)): ?>
            <input type="hidden" name="package_id" value="<?php echo $package_id; ?>">
            <button type="submit" name="delete">Delete Package</button>
        <?php endif; ?>
    </form>

    <!-- Table Displaying All Packages -->
    <table>
        <tr>
            <th>ID</th>
            <th>Package Name</th>
            <th>Charges</th>
            <th>Duration</th>
        </tr>
        <?php while($row = $packages->fetch_assoc()): ?>
        <tr>
            <td><?php echo $row['package_id']; ?></td>
            <td><?php echo $row['package_name']; ?></td>
            <td><?php echo $row['charges']; ?></td>
            <td><?php echo $row['duration']; ?></td>
        </tr>
        <?php endwhile; ?>
    </table>

    <!-- Logout Button -->
    <a href="admin.php" class="logout-btn">Logout</a>
</body>
</html>

<?php $conn->close(); ?>
