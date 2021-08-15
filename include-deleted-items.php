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
        echo "   <th>Options</th>";   
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
        echo "<td class=\"options-td\"><a class=\"btn btn-warning btn-xs a-modal\" title=\"Edit Course\" href=\"edit-course.php?course_id=".$row['course_id']."\"><i class=\"fa fa-pencil-square-o\" aria-hidden=\"true\"></i></a>";
        echo "<a class=\"btn btn-success btn-xs a-modal\" title=\"".$text_delete."\" href=\"".$link_delete."?course_id=".$row['course_id']."\"><i class=\"fa fa-undo\" aria-hidden=\"true\"></i></a></td>";
        echo "</tr>";
        }

        echo "</tbody>"; 

?>