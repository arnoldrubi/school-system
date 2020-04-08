<?php include 'layout/header.php';?>
<?php require_once("includes/db_connection.php"); ?>

<?php 
  if (isset($_GET['course_id'])) {
    $course_id = $_GET["course_id"]; //Refactor this validation later
  }
  else{
    $course_id = NULL;
  }
  if ($course_id == NULL) {
    redirect_to("view-courses.php");
  }

  $course_deleted = 0;

    $query  = "UPDATE courses SET course_deleted = '{$course_deleted}' WHERE course_id = {$course_id} LIMIT 1";
    $result = mysqli_query($connection, $query);

  //close database connection after an sql command

  if ($result === TRUE) {
    echo "<script type='text/javascript'>";
    echo "alert('Restore course successful!');";
    echo "</script>";

    $URL="view-courses.php";
    echo "<script>location.href='$URL'</script>";
  } else {
    echo "Error updating record: " . $connection->error;
  }
            //removed the redirect function and replaced it with javascript alert above
            //still need to use the redirect function in case javascript is turned off
            //redirect_to("new-subject.php");

  if(isset($connection)){ mysqli_close($connection); }

?>


<?php 

  ?>




