<?php include 'layout/header.php';?>
<?php require_once("includes/db_connection.php"); ?>

<?php 
    if (isset($_GET['student_id']) && isset($_GET['course_id']) && isset($_GET['year']) && isset($_GET['term']) && isset($_GET['sy']) && $_GET['student_id'] && $_GET['course_id'] !== "" && $_GET['year'] !== "" && $_GET['term'] !== "" && $_GET['sy'] !== "") {
      $course_id = $_GET["course_id"];
      $student_id = $_GET["student_id"];
      $student_reg_id = $_GET["student_reg_id"];
      $year = urldecode($_GET["year"]);
      $term = urldecode($_GET["term"]);
      $sy = urldecode($_GET["sy"]);
      $section = urldecode($_GET["section"]);
    }
  else{
    redirect_to("view-enrolled-students.php");
  }


    $query_current_students = query_for_current_students("schedule_block", $course_id, $year, $term, $section, $sy);
    $result_update_current_students = mysqli_query($connection, $query_current_students);

    while($row_current_students = mysqli_fetch_assoc($result_update_current_students))
    {

      $students_enrolled = $row_current_students['students_enrolled'] - 1;

      $query_update_students_enrolled  = "UPDATE schedule_block SET students_enrolled = '{$students_enrolled}' WHERE schedule_id='".$row_current_students['schedule_id']."' LIMIT 1";
      $result_update_students_enrolled = mysqli_query($connection, $query_update_students_enrolled);
    }

    $query  = "DELETE FROM enrollment WHERE student_id =".$student_id." LIMIT 1";
    $result = mysqli_query($connection, $query);

    $query2  = "DELETE FROM student_grades WHERE stud_reg_id =".$student_reg_id." AND course_id =".$course_id." AND year ='".$year."' AND term='".$term."' AND school_yr='".$sy."' AND section='".$section."'";
    $result2 = mysqli_query($connection, $query2);

  if ($result === TRUE) {
    echo "<script type='text/javascript'>";
    echo "alert('Delete student enrollment successful!');";
    echo "</script>";

    $URL="view-enrolled-students.php";
    echo "<script>location.href='$URL'</script>";
  } else {
    echo "Error updating record: " . $connection->error;

  }
  
  if(isset($connection)){ mysqli_close($connection); }

?>




