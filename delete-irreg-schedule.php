<?php 
require_once("includes/session.php");
require_once("includes/functions.php");
require_once("includes/db_connection.php");

    $stud_reg_id = $_GET["stud_reg_id"];
    $course = $_GET["course"];
    $year = $_GET["year"];
    $sy = $_GET["sy"];
    $term = $_GET["term"];;


    $query   = "SELECT * FROM irreg_manual_sched WHERE stud_reg_id='".$stud_reg_id."' AND year='".$year."' AND term='".$term."' AND school_yr='".$sy."'";
    $result = mysqli_query($connection, $query);

    if (mysqli_num_rows($result)<1) {
        echo "<script type='text/javascript'>";
        echo "alert('No schedule set to delete for this student.');";
        echo "</script>";

        $URL="irregular-manual-enrollment.php";
        echo "<script>location.href='$URL'</script>";
    }
    
    while($row = mysqli_fetch_assoc($result))
    {
      $schedule_id = $row['schedule_id'];

      echo  "<p>".$schedule_id."</p>";
        
      $update_current_students_query   ="SELECT * FROM schedule_block WHERE schedule_id=".$schedule_id;
      $result_current_students = mysqli_query($connection, $update_current_students_query);

      while($row2 = mysqli_fetch_assoc($result_current_students))
        {
          $current_students = $row2['students_enrolled'] - 1;
          $current_teacher_id = $row2['teacher_id'];
          $current_subject_id = $row2['subject_id'];
          $current_course_id = $row2['course_id'];

          $query_update_current_students = "UPDATE schedule_block SET students_enrolled = '{$current_students}' WHERE schedule_id='".$schedule_id."' LIMIT 1"; 
          $result_update_current_students = mysqli_query($connection, $query_update_current_students);
        }
      
      $query_delete_sched   = "DELETE FROM irreg_manual_sched WHERE stud_reg_id='".$stud_reg_id."' AND year='".$year."' AND term='".$term."' AND school_yr='".$sy."'";
      $result_query_delete_sched = mysqli_query($connection, $query_delete_sched);

      $query4  = "UPDATE student_grades SET teacher_id = NULL WHERE stud_reg_id='".$stud_reg_id."' AND subject_id='".$current_subject_id."' AND course_id ='".$current_course_id."' AND term='".$term."' AND school_yr='".$sy."' LIMIT 1";

      $result4 = mysqli_query($connection, $query4);

      if ($result_query_delete_sched === TRUE) {
        echo "<script type='text/javascript'>";
        echo "alert('Delete schedule set successful!');";
        echo "</script>";

        $URL="irregular-manual-enrollment.php";
        echo "<script>location.href='$URL'</script>";
        } else {
          echo "Error updating record: " . $connection->error;
        }

        
    }



  if(isset($connection)){ mysqli_close($connection); }
  //close database connection after an sql command
  ?>