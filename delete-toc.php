<?php include 'layout/header.php';?>
<?php require_once("includes/db_connection.php"); ?>

<?php 

  if (isset($_GET['id'])) {    
    $id = $_GET['id'];

    $query  = "DELETE FROM transfer_of_credits WHERE id=".$id." LIMIT 1";
    $result = mysqli_query($connection, $query);

    //close database connection after an sql command

    if ($result === TRUE) {
      echo "<script type='text/javascript'>";
      echo "alert('Delete TOC data successful!');";
      echo "</script>";

      $URL="view-toc.php";
      echo "<script>location.href='$URL'</script>";
    } else {
      echo "Error updating record: " . $connection->error;
    }

    if(isset($connection)){ mysqli_close($connection); }

  }
  else{
    redirect_to("view-toc.php");
  }

?>




