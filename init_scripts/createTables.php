<html>
<body>
<?php
        /*      This script should be used to create clean tables.
                If this script is ran after data has been inserted into the tables
                that data will be lost.
        */
    
    set_time_limit ( 0 );
    $start_time = gettimeofday(true);
    
    echo date("d M Y : hi:s.u", $start_time)  . "<br />";
    
    /* Database information */
    include_once("../submit/pword.php");
    
	/* Files with column names */
	//$files = array();
    //$files[] = "DiseaseTablesExplained.txt";
	//$files[] = "ClimateTablesExplained.txt";
	//$files[] = "CensusTablesExplained.txt";
	
	/* Connect to the database */
	mysql_connect("$server", "$username", "$password") or die(mysql_error()); 
	mysql_select_db("cs1630History") or die(mysql_error()); 

/******************************************
*    Create the column_names table
*
*   
*/		
	/* Drop table if needed */
	$result = mysql_query ("DROP TABLE IF EXISTS column_names") or die ("column_names Invalid: " . mysql_error());
	/* Create table */
	$result = mysql_query(
			"CREATE TABLE column_names (
				name char(35) primary key not null, 
				long_name char(255) not null)")
	or die ("column_names Invalid: " . mysql_error());

/******************************************
*    Create the dataset_master table
*
*   
*/	
	/* Drop table if needed */
	$result = mysql_query ("DROP TABLE IF EXISTS dataset_master") or die ("dataset_master Invalid: " . mysql_error());
	/* Create table */
	$result = mysql_query(
			"CREATE TABLE dataset_master (
				_ID int primary key not null auto_increment, 
				name char(255) not null)")
	or die ("dataset_master Invalid: " . mysql_error());
	
    
/******************************************
*    Create the location table
*
*   
*/
    
	/* Drop table if needed */
	$result = mysql_query ("DROP TABLE IF EXISTS locations") or die ("locations Invalid: " . mysql_error());
	/* Create table */
    $result = mysql_query(
			"CREATE TABLE locations (
				_ID int primary key not null auto_increment,
				name char(255) not null,
				unit int not null,
				lng double,
				lat double,
                X int,
                Y int)")
	or die ("locations Invalid: " . mysql_error());
    
    
    $line = file("location.csv", FILE_IGNORE_NEW_LINES) or die("File not found!");
    
    /* Loop through each row in file */
    foreach($line as $row)
    {
        /* Get the table name */
        $table = explode(",", addslashes(rtrim($row)));
        $query = "INSERT into locations values ('$table[0]', 
                                                '$table[1]',
                                                '$table[2]',
                                                '$table[3]',
                                                '$table[4]',
                                                '$table[5]',
                                                '$table[6]')";
                                                              
            mysql_query($query) or die ("locations Invalid insert " . mysql_error());
    }
    
/******************************************
*    Create the locations_map table
*
*   
*/
    
	/* Drop table if needed */
	$result = mysql_query ("DROP TABLE IF EXISTS locations_map") or die ("locations_map Invalid: " . mysql_error());
	/* Create table */
    $result = mysql_query(
			"CREATE TABLE locations_map (
				_ID int primary key not null auto_increment,
				child_ID int not null,
				parent_ID int not null)")
                
	or die ("locations_map Invalid: " . mysql_error());
    
    
    $line = file("location_map.csv", FILE_IGNORE_NEW_LINES) or die("File not found!");
    
    /* Loop through each row in file */
    foreach($line as $row)
    {
        /* Get the table name */
        $table = explode(",", addslashes(rtrim($row)));
        $query = "INSERT into locations_map values (NULL, 
                                                   '$table[0]',
                                                   '$table[1]')";
                                                              
        mysql_query($query) or die ("locations_map Invalid insert " . mysql_error());
    }
    
/******************************************
*    Create the locations_unit table
*
*   
*/
    
	/* Drop table if needed */
	$result = mysql_query ("DROP TABLE IF EXISTS locations_unit") or die ("locations_unit Invalid: " . mysql_error());
	/* Create table */
    $result = mysql_query(
			"CREATE TABLE locations_unit (
				_ID int primary key not null auto_increment,
				name char(255) not null)")
                
	or die ("locations_unit Invalid: " . mysql_error());
    
    
    $line = file("location_unit.csv", FILE_IGNORE_NEW_LINES) or die("File not found!");
    
    /* Loop through each row in file */
    foreach($line as $row)
    {
        /* Get the table name */
        $table = explode(",", addslashes(rtrim($row)));
        $query = "INSERT into locations_unit values ('$table[0]',
                                                   '$table[1]')";
                                                              
        mysql_query($query) or die ("locations_unit Invalid insert " . mysql_error());
    }
    
/******************************************
*    Create the data type tables
*
*   
*/
    /* Get line from file */
    $line = file("ColumnNames.txt", FILE_IGNORE_NEW_LINES) or die("File not found!");
    
    /* Loop through each row in file */
    foreach($line as $row)
    {
        /* Get the table name */
        $table = explode(";", addslashes(rtrim($row)));
        $table[0] = strtolower($table[0]);
        
        /* Drop table if needed */
        $result = mysql_query ("DROP TABLE IF EXISTS $table[0]") or die ("$table[0] Invalid: " . mysql_error()); 
        
        
        
        
        /* Create table */
        $result = mysql_query(
                "CREATE TABLE $table[0] (
                    _ID int primary key not null auto_increment, 
                    start_date date not null,
                    end_date date not null,
                    pub_date date not null,
                    frequency_unit char(30) not null,
                    frequency_quantity int not null,
                    location int not null,
                    col_ID int not null,
                    dataset_ID int not null,
                    value float not null, 
                    unit_numerator_type char(35) not null,
                    unit_numerator_value int not null,
                    unit_denominator_type char(35) not null,
                    unit_denominator_value int not null,    
                    is_real boolean not null,
                    is_obsolete boolean not null)")
        or die ("$table[0] Invalid: " . mysql_error());
        
        //echo "Created table: $table[0] <br />";
        
        /* Select column_names table*/
        $query = "SELECT * FROM column_names WHERE column_names.name = '$table[0]'";
                                                          
        $result = mysql_query($query) or die ("column_names Invalid Select " . mysql_error());
    
        $num = mysql_num_rows($result);
    
        if($num == 0)
        {
            /* Insert column name and long name into the table if doesn't exist */
            $query = "INSERT into column_names values ('$table[0]', 
                                                       '$table[1]')";
                                                              
            mysql_query($query) or die ("column_names Invalid insert " . mysql_error());
        }
    }
	
	
    

    include("init_disease_data.php");
    include("init_climate_data.php");
    include("init_1910_census.php");
    include("init_1920_census.php");
    include("init_1930_census.php");
    
    mysql_close();
    
    $end_time = gettimeofday(true);
    echo date("d M Y : hi:s.u", $end_time) . "<br />"; 
    
    $tot_time = $end_time - $start_time;
    echo $tot_time . "<br />"; 
?>
</body>
</html>