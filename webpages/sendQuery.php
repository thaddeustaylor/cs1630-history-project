<?php 
		include('inc/header.php'); 
        include('inc/creds.php');

        $typeone = $_GET['typeone'];
		$typetwo = $_GET['typetwo'];
		$typethree = $_GET['typethree'];
		$typefour = $_GET['typefour'];
		$locationID = $_GET['location'];
		$begindate = $_GET['beginDate'];
		$enddate = $_GET['endDate'];
		
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
  	<script type="text/javascript" src="js/mootools-1.2.4-core.js"></script>
	<script type="text/javascript" src="js/mootools-1.2.4.4-more.js"></script> 
	<script type="text/javascript" src="js/MilkChart.js"></script> 
</head>
<body> 
<?php  include('inc/menu.php'); ?>
	<div class="container">

      <!-- Main hero unit for a primary marketing message or call to action -->
      <div class="hero-unit">
        <h1>Query Results</h1>
		<br />	
		
		<?php
		/* Get results from database */
		/* Type One */
		$queryOne = "select * from ".$typeone." where (start_date between '".$begindate."' and '".$enddate."' and end_date between '".$startdate."' and '".$enddate."') and location = ".$locationID;
		$resultOne = mysql_query($queryOne) or die("Type One Query Error: ".mysql_error());
		$nameResult = mysql_query("select * from column_names where name = '".$typeone."'");
		$nameArray = mysql_fetch_array($nameResult);
		$longNameOne = $nameArray['long_name'];
		
		/* Type Two */
		$queryTwo = "select * from ".$typetwo." where (start_date between '".$begindate."' and '".$enddate."' and end_date between '".$startdate."' and '".$enddate."') and location = ".$locationID;
		$resultTwo = mysql_query($queryTwo) or die("Type Two Query Error: ".mysql_error());
		$nameResult = mysql_query("select * from column_names where name = '".$typetwo."'");
		$nameArray = mysql_fetch_array($nameResult);
		$longNameTwo = $nameArray['long_name'];
		
		/* Type Three */
		/*if ($typethree)
		{
			$queryThree = "select * from ".$typethree." where (start_date between '".$begindate."' and '".$enddate."' and end_date between '".$startdate."' and '".$enddate."') and location = ".$locationID;
			//echo "$queryThree<br />";
			$resultThree = mysql_query($queryThree) or die("Type Three Query Error: ".mysql_error());
			$nameResult = mysql_query("select * from column_names where name = '".$typethree."'");
			$nameArray = mysql_fetch_array($nameResult);
			$longNameThree = $nameArray['long_name'];
		
		} */
		/* Type Four */
		/*if ($typefour)
		{
			$queryFour = "select * from ".$typefour." where (start_date between '".$begindate."' and '".$enddate."' and end_date between '".$startdate."' and '".$enddate."') and location = ".$locationID;
			//echo "$queryFour<br />";
			$resultFour = mysql_query($queryFour) or die("Type Four Query Error: ".mysql_error());
			$nameResult = mysql_query("select * from column_names where name = '".$typefour."'");
			$nameArray = mysql_fetch_array($nameResult);
			$longNameFour = $nameArray['long_name'];
		
		}*/
		
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
			while($One = mysql_fetch_array($resultOne))
       		{
       			//echo $One['value'];
            	$typeOneValArray[$counterOne] = $One['value'];
            	$typeOneBeginDateArray[$counterOne] = $One['start_date'];
				$typeOneEndDateArray[$counterOne] = $One['end_date'];
				//echo "$typeOneArray[$counterOne]<br />";
            	$counterOne++;
        	}
			while($Two = mysql_fetch_array($resultTwo))
       		{
       			//echo $Two['value'];
            	$typeTwoValArray[$counterTwo] = $Two['value'];
				//echo "$typeTwoArray[$counterTwo]<br />";
            	$counterTwo++;
        	}

			/*if ($typethree)
			{
				$counterThree = 0;
				$typeThreeValArray;	
				while($Three = mysql_fetch_array($resultThree))
       			{	
       				//echo $Three['value'];
            		$typeThreeValArray[$counterThree] = $Three['value'];
					//echo "$typeThreeValArray[$counterThree]<br />";
            		$counterThree++;
        		}
			}
			if ($typefour)
			{
				$counterFour = 0;
				$typeFourValArray;
				while($Four = mysql_fetch_array($resultFour))
       			{
       				//echo $Four['value'];
            		$typeFourValArray[$counterFour] = $Four['value'];
					//echo "$typeFourValArray[$counterFour]<br />";
            		$counterFour++;
        		}
			}*/
			$locResult = mysql_query("select * from locations where _ID = ".$locationID);
			$locArray = mysql_fetch_array($locResult);
			$locName = $locArray['name'];
			
        	/* Display results in a table */
        	echo "<table align='center' border='1'>";
			echo "<caption>$locName</caption>";
			echo "<tr><th>Begin Date</th>";
			echo "<th>End Date</th>";
			echo "<th>$longNameOne</th>";
			//if (!$typethree && !$typefour)
			//{
				echo "<th>$longNameTwo</th></tr>";
			/*}
			else if ($typethree && !$typefour)
			{
				echo "<th>$longNameTwo</th>";
				echo "<th>$longNameThree</th></tr>";
			}
			else if ($typethree && $typefour)
			{
				echo "<th>$longNameTwo</th>";
				echo "<th>$longNameThree</th>";
				echo "<th>$longNameFour</th></tr>";
			}*/
			
			
			for ($i = 0; $i < $counterOne; $i++)
			{
				echo "<tr><td>$typeOneBeginDateArray[$i]</td>";
				echo "<td>$typeOneEndDateArray[$i]</td>";
				echo "<td>$typeOneValArray[$i]</td>";
				//if (!$typethree && !$typefour)
				//{
					echo "<td>$typeTwoValArray[$i]</td></tr>";
				/*}
				else if ($typethree && !$typefour)
				{
					echo "<td>$typeTwoValArray[$i]</td>";
					echo "<td>$typeThreeValArray[$i]</td></tr>";
				}
				else if ($typethree && $typefour)
				{
					echo "<td>$typeTwoValArray[$i]</td>";
					echo "<td>$typeThreeValArray[$i]</td>";
					echo "<td>$typeFourValArray[$i]</td></tr>";
				}*/
			}
			
			echo "</table>";
		}
		
        ?>
</body>