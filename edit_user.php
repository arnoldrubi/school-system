<?php
require_once("includes/functions.php");
require_once("includes/session.php");
require_once("includes/db_connection.php");

 if (isset($_POST['submit'])) {
   $user_id = $_GET["user_id"];
   $simple_password = $_POST["password"];
   $hashed_password = password_encrypt($_POST["password"]);
   $email = $_POST["email"];

   $query  = "UPDATE users SET username = '{$username}', password = '{$simple_password}', email = '{$email}' WHERE user_id =".$user_id." LIMIT 1";
   $result = mysqli_query($connection, $query);
   print_r($query);
   if ($result && mysqli_affected_rows($connection) == 1) {
    // Success
    $_SESSION["message"] = "Admin updated.";
      redirect_to("admin-dashboard.php");
    } else {
            // Failure
      $_SESSION["message"] = "Admin update failed.";
    }

    print_r($user_id);
  }
?>