<?php

include "inc/creds.php";
include "inc/header.php";

$connection = mysql_connect($dbserver, $dbusername, $dbpassword) or die("ERROR: Failed to connect to database.");
mysql_select_db($dbname, $connection);

$arg_coltypes_set = false;
import_request_variables("p", "arg_");

$dataset_name = $arg_dataset_name;

$begin_date = $arg_startDate;
$end_date = $arg_endDate;
$pub_date = $arg_pubDate;

$freq_unit = $arg_frequency_unit;
$freq_quantity = $arg_frequency_quantity;

$new_dataset_query = "INSERT IGNORE INTO dataset_master SET name = \"$dataset_name\"";
mysql_query($new_dataset_query, $connection) or die("ERROR: Error creating new record in dataset_master");

$new_dataset_id_query = "SELECT _ID FROM dataset_master WHERE name = \"$dataset_name\"";
$result = mysql_query($new_dataset_id_query, $connection) or die("ERROR: Error getting ID of new dataset");

$row = mysql_fetch_assoc($result);
$dataset_id = $row['_ID'];

$data_file = "";
$filepath = "";
if(!$arg_coltypes_set){
  
  $data_file = $arg_data_file;


  $filepath = "files/";
  $filepath = $filepath . basename($_FILES['data_file']['name']);
} 
if(!$arg_coltypes_set){
  if(move_uploaded_file($_FILES['data_file']['tmp_name'], $filepath)) {
    echo "The file ".  basename( $_FILES['data_file']['name']). 
      " has been uploaded";
  } 
  else{
    echo "There was an error uploading the file, please try again!";
  }
  }
else{
  $filepath = $arg_data_filepath;
  }


$ignored_cols = array(0,1,2,3,4,5);

if($arg_coltypes_set){
  for($j=0; $j<$arg_num_cols; $j++){
    $ignore_name = "arg_ignore-" . $j;
    if(isset($$ignore_name)){
      // echo "\nIgnoring column $j\n";
      array_push($ignored_cols, $j);
    }
  }
}

$tuples = file($filepath) or die("ERROR: Error reading in your file. Please <a href='upload.php'>return</a> to the upload page and resubmit.");


$lines = explode("\r", $tuples[0]);

$columns = explode(",", $lines[0]);

$datatypes_query = "SELECT * FROM column_names";
$res = mysql_query($datatypes_query, $connection) or die("ERROR: Error querying for datatypes");

