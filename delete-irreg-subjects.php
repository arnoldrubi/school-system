<?php 
require_once("includes/session.php");
require_once("includes/functions.php");
require_once("includes/db_connection.php");

    $stud_reg_id = $_GET["stud_reg_id"];
    $course = $_GET["course"];
    $year = $_GET["year"];
    $sy = $_GET["sy"];
    $term = $_GET["term"];;


//step 1 get all the class_id for this student put it on an array
//step 2 put the query after the irreg manual sched deletion
//step 3 loop the class id, get the sec_id on loop
//update query: 1)count all the rows where class_id == from the irreg manual sched, 2) copy the function that counts all reg. student enrollment where class_id ==, and sec_id ==
//add the row counf from 1) and 2)
//run update query class_id, update current students

    $query_get_class_ids = "SELECT * from irreg_manual_sched WHERE stud_reg_id='".$stud_reg_id."'";
    $result_get_class_ids = mysqli_query($connection, $query_get_class_ids);

    $class_ids = array();
      while($row_get_class_ids = mysqli_fetch_assoc($result_get_class_ids))
      {
        array_push($class_ids, $row_get_class_ids['class_id']);
      }

      $query_delete_sched   = "DELETE FROM irreg_manual_sched WHERE stud_reg_id='".$stud_reg_id."' AND year='".$year."' AND term='".$term."' AND school_yr='".$sy."'";
      $result = mysqli_query($connection, $query_delete_sched);

      if (sizeof($class_ids) > 0) {
       for ($i=0; $i < sizeof($class_ids); $i++) { 
          
          $query_get_irreg_count  = "SELECT COUNT(*) AS num FROM irreg_manual_sched WHERE class_id='".$class_ids[$i]."'";
          $result_get_enrolled = mysqli_query($connection, $query_get_irreg_count);
          while($row_get_enrolled = mysqli_fetch_assoc($result_get_enrolled)){
             $irreg_count = $row_get_enrolled['num'];
           }

          $sec_id = get_section_name_by_class($class_ids[$i],"",$connection);
          $count_regular_student = get_enrolled_regular_students($sec_id,$term,$sy,"",$connection);

          $current_students_total = $irreg_count + $count_regular_student;

          $query4  = "UPDATE classes SET students_enrolled = '{$current_students_total}' WHERE class_id ='".$class_ids[$i]."'";
          $result4 = mysqli_query($connection, $query4);
        }        
      }


      $query_delete_grades   = "DELETE FROM student_grades WHERE stud_reg_id='".$stud_reg_id."' AND year='".$year."' AND term='".$term."' AND school_yr='".$sy."' AND sec_id='"."0"."'";
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