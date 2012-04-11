<?php
    session_start();
	/*$needMYSQLI = true;
	include('inc/creds.php');
    //$email = $_POST['email'];
    //$password = $_POST['pwd'];
	$email = "acl37@pitt.edu";
	/*	$stmt = $mysqli->prepare("SELECT role FROM user_login WHERE email = ?");
		$stmt->bind_param('s', $email);
		$stmt->execute();
		$stmt->bind_result($question);
	echo $question."ss";*/
	
	/*$mysqli = mysqli_connect($dbserver, $dbusername, $dbpassword, $dbname);
	$query = "SELECT question FROM user_login WHERE email LIKE ?";
	$result = $mysqli->prepare($query);
	$result->bind_param('s', $email);
	$result->execute();
	$result->bind_result($question);
	$result->fetch();*/
	
	echo $_SESSION['email'];
	
	
?>

