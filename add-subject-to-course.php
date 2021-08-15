<?php include 'layout/header.php';?>
<?php require_once("includes/functions.php"); ?>
<?php require_once("includes/db_connection.php"); ?>

<?php 
  if (isset($_GET['course_id'])) {
    $course_id = (int) $_GET["course_id"];
    $subject_id = (int) $_GET["subject_id"];
    $year = urldecode($_GET["year"]);
    $term = urldecode($_GET["term"]);
    $school_yr = urldecode($_GET["school_yr"]);
  }
  else{
    $course_id = NULL;
    $year = NULL;
    $term = NULL;
    $subject_id = NULL;
  }
  if ($course_id == NULL) {
    redirect_to("manage-course-subjects.php");
  }

  // do a merge here and get the credits from subjects table, use the SUM function to get the total credit, insert will not happen if the total credits is greater than the max credits from site settings

  $get_total_units_query  = "SELECT subject_id FROM course_subjects WHERE course_id='".$course_id."' AND year='".$year."' AND term ='".$term."'";
  $get_total_units_result = mysqli_query($connection, $get_total_units_query);

  $max_units = return_max_units($connection);
  $total_units = get_subject_total_unit($subject_id,"",$connection);

  while($get_total_units_row = mysqli_fetch_assoc($get_total_units_result))
  {

    $total_units += get_subject_total_unit($get_total_units_row['subject_id'],"", $connection);

  }
// working but needed to double check
  if ($total_units > $max_units) {
    $redirect_url = "edit-course-subjects.php?course_id=".$course_id."&year=".urlencode($year)."&term=".urlencode($term)."&school_yr=".urlencode($school_yr)."&error=".urlencode("true");
    redirect_to($redirect_url);
  }

  else{

    $query  = "SELECT * FROM course_subjects WHERE subject_id ='".$subject_id."' AND course_id='".$course_id."' AND year='".$year."' AND term='".$term."' AND school_yr='".$school_yr."'  LIMIT 1";
    $result = mysqli_query($connection, $query);
    if ($result === TRUE) {
    $redirect_url = "edit-course-subjects.php?course_id=".$course_id."&year=".urlencode($year)."&term=".urlencode($term)."&school_yr=".urlencode($school_yr);
    redirect_to($redirect_url);
    }
    else{
    $query   = "INSERT INTO course_subjects (course_id, subject_id, year, term, school_yr) VALUES ('{$course_id}', '{$subject_id}', '{$year}', '{$term}', '{$school_yr}')";
    $result = mysqli_query($connection, $query);
  }

  if ($result === TRUE) {
    $redirect_url = "edit-course-subjects.php?course_id=".$course_id."&year=".urlencode($year)."&term=".urlencode($term)."&school_yr=".urlencode($school_yr)."&subject_added=1";
    redirect_to($redirect_url);
  } else {
    echo "Error updating record: " . $connection->error;
    echo "<br><br>". print_r($query);
  }

  }



  if(isset($connection)){ mysqli_close($connection); }

?>




