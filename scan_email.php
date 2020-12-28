<?php
	require_once("includes/db_connection.php");
	require_once("includes/functions.php");
	require_once("includes/session.php");

	$existing_emails = array();

	$query  = "SELECT email FROM users";
    $result = mysqli_query($connection, $query);

    while($row = mysqli_fetch_assoc($result)){
    	array_push($existing_emails, $row['email']);
    }
    if (isset($_POST['user_input_email'])) {
    	$email = $_POST['user_input_email'];
    	if (!empty($name)) {
	    	foreach ($existing_emails as $existing_email) {
	    		if ($existing_email == $email) {
	    			echo "<span style=\"color: red\">".$existing_email."</span> is already used.<br>";
	    		}
	    	}
    	}
    }
?>