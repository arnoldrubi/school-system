<?php
	require_once("includes/db_connection.php");
	require_once("includes/functions.php");
	require_once("includes/session.php");

	if (isset($_POST["section_id"])) {
		$sec_id = $_POST["section_id"];
		$query  = "SELECT * FROM classes WHERE sec_id=".$sec_id." AND term = '".return_current_term($connection,"")."' AND school_yr = '".return_current_sy($connection,"")."'";
	    $result = mysqli_query($connection, $query);

	    while($row = mysqli_fetch_assoc($result)){
	    $max_students = $row["student_limit"];
	    $current_students = $row["students_enrolled"];

	    if ($current_students >= $max_students) {
	    		echo "<script>";
	    		echo "var submit_btn = jQuery('input[name=submit]');";
	    		echo "submit_btn.attr('disabled', 'true');";
	    		echo "</script>";
	    		die("<div class=\"alert alert-danger\" role=\"alert\">One or multiple classes under this section have reached its max student limit. Please contact the administrator.</div>");
	    	}
	    }
	}
?>