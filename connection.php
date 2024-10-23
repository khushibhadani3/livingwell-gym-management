<?php

$hostname = "localhost";
$username = "root";
$password = "";
$database = "db_gym";

$conn = mysqli_connect($hostname, $username, $password, $database);
if (!$conn) {
    echo "<script>alert('Connection failed: " . mysqli_connect_error() . "');</script>";
    exit();
}

?>