
<?php 
require_once("includes/session.php");
require_once("includes/functions.php");
require_once("includes/db_connection.php");

  // // we will use ajax for this one
  // // get the subject id from #selected-subjects li
  // // create a loop for the sql insert command
  // // use the count of li elements under #selected-subjects as the max loop
  // insert course id, subject id, year, and term
  if (isset($_POST['submit'])) {

    $data = $_POST['array_values'];
    $arrVal = explode(";",$data);
    $arrLength = count($arrVal);

    $stud_reg_id = (int) $_POST["stud_reg_id"];
    $course_id = (int) $_POST["course"];
    $year = mysql_prep($_POST["year"]);
    $term = mysql_prep($_POST["term"]);
    $sy = mysql_prep($_POST["sy"]);

      foreach ($arrVal as $schedule_id) {

      //logic check to make sure no double insertion is done

      $query_check  = "SELECT * FROM irreg_manual_sched WHERE stud_reg_id = '".$stud_reg_id."' AND schedule_id='".$schedule_id."'";
      $result_check = mysqli_query($connection, $query_check);

      if (mysqli_num_rows($result_check)>0) {
        echo "<script type='text/javascript'>";
        echo "alert('Student already has schedule blocks assigned');";
        echo "</script>";
        
        $URL="irregular-manual-enrollment.php";
        echo "<script>location.href='$URL'</script>";
      }
      else{
        $update_current_students_query   ="SELECT * FROM schedule_block WHERE schedule_id=".$schedule_id;
        $result_current_students = mysqli_query($connection, $update_current_students_query);
          while($row2 = mysqli_fetch_assoc($result_current_students))
            {
              $current_students = $row2['students_enrolled'] + 1;
              $current_teacher_id = $row2['teacher_id'];
              $current_subject_id = $row2['subject_id'];
              $current_course_id = $row2['course_id'];
            }

            if ($current_students-1 > $current_students) {
            echo "<script type='text/javascript'>";
            echo "alert('Current student count for schedule is greater than the max students allowed! Edit the max students on the Group Scheduling Dashboard');";
            echo "</script>";

            $URL="irregular-manual-enrollment.php";
            echo "<script>location.href='$URL'</script>";
            }
            else{
            //insert sched id and stud reg id to the irreg manual sched table so we can remove schedule blocks for irreg students when needed
            $query   = "INSERT INTO irreg_manual_sched (stud_reg_id, schedule_id, year, term, school_yr) VALUES ('{$stud_reg_id}', '{$schedule_id}', '{$year}', '{$term}', '{$sy}')";
            $result = mysqli_query($connection, $query);
            //update all selected schedule block's current students 
            $query3  = "UPDATE schedule_block SET students_enrolled = '{$current_students}' WHERE schedule_id='".$schedule_id."' LIMIT 1";
            $result3 = mysqli_query($connection, $query3);

            //update teacher for irreg student's grade 
            $query4  = "UPDATE student_grades SET teacher_id = '{$current_teacher_id}' WHERE stud_reg_id='".$stud_reg_id."' AND subject_id='".$current_subject_id."' AND course_id ='".$current_course_id."' AND term='".$term."' AND school_yr='".$sy."' LIMIT 1";
            
            $result4 = mysqli_query($connection, $query4);
            }

      }
    }

  

      if ($result3 === TRUE) {
        echo "<script type='text/javascript'>";
        echo "alert('Create schedule set successful!');";
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