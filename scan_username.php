<?php
	require_once("includes/db_connection.php");
	require_once("includes/functions.php");
	require_once("includes/session.php");

	$existing_names = array();

	$query  = "SELECT username FROM users";
    $result = mysqli_query($connection, $query);

    while($row = mysqli_fetch_assoc($result)){
    	array_push($existing_names, $row['username']);
    }
    if (isset($_POST['user_input'])) {
    	$name = $_POST['user_input'];
    	if (!empty($name)) {
	    	foreach ($existing_names as $existing_name) {
	    		if ($existing_name == $name) {
	    			echo "<span style=\"color: red\">".$existing_name."</span> already exists.<br>";
	    		}
	    	}
    	}
    }
?>