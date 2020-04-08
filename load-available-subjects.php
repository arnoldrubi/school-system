<?php
	require_once("includes/db_connection.php");
	require_once("includes/functions.php");
	require_once("includes/session.php");


    if (isset($_POST['course']) && isset($_POST['year']) && isset($_POST['term']) && isset($_POST['school_yr'])) {
    	$query  = "SELECT * FROM course_subjects WHERE course_id=".$_POST['course']." AND year='".$_POST['year']."' AND term='".$_POST['term']."' AND school_yr='".$_POST['school_yr']."'";
    	$result = mysqli_query($connection, $query);

    	if (mysqli_num_rows($result)< 1) {
    		echo "<option value=\"N/A\">No Section Created Yet Under This Course and Year</option>";
    	}
    	else{
         while($row = mysqli_fetch_assoc($result))
	        { 
	         echo "<option value=\"".$row['subject_id']."\">".get_subject_code($row['subject_id'],"",$connection).": ".get_subject_name($row['subject_id'],"",$connection)."</option>";
	        }
	    }
    }
?>