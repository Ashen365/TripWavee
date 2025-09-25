<?php
// Database connection for tripwaveeeeeeee
$host = "localhost";
$user = "root";
$pass = ""; // default XAMPP password is empty
$dbname = "tripwaveeeeeeee";

$conn = mysqli_connect($host, $user, $pass, $dbname);

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}
?>