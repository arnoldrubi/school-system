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

    $query  = "DELETE FROM classes WHERE class_id ='".$class_id."' LIMIT 11";
    $result = mysqli_query($connection, $query);

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

?>


<?php 

  ?>




