<?php 
require_once("includes/db_connection.php");
require_once("includes/functions.php");
require_once("includes/session.php");

  $username = $_SESSION["username"];
  $role =  $_SESSION["role"];
  confirm_logged_in();

if (isset($username)) {

  $user_exist = return_duplicate_entry("user_token","username",$username,"",$connection);
 
  if ($user_exist > 0) {
    $query  = "SELECT * FROM user_token WHERE username='".$username."' LIMIT 1";
    $result = mysqli_query($connection, $query);
 
  while($row = mysqli_fetch_assoc($result))
    {
      $token = $row['token'];
    }    
    if($_SESSION['token'] != $token){
      session_destroy();
      redirect_to("index.php?error=1");
    }
  }
}

?>

<!doctype html>
<html lang="en">
  <head>
    <!-- PUT WARNING IN CASE JAVASCRIPT IS TURNED OFF -->

    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <!-- Custom fonts for this template-->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <!-- Custom Admin CSS c/o SB-Admin https://startbootstrap.com/templates/sb-admin/ -->
    <link rel="stylesheet" type="text/css" href="static/sb-admin.css">
    <!-- Data Table CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" crossorigin="anonymous">
    <!-- Google Fonts Roboto and Open Sans -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans|Roboto&display=swap" rel="stylesheet">
    <!-- Custom CSS to overide default CSS -->
    <link rel="stylesheet" type="text/css" href="static/custom.css">

