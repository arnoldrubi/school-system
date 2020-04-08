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

    while($row = mysqli_fetch_assoc($result))
    {
      $update_current_students_query   ="SELECT * FROM schedule_block WHERE schedule_id=".$row['schedule_id'];

      $result_current_students = mysqli_query($connection, $update_current_students_query);
      while($row2 = mysqli_fetch_assoc($result_current_students))
        {
          $current_students = $row2['students_enrolled'] - 1;
        }

      $query_update_current_students = "UPDATE schedule_block SET students_enrolled = '{$current_students}' WHERE schedule_id='".$row['schedule_id']."' LIMIT 1"; 
      $result_update_current_students = mysqli_query($connection, $query_update_current_students);
    }

      $query_delete_sched   = "DELETE FROM irreg_manual_sched WHERE stud_reg_id='".$stud_reg_id."' AND year='".$year."' AND term='".$term."' AND school_yr='".$sy."'";
      $result = mysqli_query($connection, $query_delete_sched);

      $query_delete_grades   = "DELETE FROM student_grades WHERE stud_reg_id='".$stud_reg_id."' AND year='".$year."' AND term='".$term."' AND school_yr='".$sy."' AND section='"."N/A"."'";
      $result2 = mysqli_query($connection, $query_delete_grades);

      $query_delete_subject   = "DELETE FROM irreg_manual_subject WHERE stud_reg_id='".$stud_reg_id."' AND year='".$year."' AND term='".$term."' AND school_yr='".$sy."'";
      $result = mysqli_query($connection, $query_delete_subject);

      if ($result === TRUE) {
        echo "<script type='text/javascript'>";
        echo "alert('Delete subject set, grades and schedule set successful!');";
        echo "</script>";

        $URL="irregular-manual-enrollment.php";
        echo "<script>location.href='$URL'</script>";
        } else {
          print_r($query);
          echo "Error updating record: " . $connection->error;
        }

  if(isset($connection)){ mysqli_close($connection); }
  //close database connection after an sql command
  ?>