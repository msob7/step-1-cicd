<?php

$sname = "localhost";
$username = "root";  // Corrected typo
$password = "";
$db_name = "login";  // Make sure this database exists

// Try to establish a connection to the database
$conn = mysqli_connect($sname, $username, $password, $db_name);

// Check for connection errors
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

echo "Connected successfully";  // Optional confirmation message

?>
