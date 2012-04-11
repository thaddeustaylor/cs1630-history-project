<?php
	session_start();
	// If page requires SSL, and we're not in SSL mode, 
	// redirect to the SSL version of the page
	/*if($requireSSL && $_SERVER['SERVER_PORT'] != 443) {
	   header("HTTP/1.1 301 Moved Permanently");
	   header("Location: https://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
	   exit();
	}*/
	if(isSet($_SESSION['role']))
	{
		$role = $_SESSION['role'];
	}
	else
	{
		$role = 0;
	}

	if(isSet($_SESSION['logged']))
	{
		$logged_in = $_SESSION['logged'];
	}
	else
	{
		$logged_in = false;
	}
?>