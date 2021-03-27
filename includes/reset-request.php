<?php 
	
	if (isset($_POST["reset-request-submit"])) {
		$selector = bin2hex(random_bytes(8));
		$token = random_bytes(32);
		$url = "https://aims-ph.000webhostapp.com/create-new-password.php?selector=".$selector."&validator=".bin2hex($token);

		$expires = date("U") + 1800;

		require 'db_connection.php'; 

		$connection;

		$userEmail = $_POST["email"];

		$query = "DELETE FROM pwdreset WHERE pwdResetEmail=?";
		$stmt = mysqli_stmt_init($connection);

		if(! mysqli_stmt_prepare($stmt, $query)){
			echo "There was an error";
			exit();
		}
		else{
			mysqli_stmt_bind_param($stmt, "s", $userEmail);
			mysqli_stmt_execute($stmt); 
		}

	 	$query = "INSERT INTO pwdreset (pwdResetEmail, pwdResetSelector, pwdResetToken, pwdResetExpires) VALUES (?,?,?,?)";

	 	$stmt = mysqli_stmt_init($connection);

		if(! mysqli_stmt_prepare($stmt, $query)){
			echo "There was an error";
			exit();
		}
		else{
			$hashedToken = password_hash($token, PASSWORD_DEFAULT);
			mysqli_stmt_bind_param($stmt, "ssss", $userEmail, $selector, $token, $expires);
			mysqli_stmt_execute($stmt); 
		}

		mysqli_stmt_close($stmt);
		mysqli_close($connection );

		// create the email

		$to = $userEmail;

		$subject = 'Reset Your Password for AIMS';

		$message = '<p>We received a password email request. The link to your password reset is below. If you did not make this request, you can ignore this email</p>';
		$message .= '<p>Here is your password email link: <br>';
		$message .= '<a href="'.$url.'"> '.$url.'</a></p>';

		$headers = "From: AIMS Admin <projects.arubi@gmail.com>\r\n";
		$headers .="Reply-To: <projects.arubi@gmail.com>\r\n";
		$headers .="Content-type: text/html\r\n";

		mail($to, $subject, $message, $headers);

		header("Location: ../reset-password.php?reset=success");
	}
	else{
		header("Location: ../index.php");
	}

?>