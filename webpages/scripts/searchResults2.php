<?php
		//Anthony Levine
        session_start();
        include('/afs/cs.pitt.edu/projects/vis/visweb/webtest/cs1630History/cs1630-history-project/webpages/inc/creds.php');
        include_once("/afs/cs.pitt.edu/projects/vis/visweb/webtest/cs1630History/cs1630-history-project/init_scripts/helper_functions.php");
        $function = $_GET['function'];
        
        
        
        set_time_limit ( 0 );
        
        /* Find locations */
        if($function == 1)
        {
                
        		/* Get variables sent by search.php */
                $typeone = strtolower($_GET['typeone']);
                $typetwo = strtolower($_GET['typetwo']);
				if (strcmp( "zzz", $_GET['typethree']) != 0)
				{
					$typethree = strtolower($_GET['typethree']);
				}
				if (strcmp( "zzz", $_GET['typefour']) != 0)
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
                //$results = array_intersect($locationOneArray, $locationTwoArray);
				$results = $locationOneArray + $locationTwoArray;
				
                if ($typethree)
				{
					$results = array_intersect($results, $locationThreeArray);
				}
				if ($typefour)
				{
					$results = array_intersect($results, $locationFourArray);
				}

                

				
                //var_dump($results);
                //echo "<hr />";
                
				/* Return states*/
				$returnString = "";
				for ($i = 0; $i < sizeof($results); $i++ )
				{
					if ($results[$i] == 0)
                            continue;
					$query = "SELECT * FROM locations WHERE _ID = ". $results[$i];
					$locResult = mysql_query($query) or die("Parent fetch error: ".mysql_error());
                    $locArray = mysql_fetch_array($locResult);
					
					if ($locArray['unit'] == 4)
					{
						if($i != sizeof($results) - 1) $returnString = $returnString.$locArray['name']." - ".$locArray['_ID'].", ";
                        else $returnString = $returnString.$locArray['name']." - ".$locArray['_ID'];
					}
					else if ($locArray['unit'] == 7)
					{
						$query = "select locations._ID, locations.name from locations, locations_map where locations_map.child_ID = ".$locArray['_ID']." and locations_map.parent_ID = locations._ID";
						
                        $stateResult = mysql_query($query) or die("State fetch error: ".mysql_error());
						
                        $stateArray = mysql_fetch_array($stateResult);
						
                        //var_dump($stateArray);
                        //echo "<hr />";
                        
                        if($i != sizeof($results) - 1) $returnString = $returnString.$stateArray['name']." - ".$stateArray['_ID'].", ";
                        else $returnString = $returnString.$stateArray['name']." - ".$stateArray['_ID'];
					}
					else if ($locArray['unit'] == 9)
					{
						$query = "select locations._ID, locations.name from locations, locations_map where locations_map.child_ID = ".$locArray['_ID']." and locations_map.parent_ID = locations._ID";
						
                        $countyResult = mysql_query($query) or die("County fetch error: ".mysql_error());
						
                        $countyArray = mysql_fetch_array($countyResult);
						
                        
                        //var_dump($countyArray);
                        //echo "<hr />";
                        
                        $query = "select locations._ID, locations.name from locations, locations_map where locations_map.child_ID = ".$countyArray['_ID']." and locations_map.parent_ID = locations._ID";
						
                        $stateResult = mysql_query($query) or die("State fetch error: ".mysql_error());
						
                        $stateArray = mysql_fetch_array($stateResult);
						
                        //var_dump($stateArray);
                        //echo "<hr />";
                        
                        if($i != sizeof($results) - 1) $returnString = $returnString.$stateArray['name']." - ".$stateArray['_ID'].", ";
                        else $returnString = $returnString.$stateArray['name']." - ".$stateArray['_ID'];
					}
				}
				//echo "<hr />" . $returnString . "<br />";
				echo $returnString;
				
		}elseif($function == 2)
        {
                
                /* Get variables sent by search.php */
                $typeone = strtolower($_GET['typeone']);
                $typetwo = strtolower($_GET['typetwo']);
                
				if ($_GET['typethree'] == "_zzz")
				{
					$typethree = strtolower($_GET['typethree']);
				}
				if ($_GET['typefour'] == "_zzz")
				{
					$typefour = strtolower($_GET['typefour']);
				}
                
                $state = strtoupper($_GET['state']);
                
			
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
				
                /* Get available location ids for data types */
                $query = "SELECT name FROM locations WHERE _ID = '$state'";
                $result = mysql_query($query) or die("Error $query: ".mysql_error());
                $state_name = mysql_fetch_array($result);
                
                //assume there is only one state. Haha.
                $state_name = $state_name[0];
                //echo $state_name . "<br />";
                
                $tree =  getLocationID($state_name, "", "", LOCATION_ALL);
                
                //var_dump($tree);
                
                //$merged_tree = array_merge($tree["COUNTY"], $tree["CITY"]);
                
                
                //echo "<hr />";
                //var_dump($tree["COUNTY"]);  
                
                //echo "<hr />";
                //var_dump($tree["CITY"]);  
                
                //echo "<hr />";
                //var_dump($locationOneArray);
                
                //echo "<hr />";
                //var_dump($locationTwoArray);
                
                
				/* Find intersections of two arrays */
                //$results = array_intersect($locationOneArray, $locationTwoArray);
				$results = array_merge($locationOneArray, $locationTwoArray);
				
                if ($typethree)
				{
					$results = array_merge($results, $locationThreeArray);
				}
				if ($typefour)
				{
					$results = array_merge($results, $locationFourArray);
				}
				
                //echo "<hr />";
                //var_dump($results);
                
                
                $intersected_county = array_unique(array_intersect($results, $tree["COUNTY"]));
                
                $intersected_city = array_unique(array_intersect($results, $tree["CITY"]));

                
                //get the city tree
                $query = "SELECT name FROM locations WHERE _ID = " . $tree["CITY"][0];
                
                $result = mysql_query($query) or die("Error $query: ".mysql_error());
                $city_name = mysql_fetch_array($result);
                
                //assume there is only one city. Haha.
                $city_name = $city_name[0];
                //echo $city_name . "<br />";
                
                $city_tree =  getLocationID($state_name, "", $city_name, LOCATION_ALL);
                
                //echo "<hr />";
                //var_dump($city_tree);
                
                $intersected_county = array_unique(array_intersect($intersected_county, $city_tree["COUNTY"]));
                
                
                
                
                //echo "<h1>County</h1><hr />";
                //var_dump($intersected_county);
                //echo "<h1>City</h1><hr />";
                //var_dump($intersected_city);
                
                
                $returnString = "";
                
                if(count($intersected_county) == 0)
                    $returnString .= "FALSE";
                else
                {
                    foreach($intersected_county as $location)
                    {
                        $query = "SELECT name FROM locations WHERE _ID = '$location'";
                        $result = mysql_query($query) or die("Error $query: ".mysql_error());
                        
                        $name = mysql_fetch_array($result);
                    
                        $name = $name[0];
                        
                        $returnString .= $name . " - " . $location . ", ";
                    }
                }

                
                $returnString .= " / ";
                
                if(count($intersected_city) == 0)
                    $returnString .= "FALSE";
                else
                {
                    foreach($intersected_city as $location)
                    {
                        $query = "SELECT name FROM locations WHERE _ID = '$location'";
                        $result = mysql_query($query) or die("Error $query: ".mysql_error());
                        
                        $name = mysql_fetch_array($result);
                    
                        $name = $name[0];
                        
                        $returnString .= $name . " - " . $location . ", ";
                    }
                }
                        
                //if($i != sizeof($results) - 1) $returnString = $returnString.$stateArray['name']." - ".$stateArray['_ID'].", ";
                //else $returnString = $returnString.$stateArray['name']." - ".$stateArray['_ID'];
				
				//echo "<hr />" . $returnString . "<br />";
                //echo "<h1>Return</h1><hr />";
				echo $returnString;
        }