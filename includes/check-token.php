<?php
// this php file is inserted into the header file: session, function, and connection php files are already called on the header file. No need to call them again.

if (isset($_SESSION['username'])) {

  $user_exist = return_duplicate_entry("user_token","username",$_SESSION['username'],"",$connection);
 
  if ($user_exist > 0) {
    $query  = "SELECT * FROM user_token WHERE username='".$_SESSION['username']."' LIMIT 1";
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