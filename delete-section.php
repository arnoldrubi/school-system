<?php include 'layout/header.php';?>
<?php require_once("includes/db_connection.php"); ?>

<?php 
  if (isset($_GET['sec_id'])) {
    $sec_id = $_GET["sec_id"]; //Refactor this validation later
  }
  else{
    $sec_id = NULL;
  }
  if ($sec_id == NULL) {
    redirect_to("view-teachers-and-rooms.php");
  }

  $data_exist = return_duplicate_entry("sections","sec_id",$sec_id,"",$connection);

  if ($data_exist > 0) {
    echo "<script type='text/javascript'>";
    echo "alert('Error! Cannot delete section info. This section is added to classes.');";
    echo "</script>";
    $URL="manage-sections.php";
    echo "<script>location.href='$URL'</script>";
  }
  else{
    $query  = "DELETE FROM sections WHERE sec_id = {$sec_id} LIMIT 1";
    $result = mysqli_query($connection, $query);

  if ($result === TRUE) {
    echo "<script type='text/javascript'>";
    echo "alert('Delete subject successful!');";
    echo "</script>";

    $URL="manage-sections.php";
    echo "<script>location.href='$URL'</script>";
    }
    else {
    echo "Error updating record: " . $connection->error;
    }

    if(isset($connection)){ mysqli_close($connection); }

  }

?>




