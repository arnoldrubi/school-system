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

    $query  = "DELETE FROM teachers WHERE teacher_id = {$teacher_id} LIMIT 1";
    $result = mysqli_query($connection, $query);

    $query  = "DELETE FROM users WHERE teacher_id = {$teacher_id} LIMIT 1";
    $result = mysqli_query($connection, $query);


  //close database connection after an sql command

  if ($result === TRUE) {
    echo "<script type='text/javascript'>";
    echo "alert('Delete teacher info successful!');";
    echo "</script>";

    $URL="view-teachers.php";
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




