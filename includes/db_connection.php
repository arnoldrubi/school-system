<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "aims_db";

  // 1. Create a database connection
$connection = mysqli_connect($servername, $username, $password, $dbname);
	// Test if connection occured
if (mysqli_connect_errno()) {
	die("Database connection failed: " .
		mysqli_connection_error() .
		" (" . mysqli_connection_errno() . ")"
		);
}
?>