<?php
	include("includes/db_connection.php");
	require_once("includes/functions.php");
    require_once("includes/session.php");

	$show_deleted = $_POST["show_deleted"];

        echo " <thead>";
        echo "  <tr>";
        echo "   <th>Courses Name</th>";
        echo "   <th>Courses Code</th>";
        echo "   <th>Courses Deleted?</th>";
        echo "   <th>&nbsp;</th>";   
        echo "  </tr></thead><tbody>";
        

 	    $query  = "SELECT * FROM courses WHERE course_deleted ='".$show_deleted."' ORDER BY course_deleted";
  	
      
        $result = mysqli_query($connection, $query);

      while($row = mysqli_fetch_assoc($result))
        {
        echo "<tr>";
        echo "<td>".$row['course_desc']."</td>";
        echo "<td>".$row['course_code']."</td>";
        if ($row['course_deleted'] == 1) {
        echo "<td>Yes</td>";
        $text_delete = "Restore Course";
        $link_delete = "restore-course.php";
        }
        else{
         echo "<td>No</td>";
         $text_delete = "Delete Course";
         $link_delete = "delete-course.php";
        }
        echo "<td><a href=\"edit-course.php?course_id=".$row['course_id']."\"".">Edit Course</a> | ";
        echo "<a href=\"javascript:confirmDelete('".$link_delete."?course_id=".$row['course_id']."')\">".$text_delete."</a></td>";
        echo "</tr>";
        }

        echo "</tbody>"; 

?>