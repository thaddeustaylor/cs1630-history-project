<?php
	session_start();
	unset($_SESSION['role']);
	unset($_SESSION['email']);
	unset($_SESSION['logged']);
	unset($logged_in);
	$logged_in = null;
	unset($role);
	header( 'Location: index.php' ) ;
?>
	