$data_types = array();
while($row = mysql_fetch_assoc($res)){
  array_push($data_types, $row['name']);
}
?>
<html>
  <!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
  <!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8" lang="en"> <![endif]-->
  <!--[if IE 8]>    <html class="no-js lt-ie9" lang="en"> <![endif]-->
  <!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
  <head>
    <title>History Project</title>
    <meta name="description" content="" />
    
    <meta name="viewport" content="width=device-width" />
    <link rel="stylesheet" href="css/bootstrap.css" />
    <link rel="stylesheet" href="css/style.css" />
    <script src="js/boostrap.js"></script>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.4/jquery.min.js"></script>
    <script src="js/libs/modernizr-2.5.3.min.js"></script>
    
  </head>
  <body>

    <?php $current = 6; include('inc/menu.php'); ?>
    <div class="container">
      
      <!-- Main hero unit for a primary marketing message or call to action -->
      <div class="hero-unit">
	<form name="upload_form" method="POST" action="upload_file.php">
	  <h1>Column Specification</h1>
	  <h3>Please map the data columns in your file to data types within our system</h3>
	  <br />
	  <input type="hidden" name="coltypes_set" value="true" />
	  
	  <?php
	    
	$i = 0;
	if(!$arg_coltypes_set){
	  // Pass through all of our upload data to be available for upload into the database
	  echo "<input type='hidden' name='dataset_name' value=\"$dataset_name\" />\n";
	  echo "<input type='hidden' name='startDate' value=\"$begin_date\" />\n";
	  echo "<input type='hidden' name='endDate' value=\"$end_date\" />\n";
	  echo "<input type='hidden' name='pubDate' value=\"$pub_date\" />\n";
	  echo "<input type='hidden' name='frequency_unit' value=\"$freq_unit\" />\n";
	  echo "<input type='hidden' name='frequency_quantity' value=\"$freq_quantity\" />\n";
	  echo "<input type='hidden' name='data_filepath' value=\"$filepath\" />\n";
	  
	  foreach($columns as $column){
	    if($i>5){
	      echo "<p style='font-weight:bold;'>Column $i: $column</p>\n";
	      echo "<p>Data Type: \n";
	      echo "<select name='data_type-$i'><br />\n";
	      foreach($data_types as $data_type){
		echo "<option value=\"$data_type\">$data_type</option>\n";
	      }
	      echo "</select>\n";
	      echo "</p>\n";
	      echo "<input type='checkbox' name=\"ignore-$i\" value='true'>Ignore this column</input>\n";
	    }
	    $i++;
	  }
	  echo "<input type='hidden' name='num_cols' value=$i />\n";
	  echo "<br /><br /><input type='submit' name='continue' value='Continue >' />";
	}
	else{
	  $j=0;
	  $temp_table_query = "CREATE TABLE $arg_dataset_name LIKE prcp";
	  mysql_query($temp_table_query, $connection) or die("ERROR: Error creating temporary table -> " . mysql_error());
	  foreach($lines as $line){
	    $columns = explode(",", $line);
	    $i=0;
	    if($j!=0){
	      foreach($columns as $column){
		if(in_array($i, $ignored_cols)){
		  // if new location, add it to DB, if not new, do nothing
		  if($i == 2){
		    // Talk to Thaddeus about this location noise
		  }
		}
		else{
		  // Fix issue with arg_numerator_type
		  $num_type = "arg_numerator_type-" . $i;
		  $num_strtype = strval($$num_type);
		  $num_val = "arg_numerator_value-" . $i;
		  $num_intval = intval($$num_val);
		  $denom_type = "arg_denominator_type-" . $i;
		  $denom_strtype = strval($$denom_type);
		  $denom_val = "arg_denominator_value-" . $i;
		  $denom_intval = intval($$denom_val);
		  
		  $dat_type = "arg_data_type-" . $i;
		  $data_strtype = strval($$dat_type);
		  
		  //echo "<p>$data_strtype</p>";

		  $get_colID_query = "SELECT col_ID FROM column_names WHERE name=\"$data_strtype\"";
		  $results = mysql_query($get_colID_query, $connection) or die("ERROR: Error getting column ID for $data_strtype -> " . mysql_error());
		  $row = mysql_fetch_assoc($results);
		  $col_id = $row['col_ID'];

		  $get_num_denom_query = "SELECT * FROM $data_strtype WHERE 1";

		  $insert_query = "INSERT INTO $arg_dataset_name VALUES (DEFAULT, \"$columns[0]\", \"$columns[1]\", \"$arg_pubDate\", \"$arg_frequency_unit\", $arg_frequency_quantity, 0, $col_id, $dataset_id, \"$column\", \"$num_strtype\", $num_intval, \"$denom_strtype\", $denom_intval, 1, 1)";
		  mysql_query($insert_query, $connection) or die("ERROR: Error uploading new data into repository ->" . mysql_error());
		  
		  
		}
		$i++;
	      }
	    }
	    $j++;
	     
	  }
	  echo "<h3>Congratulations! Your datset has been successfully uploaded and is now awaiting approval froma system administrator.</h3>";
	  //header("Location: /index.php");
	}

	  ?>
	</form>
      </div>
    </div>
    <script src="js/plugins.js"></script>
    <script src="js/script.js"></script>
    <?php include('inc/footer.php'); ?>
  </body>
</html>
<?php
mysql_close($connection);
?>