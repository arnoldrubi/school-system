<?php

if (isset($_POST["reset-password-submit"])) {
	$selector = $_POST["selector"];
	$validator = $_POST["validator"];
	$password = $_POST["pwd"];
	$passwordRepeat = $_POST["pwd-repeat"];	

	if (empty($password) || empty($passwordRepeat)) {
		header("Location: ../index.php?newpwd=empty");
		exit();
	}
	else if($password !== $passwordRepeat){
		header("Location: ../index.php?newpwd=pwdnotsame");
		exit();	
	}

	$currentDate = date("U");

	require 'db_connection.php';

	$sql = "SELECT * FROM pwdreset WHERE pwdResetSelector=? AND pwdResetExpires>= ".$currentDate;

	$stmt = mysqli_stmt_init($connection);

	if(! mysqli_stmt_prepare($stmt, $query)){
		echo "There was an error";
		exit();
	}
	else{
		mysqli_stmt_bind_param($stmt, "s", $selector);
		mysqli_stmt_execute($stmt); 

		$result = mysqli_stmt_get_result($stmt);

		if (!$row == mysqli_fetch_assoc($result)) {
			echo "You need to resubmit your reset password request";
			exit();
		}
		else{
			// token submitted through the form must match the one from the database
			$tokenBin = hex2bin($validator);
			
			$tokenCheck = password_verify($tokenBin, $row["pwdResetToken"]); 
			// $token check through the password_verify function returns a true or false value

			if ($tokenCheck === FALSE) {
				echo "You need to resubmit your reset password request";
				exit();
			}
			elseif ($tokenCheck === TRUE) {

				$tokenEmail = $row["pwdResetEmail"];

				$sql = "SELECT * FROM users WHERE email=?";
				$stmt = mysqli_stmt_init($connection);

					if(! mysqli_stmt_prepare($stmt, $query)){
						echo "There was an error";
						exit();
					}
					else{

						mysqli_stmt_bind_param($stmt, "s", $tokenEmail);
						mysqli_stmt_execute($stmt);
						if (!$row == mysqli_fetch_assoc($result)) {
							echo "There was a serious error";
							exit();
						}
						else{
							$sql = "UPDATE users SET password=? WHERE email=?";

							$stmt = mysqli_stmt_init($connection);

							if(! mysqli_stmt_prepare($stmt, $query)){
								echo "There was an error";
								exit();
							}
							else{

								$newpwdHash = password_hash($password, PASSWORD_DEFAULT);

								mysqli_stmt_bind_param($stmt, "ss", $newpwdHash, $tokenEmail);
								mysqli_stmt_execute($stmt);

								$query = "DELETE FROM pwdreset WHERE pwdResetEmail=?";
								$stmt = mysqli_stmt_init($connection);

								if(! mysqli_stmt_prepare($stmt, $query)){
									echo "There was an error";
									exit();
								}
								else{
									mysqli_stmt_bind_param($stmt, "s", $userEmail);
									mysqli_stmt_execute($stmt); 

									header("Location: ../index.php?newpwd=passwordupdated");
								}
							}
						} 

					}
			}
		}
	}
}
else{
	header("Location: ../index.php");
}

?>