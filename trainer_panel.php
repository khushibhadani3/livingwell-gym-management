<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="icon" href="https://png.pngtree.com/png-clipart/20220603/original/pngtree-fitness-gym-logo-png-image_7902040.png">
    <script language="javascript" type="text/javascript">
        window.history.forward();
  </script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trainer Management Panel - LivingWell</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
            color: #333;
        }
        h1, h2, h3 {
            color: #4caf50;
        }
        .form-section {
            background-color: white;
            padding: 20px;
            margin: 20px 0;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        label {
            display: block;
            margin: 10px 0 5px;
        }
        input[type="text"],
        input[type="number"] {
            width: calc(100% - 20px);
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }
        button {
            background-color: #4caf50;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        button:hover {
            background-color: #45a049;
        }
        .result, .profile {
            margin-top: 20px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 8px;
            background-color: #ffffff;
        }
        .popup {
            display: none;
            position: fixed;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            background-color: #4caf50;
            color: white;
            padding: 10px;
            border-radius: 5px;
            z-index: 1000;
        }
        .popup.error {
            background-color: #f44336;
        }
        .hidden {
            display: none;
        }
        .logout-section {
            text-align: center;
            margin-top: 30px;
        }
        /* Responsive styles */
        @media (max-width: 600px) {
            body {
                padding: 10px;
            }
            .form-section {
                padding: 15px;
            }
            input[type="text"],
            input[type="number"] {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <h1>Trainer Management Panel - LivingWell</h1>

    <!-- Popup Message -->
    <div id="popup" class="popup"></div>

    <!-- Form to Add Trainer -->
    <div class="form-section">
        <h2>Add Trainer</h2>
        <form id="trainerForm" action="trainer_panel.php" method="POST">
            <input type="hidden" id="trainer_id" name="trainer_id">

            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required>

            <label for="age">Age:</label>
            <input type="number" id="age" name="age" required>

            <label for="specialization">Specialization:</label>
            <input type="text" id="specialization" name="specialization" required>

            <label for="charges">Charges:</label>
            <input type="number" id="charges" name="charges" step="0.01" required>

            <label for="contact">Contact:</label>
            <input type="text" id="contact" name="contact" required>

            <button type="submit" name="add">Add Trainer</button>
        </form>
    </div>

    <!-- Form to Fetch/Update Trainer -->
    <div class="form-section">
        <h2>Fetch To Update Trainer</h2>
        <form id="fetchUpdateForm" action="trainer_panel.php" method="POST">
            <label for="fetch_contact">Contact (for fetching/updating):</label>
            <input type="text" id="fetch_contact" name="fetch_contact" required>
            <button type="submit" name="fetch">Fetch Trainer</button>
        </form>

        <div id="updateSection" class="hidden">
            <h3>Trainer Details for Update</h3>
            <form id="updateTrainerForm" action="trainer_panel.php" method="POST">
                <label for="update_name">Name:</label>
                <input type="text" id="update_name" name="update_name" required>

                <label for="update_age">Age:</label>
                <input type="number" id="update_age" name="update_age" required>

                <label for="update_specialization">Specialization:</label>
                <input type="text" id="update_specialization" name="update_specialization" required>

                <label for="update_charges">Charges:</label>
                <input type="number" id="update_charges" name="update_charges" step="0.01" required>

                <label for="update_contact">Contact:</label>
                <input type="text" id="update_contact" name="update_contact" required>

                <input type="hidden" id="update_trainer_id" name="update_trainer_id">
                <button type="submit" name="update">Update Trainer</button>
            </form>
        </div>
    </div>

    <div class="result">
        <?php
        // Enable error reporting
        error_reporting(E_ALL);
        ini_set('display_errors', 1);

        // Database connection
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "gym_management";

        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Fetch Trainer
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['fetch'])) {
            $fetch_contact = $_POST['fetch_contact'];

            $sql_fetch = "SELECT * FROM tbl_trainers WHERE contact = '$fetch_contact'";
            $result_fetch = $conn->query($sql_fetch);

            if ($result_fetch->num_rows > 0) {
                $trainer = $result_fetch->fetch_assoc();
                echo "<script>
                    document.getElementById('trainer_id').value = '{$trainer['trainer_id']}';
                    document.getElementById('update_trainer_id').value = '{$trainer['trainer_id']}';
                    document.getElementById('update_name').value = '{$trainer['name']}';
                    document.getElementById('update_age').value = '{$trainer['age']}';
                    document.getElementById('update_specialization').value = '{$trainer['specialization']}';
                    document.getElementById('update_charges').value = '{$trainer['charges']}';
                    document.getElementById('update_contact').value = '{$trainer['contact']}';
                    document.getElementById('updateSection').classList.remove('hidden');
                </script>";
                echo "Trainer fetched. You can now update their details.";
            } else {
                echo "No trainer found with the given contact.";
            }
        }

        // Add Trainer
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add'])) {
            $name = $_POST['name'];
            $age = $_POST['age'];
            $specialization = $_POST['specialization'];
            $charges = $_POST['charges'];
            $contact = $_POST['contact'];

            // Validate contact
            if (!preg_match('/^\d{10}$/', $contact)) {
                echo "Contact number must be a 10-digit integer.";
            } else {
                // Check if trainer exists by contact
                $sql_check = "SELECT * FROM tbl_trainers WHERE contact = '$contact'";
                $result_check = $conn->query($sql_check);

                if ($result_check->num_rows > 0) {
                    echo "Trainer already exists. Please update the trainer information.";
                } else {
                    // Add Trainer
                    $sql_add = "INSERT INTO tbl_trainers (name, age, specialization, charges, contact) 
                                VALUES ('$name', $age, '$specialization', $charges, '$contact')";
                    
                    if ($conn->query($sql_add) === TRUE) {
                        echo "Trainer added successfully!";
                        // Fetch and display profile after adding
                        $sql_profile = "SELECT * FROM tbl_trainers WHERE contact = '$contact'";
                        $result_profile = $conn->query($sql_profile);
                        if ($result_profile->num_rows > 0) {
                            $profile = $result_profile->fetch_assoc();
                            echo "<div class='profile'>
                                    <h3>Trainer Profile</h3>
                                    <p>Name: " . $profile['name'] . "</p>
                                    <p>Age: " . $profile['age'] . "</p>
                                    <p>Specialization: " . $profile['specialization'] . "</p>
                                    <p>Charges: " . $profile['charges'] . "</p>
                                    <p>Contact: " . $profile['contact'] . "</p>
                                  </div>";
                        }
                    } else {
                        echo "Error adding trainer: " . $conn->error;
                    }
                }
            }
        }

        // Update Trainer
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update'])) {
            $update_name = $_POST['update_name'];
            $update_age = $_POST['update_age'];
            $update_specialization = $_POST['update_specialization'];
            $update_charges = $_POST['update_charges'];
            $update_contact = $_POST['update_contact'];
            $update_trainer_id = $_POST['update_trainer_id'];

            $sql_update = "UPDATE tbl_trainers SET 
                name='$update_name', age=$update_age, 
                specialization='$update_specialization', charges=$update_charges, 
                contact='$update_contact' 
                WHERE trainer_id=$update_trainer_id";

            if ($conn->query($sql_update) === TRUE) {
                echo "Trainer updated successfully!";
            } else {
                echo "Error updating trainer: " . $conn->error;
            }
        }

        $conn->close();
        ?>
    </div>

    <!-- Logout Section -->
    <div class="logout-section">
        <form action="admin.php" method="POST">
            <button type="submit" name="logout">Logout</button>
        </form>
    </div>
</body>
</html>
