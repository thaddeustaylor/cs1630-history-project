<?php 
        include('inc/header.php'); 
        include('inc/creds.php');
		
        $typeone = "totpop";
		$typetwo = "cases";
		$typethree = "tmin";
		$typefour =  "tmax";
		$begindate = "1920-01-01";
		$enddate = "1930-01-01";
		$locationID1 = 91;
		$locationID2 = 3164;
		$locationID3 = 3164;
		$locationID4 = 3164;	
		
		?>
<!doctype html>
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <title>History Project</title>
  <meta name="description" content="">

  <meta name="viewport" content="width=device-width">
  <link rel="stylesheet" href="css/bootstrap.css">
  <link rel="stylesheet" href="css/style.css">
  <script src="js/boostrap.js"></script>
  <script src="js/libs/modernizr-2.5.3.min.js"></script>
  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>  
  
</head>
<body>

        <?php include('inc/menu.php'); ?>
        <div class="container">	
        	<div class="hero-unit">
        <?php
		
		/* Get results from database */
		/* Type One */
		$queryOne = "select * from ".$typeone." where location = ".$locationID1;
		//echo "$queryOne";
		$resultOne = mysql_query($queryOne) or die("Type One Query Error: ".mysql_error());
		$nameResult = mysql_query("select * from column_names where name = '".$typeone."'");
		$nameArray = mysql_fetch_array($nameResult);
		$longNameOne = $nameArray['long_name'];
		$tables[0] = "Total Population";
		
		/* Type Two */
		$queryTwo = "select * from ".$typetwo." where location = ".$locationID2;
		//echo "$queryTwo";
		$resultTwo = mysql_query($queryTwo) or die("Type Two Query Error: ".mysql_error());
		$nameResult = mysql_query("select * from column_names where name = '".$typetwo."'");
		$nameArray = mysql_fetch_array($nameResult);
		$longNameTwo = $nameArray['long_name'];
		$tables[1] = "Measles Cases";
		
		/* Type Three */
		if ($typethree != "czz")
		{
			$queryThree = "select * from ".$typethree." where location = ".$locationID3;
			//echo "$queryThree<br />";
			$resultThree = mysql_query($queryThree) or die("Type Three Query Error: ".mysql_error());
			$nameResult = mysql_query("select * from column_names where name = '".$typethree."'");
			$nameArray = mysql_fetch_array($nameResult);
			$longNameThree = $nameArray['long_name'];
			$tables[2] = $longNameThree;
		} 
		/* Type Four */
		if ($typefour != "czz")
		{
			$queryFour = "select * from ".$typefour." where location = ".$locationID4;
			//echo "$queryFour<br />";
			$resultFour = mysql_query($queryFour) or die("Type Four Query Error: ".mysql_error());
			$nameResult = mysql_query("select * from column_names where name = '".$typefour."'");
			$nameArray = mysql_fetch_array($nameResult);
			$longNameFour = $nameArray['long_name'];
			$tables[3] = $longNameFour;
		}
		$tables[4] = "Dates";
				
		/* If no data returned */
		if (mysql_num_rows($resultOne) == 0 || mysql_num_rows($resultTwo) == 0)
		{
			echo "Sorry, there was no data for that date range.";
		}
		else 
		{
			$counterOne = 0;
			$typeOneValArray;
			$typeOneBeginDateArray;
			$typeOneEndDateArray;
			$counterTwo = 0;
			$typeTwoValArray;
			$result1;
			while($One = mysql_fetch_array($resultOne))
       		{
       			//echo $One['value'];
       			//echo "Result 1: <br />";
            	$typeOneValArray[$counterOne] = $One['value'];
            	$result5[$counterOne] = $One['start_date'];
				$result1[$counterOne] = $One['value'];
				//echo "$result1[$counterOne]<br />";
            	$counterOne++;
        	}
        	//var_dump($result1);
			$result2;
			while($Two = mysql_fetch_array($resultTwo))
       		{
       			//echo $Two['value'];
       			//echo "Result 2: <br />";
            	$typeTwoValArray[$counterTwo] = $Two['value'];
				$result2[$counterTwo] = $Two['value'];
				//echo "$result2[$counterTwo]<br />";
            	$counterTwo++;
        	}
			//var_dump($result2);

			if ($typethree != "czz")
			{
				$counterThree = 0;
				$typeThreeValArray;	
				while($Three = mysql_fetch_array($resultThree))
       			{	
       				//echo $Three['value'];
            		$typeThreeValArray[$counterThree] = $Three['value'];
			 		$result3[$counterThree] = $Three['value'];
					//echo "$typeThreeValArray[$counterThree]<br />";
            		$counterThree++;
        		}
			}
			if ($typefour != "czz")
			{
				$counterFour = 0;
				$typeFourValArray;
				while($Four = mysql_fetch_array($resultFour))
       			{
       				//echo $Four['value'];
            		$typeFourValArray[$counterFour] = $Four['value'];
			 		$result4[$counterFour] = $Four['value'];
					//echo "$typeFourValArray[$counterFour]<br />";
            		$counterFour++;
        		}
			}
			
			/* Get location with coordinates */
			/*$locResult = mysql_query("select * from locations where _ID = ".$locationID1);
			$locArray = mysql_fetch_array($locResult);
			$locName = $locArray['name'];
			$locX = $locArray['X'];
			$locY = $locArray['Y'];*/
			
			/*$_SESSION['$tables'] = $tables;
			$_SESSION['$result1'] = $result1;
			$_SESSION['$result2'] = $result2;
			$_SESSION['$result3'] = $result3;
			if ($typethree != "czz")
			{
				$_SESSION['$result4'] = $result4;	
			}
			if ($typefour != "czz")
			{
				$_SESSION['$result5'] = $result5;
			}*/
			
			$tLength = sizeof($tables);
			//echo "T1Length: $tLength <br />";
        	$r1Length = sizeof($result1);
			//echo "R1Length: $r1Length <br />";
            $r2Length = sizeof($result2);
			//echo "R2Length: $r2Length <br />";
			$r2Length = sizeof($result3);
			if ($typethree != "czz")
			{
				$r4Length = sizeof($result4);
			}
			if ($typefour != "czz")
			{
            	$r5Length = sizeof($result5);
			}
			?>
			
			<table id="data" border = "1" title="Test Title">
    			<thead>
        			<tr>
                    <?php
                    	for($i = 0; $i < $tLength; $i++){
                        	//Print the headers
                            echo "<th>$tables[$i]</th>";
                        }
                     ?>
        			</tr>
    			</thead>
    			<tbody>
              	<?php
                	for($i = 0; $i < $r1Length; $i++){
                    	echo "<tr>";
                        for($k = 1; $k < $tLength+1; $k++){
                   			$magic = "result$k";
							//echo "Magic: $magic <br />";
                            $magic2 = $$magic;
                            //echo "Magic2: $magic2 <br />";
                            echo "<td>$magic2[$i]</td>";     
                            //Print the table datas
                        }
                        echo "</tr>";
                    }
                 ?>
                 </tbody>
                </table>
                 <?php
		}	?>
		
		<form action = "visual4.php">
			
			<button class="btn btn-primary" type="submit" style="width: 150px" >Visualize</button>
		</form>
		<script src="js/plugins.js"></script>
  		<script src="js/script.js"></script>
  		<?php include('inc/footer.php'); ?>
		</body>
		</html>
		

