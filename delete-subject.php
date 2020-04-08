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
            //removed the redirect function and replaced it with javascript alert above
            //still need to use the redirect function in case javascript is turned off
            //redirect_to("new-subject.php");

  if(isset($connection)){ mysqli_close($connection); }

?>




