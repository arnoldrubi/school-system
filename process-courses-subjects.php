
<?php 
require_once("includes/session.php");
require_once("includes/functions.php");
require_once("includes/db_connection.php");

  // // get the subject id from #selected-subjects li
  // // create a loop for the sql insert command
  // // use the count of li elements under #selected-subjects as the max loop
  // insert course id, subject id, year, and term
  if (isset($_POST['submit'])) {

    $data = $_POST['array_values'];
    $arrVal = explode(";",$data);
    $arrLength = count($arrVal);


    $course = $_POST["course"];
    $year = mysql_prep($_POST["year"]);
    $semester = mysql_prep($_POST["semester"]);
    $school_yr = mysql_prep($_POST["school_yr"]);

    $query  = "SELECT * FROM course_subjects WHERE course_id = '".$course."' AND year = '".$year."' AND term = '".$semester."'";
    $result = mysqli_query($connection, $query);

    if (mysqli_num_rows($result)>0) {
      echo "<script type='text/javascript'>";
      echo "alert('Subject set already exists for this course, year and term.');";
      echo "</script>";

      $URL="manage-course-subjects.php";
      echo "<script>location.href='$URL'</script>";
    }

    else{

      foreach ($arrVal as $subjects) {
      $query   = "INSERT INTO course_subjects (course_id, subject_id, year, term, school_yr) VALUES ('{$course}', '{$subjects}', '{$year}', '{$semester}', '{$school_yr}')";
      $result = mysqli_query($connection, $query);

      }

    }

      if ($result === TRUE) {
        echo "<script type='text/javascript'>";
        echo "alert('Create subject set successful!');";
        echo "</script>";

        $URL="manage-course-subjects.php";
        echo "<script>location.href='$URL'</script>";

        } else {
          echo "Error updating record: " . $connection->error;
        }
 }

  if(isset($connection)){ mysqli_close($connection); }
  //close database connection after an sql command
  ?>