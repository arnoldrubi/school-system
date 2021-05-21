<?php
	require_once("includes/db_connection.php");
	require_once("includes/functions.php");
	require_once("includes/session.php");

	if (!isset($_POST['CourseId'])) {
		exit;
	}
	else{
	 	$CourseId = $_POST['CourseId'];
	}

if (isset($CourseId)) {

    echo "<div id=\"dataTable_wrapper\"><table class=\"table table-bordered dataTable\" id=\"dataTable\" width=\"100%\" cellspacing=\"0\" role=\"grid\" aria-describedby=\"dataTable_info\" style=\"width: 100%;\">";
    echo " <thead>";
    echo "  <tr>";
    echo "   <th class=\"skip-filter\">Student Number</th>";
    echo "   <th class=\"skip-filter\">Last Name</th>";
    echo "   <th class=\"skip-filter\">First Name</th>";
    echo "   <th>Course</th>";
    echo "   <th>Option</th>";
    echo "  </tr></thead><tbody>";

	  $query  = "SELECT enrollment.stud_reg_id,enrollment.student_id, enrollment.student_number, enrollment.course_id, enrollment.year, enrollment.sec_id, enrollment.school_yr, enrollment.term, enrollment.irregular, students_reg.last_name, students_reg.first_name, students_reg.middle_name FROM enrollment INNER JOIN students_reg ON enrollment.stud_reg_id=students_reg.stud_reg_id WHERE enrollment.term='".return_current_term($connection,"")."' AND school_yr='".return_current_sy($connection,"")."' AND enrollment.course_id =".$CourseId." ORDER BY last_name ASC";
    $result = mysqli_query($connection, $query);

    while($row = mysqli_fetch_assoc($result)){
    echo "<tr>";
    echo "<td>".$row['student_number']."</td>";
    echo "<td>".$row['last_name']."</td>";
    echo "<td>".$row['first_name']."</td>";
    echo "<td>".get_course_code($row['course_id'],"",$connection)."</td>";
    echo "<td><button id=\"".$row['student_number']."\" type=\"submit\" class=\"select-student-btn btn-success form-control btn-sm\">Select</button></td>";
    echo "</tr>";

    }

    echo "</tbody></table></div>"; 
}
?>
