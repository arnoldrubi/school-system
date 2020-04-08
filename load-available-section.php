<?php
	require_once("includes/db_connection.php");
	require_once("includes/functions.php");
	require_once("includes/session.php");


    if (isset($_POST['course']) && isset($_POST['year'])) {
    	$query  = "SELECT * FROM sections WHERE course_id=".$_POST['course']." AND year='".$_POST['year']."'";
    	$result = mysqli_query($connection, $query);

    	if (mysqli_num_rows($result)< 1) {
    		echo "<option value=\"N/A\">No Section Created Yet Under This Course and Year</option>";
    	}
    	else{
         while($row = mysqli_fetch_assoc($result))
	        { 
	         echo "<option value=\"".$row['sec_id']."\">".$row['sec_name']."</option>";
	        }
	    }
    }
?>