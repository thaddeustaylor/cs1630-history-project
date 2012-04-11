<?php 

     // The column index that has what kind of location the record is:
    //values in the column:
    // County = 1
    // State = 2
    // Country = 3
    define("LEVEL_1920",     194); //this will change for each dataset
    
    
    $in_table = file("../submit/data/1920_census_DS24.csv", FILE_IGNORE_NEW_LINES);
    echo "Started 1920 census data <br/>";

    parse_data($in_table, LEVEL_1920);
   
    echo "Finished 1920 census data <br/>";
    

?>