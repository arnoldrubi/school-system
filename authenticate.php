<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="static/custom.css">
    <title>Log in</title>
  </head>
  <body>

  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-12"><br><br>

<?php
require_once("includes/session.php");
require_once("includes/db_connection.php");
require_once("includes/functions.php");

if (isset($_POST['submit'])) {

	if ( !isset($_POST['username'], $_POST['password']) ) {
	  // Could not get the data that should have been sent.
	  die ("<div class=\"alert alert-danger\" role=\"alert\">Please fill both the username and password field!</div>");
	}
	else{
    // $admin_set = find_admin_by_username($_POST['username']);
    // //echo $admin_set['password'];
    $username = $_POST["username"];
    $password = $_POST["password"];


    $found_admin = attempt_login($username, $password);
    if ($found_admin) {
    // Success
    // Mark user as logged in
    $_SESSION["user_id"] = $found_admin["user_id"];
    $_SESSION["username"] = $found_admin["username"];
    $_SESSION["role"] = $found_admin["role"];
    $_SESSION["email"] = $found_admin["email"];
    $_SESSION["message"] = "";
    $_SESSION["teacher_id"] =  $found_admin["teacher_id"];

// insert codes here for the user token

    $token = getToken(16);
    $timestamp = date("Y-m-d H:i:s");
    $user_exist = return_duplicate_entry("user_token","username",$username,"",$connection);
    // create session token
    $_SESSION['token'] = $token;

    if ($user_exist > 0) {
      $query_update_token  = "UPDATE user_token SET token = '{$token}', timemodified = '{$timestamp}' WHERE username ='".$username."' LIMIT 1";
      $result_update_token = mysqli_query($connection, $query_update_token);
    }
    else if ($user_exist < 1) {
      $query_insert_token  = "INSERT INTO user_token (username, token, timemodified) VALUES ('{$username}', '{$token}', '{$timestamp}')";
      $result_insert_token = mysqli_query($connection, $query_insert_token);
    }


// end codes for user token

// insert codes here for the user log
    $userIPaddress = getIPAddress();

    $query = "INSERT INTO user_logs (user_id, ip_address, time_logged_in) VALUES ('{$_SESSION["user_id"]}', '{$userIPaddress}', '{$timestamp}')";
    $result = mysqli_query($connection, $query);

// end codes for user log

    if ($_SESSION["role"] == "faculty") {
      redirect_to("faculty-dashboard.php");
    }
    else{
      redirect_to("admin-dashboard.php");
      }
    }
    else{
    $_SESSION["message"] = "Username/password not found";
    redirect_to("index.php");
    } 
	}

}
?>

      </div>
    </div>
  </div>




    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>
