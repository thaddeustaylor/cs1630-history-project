<?php include('inc/header.php'); ?>
<?php include('sendQuery.php'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml"  dir="ltr" class="no-js" lang="en"> 
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<title>History Project</title>
	<meta name="description" content="">

	<meta name="viewport" content="width=device-width">
	<link rel="stylesheet" href="css/bootstrap.css">
	<link rel="stylesheet" href="css/style.css">
	<link rel="stylesheet" href="slider.css">
	<script src="js/boostrap.js"></script>
	<script src="js/libs/modernizr-2.5.3.min.js"></script>
	<script type="text/javascript" src="js/mootools-core-1.4.5.js"></script>
	<script type="text/javascript" src="js/mootools-more-1.4.0.1.js"></script> 
	<script type="text/javascript" src="js/MilkChart_tw.js"></script>
	<link rel="stylesheet" href="css/slider.css">
</head>
<body onload="graph();">
<?php $current = 9; include('inc/menu.php'); ?>
	<div class="container">

      <!-- Main hero unit for a primary marketing message or call to action -->
      <div class="hero-unit">
        <h1>Visualizations</h1>
		<br />
		<div class="row">
			<div class="span8">
<h2>Options</h2>
<form method="get">
	<select name="type" id="type" onchange="changeFunc();">
		<option value="">-- Select Chart Type --</option>
		<?php
			$chart_types = array('Line_rpb', 'Scatter_rpb', 'Bubble_rpb', 'Bubble_Motion_rpb', 'Map_rpb', 'Map_Motion_rpb');
			foreach($chart_types as $chart_type):
				echo '<option value="',$chart_type,'"',($type == $chart_type ? ' selected="selected"' : ''),'>',$chart_type,'</option>';
			endforeach;
			?>
			<script type="text/javascript">
				
				
				function changeFunc(){
					var e = document.getElementById("type");
					var chart = e.options[e.selectedIndex].text;
					//alert(chart);
					
					if(chart == "Line_rpb"){
						var d = document.getElementById("xaxis");
						d.disabled = false;
						var d = document.getElementById("yaxis");
						d.disabled = false;
						var d = document.getElementById("color");
						d.disabled = true;
						var d = document.getElementById("size");
						d.disabled = true;
						var d = document.getElementById("time");
						d.disabled = true;
						var d = document.getElementById("location");
						d.disabled = true;
					}
					if(chart == "Scatter_rpb"){
						var d = document.getElementById("xaxis");
						d.disabled = false;
						var d = document.getElementById("yaxis");
						d.disabled = false;
						var d = document.getElementById("color");
						d.disabled = true;
						var d = document.getElementById("size");
						d.disabled = true;
						var d = document.getElementById("time");
						d.disabled = true;
						var d = document.getElementById("location");
						d.disabled = true;
					}
					if(chart == "Bubble_rpb"){
						var d = document.getElementById("xaxis");
						d.disabled = false;
						var d = document.getElementById("yaxis");
						d.disabled = false;
						var d = document.getElementById("color");
						d.disabled = false;
						var d = document.getElementById("size");
						d.disabled = false;
						var d = document.getElementById("time");
						d.disabled = true;
						var d = document.getElementById("location");
						d.disabled = true;
					}
					if(chart == "Bubble_Motion_rpb"){
						var d = document.getElementById("xaxis");
						d.disabled = false;
						var d = document.getElementById("yaxis");
						d.disabled = false;
						var d = document.getElementById("color");
						d.disabled = false;
						var d = document.getElementById("size");
						d.disabled = false;
						var d = document.getElementById("time");
						d.disabled = false;
						var d = document.getElementById("location");
						d.disabled = true;
					}
					if(chart == "Map_rpb"){
						var d = document.getElementById("xaxis");
						d.disabled = true;
						var d = document.getElementById("yaxis");
						d.disabled = true;
						var d = document.getElementById("color");
						d.disabled = false;
						var d = document.getElementById("size");
						d.disabled = false;
						var d = document.getElementById("time");
						d.disabled = true;
						var d = document.getElementById("location");
						d.disabled = false;
					}
					if(chart == "Map_Motion_rpb"){
						var d = document.getElementById("xaxis");
						d.disabled = true;
						var d = document.getElementById("yaxis");
						d.disabled = true;
						var d = document.getElementById("color");
						d.disabled = false;
						var d = document.getElementById("size");
						d.disabled = false;
						var d = document.getElementById("time");
						d.disabled = false;
						var d = document.getElementById("location");
						d.disabled = false;
					}
					
					//var e = document.getElementById("color");
					//e.disabled = true
				}
				
				
			</script>
			
		
	</select>
	<input type="submit" name="submit" id="submit" value="Graph" />

<?php
	
	
	for($k = 0; $k < $oLength-1; $k+=2){
		//Print the label and ID
		echo "<p><label>$options[$k]: <select name=\"".$options[$k+1]."\" id=\"".$options[$k+1]."\" disabled=\"disabled\">";
		for($i = 0; $i < $tLength; $i++){
			//Print the drop down boxes
			echo "<option value=$i>$tables[$i]</option>";
		}
		echo "</select></label></p>";
		//$num = $k+1;
		//if(isset($_GET["$options[$num]"])){
		//			echo $_GET["$options[$num]"];
		//}
	}
	
?>
</form>

<div id= "drawpane" style="margin: auto"></div>
		
<div id= "sl" >
		
	<h3>Date Slider</h3>
	<div id="slider" class="slider">
		<div class="knob"></div>
			<div class = "currstep" id="currstep" hidden="true">0</div>
	</div>				
</div>


	<h2>Data</h2>
	<script type="text/javascript">
		var mychart;
		function graph() {
		
		mychart = new MilkChart.<?php echo $_GET['type']; ?>('data', document.getElement(".currstep"),{<?php
		
			/*These two lines are here to prevent having to scroll up to see what the arrays store*/
			//$chart_types = array('Line_rpb', 'Scatter_rpb', 'Bubble_rpb', 'Bubble_Motion_rpb', 'Map_rpb', 'Map_Motion_rpb');
			//$options = array("Location", "location", "X-Axis", "xaxis", "Y-Axis", "yaxis", "Color", "color", "Size", "size", "Time", "time");
			if(isset($_GET["type"])){
				$index;
				
				for($i = 0; $i < sizeOf($chart_types); $i++){
					if($_GET["type"] == $chart_types[$i]){
						$index = $i;
						break;
					}
				}
				if($chart_types[$index] == "Line_rpb"){
					$chartStr = sprintf("%s: %d, %s: %d", $options[3], $_GET["$options[3]"], $options[5], $_GET["$options[5]"]); 
				}
				else if($chart_types[$index] == "Scatter_rpb"){
					$chartStr = sprintf("%s: %d, %s: %d", $options[3], $_GET["$options[3]"], $options[5], $_GET["$options[5]"]); 
				}
				else if($chart_types[$index] == "Bubble_rpb"){
					$chartStr = sprintf("%s: %d, %s: %d, %s: %d, %s: %d", $options[3], $_GET["$options[3]"], $options[5], $_GET["$options[5]"], 
										$options[7], $_GET["$options[7]"], $options[9], $_GET["$options[9]"]); 
				}
				else if($chart_types[$index] == "Bubble_Motion_rpb"){
					$chartStr = sprintf("%s: %d, %s: %d, %s: %d, %s: %d, %s: %d", $options[3], $_GET["$options[3]"], $options[5], $_GET["$options[5]"], 
										$options[7], $_GET["$options[7]"], $options[9], $_GET["$options[9]"], $options[11], $_GET["$options[11]"]); 
				}
				//I am not sure how you want to store the hidden fields so I just put -1 for now.
				else if($chart_types[$index] == "Map_rpb"){
					$chartStr = sprintf("%s: %d, %s: %d, %s: %d, %s: %d, %s: %d", $options[1], $_GET["$options[1]"], $options[3], -1, 
										$options[5], -1, $options[7], $_GET["$options[7]"], $options[9], $_GET["$options[9]"]); 
				}
				//I am not sure how you want to store the hidden fields so I just put -1 for now.
				else if($chart_types[$index] == "Map_Motion_rpb"){
					$chartStr = sprintf("%s: %d, %s: %d, %s: %d, %s: %d, %s: %d, %s: %d", $options[1], $_GET["$options[1]"], $options[3], -1, 
										$options[5], -1, $options[7], $_GET["$options[7]"], $options[9], $_GET["$options[9]"], $options[11], $_GET["$options[11]"]); 
				}
				
				//if(isset($_GET["$options[$num]"])){
				//	echo $_GET["$options[$num]"];
				
				//echo "cString = \"$chartStr\";";
				echo $chartStr;
			}
		?>});
		var slider = document.getElement(".slider");
				var knob = slider.getElement(".knob");
				new Slider(slider, knob, {
					range: [0, 1000],
					steps: 1000,
					initialStep: 0,
					onChange: function(value){
						if (value) document.getElement(".currstep").firstChild.data = value;
					}
				});
		}
	</script>
	
	
			
	
		<script type="text/javascript">
						
			/*window.addEvent('domready', function(){
			function slider() {	
				var slider = document.getElement(".slider");
				var knob = slider.getElement(".knob");
				new Slider(slider, knob, {
					range: [0, 1000],
					steps: 1000,
					initialStep: 0,
					onChange: function(value){
						if (value) document.getElement(".currstep").firstChild.data = value;
					}
				});
			}});*/
		</script>

		
		
      </div>
	  </div>
	  
 
 
 

  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
  <script>window.jQuery || document.write('<script src="js/libs/jquery-1.7.1.min.js"><\/script>')</script>

  <script src="js/plugins.js"></script>
  <script src="js/script.js"></script>
  <?php include('inc/footer.php'); ?>

</body>
</html>