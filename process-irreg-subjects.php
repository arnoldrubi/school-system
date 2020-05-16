
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
    $course = (int) $_POST["course"];
    $year = mysql_prep($_POST["year"]);
    $term = mysql_prep($_POST["term"]);
    $sy = mysql_prep($_POST["sy"]);

    $query  = "SELECT * FROM student_grades WHERE stud_reg_id = '".$stud_reg_id."' AND course_id='".$course."' AND year = '".$year."' AND term = '".$term."' AND school_yr='".$sy."'";
    $result = mysqli_query($connection, $query);

    if (mysqli_num_rows($result)>0) {
      echo "<script type='text/javascript'>";
      echo "alert('Student has subjects assigned for this year, and term');";
      echo "</script>";

      $URL="irregular-manual-enrollment.php";
      echo "<script>location.href='$URL'</script>";
    }

    else{


      foreach ($arrVal as $class_id) {


      //insert irreg student schedule based on class_id

      $query_class_info = "SELECT * FROM classes WHERE class_id='".$class_id."'";
      $result_class_info = mysqli_query($connection, $query_class_info);

      while($row_class_info = mysqli_fetch_assoc($result_class_info))
      {
        $subject_id = $row_class_info['subject_id'];
        $teacher_id = $row_class_info['teacher_id'];
        $current_students = $row_class_info['students_enrolled'];
      }

      //insert irreg student and record his/her schedule
      $query3   = "INSERT INTO irreg_manual_sched (stud_reg_id, schedule_id, year, term, school_yr) VALUES ('{$stud_reg_id}', '{$class_id}', '{$year}', '{$term}', '{$sy}')";
      $result3 = mysqli_query($connection, $query3);

      //update all selected schedule block's current students 
      $current_students = $current_students + 1;

      $query_update_current_students  = "UPDATE classes SET students_enrolled = '{$current_students}' WHERE class_id='".$class_id."' LIMIT 1";
      $result_update_current_students = mysqli_query($connection, $query_update_current_students);

      //insert irreg student and record his/her subjects/classes
      $query3  = "INSERT INTO irreg_manual_sched (stud_reg_id, class_id, year, term, school_yr) VALUES ('{$stud_reg_id}', '{$class_id}', '{$year}', '{$term}', '{$sy}')";
      $result3 = mysqli_query($connection, $query3);

      $query2   = "INSERT INTO irreg_manual_subject (stud_reg_id, subject_id, year, term, school_yr) VALUES ('{$stud_reg_id}', '{$subject_id}', '{$year}', '{$term}', '{$sy}')";
      $result2 = mysqli_query($connection, $query2);

      //insert irreg student to the grading tables
      $query   = "INSERT INTO student_grades (stud_reg_id, course_id, subject_id, teacher_id, year, term, sec_id, school_yr,grade_posted) VALUES ('{$stud_reg_id}', '{$course}', '{$subject_id}', '{$teacher_id}', '{$year}', '{$term}','0', '{$sy}', '0')";      

      $result = mysqli_query($connection, $query);
    

      }
    }

      if ($result === TRUE) {
        echo "<script type='text/javascript'>";
        echo "alert('Create subject set successful!');";
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