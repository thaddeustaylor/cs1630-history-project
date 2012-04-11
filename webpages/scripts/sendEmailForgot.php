<?php
	//$function = $_POST['function'];
	//$email = $_POST['email'];
	
	$function = "reset";
	$email = "acl37@pitt.edu";
	
	
	$needMYSQLI = true;
	include('../inc/creds.php');
	
	if($function == "email")
	{
		$stmt = $mysqli->prepare("SELECT * FROM ".$userlogintable." WHERE email = ?");
		$stmt->bind_param('s', $email);
		$stmt->execute();
		$stmt->store_result();
		$num_of_rows = $stmt->num_rows;
		if($num_of_rows > 0)
		{
			$to = $email;
			$subject = "Password Reset";
			$message = "You have chosen to reset your password. Please follow this link for further instructions: http://www.historyproject.org/resetpassword?email=".$email;
			$headers  = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			mail($to, $subject, $message, $headers);
			echo "true";
		}
		else
		{
			echo "false";
		}
	}
	else if ($function == "reset")
	{
		//$oldpassword = $_POST['password'];
		/*$oldpassword = "levine";
		
		$password = crypt($oldpassword);
		$stmt = $mysqli->prepare("UPDATE ".$userlogintable." SET password = ? WHERE email IS ?");
		$stmt->bind_param('ss', $password, $email);
		$stmt->execute(); 
		
		echo "valid";*/
	}
	else
	{ 
		echo "false";
	}
?>
