<?php 
include('inc/header.php'); 
include "inc/creds.php";

$connection = mysql_connect($dbserver, $dbusername, $dbpassword) or die("ERROR: Failed to connect to database.");
mysql_select_db($dbname, $connection);

$arg_upload_submitted = false;
import_request_variables("p", "arg_");

//Temporarily manually logging myself in since login is not working for some reason.


$user_email = "";
$user_role = "";
if(!isset($_SESSION['logged'])){
  // Had to comment this out because login is not working for some reason
  header("Location: login.php");
  }
else{
  $user_email = $_SESSION['email'];
  $user_role = $_SESSION['role'];
  
  if($user_role == 1){
?>
<html>
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
  <head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>History Project</title>
    <meta name="description" content="" />
    
    <meta name="viewport" content="width=device-width" />
    <link rel="stylesheet" href="css/bootstrap.css" />
    <link rel="stylesheet" href="css/style.css" />
    <script src="js/boostrap.js"></script>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.4/jquery.min.js"></script>
    <script src="js/libs/modernizr-2.5.3.min.js"></script>
    <style type="text/css">@import "datepick/smoothness.datepick.css";</style> 
    <script src="datepick/jquery.datepick.js"></script>
    <script>
      
      $(function() {
      $('#popupDatepicker').datepick({showOnFocus: false, showTrigger: '#calImg'});
      });
      $(function() {
      $('#endDate').datepick({showOnFocus: false, showTrigger: '#calImg'});
      });
      
    </script>
  </head>
  <body>
      
    <?php $current = 6; include('inc/menu.php'); ?>
    <div class="container">
      
      <!-- Main hero unit for a primary marketing message or call to action -->
      <div class="hero-unit">
	<h1>Upload Dataset</h1>
	<!--<p>Unfortunately, this functionality has not been implemented yet. This is just a template </p>-->
	<br />
	<div class="row">
	  <div class="span8">
	    <form class="well form-horizontal" enctype="multipart/form-data" name='upload-form' action="upload_file.php" method="POST">
	      <input type='hidden' name='upoload_submitted' value='true' />
	      <fieldset>
		<div class="control-group" id="name-group">
		  <label class="control-label" for="name">Name of Dataset:</label>
		  <div class="controls" id="for-name">
		    <input type="text" style="font-size:10pt; padding:0px; height:25px;" name="dataset_name" />
		  </div>
		</div>
		<div class="control-group" id="file-group">
		  <label class="control-label" for="file">Please Select File:</label>
		  <div class="controls" id="for-file">
		    <input name="data_file" class="input-file" type="file" />
		    </div>
		  </div>

		  <!-- Start Date input Div -->
		  <div class="control-group" id="beginDate-group">
		    <label class="control-label" for="beginDate">Begin Date:</label>
		    <div class="controls" id="for-beginDate">
		      <input type="text" style="font-size:10pt; padding:0px; height:25px;" name="startDate" /><div style="display: none;" > 	      
		      <img id="calImg" src="datepick/calendar.gif" alt="Popup" class="trigger"> 
		      </div>
		    </div>
		  </div>
		  <div class="control-group" id="endDate-group">
		    <label class="control-label" for="endDate">End Date:</label>
		    <div class="controls" id="for-endDate">
		      <input type="text" style="font-size:10pt; padding:0px; height:25px;" name="endDate" /><div style="display: none;" > 
		      <img id="calImg" src="datepick/calendar.gif" alt="Popup" class="trigger"> 
		      </div>
		    </div>
		  </div>
		  <div class="control-group" name="pubDate-group">
		    <label class="control-label" for="endDate">Publish Date:</label>
		    <div class="controls" id="for-endDate">
		      <input type="text" style="font-size:10pt; padding:0px; height:25px;" name="pubDate" /><div style="display: none;" > 
		      <img id="calImg" src="datepick/calendar.gif" alt="Popup" class="trigger"> 
		      </div>
		    </div>
		  </div>
		  <!-- Div for frequency unit input -->
		  <div class="control-group" id="freqUnit-group">
		    <label class="control-label" for="freqUnit">Frequency Unit:</label>
		    <div class="controls" id="for-freqUnit">
		      <select name="frequency_unit">
			<option value="DAY">Day</option>
			<option value="WEEK">Week</option>
			<option value="MONTH">Month</option>
			<option value="YEAR">Year</option>
		      </select>
		    </div>
		  </div>
		  <!-- Div for frequency quantity input -->
		  <div class="control-group" id="freqQuant-group">
		    <label class="control-label" for="freqQuant">Frequency Quantity:</label>
		    <div class="controls" id="for-freqQuant">
		      <input type="text" style="font-size:10pt; padding:0px; height:25px;" name="frequency_quantity" />
		     
		 
		    </div>
		   
		  </div>
		  
		  <div class="form-actions">
		    <button class="btn btn-primary" type="submit" style="width: 150px" name="submit">Submit</button>
		  </div>
		</fieldset>
	      </form>
	    </div>
	  </div>
	  <div class="row">
	    <div class="span8">
	      <p style="color: red" align="center" id="success">Note: Once submitted, your dataset will be sent to a group of moderators who will approve/deny the dataset into the collection.</p>
	    </div>
	  </div>
	  
	</div>
	
	
	
	<script src="js/plugins.js"></script>
	<script src="js/script.js"></script>
	<?php include('inc/footer.php'); ?>
	
      </body>
    </html>
    <?php
  }
  else{
    echo "<p>You must have an administrator or uploader account to access this page. We apologize for the inconvenience.</p>";
    echo "<p>To request to become an uploader, please go <a href='#'>here</a> to send a request to a system administrator.</p>";
  }
  }
  
  mysql_close($connection);
  ?>