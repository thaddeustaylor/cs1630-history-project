<?php

    //12 is the first row of data after the metadata.
    define("METADATA_OFFSET",     12);

    // The column that has what kind of location the record is 
    // County = 1
    // State = 2
    // Country = 3
    //define("LEVEL",     194); //this will change for each dataset

    //indexes of the metadata
    define("COLUMN_NAMES",          0);
    define("METADATA_START_DATE",   1);
    define("METADATA_END_DATE",     2);
    define("METADATA_PUB_DATE",     3);
    define("METADATA_FREQ_UNIT",    4);
    define("METADATA_FREQ_QTY",     5);
    define("METADATA_NUMER_TYPE",   6);
    define("METADATA_NUMER_VALUE",  7);
    define("METADATA_DENOM_TYPE",   8);
    define("METADATA_DENOM_VALUE",  9);
    define("METADATA_IS_REAL",      10);
    define("METADATA_IS_OBSOLETE",  11);
   
    include_once("helper_functions.php");

function parse_data($in_table)
{ 
    //get column names
    $col_names = explode(",", rtrim($in_table[COLUMN_NAMES]));
    
    //get meta data
    $start_dates = explode(",", rtrim($in_table[METADATA_START_DATE]));
    $end_dates = explode(",", rtrim($in_table[METADATA_END_DATE]));
    $pub_dates = explode(",", rtrim($in_table[METADATA_PUB_DATE]));
    
    $freq_units = explode(",", rtrim($in_table[METADATA_FREQ_UNIT]));
    $freq_quantity = explode(",", rtrim($in_table[METADATA_FREQ_QTY]));
     
    $numer_type = explode(",", rtrim($in_table[METADATA_NUMER_TYPE]));
    $numer_value = explode(",", rtrim($in_table[METADATA_NUMER_VALUE]));
    $denom_type = explode(",", rtrim($in_table[METADATA_DENOM_TYPE]));
    $denom_value = explode(",", rtrim($in_table[METADATA_DENOM_VALUE]));
    
    $reals = explode(",", $in_table[METADATA_IS_REAL]);
    $obsoletes = explode(",", $in_table[METADATA_IS_OBSOLETE]);
    
    //echo var_dump($col_names) . "<br />";
    
    //remove the metadata from the table
    $table = array_slice($in_table, METADATA_OFFSET);
    
    //fill_location_table($table, $level_col);

    
    //init variables for loop
    $count = 0;
    $col_names_to_ignore = array();
  
    
    //Checks for column names that are in the approved list of names
    
    echo "Not included: <br />";
    foreach ($col_names as $name)
    {
            
        $query = "SELECT * FROM column_names WHERE column_names.name = '$name'";
                    
        $result = mysql_query($query) or die(mysql_error());
        $num = mysql_num_rows($result);
        
        if($num == 0)
        {
            //tracks the index of the columns to ignore
            array_push($col_names_to_ignore, $count); 
            echo $name . "<br />";
        }
   
        $count++;    
    }
    
    $count = 0;
    $start = 0;
    $end = 0;

    
    //for testing
    //$j = 4;
    
    foreach ($table as $row)
    {
        if($row)
        {
            //echo "Before exploding <br />";    
            $row = addslashes(rtrim($row));
            $line = explode(",", $row);
            
            $state = strtoupper($line[0]);
            $county = strtoupper($line[2]);
            
            $location = getLocationID($state, $county, "", LOCATION_COUNTY);     
                
            for($j = 0; $j < count($col_names); $j++)
            {
             
                if (!in_array($j, $col_names_to_ignore))        
                {
                    //The dates are formated as a year in the dataset
                    //This formats that into a Year month day with the
                    //day and month set to 1 Jan.
                    //$date = date_create_from_format("!Y", $start_dates[$j]);
                    
                    
                    $date = new DateTime();
                    $date->setDate($start_dates[$j], 01, 01);
                    $current_start_date = date_format($date, "Y-m-d");
                   
                    $date = new DateTime();
                    $date->setDate($end_dates[$j], 01, 01);
                    $current_end_date = date_format($date, "Y-m-d"); 
                     
                    $date = new DateTime();
                    $date->setDate($pub_dates[$j], 01, 01);
                    $current_pub_date = date_format($date, "Y-m-d");
                    
                    //Set the table name to lower case as per our database convention
                    $table_name = strtolower($col_names[$j]); 
                     
                    $query = "INSERT into $table_name values  (NULL, 
                                                                '$current_start_date',
                                                                '$current_end_date',
                                                                '$current_pub_date',
                                                                '$freq_units[$j]',
                                                                '$freq_quantity[$j]',
                                                                '$location',
                                                                '$j',
                                                                '1',  
                                                                '$line[$j]',
                                                                '$numer_type[$j]',
                                                                '$numer_value[$j]',
                                                                '$denom_type[$j]',
                                                                '$denom_value[$j]',
                                                                '$reals[$j]',
                                                                '$obsoletes[$j]')";
                    mysql_query($query) or die ("$col_names[$j] Invalid insert " . mysql_error()); 
                    
                } 
            }
        }
            
	}
       
}




?>