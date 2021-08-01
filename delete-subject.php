<?php include 'layout/header.php';?>
<?php require_once("includes/db_connection.php"); ?>

<?php 
  if (isset($_GET['subject_id'])) {
    $subject_id = $_GET["subject_id"]; //Refactor this validation later
  }
  else{
    $subject_id = NULL;
  }
  if ($subject_id == NULL) {
    redirect_to("view-subject.php");
  }

  $data_exist = return_duplicate_entry("course_subjects","subject_id",$subject_id,"",$connection);

  if ($data_exist > 0) {
    echo "<script type='text/javascript'>";
    echo "alert('Error! Cannot delete subject info. This subject is added to a course(es).');";
    echo "</script>";
    $URL="view-subject.php";
    echo "<script>location.href='$URL'</script>";
  }

  else{
      $query  = "DELETE FROM subjects WHERE subject_id = {$subject_id} LIMIT 1";
      $result = mysqli_query($connection, $query);


      //close database connection after an sql command

      if ($result === TRUE) {
        echo "<script type='text/javascript'>";
        echo "alert('Delete subject successful!');";
        echo "</script>";

        $URL="view-subject.php";
        echo "<script>location.href='$URL'</script>";
      } else {
        echo "Error updating record: " . $connection->error;
      }

    if(isset($connection)){ mysqli_close($connection); }
  }

?>




