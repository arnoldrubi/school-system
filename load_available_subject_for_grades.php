<?php
	require_once("includes/db_connection.php");
	require_once("includes/functions.php");
	require_once("includes/session.php");

	if (isset($_POST["sy_and_term"])) {

    if ($_POST["sy_and_term"] == "0") {
      echo "<script>location.reload();</script>";    }
    else{
    $sy_and_term = explode(",", $_POST["sy_and_term"]);

    $school_yr = $new_str = str_replace(' ', '', $sy_and_term[1]);

    echo "<table class=\"table table-bordered\" id=\"dataTable2\" width=\"100%\" cellspacing=\"0\" role=\"grid\" aria-describedby=\"dataTable_info\" style=\"width: 100%;\">";
    echo " <thead>";
    echo "  <tr>";
    echo "   <th>Subject Code</th>";
    echo "   <th class=\"skip-filter\">Description</th>";
    echo "   <th>Course</th>";
    echo "   <th>Year</th>";
    echo "   <th>Semester</th>";
    echo "   <th>Section</th>";
    echo "   <th>Teacher</th>";
    echo "   <th class=\"skip-filter\">&nbsp;</th>";   
    echo "  </tr></thead><tbody>";
    
    $query  = "SELECT DISTINCT course_id,subject_id, year, term, sec_id, teacher_id FROM student_grades WHERE term='". $sy_and_term[0]."' AND school_yr='". $school_yr."'";
    $result = mysqli_query($connection, $query);

  while($row = mysqli_fetch_assoc($result))
    {
    echo "<tr>";

    $subject_id = $row['subject_id'];

    $query2 = "SELECT subject_name, subject_code FROM subjects WHERE subject_id='".$subject_id."'";
    $result2 = mysqli_query($connection, $query2);
    while($row2 = mysqli_fetch_assoc($result2))
    {
      echo "<td>".$row2['subject_code']."</td>";
      echo "<td>".$row2['subject_name']."</td>";
    }
    echo "<td>".get_course_code($row['course_id'],"",$connection)."</td>"; 
    echo "<td>".$row['year']."</td>"; 
    echo "<td>".$row['term']."</td>"; 

    if ($row['sec_id'] == "0") {
       echo "<td>N/A (Irregular Students)</td>"; 
    }
    else{
    echo "<td>".get_section_name($row['sec_id'],"",$connection)."</td>"; 
    }
    if ($row['teacher_id'] == "") {
    echo "<td><small>No teacher assigned. Used the scheduling menu to assign a teacher to this subject.</small></td>"; 
    }
    else{
    echo "<td>".get_teacher_name($row['teacher_id'],"",$connection)."</td>"; 
   }
    echo "<td><a href=\"encode-grades.php?subject_id=".$subject_id."&term=".urlencode($row['term'])."&school_yr=".urlencode(return_current_sy($connection,""))."&course_id=".urlencode($row['course_id'])."&year=".urlencode($row['year'])."&section=".urlencode($row['sec_id'])."&teacher_id=".urlencode($row['teacher_id'])."\">Encode Grades</a></td>";
    echo "</tr>";
    }

    echo "</tbody></table>";
  }
}
else {
   redirect_to("grading-portal.php");
 } 
?>