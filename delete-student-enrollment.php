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
      $sec_id = urldecode($_GET["sec_id"]);
      $irregular = urldecode($_GET["irregular"]);
    }
  else{
    redirect_to("view-enrolled-students.php");
  }

    $query  = "DELETE FROM enrollment WHERE student_id =".$student_id." LIMIT 1";
    $result = mysqli_query($connection, $query);

      //start updating current students for classes under the section enrolled

      $query_get_class_ids = "SELECT * from classes WHERE sec_id='".$sec_id."'";
      $result_get_class_ids = mysqli_query($connection, $query_get_class_ids);

      $class_ids = array();
      while($row_get_class_ids = mysqli_fetch_assoc($result_get_class_ids))
      {
        array_push($class_ids, $row_get_class_ids['class_id']);
      }

     for ($i=0; $i < sizeof($class_ids); $i++) { 
        
        $query_get_irreg_count  = "SELECT COUNT(*) AS num FROM irreg_manual_sched WHERE class_id='".$class_ids[$i]."'";
        $result_get_enrolled = mysqli_query($connection, $query_get_irreg_count);
        while($row_get_enrolled = mysqli_fetch_assoc($result_get_enrolled)){
           $irreg_count = $row_get_enrolled['num'];
         }

        $sec_id = get_section_name_by_class($class_ids[$i],"",$connection);
        $count_regular_student = get_enrolled_regular_students($sec_id,$term,$sy,"",$connection);

        $current_students_total = $irreg_count + $count_regular_student;

        $query4  = "UPDATE classes SET students_enrolled = '{$current_students_total}' WHERE class_id ='".$class_ids[$i]."'";;   
        $result4 = mysqli_query($connection, $query4);
        }
      //End updating current students enrolled for each classes under this section

    $query2  = "DELETE FROM student_grades WHERE stud_reg_id =".$student_reg_id." AND course_id =".$course_id." AND year ='".$year."' AND term='".$term."' AND school_yr='".$sy."' AND sec_id='".$sec_id."'";
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




