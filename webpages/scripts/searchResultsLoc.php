<?php
		//Anthony Levine
        session_start();
        include('/afs/cs.pitt.edu/projects/vis/visweb/webtest/cs1630History/cs1630-history-project/webpages/inc/creds.php');
        $function = $_GET['function'];

	//set_time_limit ( 0 );
        
        /* Find locations */
        if($function == 1)
        {
        		/* Get variables sent by search.php */
                $typeone = strtolower($_GET['typeone']);
                $typetwo = strtolower($_GET['typetwo']);
				if ($_GET['typethree'])
				{
					$typethree = strtolower($_GET['typethree']);
				}
				if ($_GET['typefour'])
				{
					$typefour = strtolower($_GET['typefour']);
				}
				//echo "$typeone<br />";
				//echo "$typetwo<br />";
				
				/* Get available location ids for data types */
                $queryOne = "SELECT location FROM ".$typeone;
				//echo "$queryOne<br />";
                $resultOne = mysql_query($queryOne) or die("Error typeone: ".mysql_error());
                $queryTwo = "SELECT location FROM ".$typetwo;
				//echo "$queryTwo<br />";
                $resultTwo = mysql_query($queryTwo) or die("Error typetwo: ".mysql_error());
				if ($typethree)
				{
					$queryThree = "SELECT location FROM ".$typethree;
                	$resultThree = mysql_query($queryThree) or die("Error typethree: ".mysql_error());
				}
                if ($typefour)
				{
					$queryFour = "SELECT location FROM ".$typefour;
                	$resultFour = mysql_query($queryFour) or die("Error typefour: ".mysql_error());
				}
				
                ini_set('memory_limit', '-1');
                $counter = 0;
                $locationOneArray;
                $counterTwo = 0;
                $locationTwoArray;
				if ($typethree)
				{
					$counterThree = 0;
                	$locationThreeArray;
				}
				if ($typefour)
				{
					$counterFour = 0;
                	$locationFourArray;
				}
				
				/* Store all returned locations in arrays */
                while($locOne = mysql_fetch_array($resultOne))
                {
                        $locationOneArray[$counter] = $locOne['location'];
						//echo "$locationOneArray[$counter]<br />";
                        $counter++;
                }
				$locationOneArray = array_flip(array_flip(array_reverse($locationOneArray,true)));
                while($locTwo = mysql_fetch_array($resultTwo))
                {
                        $locationTwoArray[$counterTwo] = $locTwo['location'];
                        $counterTwo++;
                }
				$locationTwoArray = array_flip(array_flip(array_reverse($locationTwoArray,true)));
				if ($typethree)
				{
					while($locThree = mysql_fetch_array($resultThree))
                	{
                        $locationThreeArray[$counterThree] = $locThree['location'];
                        $counterThree++;
                	}
					$locationThreeArray = array_flip(array_flip(array_reverse($locationThreeArray,true)));
				}
				if ($typefour)
				{
					while($locFour = mysql_fetch_array($resultFour))
                	{
                        $locationFourArray[$counterFour] = $locFour['location'];
                        $counterFour++;
                	}
					$locationFourArray = array_flip(array_flip(array_reverse($locationFourArray,true)));
				}
				
                /* Find intersections of two arrays */
                $results = array_intersect($locationOneArray, $locationTwoArray);
				if ($typethree)
				{
					$results = array_intersect($results, $locationThreeArray);
				}
				if ($typefour)
				{
					$results = array_intersect($results, $locationFourArray);
				}
                
				/* Put all intersecting locations in one string and send to search.php */
                $returnString = "";
                for ($i = 0; $i < sizeof($results); $i++ )
                {
                        if ($results[$i] == 0)
                            continue;
                        $query = "SELECT * FROM locations WHERE _ID = ". $results[$i];
						//echo "$query<br />";
                        $locResult = mysql_query($query) or die("Location error: ".mysql_error());
                        $locArray = mysql_fetch_array($locResult);
						
						if($i != sizeof($results) - 1) $returnString = $returnString.$locArray['name']." - ".$locArray['_ID'].", ";
                        else $returnString = $returnString.$locArray['name']." - ".$locArray['_ID'];			
                }    
                echo $returnString;   
				
        }
		/* Find dates */
        else if($function == 2)
        {
        		/* Get variables sent by search.php */
        		$typeone = strtolower($_GET['typeone']);
                $typetwo = strtolower($_GET['typetwo']);
				if ($_GET['typethree'])
				{
					$typethree = strtolower($_GET['typethree']);
				}
				if ($_GET['typefour'])
				{
					$typefour = strtolower($_GET['typefour']);
				}
				$locationID = $_GET['location'];
	
				/* Get all dates for data types */
                $queryLocOne = "SELECT start_date, end_date FROM ".$typeone." WHERE location = ".$locationID;
				$dateResultOne = mysql_query($queryLocOne) or die("LocOne query error: ".mysql_error());
                $queryLocTwo = "SELECT start_date, end_date FROM ".$typetwo." WHERE location = ".$locationID;
                $dateResultTwo = mysql_query($queryLocTwo) or die("LocTwo query error: ".mysql_error());
				if ($typethree)
				{
					$queryLocThree = "SELECT start_date, end_date FROM ".$typethree." WHERE location = ".$locationID;
					$dateResultThree = mysql_query($queryLocThree) or die("LocThree query error: ".mysql_error());
				}
				if ($typefour)
				{
					$queryLocFour = "SELECT start_date, end_date FROM ".$typefour." WHERE location = ".$locationID;
					$dateResultFour = mysql_query($queryLocFour) or die("LocFour query error: ".mysql_error());
				}
				
                $dateCountOne = 0;
				/* Store all returned dates in arrays */
                while($dateOne = mysql_fetch_array($dateResultOne))
                {
                        $dateArrayOne[$dateCountOne] = $dateOne['start_date']." - ".$dateOne['end_date'];
                        $dateCountOne++;
                }
                $dateArrayOne = array_unique($dateArrayOne);
                $dateCountTwo = 0;
                while($dateTwo = mysql_fetch_array($dateResultTwo))
                {
                        $dateArrayTwo[$dateCountTwo] = $dateTwo['start_date']." - ".$dateTwo['end_date'];
                        $dateCountTwo++;
                }
				/* Eliminate duplicates */
                $dateArrayTwo = array_unique($dateArrayTwo);
				if ($typethree)
				{
					$dateCountThree = 0;
                	while($dateThree = mysql_fetch_array($dateResultThree))
                	{
                		$dateArrayThree[$dateCountThree] = $dateThree['start_date']." - ".$dateThree['end_date'];
                        $dateCountThree++;
                	}
                	$dateArrayThree = array_unique($dateArrayThree);
				}
				if ($typefour)
				{
					$dateCountFour = 0;
               		while($dateFour = mysql_fetch_array($dateResultFour))
                	{
                        	$dateArrayFour[$dateCountFour] = $dateFour['start_date']." - ".$dateFour['end_date'];
                        	$dateCountFour++;
                	}
                	$dateArrayFour = array_unique($dateArrayFour);
				}
					
				
				/* Find intersection of two arrays */
                $results = array_intersect($dateArrayOne, $dateArrayTwo);
				if ($typethree)
				{
					$results = array_intersect($results, $dateArrayThree);
				}
				if ($typefour)
				{
					$results = array_intersect($results, $dateArrayFour);
				}
				
				/* Return all intersecting dates as one string to search.php */
                if($results == null) echo "false";
                else
                {
                        $dateResult = "";
                        $arraycount = count($results);
                        for($i = 0; $i < $arraycount; $i++)
                        {
                            if($i == $arraycount-1) $dateResult = $dateResult.$results[$i];
                            else $dateResult = $dateResult.$results[$i].", ";
                        }
                        echo $dateResult;
                }
        }
        else if($function == 3)
        {
            	/* Get variables sent by search.php */
                $typeone = strtolower($_GET['typeone']);
                $typetwo = strtolower($_GET['typetwo']);
				if ($_GET['typethree'])
				{
					$typethree = strtolower($_GET['typethree']);
				}
				if ($_GET['typefour'])
				{
					$typefour = strtolower($_GET['typefour']);
				}
				//echo "$typeone<br />";
				//echo "$typetwo<br />";
				
				/* Get available location ids for data types */
                $queryOne = "SELECT location, unit FROM $typeone, locations WHERE '$typeone'.location = location._ID";
                
				//echo "$queryOne<br />";
                $resultOne = mysql_query($queryOne) or die("Error typeone: ".mysql_error());
                $queryTwo = "SELECT location FROM ".$typetwo;
				//echo "$queryTwo<br />";
                $resultTwo = mysql_query($queryTwo) or die("Error typetwo: ".mysql_error());
				if ($typethree)
				{
					$queryThree = "SELECT location FROM ".$typethree;
                	$resultThree = mysql_query($queryThree) or die("Error typethree: ".mysql_error());
				}
                if ($typefour)
				{
					$queryFour = "SELECT location FROM ".$typefour;
                	$resultFour = mysql_query($queryFour) or die("Error typefour: ".mysql_error());
				}
				
                ini_set('memory_limit', '-1');
                $counter = 0;
                $locationOneArray;
                $counterTwo = 0;
                $locationTwoArray;
				if ($typethree)
				{
					$counterThree = 0;
                	$locationThreeArray;
				}
				if ($typefour)
				{
					$counterFour = 0;
                	$locationFourArray;
				}
				
				/* Store all returned locations in arrays */
                while($locOne = mysql_fetch_array($resultOne))
                {
                        $locationOneArray[$counter]['location'] = $locOne['location'];
						//echo "$locationOneArray[$counter]<br />";
                        $counter++;
                }
				$locationOneArray = array_unique($locationOneArray);
                while($locTwo = mysql_fetch_array($resultTwo))
                {
                        $locationTwoArray[$counterTwo]['location'] = $locTwo['location'];
                        $counterTwo++;
                }
				$locationTwoArray = array_unique($locationTwoArray);
				if ($typethree)
				{
					while($locThree = mysql_fetch_array($resultThree))
                	{
                        $locationThreeArray[$counterThree]['location'] = $locThree['location'];
                        $counterThree++;
                	}
					$locationThreeArray = array_unique($locationThreeArray);
				}
				if ($typefour)
				{
					while($locFour = mysql_fetch_array($resultFour))
                	{
                        $locationFourArray[$counterFour]['location'] = $locFour['location'];
                        $counterFour++;
                	}
					$locationFourArray = array_unique($locationFourArray);
				}
				
                /* Find intersections of two - four arrays */
                $results = array_intersect($locationOneArray, $locationTwoArray);
				if ($typethree)
				{
					$results = array_intersect($results, $locationThreeArray);
				}
				if ($typefour)
				{
					$results = array_intersect($results, $locationFourArray);
				}
                
				
                //$results is an array of all all the locations in the data tables these could
                //be county or city
                //print_r($locations);
                
                
                //print_r($results);
                $counter = 0;
                     
                for($i = 0; $i < count($results); $i++)
                {
                    //echo $results[$i]['location'] . "<br />";
                    
                    if ($results[$i]['location'] == 0)
                        continue;
                    $query = "SELECT unit FROM locations WHERE _ID = '" . $results[$i]['location']. "'";
                    
                    $ret = mysql_query($query) or die("$query error: ".mysql_error());
                    //echo $query . "<br />";
                    //$counter = 0;
                     
                    //while(
                    $units = mysql_fetch_array($ret);
                    //{
                        $results[$counter]['unit'] =  $units['unit'];
                        $counter++;
                        // $units['unit'] . "<br />";
                    //}
                }
                
                //for($i = 0; $i < count($results); $i++)
                //{
                    //$counties
                //}
                
                //results now has a multi dimensional array
                //print_r($results);
                
                for($i = 0; $i < count($results); $i++)
                {
                    if ($results[$i]['location'] == 0)
                        continue;
                    $query = "SELECT parent_ID FROM locations_map WHERE child_ID = '" . $results[$i]['location']. "'";
                    
                    $ret = mysql_query($query) or die("$query error: ".mysql_error());
                    //echo $query . "<br />";
                    //$counter = 0;
                     
                    while($ID = mysql_fetch_array($ret))
                    {
                        $states[] = $ID['parent_ID'];
                    }
                }
                
                $states = array_unique($states);
                
                print_r($states);
                
                
                
                
        }else if($function == 4)
        {
            /* Get variables sent by search.php */
            $typeone = strtolower($_GET['typeone']);
            $typetwo = strtolower($_GET['typetwo']);
            if ($_GET['typethree'])
            {
                $typethree = strtolower($_GET['typethree']);
            }
            if ($_GET['typefour'])
            {
                $typefour = strtolower($_GET['typefour']);
            }
        
            $start_time = gettimeofday(true);
    
            print_r(get_states_from_table($typeone));
        
            end_time($start_time);
            
            $start_time = gettimeofday(true);
    
            print_r(get_states_from_table($typetwo));
        
            end_time($start_time);
        }
        
        function get_states_from_table($table_name)
        {
            /* Get available location ids for data types */
            $query = "SELECT DISTINCT location FROM $table_name";
            
            $ret = mysql_query($query) or die("$query error: ".mysql_error());
            
            $i = 0;
            
            while($row = mysql_fetch_array($ret))
            {
                //If the location is zero there was an error so skip it
                if($row['location'] == 0)
                    continue;
                    
                    
                $locations[$i]['location'] = $row['location'];
                $i++;  
            }
            
            //return $locations;
                
            for($i = 0; $i < count($locations); $i++)
            {
                //echo $results[$i]['location'] . "<br />";
                
                //if ($locations[$i]['location'] == 0)
                //    continue;
                $query = "SELECT unit FROM locations WHERE _ID = '" . $locations[$i]['location']. "'";
                
                $ret = mysql_query($query) or die("$query error: ".mysql_error());
               
                $units = mysql_fetch_array($ret);
                
                $locations[$i]['unit'] =  $units['unit'];
                //$counter++;
            }
            
            //return $locations;
           
            for($i = 0; $i < count($locations); $i++)
            {
                //4 is a state location
                if($locations[$i]['unit'] == 4)
                    continue;
                    
                $query = "SELECT parent_ID FROM locations_map WHERE child_ID = '" . $locations[$i]['location']. "'";
                    
                $ret = mysql_query($query) or die("$query error: ".mysql_error());
                //echo $query . "<br />";
                //$counter = 0;
                 
                while($row = mysql_fetch_array($ret))
                {
                    $states[] = $row['parent_ID'];
                }
            }
            
            return array_unique($states);
        
        }
        
        function end_time($start_time)
        {
            $end_time = gettimeofday(true);
            //echo date("d M Y : hi:s.u", $end_time) . "<br />"; 
            
            $tot_time = $end_time - $start_time;
            echo "<br />" . $tot_time . " seconds <br />";        
        }
        
?>