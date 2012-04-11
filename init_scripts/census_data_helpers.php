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
    
// Start at the given postion($pos) and find the next state
// by looking in the second column for a zero which indicates a state
// or a country.

// param[in] $table = the census dataset
// param[in] $pos = the current position in the table

// return - the next state in the dataset as a string 
function get_next_state($table, $pos)
{
    //exit if there the pos is past the end of the table
    if ($pos > count($table) - 1)
        return null;
    
    //loop until we find a 0 in the second column, this indicates a state(or larger area)
    do{
        
        $line = explode(",", addslashes(rtrim($table[$pos])));
        $pos++;
        
    }while($line[1] != 0);

    //echo $line[2] . "<br/>";
 
    //return the state name
    return $line[2];
}    


//Goes through the data table and populates the locations database with the 
//state, county, and country info.    

// param[in] $table - the census dataset
// param[in] $level_col - the index of the column that is called level

function fill_location_table($table, $level_col)
{

    $start = 0;
    $end = 0;
    $count = 0;

    
    foreach ($table as $row)
    {
          

    	
        if($row)
        {
                
            $row = addslashes(rtrim($row));
            $line = explode(",", $row);
            
            //if the second column is 0 then this is a state
            if ($line[1] == 0)
            {  
                $end = $count;
                $state = $line[2];
                
            
                //echo "Found " . $state . " from " . $start . " to " . $end . ". Level = " . $line[194] ."<br />"; 
                
                //This detects if there is only the state and no counties
                if($start == $end && $line[$level_col] == 2)
                {
                    //look to make sure the location isn't already in the table    
                    $query = "SELECT * FROM locations WHERE locations.state = '$state'
                                                      AND locations.county IS NULL";
                        
                    $result = mysql_query($query) or die(mysql_error());
                    $num = mysql_num_rows($result);
                        
                    //echo $data[2] . " : " . $num . "<br />"; 
                    
                    //if the result of the query is zero then this is a new location
                    // so add it
                    if ($num == 0)
                    {    
                        
                        $query = "INSERT into locations values (NULL, 
                                                                'UNITED STATES',
                                                                '$state',
                                                                NULL,
                                                                NULL)";
                                                              
                        mysql_query($query) or die ("locations Invalid insert " . mysql_error());
                    }
            
                }else 
                {
                    //this goes back to the beginning of the state 
                    // and iterates until it gets back to the state
                    for($j = $start; $j != $end; $j++)
                    {
                      
                        
                        $data = explode(",", addslashes(rtrim($table[$j])));
                        
                        
                        //look for the location in the table
                        $query = "SELECT * FROM locations WHERE locations.county = '$data[2]' AND
                                                                locations.state = '$state'";
                        
                        $result = mysql_query($query) or die(mysql_error());
                        $num = mysql_num_rows($result);
                        
                        //echo $data[2] . " : " . $num . "<br />"; 
                        
                        //if the result of the query is zero then this is a new location
                        // so add it.
                        if ($num == 0)
                        {    
                            
                         
                            $query = "INSERT into locations values (NULL, 
                                                                  'UNITED STATES',
                                                                  '$state',
                                                                  '$data[2]',
                                                                  NULL)";
                                                                  
                            mysql_query($query) or die ("locations Invalid insert " . mysql_error());
                        }
                            
                    }
                }
                $start = $end + 1;
    
            }
        }
        $count++;
    }

}    

function parse_data($in_table, $level_col)
{ 
    //get column names
    $col_names = explode(",", $in_table[COLUMN_NAMES]);
    
    //get meta data
    $start_dates = explode(",", $in_table[METADATA_START_DATE]);
    $end_dates = explode(",", $in_table[METADATA_END_DATE]);
    $pub_dates = explode(",", $in_table[METADATA_PUB_DATE]);
    
    $freq_units = explode(",", $in_table[METADATA_FREQ_UNIT]);
    $freq_quantity = explode(",", $in_table[METADATA_FREQ_QTY]);
     
    $numer_type = explode(",", $in_table[METADATA_NUMER_TYPE]);
    $numer_value = explode(",", $in_table[METADATA_NUMER_VALUE]);
    $denom_type = explode(",", $in_table[METADATA_DENOM_TYPE]);
    $denom_value = explode(",", $in_table[METADATA_DENOM_VALUE]);
    
    $reals = explode(",", $in_table[METADATA_IS_REAL]);
    $obsoletes = explode(",", $in_table[METADATA_IS_OBSOLETE]);
    
    //echo count($in_table) . "<br />";
    
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
            array_push($col_names_to_ignore, $count); 
            echo $name . "<br />";
        }
   
        $count++;    
    }
    
    $count = 0;
    $start = 0;
    $end = 0;
    $state = get_next_state($table, 0);
    
    //for testing
    //$j = 4;
    
    foreach ($table as $row)
    {
        if($row)
        {
            //echo "Before exploding <br />";    
            $row = addslashes(rtrim($row));
            $line = explode(",", $row);
            
            //a zero in column 2 indicates a state has been reached.
            if ($line[1] == 0 )
            {  
                $state = strtoupper(get_next_state($table, ($count + 1)));
            } else
            {
                
                
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
                        
                        //$date = date_create_from_format("!Y", $pub_dates[$j]);
                        //$current_pub_date = date_format($date, "Y-m-d");
                       
                        //echo "after date fixing <br />";  
                        //find the location in the locations DB and return the primary key
                        $county = strtoupper($line[2]);
                        //echo $state . ", " . $city . "<br />";
                        
                        $location = getLocationID($state, $county, "", LOCATION_COUNTY); 
                        
                        if ($location == -1 || $location == null)
                            echo $state . ", " . $county . "<br />";
                            
                            
                        //echo "Location = " . $location . "<br />";
                        //echo "before query <br />";  
                         
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
        $count++;  
	}
}



?>