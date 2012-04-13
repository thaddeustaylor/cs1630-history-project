<?php

$dbserver = "mysql.cs.pitt.edu";
$dbname = "cs1630History";
$dbusername = "tbl8";
$dbpassword = "datasucks()";

$userlogintable = "user_login";

if(isSet($needMYSQLI) && $needMYSQLI == true)
{
	$mysqli = mysqli_connect($dbserver, $dbusername, $dbpassword, $dbname);
	if(!$mysqli) echo "no connect";
}
else
{
	mysql_connect($dbserver, $dbusername, $dbpassword);
	mysql_select_db($dbname);
}
?>