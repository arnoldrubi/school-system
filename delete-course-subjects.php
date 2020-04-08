<?php include 'layout/header.php';?>
<?php require_once("includes/db_connection.php"); ?>

<?php 



  if (isset($_GET['course_id']) && ($_GET['year']) && ($_GET['term'])) {
    $course_id = $_GET["course_id"]; //Refactor this validation later
    $year = urldecode($_GET['year']);
    $term = urldecode($_GET['term']);
  }
  else{
    $course_id = NULL;
    $year = NULL;
    $term = NULL;
  }
    $query  = "DELETE FROM course_subjects WHERE course_id = {$course_id} AND year ='".$year."' AND term ='".$term."'";

    $result = mysqli_query($connection, $query);

  //close database connection after an sql command

  if ($result === TRUE) {
    echo "<script type='text/javascript'>";
    echo "alert('Delete course subjects successful!');";
    echo "</script>";

    $URL="view-courses.php";
    echo "<script>location.href='$URL'</script>";
  } else {
    $msg = "Error updating record: " . $connection->error;
    echo "alert('".$msg."');";
    $URL="view-course-subjects.php";
    echo "<script>location.href='$URL'</script>";
  }

  if(isset($connection)){ mysqli_close($connection); }

?>




