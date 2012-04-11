<?php 

    // The column index that has what kind of location the record is:
    //values in the column:
    // County = 1
    // State = 2
    // Country = 3
    define("LEVEL_1910",     194); //this will change for each dataset
    
    include_once("census_data_helpers.php");
    
    $in_table = file("../submit/data/1910_census_DS22.csv", FILE_IGNORE_NEW_LINES);
    echo "Started 1910 census data <br/>";

    parse_data($in_table, LEVEL_1910);
   
    echo "Finished 1910 census data <br/>";
    

?>