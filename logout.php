<?php 

require_once("includes/session.php");
require_once("includes/functions.php");

//note: session already started using the session.php

	// $_SESSION["user_id"] = null;
	// $_SESSION["username"] = null;
	// $_SESSION["role"] = null;

	// redirect_to("index.php");

	//v2: destroy session
	// assumes nothing else in session to keep
	session_start();
	$_SESSION = array();
	if (isset($_COOKIE[session_name()])) {
		setcookie(session_name(), '', time()-42000, '/');
	}
	session_destroy();
	redirect_to("index.php");

?>