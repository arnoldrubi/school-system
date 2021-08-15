<?php
	require_once("includes/db_connection.php");
	require_once("includes/functions.php");
	require_once("includes/session.php");

	if (!isset($_POST['StudentLastName'])) {
		$last_name = "";
	}
	else{
		$last_name = $_POST['StudentLastName'];
	}

	if (!isset($_POST['StudentFirstName'])) {
		$first_name = "";
	}
	else{
	 	$first_name = $_POST['StudentFirstName'];
	}

if (isset($_POST['StudentLastName']) || isset($_POST['StudentFirstName'])) {

    echo "<div id=\"dataTable_wrapper\"><table class=\"table table-bordered dataTable\" id=\"dataTable\" width=\"100%\" cellspacing=\"0\" role=\"grid\" aria-describedby=\"dataTable_info\" style=\"width: 100%;\">";
    echo " <thead>";
    echo "  <tr>";
    echo "   <th class=\"skip-filter\">Student Number</th>";
    echo "   <th class=\"skip-filter\">Last Name</th>";
    echo "   <th class=\"skip-filter\">First Name</th>";
    echo "   <th>Course</th>";
    echo "   <th>Option</th>";
    echo "  </tr></thead><tbody>";

	$query  = "SELECT DISTINCT students_reg.last_name, students_reg.first_name, enrollment.student_number, enrollment.course_id FROM students_reg INNER JOIN enrollment ON students_reg.stud_reg_id=enrollment.stud_reg_id WHERE students_reg.first_name='".$first_name."' OR students_reg.last_name='".$last_name."'";
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

<!-- add ko dito paglipat ng value ng name daanan ko sa php -->

  <script>
  $(document).ready(function() {
    $(".select-student-btn").click(function(){
      $("#student-number").val("");
      let student_number = $(this).attr("id");
      $("#student-number").val(student_number);

      var StudentNumber = $("#student-number").val();
      //run ajax
      $.post("scan_student_number.php",{
        StudentNumber: StudentNumber
      },function(data,status){
        $("#display-student-name").html(data);
      });


    });
  });
  </script>