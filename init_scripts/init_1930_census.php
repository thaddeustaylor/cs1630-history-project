<?php 
    $table[0] = file("../submit/data/1930a_census_DS26.csv", FILE_IGNORE_NEW_LINES);
    $table[1] = file("../submit/data/1930b_census_DS27.csv", FILE_IGNORE_NEW_LINES);
    $table[2] = file("../submit/data/1930c_census_DS28.csv", FILE_IGNORE_NEW_LINES);
    $table[3] = file("../submit/data/1930d_census_DS29.csv", FILE_IGNORE_NEW_LINES);
    
    $level[0] = 252;
    $level[1] = 199;
    $level[2] = 204;
    $level[3] = 157;
    
    echo "Started 1930 census data <br/>";

    for($i = 0; $i < count($table); $i++)
    {
        parse_data($table[$i], $level[$i]);
    }
    echo "Finished 1930 census data <br/>";  
?>