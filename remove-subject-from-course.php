<?php include 'layout/header.php';?>
<?php require_once("includes/db_connection.php"); ?>

<?php 
  if (isset($_GET['course_id'])) {
    $course_id = $_GET["course_id"];
    $subject_id = $_GET["subject_id"];
    $year = urldecode($_GET["year"]);
    $term = urldecode($_GET["term"]);
    $section = urldecode($_GET["section"]);
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

    $query  = "DELETE FROM course_subjects WHERE course_id ={$course_id} AND subject_id = {$subject_id} AND year ='".$year."' AND term ='".$term."' AND school_yr ='".$school_yr."' LIMIT 1";
    $result = mysqli_query($connection, $query);


  //close database connection after an sql command

  if ($result === TRUE) {
    $redirect_url = "edit-course-subjects.php?course_id=".$course_id."&year=".urlencode($year)."&term=".urlencode($term)."&section=".urlencode($section)."&school_yr=".urlencode($school_yr);
    redirect_to($redirect_url);
    
  } else {
    echo "Error updating record: " . $connection->error;
    echo "<br><br>". print_r($query);
  }
            //removed the redirect function and replaced it with javascript alert above
            //still need to use the redirect function in case javascript is turned off
            //redirect_to("new-subject.php");

  if(isset($connection)){ mysqli_close($connection); }

?>




