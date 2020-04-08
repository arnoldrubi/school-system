<?php include 'layout/header.php';?>
<?php require_once("includes/db_connection.php"); ?>

<?php 
  if (isset($_GET['schedule_id'])) {
    $schedule_id = $_GET["schedule_id"]; //Refactor this validation later
  }
  else{
    $schedule_id = NULL;
  }
  if ($schedule_id == NULL) {
    redirect_to("view-schedule.php");
  }

    //check if record exist before deletion, if no record: redirect
    $query  = "SELECT * FROM schedule_block WHERE schedule_id = {$schedule_id} LIMIT 1";
    $result = mysqli_query($connection, $query);

    if (mysqli_num_rows($result)<1) {
     redirect_to("view-schedule.php");
    }
    else{
      $query  = "DELETE FROM schedule_block WHERE schedule_id = {$schedule_id} LIMIT 1";
      $result = mysqli_query($connection, $query);
    }

  //close database connection after an sql command

  if ($result === TRUE) {
    echo "<script type='text/javascript'>";
    echo "alert('Delete schedule successful!');";
    echo "</script>";

    $URL="view-schedule.php";
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




