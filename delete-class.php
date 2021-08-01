<?php include 'layout/header.php';?>
<?php require_once("includes/db_connection.php"); ?>

<?php 
  if (isset($_GET['class_id'])) {
    $class_id = $_GET["class_id"]; //Refactor this validation later
  }
  else{
    $class_id = NULL;
  }
  if ($class_id == NULL) {
    redirect_to("view-teachers-and-rooms.php");
  }


  $data_exist = return_duplicate_entry("schedule_block","class_id",$class_id,"",$connection);

  if ($data_exist > 0) {
    echo "<script type='text/javascript'>";
    echo "alert('Error! Cannot delete class info. This class has schedule created. Delete the schedule first.');";
    echo "</script>";
    $URL="sections-and-classes.php";
    echo "<script>location.href='$URL'</script>";
  }
  else{ 
    $query  = "DELETE FROM classes WHERE class_id ='".$class_id."' LIMIT 1";
    $result = mysqli_query($connection, $query);

    $query_schedule  = "DELETE FROM schedule_block WHERE class_id ='".$class_id."'";
    $result_schedule = mysqli_query($connection, $query_schedule);

    //close database connection after an sql command

    if ($result === TRUE) {
      echo "<script type='text/javascript'>";
      echo "alert('Delete class successful!');";
      echo "</script>";

      $URL="classes.php";
      echo "<script>location.href='$URL'</script>";
    } else {
      echo "Error updating record: " . $connection->error;
    }

    if(isset($connection)){ mysqli_close($connection); }
  }
?>


<?php 

  ?>




