<?php 
        include('inc/header.php'); 
        include('inc/creds.php');
        
        $types = mysql_query("SELECT * FROM column_names");
        while($row = mysql_fetch_array( $types )) 
        {
                $arrayoftypes[$row['name']] = $row['long_name'];
        }
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

      <!-- Main hero unit for a primary marketing message or call to action -->
      <div class="hero-unit">
        <h1>Dataset Search</h1>
                <p> Below are the fields to use for searching the datasets. After you have selected two datasets, you will be directed to another page in which you may visualize the datasets being presented against each other. </p>
                
                <br />
                
                <div class="row">
                        <div class="span8">
                                <form class="well form-horizontal" onsubmit="return validate()" action="sendQuery.php" method="POST">
                                        <fieldset>
                                        <p>Please select two variable types:</p>
                                                <div class="control-group" id="typeone-group">
                                                        <label class="control-label" for="typeone">Type One:</label>
                                                        <div class="controls" id="for-typeone">
                                                                <select id="typeone">
                                                                        <option value="NULL">Please Select a Type</option>
                                                                        <?php 
                                                                                foreach($arrayoftypes as $key=> $value)
                                                                                {
                                                                                        echo "<option value=\"".$key."\">".$value."</option>";
                                                                                }
                                                                        ?>
                                                                </select>
                                                        </div>
                                                </div>
                                                <div class="control-group" id="typetwo-group">
                                                        <label class="control-label" for="typetwo">Type Two:</label>
                                                        <div class="controls" id="for-typetwo">
                                                                <select id="typetwo">
                                                                        <option value="NULL">Please Select a Type</option>
                                                                        <?php 
                                                                                foreach($arrayoftypes as $key=> $value)
                                                                                {
                                                                                        echo "<option value=\"".$key."\">".$value."</option>";
                                                                                }
                                                                        ?>
                                                                </select>
                                                        </div>
                                                </div>
                                                <div class="control-group" id="typethree-group">
                                                        <label class="control-label" for="typetwo">Type Three:</label>
                                                        <div class="controls" id="for-typethree">
                                                                <select id="typethree">
                                                                        <option value="NULL">Please Select a Type</option>
                                                                        <?php 
                                                                                foreach($arrayoftypes as $key=> $value)
                                                                                {
                                                                                        echo "<option value=\"".$key."\">".$value."</option>";
                                                                                }
                                                                        ?>
                                                                </select>
                                                        </div>
                                                </div>
                                                <div class="control-group" id="typefour-group">
                                                        <label class="control-label" for="typefour">Type Four:</label>
                                                        <div class="controls" id="for-typefour">
                                                                <select id="typefour">
                                                                        <option value="NULL">Please Select a Type</option>
                                                                        <?php 
                                                                                foreach($arrayoftypes as $key=> $value)
                                                                                {
                                                                                        echo "<option value=\"".$key."\">".$value."</option>";
                                                                                }
                                                                        ?>
                                                                </select>
                                                        </div>
                                                </div>
                                                <p>Please select a location:</p>
                                                <div class="control-group" id="location-group">
                                                        <label class="control-label" for="location">Location:</label>
                                                        <div class="controls" id="for-location">
                                                                <select id="location" disabled="true">
                                                                        <option value="NULL">Please Select a Type</option>
                                                                </select>
                                                        </div>
                                                </div>
                                                <p>Please select a begin and end date (Format MM/dd/YYYY):</p>
                                                <p>Please look below for valid dates.</p>
                                                
                                                <div class="control-group" id="beginDate-group">
                                                        <label class="control-label" for="beginDate">Begin Date:</label>
                                                        <div class="controls" id="for-beginDate">
                                                                <input type="text" id="beginDate" disabled="true">
                                                        </div>
                                                </div>
                                                <div class="control-group" id="endDate-group">
                                                        <label class="control-label" for="endDate">End Date:</label>
                                                        <div class="controls" id="for-endDate">
                                                                <input type="text" id="endDate" disabled="true">
                                                        </div>
                                                </div>
                                                <div class="form-actions">
                                                        <button class="btn btn-primary" type="submit" style="width: 150px" id="submit" onsubmit="return validate()">Submit</button>
                                                </div>
                                        </fieldset>
                                </form>
                                <div id="dateRange"></div>
                        </div>
                </div>
      </div>

 
 
 

  
  <script>window.jQuery || document.write('<script src="js/libs/jquery-1.7.1.min.js"><\/script>')</script>
<script>
        var typeone = null; 
        var typetwo = null;
        var locationData = null;
        var dates = null;
        $("#typeone").change(function() {
                typeone = $("#typeone").val();
                if(typeone != null && typetwo != null) popLocation();
                else $("#location").attr('disabled', true);
        });
        $("#typetwo").change(function() {
                typetwo = $("#typetwo").val();
                if(typeone != null && typetwo != null) popLocation();
                else $("#location").attr('disabled', true);
        });
        function popLocation()
        {
                $.ajax({
            type: "GET",
            url: "scripts/searchResults.php",
            data: "function=1&typeone="+typeone+"&typetwo="+typetwo,
            success: function(html){
                if(html!='false')
                {
                                        $("#location").removeAttr('disabled');
                                        var locations = html.split(", ");
                                        var locationDrop = $("#location");
                                        for(i = 0; i <  locations.length; i++)
                                        {       
                                        	if (i == 0 || strcmp(locations[i], locations[i-1]) != 0)
                                                var idsplit = locations[i].split(" - ");
                                                locationDrop.append($("<option />").val(idsplit[1]).text(idsplit[0]));
                                        }
                }
                else
                {

                                        alert('Im sorry. There were no common locations found.');
                }
            }
        });
        }
        $("#location").change(function() {
                locationData = $("#location").val();
                $.ajax({
            type: "GET",
            url: "scripts/searchResults.php",
            data: "function=2&typeone="+typeone+"&typetwo="+typetwo+"&location="+locationData,
            success: function(html){
                if(html!='false')
                {
                                        $("#beginDate").removeAttr('disabled');
                                        $("#endDate").removeAttr('disabled');
                                        var dates = html.split(", ");
                                        var stringOfDates = "";
                                        for(i = 0; i < dates.length; i++)
                                        {
                                                stringOfDates = stringOfDates + dates[i] + "<br />";
                                        }
                                        //$("#dateRange").html('<p>Possible date spans:</p><p>' + dates[0] + ' - ' + dates[i-1] +  '</p>');
                                        //var start = dates[0].split("-");
                                        //var end = dates[i-1].split("-");
                                        //$("#dateRange").html('<p>Date Span:</p><p>' + start + ' - ' + end + '</p>');
                                        $("#dateRange").html('<p>Possible date spans:</p><p>' + stringOfDates + '</p>');
                                        
                }
                else
                {

                                        alert('Im sorry. There were no common dates found.');
                }
            }
        });
        });
        function validate()
        {
                /*var dateOne = $("#beginDate").val();
                var dateTwo = $("#endDate").val();*/
                return true;
                
        }
</script>

  <script src="js/plugins.js"></script>
  <script src="js/script.js"></script>
  <?php include('inc/footer.php'); ?>

</body>
</html>