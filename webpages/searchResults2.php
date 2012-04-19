<?php
		//Anthony Levine
        session_start();
        include('/afs/cs.pitt.edu/projects/vis/visweb/webtest/cs1630History/cs1630-history-project/webpages/inc/creds.php');
        $function = $_GET['function'];

	set_time_limit ( 0 );
        
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
						if($i != sizeof($results) - 1) $returnString = $returnString.$stateArray['name']." - ".$stateArray['_ID'].", ";
                        else $returnString = $returnString.$stateArray['name']." - ".$stateArray['_ID'];
					}
					else if ($locArray['unit'] == 9)
					{
						$query = "select locations._ID, locations.name from locations, locations_map where locations_map.child_ID = ".$locArray['_ID']." and locations_map.parent_ID = locations._ID";
						$countyResult = mysql_query($query) or die("County fetch error: ".mysql_error());
						$countyArray = mysql_fetch_array($countyResult);
						$query = "select locations._ID, locations.name from locations, locations_map where locations_map.child_ID = ".$countyArray['_ID']." and locations_map.parent_ID = locations._ID";
						$stateResult = mysql_query($query) or die("State fetch error: ".mysql_error());
						$stateArray = mysql_fetch_array($stateResult);
						if($i != sizeof($results) - 1) $returnString = $returnString.$stateArray['name']." - ".$stateArray['_ID'].", ";
                        else $returnString = $returnString.$stateArray['name']." - ".$stateArray['_ID'];
					}
				}
				echo $returnString;
				
		}