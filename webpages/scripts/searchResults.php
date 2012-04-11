<?php
		//Anthony Levine
        session_start();
        include('../inc/creds.php');
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
				
				/* Get available location ids for data types */
                $queryOne = "SELECT location FROM ".$typeone." ORDER BY location ASC";
                $resultOne = mysql_query($queryOne) or die("Error typeone: ".mysql_error());
                $queryTwo = "SELECT location FROM ".$typetwo;
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
                        $counter++;
                }
                while($locTwo = mysql_fetch_array($resultTwo))
                {
                        $locationTwoArray[$counterTwo] = $locTwo['location'];
                        $counterTwo++;
                }
				if ($typethree)
				{
					while($locThree = mysql_fetch_array($resultThree))
                	{
                        $locationThreeArray[$counterThree] = $locThree['location'];
                        $counterThree++;
                	}
				}
				if ($typefour)
				{
					while($locFour = mysql_fetch_array($resultFour))
                	{
                        $locationFourArray[$counterFour] = $locFour['location'];
                        $counterFour++;
                	}
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
				
				$i = 0;
                while ($i < 10)
                {
                        $query = "SELECT * FROM locations WHERE _ID = ".$results[$i];
                        $locResult = mysql_query($query) or die("Location error: ".mysql_error());
                        $locArray = mysql_fetch_array($locResult);
						if($i == 0 || strcmp($locations[$i], $locations[$i-1]) != 0)
						{
							$locations[$i] = $locArray['name'];
							if($i != 9) $returnString = $returnString.$locArray['name']." - ".$locArray['_ID'].", ";
                        	else $returnString = $returnString.$locArray['name']." - ".$locArray['_ID'];
						}
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
?>