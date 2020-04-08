<?php include 'layout/header.php';?>
<?php require_once("includes/db_connection.php"); ?>

<?php

  $role = $_SESSION["role"];

  if ($role == "administrator") {

    if (isset($_GET['user_id'])) {
      $user_id = $_GET["user_id"]; //Refactor this validation later
    }
    else{
      $user_id = NULL;
    }
    if ($user_id == NULL) {
      redirect_to("view-users.php");
    }

      $query  = "DELETE FROM users WHERE user_id = {$user_id} LIMIT 1";
      $result = mysqli_query($connection, $query);


    //close database connection after an sql command

    if ($result === TRUE) {
      echo "<script type='text/javascript'>";
      echo "alert('Delete user successful!');";
      echo "</script>";

      $URL="view-users.php";
      echo "<script>location.href='$URL'</script>";
    } else {
      echo "Error updating record: " . $connection->error;
    }
              //removed the redirect function and replaced it with javascript alert above
              //still need to use the redirect function in case javascript is turned off
              //redirect_to("new-subject.php");

    if(isset($connection)){ mysqli_close($connection); }

  }
  else{
    redirect_to("index.php");
  }

?>