<html>
<head>
	<title>Disease Data Locations Input Script</title>
</head>
<body>
<?php
	/*
		This script manually inputs hardcoded data for the
		measles datasets into the location table
		use this before running the init_Disease_Data script
	*/
	
	echo "Inputting the disease locations into the database...<br>";
	
	/* Database information */
    include_once("../submit/pword.php");
	
	//Connect to the database
	mysql_connect("$server", "$username", "$password") or die(mysql_error());
	mysql_select_db("cs1630History") or die(mysql_error());
	
	//Create arrays with the data
	$states = array("MARYLAND", "MASSACHUSETTS", "SOUTH CAROLINA", "NEW YORK");
	//I'm leaving counties as NULL for now, until we can decide how to work them out
	//as Baltimore is in no county, and New York City is in 5 counties
	$cities = array("BALTIMORE", "BOSTON", "CHARLESTON", "NEW YORK");
	
	for ($i = 0; $i < 4; $i++) {
		//Check if the city is already in the locations table
		$query = "SELECT * FROM locations WHERE locations.city = '$cities[$i]'";
		$result = mysql_query($query) or die(mysql_error());
		//If it was not, make the insert
		if (mysql_num_rows($result) == 0) {
			$query = "INSERT into locations values (NULL,
													'UNITED STATES',
													'$states[$i]',
													NULL,
													'$cities[$i]')";
			mysql_query($query) or die ("Cannot insert $cities[$i]: " . mysql_error());
		}
		else {
			echo "$cities[$i] was already in the locations table.";
		}
	}
	
	echo "Finished";
?>
</body>
</html>