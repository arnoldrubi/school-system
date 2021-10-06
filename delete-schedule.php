<?php include 'layout/header.php';?>
<?php require_once("includes/db_connection.php"); ?>

<?php 
  if (isset($_GET['schedule_id'])) {
    $schedule_id = $_GET["schedule_id"];
    $class_id = $_GET["class_id"];
    $term = $_GET["term"];
    $school_yr = $_GET["school_yr"];  
  }
  else{
    redirect_to("classes.php");
  }

  $query  = "DELETE FROM schedule_block WHERE schedule_id=".$schedule_id." LIMIT 1";
  $result = mysqli_query($connection, $query);


    //close database connection after an sql command

    if ($result === TRUE) {
      echo "<script type='text/javascript'>";
      echo "alert('Delete schedule successful!');";
      echo "</script>";

      $URL="view-class-schedule.php?class_id=".$class_id."&school_yr=".$school_yr."&term=".$term;
      echo "<script>location.href='$URL'</script>";
    } else {
      echo "Error updating record: " . $connection->error;
    }

  if(isset($connection)){ mysqli_close($connection); }


?>




