<?php
//Using mysqli and binding parameters, we do not need to worry about sql injection.
//Anthony Levine
	session_start();
	$needMYSQLI = true;

	include('../inc/creds.php');
	
    $email = $_POST['email'];
    $password = $_POST['pwd'];
	//$email = "acl37@pitt.edu";
	//$password = "anthony";
	$query = "SELECT password , role FROM ".$userlogintable." WHERE email LIKE ?";
	$result = $mysqli->prepare($query);
	$result->bind_param('s', $email);
	$result->execute();
	$result->bind_result($ret_pass, $role);
	$result->fetch();
	if($ret_pass != null && crypt($password, $ret_pass) == $ret_pass) 
	{
		$_SESSION['role'] = $role;
		$_SESSION['email'] = $email;
		$_SESSION['logged'] = true;
		echo "true";
	}
	else echo "false";
?>