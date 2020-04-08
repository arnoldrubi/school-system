<?php include 'layout/header.php';?>
<?php require_once("includes/db_connection.php"); ?>

<?php 
  if (isset($_GET['room_id'])) {
    $room_id = $_GET["room_id"]; //Refactor this validation later
  }
  else{
    $room_id = NULL;
  }
  if ($room_id == NULL) {
    redirect_to("view-room.php");
  }

    $query  = "DELETE FROM rooms WHERE room_id = {$room_id} LIMIT 1";
    $result = mysqli_query($connection, $query);


  //close database connection after an sql command

  if ($result === TRUE) {
    echo "<script type='text/javascript'>";
    echo "alert('Delete room successful!');";
    echo "</script>";

    $URL="view-room.php";
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




