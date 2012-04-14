<?php 

  
    include_once("census_data_helpers.php");
    
    $in_table = file("../submit/data/1920_census_DS24_revised.csv", FILE_IGNORE_NEW_LINES);
    echo "<br /> Started 1920 census data <br/>";

    parse_data($in_table);
   
    echo "Finished 1920 census data <br/>";
    
    $in_table = file("../submit/data/1930a_census_DS26_revised.csv", FILE_IGNORE_NEW_LINES);
    
    echo "Started 1930 census data <br/>";

    parse_data($in_table);
    
    echo "Finished 1930 census data <br/>"; 
?>