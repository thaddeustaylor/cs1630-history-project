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
                                <form class="well form-horizontal" action="sendQuery.php" method="GET">
                                        <fieldset>
                                        <p>Please select two variable types:</p>
                                                <div class="control-group" id="typeone-group">
                                                        <label class="control-label" for="typeone">Type One:</label>
                                                        <div class="controls" id="for-typeone">
                                                                <select name="typeone" id="typeone">
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
                                                                <select name="typetwo" id="typetwo">
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
                                                                <select name="typethree" id="typethree">
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
                                                                <select name="typefour" id="typefour">
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
                                                <div class="control-group" id="state-group">
                                                        <label class="control-label" for="state">State:</label>
                                                        <div class="controls" id="for-state">
                                                                <select name="state" id="state" disabled="true">
                                                                        <option value="NULL">Please Select a State</option>
                                                                </select>
                                                        </div>
                                                
                                                </div>
                                                <div class="control-group" id="county-group">
                                                        <label class="control-label" for="county">County:</label>
                                                        <div class="controls" id="for-county">
                                                                <select name="county" id="county" disabled="true">
                                                                        <option value="NULL">Please Select a County</option>
                                                                </select>
                                                        </div>
                                                
                                                </div>
                                                <div class="control-group" id="city-group">
                                                        <label class="control-label" for="city">City:</label>
                                                        <div class="controls" id="for-city">
                                                                <select name="city" id="city" disabled="true">
                                                                        <option value="NULL">Please Select a City</option>
                                                                </select>
                                                        </div>
                                                
                                                </div>
                                                <p>Please select a begin and end date (Format YYYY-MM-DD):</p>
                                                <?php //<p>Please look below for valid dates.</p> ?>
                                                
                                                <div class="control-group" id="beginDate-group">
                                                        <label class="control-label" for="beginDate">Begin Date:</label>
                                                        <div class="controls" id="for-beginDate">
                                                                <input type="text" name="beginDate" id="beginDate" <?php //disabled="true"?>>
                                                        </div>
                                                </div>
                                                <div class="control-group" id="endDate-group">
                                                        <label class="control-label" for="endDate">End Date:</label>
                                                        <div class="controls" id="for-endDate">
                                                                <input type="text" name="endDate" id="endDate" <?php //disabled="true"?>>
                                                        </div>
                                                </div>
                                                <div class="form-actions">
                                                        <button class="btn btn-primary" type="submit" style="width: 150px" id="submit">Submit</button>
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
		var typethree = null;
		var typefour = null;
        var state = null;
        var dates = null;
        $("#typeone").change(function() {
                typeone = $("#typeone").val();
                if(typeone != null && typetwo != null) {
					if(typethree == null) typethree = "zzz";
					if(typefour == null) typefour = "zzz";
					popLocation();
				}
                else $("#state").attr('disabled', true);
        });
        $("#typetwo").change(function() {
                typetwo = $("#typetwo").val();
                if(typeone != null && typetwo != null) {
					if(typethree == null) typethree = "zzz";
					if(typefour == null) typefour = "zzz";
					popLocation();
				}
                else $("#state").attr('disabled', true);
        });
		$("#typethree").change(function() {
                typethree = $("#typethree").val();
                if(typeone != null && typetwo != null) {
					if(typethree == null) typethree = "zzz";
					if(typefour == null) typefour = "zzz";
					popLocation();
				}
                else $("#state").attr('disabled', true);
        });
		$("#typefour").change(function() {
                typefour = $("#typefour").val();
                if(typeone != null && typetwo != null) {
					if(typethree == null) typethree = "zzz";
					if(typefour == null) typefour = "zzz";
					popLocation();
				}
                else $("#state").attr('disabled', true);
        });
		$("#state").change(function() {
			state = $("#state").val();
			if(state != null) popCountyAndCity();
		});	
        function popCountyAndCity()
        {
            $.ajax({
            type: "GET",
            url: "scripts/searchResults2.php",
			            data: "function=2&typeone="+typeone+"&typetwo="+typetwo+"&typethree="+typethree+"&typefour="+typefour+"&state="+state,
  
            success: function(html){
                if(html!='false')
                {
                    $("#county").removeAttr('disabled');
					$("#city").removeAttr('disabled');
					var cityAndStates = html.split(" / ");
					var cities = cityAndStates[1];
					var counties = cityAndStates[0];
					
					if(cities != "FALSE")
					{
						var cityDrop = $("#city");
						cities = cities.split(" , ");
						for(i = 0; i < cities.length; i++)
						{
							var idsplit = cities[i].split(" - ");
							cityDrop.append($("<option />").val(idsplit[1]).text(idsplit[0]));
						}
					}
					if(counties != "FALSE")
					{
						var countiesDrop = $("#county");
				
						counties = counties.split(", ");

						for(i = 0; i < counties.length; i++)
						{
							
							var idsplit = counties[i].split(" - ");
							countiesDrop.append($("<option />").val(idsplit[1]).text(idsplit[0]));
						}
					}										
                }
                else
                {

                                        alert('Im sorry. There were no common locations found.');
                }
            }
			});
        }
		function popLocation()
		{
			$.ajax({
            type: "GET",
            url: "scripts/searchResults2.php",
          data: "function=1&typeone="+typeone+"&typetwo="+typetwo+"&typethree="+typethree+"&typefour="+typefour,
            success: function(html){
                if(html!='false')
                {
                                        $("#state").removeAttr('disabled');
                                        var states = html.split(", ");
                                        var stateDrop = $("#state");
                                        for(i = 0; i <  states.length; i++)
                                        {       
                                            var idsplit = states[i].split(" - ");
                                            stateDrop.append($("<option />").val(idsplit[1]).text(idsplit[0]));
                                        }
                }
                else
                {

                                        alert('Im sorry. There were no common locations found.');
                }
            }
			});
		}
		
      
</script>

  <script src="js/plugins.js"></script>
  <script src="js/script.js"></script>
  <?php include('inc/footer.php'); ?>

</body>
</html>