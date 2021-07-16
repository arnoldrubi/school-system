<?php 

require_once("includes/session.php");
require_once("includes/db_connection.php");
require_once("includes/functions.php");

//note: session already started using the session.php
//addition for security: delete the rows of the user from usertokens table

    $user_exist = return_duplicate_entry("user_token","username",$_SESSION["username"],"",$connection);
    if ($user_exist > 0) {
	    $query  = "DELETE FROM user_token WHERE username='".$_SESSION["username"]."' LIMIT 1";
	    $result = mysqli_query($connection, $query);
    }
	$_SESSION = array();
	if (isset($_COOKIE[session_name()])) {
		setcookie(session_name(), '', time()-42000, '/');
	}
	session_destroy();
	redirect_to("index.php");

?>