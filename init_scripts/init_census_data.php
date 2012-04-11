<html>
 <head>
  <title>Script to Initialize Database</title>
 </head>
 <body>
 <h1>Welcome to the init</h1>
 
 <?php
    set_time_limit ( 0 );
    $start_time = gettimeofday(true);
    
    echo date("d M Y : hi:s.u", $start_time)  . "<br />";
    
    $server = "mysql.cs.pitt.edu";
    $username = "tbl8";
    $password = "datasucks()";
    
    
    $db = mysql_connect($server, $username, $password);

    if ($db):
        mysql_select_db('cs1630History');
    else:
        die ("Could not connect to db " . mysql_error());
    endif;

    //mysql_query("drop table IF EXISTS LOCATIONS");
    //mysql_query("drop table IF EXISTS COLUMN_NAMES");
    


 /*      

    $result = mysql_query(
        "create table IF NOT EXISTS LOCATIONS (
            _ID int primary key not null auto_increment, 
            country char(50),
            state char(50),
            county char(50),
            city char(50))") 
        or die ("LOCATIONS Invalid: " . mysql_error());
      
    $result = mysql_query(
        "create table IF NOT EXISTS COLUMN_NAMES (
            name char(30) primary key not null, 
            long_name varchar(255) not null)") 
        or die ("COLUMN_NAMES Invalid: " . mysql_error());
         
  
    $table = file("CensusTablesExplained.txt", FILE_IGNORE_NEW_LINES);
  
 
    foreach($table as $row)
    {
        $line = explode(",", addslashes(rtrim($row)));
        
        $query = "SELECT * FROM COLUMN_NAMES WHERE COLUMN_NAMES.name = '$line[0]'";
                                                              
        $result = mysql_query($query) or die ("COLUMN_NAMES Invalid Select " . mysql_error());
        
        $num = mysql_num_rows($result);
        
        if($num == 0)
        {
            $query = "INSERT into COLUMN_NAMES values ('$line[0]', 
                                                       '$line[1]')";
                                                              
            mysql_query($query) or die ("COLUMN_NAMES Invalid insert " . mysql_error());
        }
        
        $result = mysql_query(
                "create table IF NOT EXISTS $line[0] (
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
                or die ("$line[0] create Invalid: " . mysql_error());
    }
    */

    include "census_data_helpers.php";
    include "init_1910_census.php";
    include "init_1920_census.php";
    include "init_1930_census.php";
   
   
   
   
    $end_time = gettimeofday(true);
    
    echo date("d M Y : hi:s.u", $end_time) . "<br />"; 
    
    $tot_time = $end_time - $start_time;
    echo $tot_time . "<br />"; 
    
    mysql_close($db);
?>	

 </body>
</html>
