<?php include 'layout/header.php';?>
<?php require_once("includes/db_connection.php"); ?>

<?php 
  if (isset($_GET['teacher_id'])) {
    $teacher_id = $_GET["teacher_id"]; //Refactor this validation later
  }
  else{
    $teacher_id = NULL;
  }
  if ($teacher_id == NULL) {
    redirect_to("view-teachers.php");
  }

  $data_exist = return_duplicate_entry("classes","teacher_id",$teacher_id,"",$connection);

  if ($data_exist > 0) {
    echo "<script type='text/javascript'>";
    echo "alert('Error! Cannot delete teacher info. This teacher is added to classes.');";
    echo "</script>";
    $URL="view-teachers.php";
    echo "<script>location.href='$URL'</script>";
  }
  else{
    $query  = "UPDATE teachers SET active = 0 WHERE teacher_id = {$teacher_id} LIMIT 1";
    $result = mysqli_query($connection, $query);

    $query  = "UPDATE users SET active = 0 WHERE teacher_id = {$teacher_id} LIMIT 1";
    $result = mysqli_query($connection, $query);


    //close database connection after an sql command

    if ($result === TRUE) {
      echo "<script type='text/javascript'>";
      echo "alert('Teacher set to inactive!');";
      echo "</script>";

      $URL="view-teachers.php";
      echo "<script>location.href='$URL'</script>";
    } else {
      echo "Error updating record: " . $connection->error;
    }

  }



  if(isset($connection)){ mysqli_close($connection); }

?>


<?php 

  ?>




