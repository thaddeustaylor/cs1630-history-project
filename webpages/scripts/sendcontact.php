<?php
/* This is the mail script for contacting an administrator */
	
	$name = $_POST['name'];
	$email = $_POST['email'];
	$comment = $_POST['comment'];
	
	$to = $email;
	$subject = "Contact".$name;
	$message = $comment;
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	$success = mail($to, $subject, $message, $headers);
	
	if($success) echo "true";
	else echo "false";
	

?>