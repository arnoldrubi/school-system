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

      $query  = "UPDATE users SET active = 0 WHERE user_id = {$user_id} LIMIT 1";
      $result = mysqli_query($connection, $query);

      $query_check_teacher  = "SELECT teacher_id FROM users WHERE user_id = {$user_id} LIMIT 1";
      $result_check_teacher = mysqli_query($connection, $query_check_teacher);
      if (mysqli_num_rows($result_check_teacher)>0) {

      while($row = mysqli_fetch_assoc($result_check_teacher))
        {
          $teacher_id = $row['teacher_id'];
        }
        if (isset($teacher_id) || $teacher_id !== NULL) {
            $query  = "UPDATE teachers SET active = 0 WHERE teacher_id = {$teacher_id} LIMIT 1";
            $result = mysqli_query($connection, $query);
          }    

      } 
      print_r($query_check_teacher);

    //close database connection after an sql command

    if ($result === TRUE) {
      echo "<script type='text/javascript'>";
      echo "alert('User set to inactive!');";
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