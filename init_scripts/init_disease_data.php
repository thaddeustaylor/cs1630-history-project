<?php
	/*
		This is the script to upload the data from the measles datasets
		into the tables in the database.
		
		The following datasets are used
		-Baltimore_MD_measweek.csv
		-Boston_MA_measweek.csv
		-Charleston_SC_measweek.csv
		-NewYork_NY_measweek.csv
		
		This will not clean the tables before hand, a seperate script will do that
	*/
	set_time_limit ( 0 );
	echo "Starting Disease Data Input...<br>";
	
	
   /* Database information */
    include_once("../submit/pword.php");
	include_once("helper_functions.php");
    
    
	//Connect to the database
	mysql_connect("$server", "$username", "$password") or die(mysql_error());
	mysql_select_db("cs1630History") or die(mysql_error());
	
	//Create an array for the filenames
	$filenames = array("Boston_MA_measweek_condensed.csv");                   
	
    foreach($filenames as $filename) {
        
        //echo "$filename <br/>";
        init_disease_csv($filename);
    }
    
    
    function init_disease_csv($filename)
    {
        
        $tuples = file("../submit/data/" . $filename, FILE_IGNORE_NEW_LINES) or die("$filename not found");
        //Remove the line with the column headers
        unset($tuples[0]);
        
        //Create an array of the column names
        $columns = array( "cases", "prcp", "tmin", "tmax");
        
        //Create an array for the data types
        $datatypes = array("PEOPLE", "INCHES", "F", "F");
	
        $pubdate = "01/01/1952";
	
    
        //Get the location
        $location = explode("_", addslashes(rtrim($filename)));
        
        $datasetname = explode(".", $filename);
        $datasetNum = getDatasetID($datasetname[0]);
    
        $city = strtoupper($location[0]);
        $state = strtoupper(getStateNameByAbbreviation($location[1]));
        
        $location = getLocationID($state, "", $city, LOCATION_CITY);
        //echo "<br />" . "Location: " . $location . "<br />";

        //Process the entries
        foreach($tuples as $line) {
  
            //Divide up the entry
            $entry = explode(",", addslashes(rtrim($line)));

            
            $startDate = parse_date($entry[1]);
            
            $endDate = parse_date($entry[2]);
            
            
            //Make insert queries for each data column
            for($i = 0; $i < count($columns); $i++)
            {
                $j = $i + 6;
                $query = "INSERT INTO $columns[$i] VALUES (NULL, 
                                                    '$startDate',
                                                    '$endDate',
                                                    '$pubDate',
                                                    'WEEK',
                                                    '1',
                                                    '$location',
                                                    '0',
                                                    '$datasetNum',
                                                    '$entry[$j]',
                                                    '$datatypes[$i]',
                                                    '1',
                                                    'NONE',
                                                    '1',
                                                    '1',
                                                    '0')";
                                                    
                //echo $query . "<br />";
            
                mysql_query($query) or die("$query Insert Invalid " . mysql_error());
            } 
        }
    
    
        echo "Disease Data Inputted";
    
    }
    
    
    
    function parse_date($in_date)
    {
    
        $date = explode("/", addslashes(rtrim($in_date)));
            
        $new_date = new DateTime();
            
        $new_date->setDate($date[2],$date[0] ,$date[1]);
        
        return $new_date->format("Y-m-d");
    }
    
    
    
    
    
	//Function will take a numbered day (out of 365) and a year and convert them into a Month-Day-Year date
	//(I'm seriously bad at naming functions)
	//Does not currently handle leap years (which would be pretty easy, but kinda unneeded)
	function dayYear_To_YearMonthDay($d, $y) {
		$month = '';
		$day = $d;
		if ($day < 32) {
			$month = '1';
		}
		elseif ($day < 60) {
			$month = '2';
			$day = $day - 31;
		}
		elseif ($day < 91) {
			$month = '3';
			$day = $day - 59;
		}
		elseif ($day < 121) {
			$month = '4';
			$day = $day - 90;
		}
		elseif ($day < 152) {
			$month = '5'; 
			$day = $day - 120;
		}
		elseif ($day < 182) {
			$month = '6';
			$day = $day - 151;
		}
		elseif ($day < 213) {
			$month = '7';
			$day = $day - 181;
		}
		elseif ($day < 244) {
			$month = '8';
			$day = $day - 212;
		}
		elseif ($day < 274) {
			$month = '9';
			$day = $day - 243;
		}
		elseif ($day < 305) {
			$month = '10';
			$day = $day - 273;
		}
		elseif ($day < 335) {
			$month = '11';
			$day = $day - 304;
		}
		else {
			$month = '12';
			$day = $day - 334;
		}
		//$date = date_create_from_format("M j Y", "$month $day $y");
        $date = new DateTime();
        $date->setDate($y, $month, $day); 
        
		return date_format($date, "Y-m-d");
	}
?>
</body>
</html>