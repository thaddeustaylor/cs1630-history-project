<?php include('inc/header.php'); ?>
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
	//$tables should be passed to us
	$tables = array("Date", "Population", "Measles Cases","Temperature, Low", "Temperature, High" );
	$tLength = sizeOf($tables);
	
	//$Options should also be passed to us in the format of name,id.
	//Unless we make the id the same as the name then just name needs to be passed
	$options = array("Location", "location", "X-Axis", "xaxis", "Y-Axis", "yaxis", "Color", "color", "Size", "size", "Time", "time");
	$oLength = sizeOf($options);
	
	//This is the variable I am not sure about exactly. Not sure if they
	//will decide to give us a 2D array like: results[$table][$value] or
	//if they will give us an array for each table: $result1[$value].
	//I will do the naive way and have an array for each for now. 
	$result1 = array(6,12,2,7,10,6,7,3,1,10,13,9,15,13,30,20,42,41,58,70,59,78,107,111,118,107,130,84,138); //Cases

	$result2 = array(194,32,287,34,27,40,40,83,83,51,0,36,66,179,125,36,123,103,28,129,19,0,66,63,84,85,65,7,33); //Precip

	$result3 = array(55.42857143,38.57142857,55.14285714,50.85714286,38.28571429,40,40,36.28571429,36.28571429
				,46.14285714,36,25.42857143,33.28571429,27,29.375,39.28571429,36.28571429,26.71428571
				,17,24.14285714,17.85714286,21.71428571,22.28571429,25.14285714,27.71428571,38.42857143
				,42.57142857,45.42857143,34.85714286); //Min Temp

	$result4 = array(68.71428571,59.71428571,66.42857143,64.42857143,54.42857143,56.57142857,56.57142857,50.28571429
				,50.28571429,57.42857143,51.28571429,44.71428571,50.85714286,38.28571429,39.75,55.85714286
				,51.28571429,39,34,36.42857143,32.14285714,40.57142857,34.42857143,40.85714286,41,58.85714286
				,65.71428571,65.28571429,55); //Max Temp
	$r1Length = sizeOf($result1);
	$r2Length = sizeOf($result2);
	$r3Length = sizeOf($result3);
	$r4Length = sizeOf($result4);
	
	//Check if they all have the same ammount of rows returned.
	if(($r1Length != $r2Length) || ($r2Length != $r3Length) || ($r3Length != $r4Length)){
		echo "FAIL there will be errors! If we continue!";
	}
	
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
		<input type="button" value="play" onclick="playdates();"/>
</div>



<table id="data" hidden="true" title="Population and Measles in Boston 1907-1952">
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
			//For the sake of sanity I will only be doing the first
			//30 value the rest is still hard coded in. The commented
			//out section are the first 30 rows.
			/*for($i = 0; $i < $r1Length; $i++){
				echo "<tr>";
				for($k = 1; $k < $tLength+1; $k++){
					$magic = "result$k";
					$magic2 = $$magic;
					echo "<td>$magic2[$i]</td>";	//Print the table datas
				}
				echo "</tr>";
			}*/
		?>
        <tr><td>835522</td><td>254</td><td>15.5714</td><td>30.8571</td><td>1920-01-01</td></tr><tr><td>835607</td><td>266</td><td>18.5714</td><td>33.1429</td><td>1920-01-08</td></tr><tr><td>835691</td><td>337</td><td>7.14286</td><td>23.5714</td><td>1920-01-15</td></tr><tr><td>835776</td><td>303</td><td>12.5714</td><td>31.8571</td><td>1920-01-22</td></tr><tr><td>835861</td><td>278</td><td>12.2857</td><td>31.4286</td><td>1920-01-29</td></tr><tr><td>835945</td><td>326</td><td>24.7143</td><td>34.8571</td><td>1920-02-05</td></tr><tr><td>836030</td><td>264</td><td>21.8571</td><td>38.1429</td><td>1920-02-12</td></tr><tr><td>836114</td><td>248</td><td>22.4286</td><td>34.5714</td><td>1920-02-19</td></tr><tr><td>836199</td><td>236</td><td>12.5714</td><td>31</td><td>1920-02-26</td></tr><tr><td>836284</td><td>199</td><td>21.7143</td><td>39.1429</td><td>1920-03-04</td></tr><tr><td>836368</td><td>209</td><td>31.8571</td><td>48.4286</td><td>1920-03-11</td></tr><tr><td>836453</td><td>192</td><td>33</td><td>50.7143</td><td>1920-03-18</td></tr><tr><td>836538</td><td>246</td><td>41.5714</td><td>58.5714</td><td>1920-03-25</td></tr><tr><td>836622</td><td>210</td><td>35.4286</td><td>47.7143</td><td>1920-04-01</td></tr><tr><td>836707</td><td>273</td><td>33.7143</td><td>48</td><td>1920-04-08</td></tr><tr><td>836792</td><td>193</td><td>40.1429</td><td>57.1429</td><td>1920-04-15</td></tr><tr><td>836876</td><td>214</td><td>41</td><td>53.5714</td><td>1920-04-22</td></tr><tr><td>836961</td><td>245</td><td>41.4286</td><td>53.2857</td><td>1920-04-29</td></tr><tr><td>837046</td><td>242</td><td>46.7143</td><td>63.4286</td><td>1920-05-06</td></tr><tr><td>837130</td><td>230</td><td>48</td><td>62.7143</td><td>1920-05-13</td></tr><tr><td>837215</td><td>253</td><td>48.2857</td><td>59.2857</td><td>1920-05-20</td></tr><tr><td>837300</td><td>191</td><td>56.2857</td><td>77.4286</td><td>1920-05-27</td></tr><tr><td>837384</td><td>189</td><td>53.8571</td><td>65.8571</td><td>1920-06-03</td></tr><tr><td>837469</td><td>116</td><td>58.2857</td><td>78.8571</td><td>1920-06-10</td></tr><tr><td>837553</td><td>102</td><td>52.5714</td><td>66.2857</td><td>1920-06-17</td></tr><tr><td>837638</td><td>58</td><td>64.4286</td><td>80.8571</td><td>1920-06-24</td></tr><tr><td>837723</td><td>70</td><td>60.5714</td><td>77.5714</td><td>1920-07-01</td></tr><tr><td>837807</td><td>36</td><td>67.5714</td><td>86.4286</td><td>1920-07-08</td></tr><tr><td>837892</td><td>51</td><td>63</td><td>81.4286</td><td>1920-07-15</td></tr><tr><td>837977</td><td>18</td><td>61.5714</td><td>78.2857</td><td>1920-07-22</td></tr><tr><td>838061</td><td>14</td><td>64.4286</td><td>80.2857</td><td>1920-07-29</td></tr><tr><td>838146</td><td>13</td><td>68.1429</td><td>84.5714</td><td>1920-08-05</td></tr><tr><td>838231</td><td>5</td><td>69.2857</td><td>80.4286</td><td>1920-08-12</td></tr><tr><td>838315</td><td>9</td><td>60.2857</td><td>72.1429</td><td>1920-08-19</td></tr><tr><td>838400</td><td>8</td><td>63</td><td>79.2857</td><td>1920-08-26</td></tr><tr><td>838484</td><td>4</td><td>57.4286</td><td>74.1429</td><td>1920-09-02</td></tr><tr><td>838569</td><td>5</td><td>58.7143</td><td>70.8571</td><td>1920-09-09</td></tr><tr><td>838654</td><td>5</td><td>51.5714</td><td>68.2857</td><td>1920-09-16</td></tr><tr><td>838738</td><td>6</td><td>61.7143</td><td>78</td><td>1920-09-23</td></tr><tr><td>838823</td><td>10</td><td>52.5714</td><td>70</td><td>1920-09-30</td></tr><tr><td>838908</td><td>7</td><td>50.2857</td><td>71</td><td>1920-10-07</td></tr><tr><td>838992</td><td>6</td><td>54.5714</td><td>66.7143</td><td>1920-10-14</td></tr><tr><td>839077</td><td>9</td><td>51.7143</td><td>71.4286</td><td>1920-10-21</td></tr><tr><td>839162</td><td>7</td><td>43.4286</td><td>61.7143</td><td>1920-10-28</td></tr><tr><td>839246</td><td>14</td><td>40.1429</td><td>56.7143</td><td>1920-11-04</td></tr><tr><td>839331</td><td>10</td><td>30.5714</td><td>44.5714</td><td>1920-11-11</td></tr><tr><td>839416</td><td>23</td><td>34.7143</td><td>45.7143</td><td>1920-11-18</td></tr><tr><td>839500</td><td>22</td><td>31.5714</td><td>41</td><td>1920-11-25</td></tr><tr><td>839585</td><td>26</td><td>32.4286</td><td>44.7143</td><td>1920-12-02</td></tr><tr><td>839670</td><td>34</td><td>34.8571</td><td>44.8571</td><td>1920-12-09</td></tr><tr><td>839754</td><td>36</td><td>29.1429</td><td>39.4286</td><td>1920-12-16</td></tr><tr><td>839839</td><td>41</td><td>23</td><td>37.5556</td><td>1920-12-23</td></tr><tr><td>839923</td><td>54</td><td>32</td><td>46.2857</td><td>1920-12-30</td></tr><tr><td>840008</td><td>58</td><td>26</td><td>40.8571</td><td>1921-01-06</td></tr><tr><td>840093</td><td>62</td><td>19.4286</td><td>37.4286</td><td>1921-01-13</td></tr><tr><td>840177</td><td>70</td><td>17.7143</td><td>36.7143</td><td>1921-01-20</td></tr><tr><td>840262</td><td>54</td><td>25.8571</td><td>35.8571</td><td>1921-01-27</td></tr><tr><td>840347</td><td>113</td><td>30</td><td>42.1429</td><td>1921-02-03</td></tr><tr><td>840431</td><td>69</td><td>26.4286</td><td>44.1429</td><td>1921-02-10</td></tr><tr><td>840516</td><td>109</td><td>19</td><td>34.4286</td><td>1921-02-17</td></tr><tr><td>840601</td><td>77</td><td>32.5714</td><td>46.8571</td><td>1921-02-24</td></tr><tr><td>840685</td><td>85</td><td>36.8571</td><td>55.2857</td><td>1921-03-03</td></tr><tr><td>840770</td><td>101</td><td>37.5714</td><td>54.2857</td><td>1921-03-10</td></tr><tr><td>840854</td><td>93</td><td>37.7143</td><td>60.1429</td><td>1921-03-17</td></tr><tr><td>840939</td><td>155</td><td>35.8571</td><td>56.2857</td><td>1921-03-24</td></tr><tr><td>841024</td><td>131</td><td>40.7143</td><td>60</td><td>1921-03-31</td></tr><tr><td>841108</td><td>123</td><td>45.1429</td><td>61.7143</td><td>1921-04-07</td></tr><tr><td>841193</td><td>134</td><td>43.5714</td><td>61.5714</td><td>1921-04-14</td></tr><tr><td>841278</td><td>115</td><td>47.1429</td><td>56.2857</td><td>1921-04-21</td></tr><tr><td>841362</td><td>110</td><td>44.1429</td><td>52.1429</td><td>1921-04-28</td></tr><tr><td>841447</td><td>107</td><td>45.8571</td><td>59.1429</td><td>1921-05-05</td></tr><tr><td>841532</td><td>100</td><td>51.4286</td><td>70.5714</td><td>1921-05-12</td></tr><tr><td>841616</td><td>87</td><td>53.1429</td><td>73.7143</td><td>1921-05-19</td></tr><tr><td>841701</td><td>117</td><td>56</td><td>75.4286</td><td>1921-05-26</td></tr><tr><td>841786</td><td>111</td><td>56.2857</td><td>76.4286</td><td>1921-06-02</td></tr><tr><td>841870</td><td>77</td><td>58.4286</td><td>78.2857</td><td>1921-06-09</td></tr><tr><td>841955</td><td>105</td><td>62.5714</td><td>81.5714</td><td>1921-06-16</td></tr><tr><td>842039</td><td>94</td><td>62.1429</td><td>71.4286</td><td>1921-06-23</td></tr><tr><td>842124</td><td>85</td><td>65.2857</td><td>79.8571</td><td>1921-06-30</td></tr><tr><td>842209</td><td>60</td><td>66.1429</td><td>78.1429</td><td>1921-07-07</td></tr><tr><td>842293</td><td>43</td><td>65.1429</td><td>80</td><td>1921-07-14</td></tr><tr><td>842378</td><td>37</td><td>69.5714</td><td>87.8571</td><td>1921-07-21</td></tr><tr><td>842463</td><td>21</td><td>61.2857</td><td>73.7143</td><td>1921-07-28</td></tr><tr><td>842547</td><td>13</td><td>65.4286</td><td>82.1429</td><td>1921-08-04</td></tr><tr><td>842632</td><td>16</td><td>61.8571</td><td>79.2857</td><td>1921-08-11</td></tr><tr><td>842717</td><td>11</td><td>58.2857</td><td>73.5714</td><td>1921-08-18</td></tr><tr><td>842801</td><td>10</td><td>62.7143</td><td>82.7143</td><td>1921-08-25</td></tr><tr><td>842886</td><td>16</td><td>63.2857</td><td>78.8571</td><td>1921-09-01</td></tr><tr><td>842970</td><td>9</td><td>59</td><td>77</td><td>1921-09-08</td></tr><tr><td>843055</td><td>10</td><td>58.5714</td><td>73.8571</td><td>1921-09-15</td></tr><tr><td>843140</td><td>12</td><td>58.4286</td><td>75</td><td>1921-09-22</td></tr><tr><td>843224</td><td>23</td><td>52.7143</td><td>70.5714</td><td>1921-09-29</td></tr><tr><td>843309</td><td>11</td><td>46</td><td>65</td><td>1921-10-06</td></tr><tr><td>843394</td><td>21</td><td>50.4286</td><td>65.1429</td><td>1921-10-13</td></tr><tr><td>843478</td><td>21</td><td>39.1429</td><td>57.2857</td><td>1921-10-20</td></tr><tr><td>843563</td><td>48</td><td>43.1429</td><td>54.4286</td><td>1921-10-27</td></tr><tr><td>843648</td><td>32</td><td>33.1429</td><td>46</td><td>1921-11-03</td></tr><tr><td>843732</td><td>54</td><td>36.5714</td><td>47.7143</td><td>1921-11-10</td></tr><tr><td>843817</td><td>51</td><td>34.8571</td><td>52.1429</td><td>1921-11-17</td></tr><tr><td>843902</td><td>61</td><td>32.1429</td><td>43.5714</td><td>1921-11-24</td></tr><tr><td>843986</td><td>45</td><td>28.2857</td><td>40</td><td>1921-12-01</td></tr><tr><td>844071</td><td>58</td><td>26.2857</td><td>37.2857</td><td>1921-12-08</td></tr><tr><td>844156</td><td>47</td><td>21.2857</td><td>41.5714</td><td>1921-12-15</td></tr><tr><td>844240</td><td>51</td><td>18.125</td><td>32.625</td><td>1921-12-22</td></tr><tr><td>844325</td><td>72</td><td>19</td><td>33.5714</td><td>1921-12-29</td></tr><tr><td>844409</td><td>63</td><td>23.1429</td><td>35.8571</td><td>1922-01-05</td></tr><tr><td>844494</td><td>65</td><td>26.8571</td><td>39.2857</td><td>1922-01-12</td></tr><tr><td>844579</td><td>96</td><td>9.85714</td><td>26.5714</td><td>1922-01-19</td></tr><tr><td>844663</td><td>106</td><td>29.2857</td><td>42.8571</td><td>1922-01-26</td></tr><tr><td>844748</td><td>124</td><td>25.4286</td><td>37</td><td>1922-02-02</td></tr><tr><td>844833</td><td>123</td><td>12.5714</td><td>30.7143</td><td>1922-02-09</td></tr><tr><td>844917</td><td>152</td><td>29.8571</td><td>46.5714</td><td>1922-02-16</td></tr><tr><td>845002</td><td>154</td><td>24</td><td>39.7143</td><td>1922-02-23</td></tr><tr><td>845087</td><td>149</td><td>34.8571</td><td>49.1429</td><td>1922-03-02</td></tr><tr><td>845171</td><td>125</td><td>30.5714</td><td>46.8571</td><td>1922-03-09</td></tr><tr><td>845256</td><td>140</td><td>32.5714</td><td>47.7143</td><td>1922-03-16</td></tr><tr><td>845340</td><td>185</td><td>34.2857</td><td>51</td><td>1922-03-23</td></tr><tr><td>845425</td><td>215</td><td>37.8571</td><td>51.4286</td><td>1922-03-30</td></tr><tr><td>845510</td><td>218</td><td>43.2857</td><td>63.1429</td><td>1922-04-06</td></tr><tr><td>845594</td><td>256</td><td>38.7143</td><td>57.5714</td><td>1922-04-13</td></tr><tr><td>845679</td><td>227</td><td>40.1429</td><td>61.7143</td><td>1922-04-20</td></tr><tr><td>845764</td><td>190</td><td>46.2857</td><td>65.1429</td><td>1922-04-27</td></tr><tr><td>845848</td><td>207</td><td>51.2857</td><td>70.7143</td><td>1922-05-04</td></tr><tr><td>845933</td><td>236</td><td>51</td><td>69.7143</td><td>1922-05-11</td></tr><tr><td>846018</td><td>201</td><td>55.7143</td><td>71.1429</td><td>1922-05-18</td></tr><tr><td>846102</td><td>206</td><td>57.1429</td><td>78</td><td>1922-05-25</td></tr><tr><td>846187</td><td>188</td><td>66.1429</td><td>86</td><td>1922-06-01</td></tr><tr><td>846272</td><td>160</td><td>55.2857</td><td>71.7143</td><td>1922-06-08</td></tr><tr><td>846356</td><td>145</td><td>58.1429</td><td>70.5714</td><td>1922-06-15</td></tr><tr><td>846441</td><td>144</td><td>65.2857</td><td>79.5714</td><td>1922-06-22</td></tr><tr><td>846526</td><td>98</td><td>64.8571</td><td>80.2857</td><td>1922-06-29</td></tr><tr><td>846610</td><td>105</td><td>63.1429</td><td>78.1429</td><td>1922-07-06</td></tr><tr><td>846695</td><td>58</td><td>67.2857</td><td>82.8571</td><td>1922-07-13</td></tr><tr><td>846779</td><td>38</td><td>62.5714</td><td>75.2857</td><td>1922-07-20</td></tr><tr><td>846864</td><td>40</td><td>63.7143</td><td>77.8571</td><td>1922-07-27</td></tr><tr><td>846949</td><td>35</td><td>62</td><td>73</td><td>1922-08-03</td></tr><tr><td>847033</td><td>24</td><td>67</td><td>85.5714</td><td>1922-08-10</td></tr><tr><td>847118</td><td>26</td><td>61.2857</td><td>78</td><td>1922-08-17</td></tr><tr><td>847203</td><td>14</td><td>61.8571</td><td>74.2857</td><td>1922-08-24</td></tr><tr><td>847287</td><td>8</td><td>61.4286</td><td>74.8571</td><td>1922-08-31</td></tr><tr><td>847372</td><td>11</td><td>63</td><td>78.7143</td><td>1922-09-07</td></tr><tr><td>847457</td><td>15</td><td>51.1429</td><td>65.8571</td><td>1922-09-14</td></tr><tr><td>847541</td><td>34</td><td>51.5714</td><td>72.1429</td><td>1922-09-21</td></tr><tr><td>847626</td><td>19</td><td>57.1429</td><td>74.8571</td><td>1922-09-28</td></tr><tr><td>847710</td><td>37</td><td>51.2857</td><td>66</td><td>1922-10-05</td></tr><tr><td>847795</td><td>25</td><td>41.7143</td><td>60.2857</td><td>1922-10-12</td></tr><tr><td>847880</td><td>41</td><td>38.8571</td><td>58.5714</td><td>1922-10-19</td></tr><tr><td>847964</td><td>71</td><td>39.4286</td><td>53.2857</td><td>1922-10-26</td></tr><tr><td>848049</td><td>56</td><td>42.7143</td><td>54.2857</td><td>1922-11-02</td></tr><tr><td>848134</td><td>63</td><td>39.5714</td><td>56.1429</td><td>1922-11-09</td></tr><tr><td>848218</td><td>45</td><td>33.8571</td><td>44.8571</td><td>1922-11-16</td></tr><tr><td>848303</td><td>53</td><td>31.7143</td><td>46</td><td>1922-11-23</td></tr><tr><td>848388</td><td>75</td><td>25.5714</td><td>36.5714</td><td>1922-11-30</td></tr><tr><td>848472</td><td>62</td><td>22</td><td>35.7143</td><td>1922-12-07</td></tr><tr><td>848557</td><td>81</td><td>21.1429</td><td>32.4286</td><td>1922-12-14</td></tr><tr><td>848642</td><td>70</td><td>25.25</td><td>38.375</td><td>1922-12-21</td></tr><tr><td>848726</td><td>63</td><td>23.4286</td><td>36.1429</td><td>1922-12-28</td></tr><tr><td>848811</td><td>53</td><td>19.8571</td><td>32.2857</td><td>1923-01-04</td></tr><tr><td>848896</td><td>86</td><td>21.7143</td><td>39.2857</td><td>1923-01-11</td></tr><tr><td>848980</td><td>52</td><td>16</td><td>31.8571</td><td>1923-01-18</td></tr><tr><td>849065</td><td>91</td><td>19.7143</td><td>33.8571</td><td>1923-01-25</td></tr><tr><td>849149</td><td>121</td><td>16.8571</td><td>29.8571</td><td>1923-02-01</td></tr><tr><td>849234</td><td>142</td><td>9.85714</td><td>23.8571</td><td>1923-02-08</td></tr><tr><td>849319</td><td>116</td><td>12.7143</td><td>30.7143</td><td>1923-02-15</td></tr><tr><td>849403</td><td>105</td><td>32</td><td>42.7143</td><td>1923-02-22</td></tr><tr><td>849488</td><td>115</td><td>19.5714</td><td>35</td><td>1923-03-01</td></tr><tr><td>849573</td><td>116</td><td>28.4286</td><td>42.1429</td><td>1923-03-08</td></tr><tr><td>849657</td><td>111</td><td>28.8571</td><td>50.2857</td><td>1923-03-15</td></tr><tr><td>849742</td><td>145</td><td>17.5714</td><td>38.1429</td><td>1923-03-22</td></tr><tr><td>849827</td><td>178</td><td>39.2857</td><td>62.4286</td><td>1923-03-29</td></tr><tr><td>849911</td><td>185</td><td>31.5714</td><td>47.4286</td><td>1923-04-05</td></tr><tr><td>849996</td><td>150</td><td>41</td><td>64.7143</td><td>1923-04-12</td></tr><tr><td>850080</td><td>334</td><td>43.7143</td><td>59.5714</td><td>1923-04-19</td></tr><tr><td>850165</td><td>242</td><td>47.7143</td><td>60.8571</td><td>1923-04-26</td></tr><tr><td>850250</td><td>78</td><td>44.2857</td><td>63.5714</td><td>1923-05-03</td></tr><tr><td>850334</td><td>278</td><td>49.4286</td><td>69.7143</td><td>1923-05-10</td></tr><tr><td>850419</td><td>270</td><td>52.8571</td><td>72.2857</td><td>1923-05-17</td></tr><tr><td>850504</td><td>306</td><td>53.4286</td><td>73</td><td>1923-05-24</td></tr><tr><td>850588</td><td>203</td><td>56.4286</td><td>75</td><td>1923-05-31</td></tr><tr><td>850673</td><td>210</td><td>55</td><td>72.5714</td><td>1923-06-07</td></tr><tr><td>850758</td><td>140</td><td>64.7143</td><td>85.1429</td><td>1923-06-14</td></tr><tr><td>850842</td><td>110</td><td>62.5714</td><td>80.7143</td><td>1923-06-21</td></tr><tr><td>850927</td><td>68</td><td>61.1429</td><td>74.8571</td><td>1923-06-28</td></tr><tr><td>851012</td><td>49</td><td>65.1429</td><td>83.4286</td><td>1923-07-05</td></tr><tr><td>851096</td><td>69</td><td>65.2857</td><td>87.4286</td><td>1923-07-12</td></tr><tr><td>851181</td><td>36</td><td>59</td><td>72.5714</td><td>1923-07-19</td></tr><tr><td>851266</td><td>20</td><td>62.8571</td><td>78.1429</td><td>1923-07-26</td></tr><tr><td>851350</td><td>28</td><td>63.4286</td><td>79.7143</td><td>1923-08-02</td></tr><tr><td>851435</td><td>14</td><td>55.8571</td><td>73.8571</td><td>1923-08-09</td></tr><tr><td>851519</td><td>11</td><td>61.8571</td><td>76.7143</td><td>1923-08-16</td></tr><tr><td>851604</td><td>8</td><td>59</td><td>73.5714</td><td>1923-08-23</td></tr><tr><td>851689</td><td>8</td><td>54.4286</td><td>68.4286</td><td>1923-08-30</td></tr><tr><td>851773</td><td>11</td><td>55.7143</td><td>71.4286</td><td>1923-09-06</td></tr><tr><td>851858</td><td>12</td><td>56.5714</td><td>72.1429</td><td>1923-09-13</td></tr><tr><td>851943</td><td>9</td><td>46.7143</td><td>66.5714</td><td>1923-09-20</td></tr><tr><td>852027</td><td>10</td><td>49.5714</td><td>66.5714</td><td>1923-09-27</td></tr><tr><td>852112</td><td>25</td><td>49.2857</td><td>63.8571</td><td>1923-10-04</td></tr><tr><td>852197</td><td>43</td><td>45.7143</td><td>58</td><td>1923-10-11</td></tr><tr><td>852281</td><td>32</td><td>38.7143</td><td>56.8571</td><td>1923-10-18</td></tr><tr><td>852366</td><td>39</td><td>38.8571</td><td>52</td><td>1923-10-25</td></tr><tr><td>852450</td><td>37</td><td>41.2857</td><td>48.5714</td><td>1923-11-01</td></tr><tr><td>852535</td><td>43</td><td>36.5714</td><td>51.5714</td><td>1923-11-08</td></tr><tr><td>852620</td><td>46</td><td>37.2857</td><td>53.1429</td><td>1923-11-15</td></tr><tr><td>852704</td><td>51</td><td>43.1429</td><td>53</td><td>1923-11-22</td></tr><tr><td>852789</td><td>52</td><td>32.5714</td><td>47.7143</td><td>1923-11-29</td></tr><tr><td>852874</td><td>34</td><td>33</td><td>45.5714</td><td>1923-12-06</td></tr><tr><td>852958</td><td>57</td><td>27.25</td><td>39.25</td><td>1923-12-13</td></tr><tr><td>853043</td><td>118</td><td>20.8571</td><td>35.5714</td><td>1923-12-20</td></tr><tr><td>853128</td><td>99</td><td>32.1429</td><td>46.4286</td><td>1923-12-27</td></tr><tr><td>853212</td><td>117</td><td>25.5714</td><td>43.7143</td><td>1924-01-03</td></tr><tr><td>853297</td><td>1</td><td>25.5714</td><td>43.7143</td><td>1924-01-10</td></tr><tr><td>853382</td><td>105</td><td>11.5714</td><td>32.4286</td><td>1924-01-17</td></tr><tr><td>853466</td><td>150</td><td>26.2857</td><td>41.7143</td><td>1924-01-24</td></tr><tr><td>853551</td><td>157</td><td>20.2857</td><td>32.4286</td><td>1924-01-31</td></tr><tr><td>853635</td><td>180</td><td>15.4286</td><td>30</td><td>1924-02-07</td></tr><tr><td>853720</td><td>197</td><td>17.5714</td><td>32.1429</td><td>1924-02-14</td></tr><tr><td>853805</td><td>233</td><td>26</td><td>39.1429</td><td>1924-02-21</td></tr><tr><td>853889</td><td>181</td><td>35</td><td>44.2857</td><td>1924-02-28</td></tr><tr><td>853974</td><td>242</td><td>26.1429</td><td>38</td><td>1924-03-06</td></tr><tr><td>854059</td><td>197</td><td>34</td><td>46.8571</td><td>1924-03-13</td></tr><tr><td>854143</td><td>198</td><td>34.2857</td><td>46.5714</td><td>1924-03-20</td></tr><tr><td>854228</td><td>149</td><td>35.7143</td><td>51.2857</td><td>1924-03-27</td></tr><tr><td>854313</td><td>149</td><td>40.5714</td><td>56.2857</td><td>1924-04-03</td></tr><tr><td>854397</td><td>156</td><td>39.5714</td><td>53.8571</td><td>1924-04-10</td></tr><tr><td>854482</td><td>185</td><td>42.2857</td><td>57.4286</td><td>1924-04-17</td></tr><tr><td>854566</td><td>194</td><td>45.7143</td><td>63.1429</td><td>1924-04-24</td></tr><tr><td>854651</td><td>193</td><td>44.2857</td><td>52.2857</td><td>1924-05-01</td></tr><tr><td>854736</td><td>164</td><td>53.2857</td><td>69.8571</td><td>1924-05-08</td></tr><tr><td>854820</td><td>183</td><td>47.7143</td><td>62.2857</td><td>1924-05-15</td></tr><tr><td>854905</td><td>117</td><td>51.8571</td><td>71</td><td>1924-05-22</td></tr><tr><td>854990</td><td>165</td><td>55.4286</td><td>70.5714</td><td>1924-05-29</td></tr><tr><td>855074</td><td>104</td><td>53.4286</td><td>66.1429</td><td>1924-06-05</td></tr><tr><td>855159</td><td>111</td><td>61.8571</td><td>80.8571</td><td>1924-06-12</td></tr><tr><td>855244</td><td>70</td><td>63.7143</td><td>83.1429</td><td>1924-06-19</td></tr><tr><td>855328</td><td>45</td><td>61.5714</td><td>75</td><td>1924-06-26</td></tr><tr><td>855413</td><td>41</td><td>68.8571</td><td>85.8571</td><td>1924-07-03</td></tr><tr><td>855498</td><td>22</td><td>61.8571</td><td>82.7143</td><td>1924-07-10</td></tr><tr><td>855582</td><td>18</td><td>66.4286</td><td>86.2857</td><td>1924-07-17</td></tr><tr><td>855667</td><td>21</td><td>61.8571</td><td>79.8571</td><td>1924-07-24</td></tr><tr><td>855752</td><td>3</td><td>69.7143</td><td>87.7143</td><td>1924-07-31</td></tr><tr><td>855836</td><td>17</td><td>60.7143</td><td>72.2857</td><td>1924-08-07</td></tr><tr><td>855921</td><td>18</td><td>62.2857</td><td>76</td><td>1924-08-14</td></tr><tr><td>856005</td><td>16</td><td>68</td><td>86.4286</td><td>1924-08-21</td></tr><tr><td>856090</td><td>8</td><td>55.8571</td><td>73</td><td>1924-08-28</td></tr><tr><td>856175</td><td>9</td><td>56.5714</td><td>71.7143</td><td>1924-09-04</td></tr><tr><td>856259</td><td>4</td><td>53</td><td>65.8571</td><td>1924-09-11</td></tr><tr><td>856344</td><td>6</td><td>48.4286</td><td>66</td><td>1924-09-18</td></tr><tr><td>856429</td><td>10</td><td>53</td><td>70.8571</td><td>1924-09-25</td></tr><tr><td>856513</td><td>19</td><td>48.4286</td><td>63.7143</td><td>1924-10-02</td></tr><tr><td>856598</td><td>17</td><td>42.2857</td><td>60.2857</td><td>1924-10-09</td></tr><tr><td>856683</td><td>18</td><td>44.4286</td><td>63.7143</td><td>1924-10-16</td></tr><tr><td>856767</td><td>27</td><td>43</td><td>58.5714</td><td>1924-10-23</td></tr><tr><td>856852</td><td>29</td><td>41.1429</td><td>57.7143</td><td>1924-10-30</td></tr><tr><td>856936</td><td>28</td><td>36.4286</td><td>52.1429</td><td>1924-11-06</td></tr><tr><td>857021</td><td>41</td><td>33.7143</td><td>49.1429</td><td>1924-11-13</td></tr><tr><td>857106</td><td>39</td><td>32.4286</td><td>42.7143</td><td>1924-11-20</td></tr><tr><td>857190</td><td>41</td><td>31.5714</td><td>46.1429</td><td>1924-11-27</td></tr><tr><td>857275</td><td>59</td><td>26.5714</td><td>40.7143</td><td>1924-12-04</td></tr><tr><td>857360</td><td>36</td><td>20.5714</td><td>35.7143</td><td>1924-12-11</td></tr><tr><td>857444</td><td>41</td><td>16.8889</td><td>34.8889</td><td>1924-12-18</td></tr><tr><td>857529</td><td>80</td><td>23.8571</td><td>34.8571</td><td>1924-12-25</td></tr><tr><td>857614</td><td>88</td><td>22.8571</td><td>36.8571</td><td>1925-01-01</td></tr><tr><td>857698</td><td>135</td><td>16.4286</td><td>31.2857</td><td>1925-01-08</td></tr><tr><td>857783</td><td>117</td><td>13.7143</td><td>34.5714</td><td>1925-01-15</td></tr><tr><td>857868</td><td>148</td><td>22.2857</td><td>36.4286</td><td>1925-01-22</td></tr><tr><td>857952</td><td>175</td><td>36.8571</td><td>51.5714</td><td>1925-01-29</td></tr><tr><td>858037</td><td>199</td><td>31.5714</td><td>45.8571</td><td>1925-02-05</td></tr><tr><td>858122</td><td>143</td><td>34.8571</td><td>50</td><td>1925-02-12</td></tr><tr><td>858206</td><td>225</td><td>17.2857</td><td>39.5714</td><td>1925-02-19</td></tr><tr><td>858291</td><td>147</td><td>38.4286</td><td>50</td><td>1925-02-26</td></tr><tr><td>858375</td><td>220</td><td>33.2857</td><td>51.4286</td><td>1925-03-05</td></tr><tr><td>858460</td><td>215</td><td>36</td><td>52.8571</td><td>1925-03-12</td></tr><tr><td>858545</td><td>266</td><td>40.8571</td><td>56.5714</td><td>1925-03-19</td></tr><tr><td>858629</td><td>344</td><td>37</td><td>55.5714</td><td>1925-03-26</td></tr><tr><td>858714</td><td>277</td><td>40.8571</td><td>58.5714</td><td>1925-04-02</td></tr><tr><td>858799</td><td>402</td><td>38</td><td>55.2857</td><td>1925-04-09</td></tr><tr><td>858883</td><td>302</td><td>49.7143</td><td>66.4286</td><td>1925-04-16</td></tr><tr><td>858968</td><td>296</td><td>45.4286</td><td>62</td><td>1925-04-23</td></tr><tr><td>859053</td><td>286</td><td>48.4286</td><td>66.1429</td><td>1925-04-30</td></tr><tr><td>859137</td><td>264</td><td>49</td><td>67</td><td>1925-05-07</td></tr><tr><td>859222</td><td>235</td><td>47.1429</td><td>65</td><td>1925-05-14</td></tr><tr><td>859306</td><td>220</td><td>55.8571</td><td>76.4286</td><td>1925-05-21</td></tr><tr><td>859391</td><td>188</td><td>64.8571</td><td>85.8571</td><td>1925-05-28</td></tr><tr><td>859476</td><td>136</td><td>59.4286</td><td>80.7143</td><td>1925-06-04</td></tr><tr><td>859560</td><td>75</td><td>60.1429</td><td>78.2857</td><td>1925-06-11</td></tr><tr><td>859645</td><td>59</td><td>62.8571</td><td>81.4286</td><td>1925-06-18</td></tr><tr><td>859730</td><td>52</td><td>66.1429</td><td>82.5714</td><td>1925-06-25</td></tr><tr><td>859814</td><td>28</td><td>67.4286</td><td>81.5714</td><td>1925-07-02</td></tr><tr><td>859899</td><td>30</td><td>63</td><td>77.2857</td><td>1925-07-09</td></tr><tr><td>859984</td><td>30</td><td>63.1429</td><td>80.8571</td><td>1925-07-16</td></tr><tr><td>860068</td><td>18</td><td>64.1429</td><td>78</td><td>1925-07-23</td></tr><tr><td>860153</td><td>11</td><td>65.1429</td><td>79.7143</td><td>1925-07-30</td></tr><tr><td>860238</td><td>10</td><td>60.1429</td><td>81.8571</td><td>1925-08-06</td></tr><tr><td>860322</td><td>6</td><td>59</td><td>80</td><td>1925-08-13</td></tr><tr><td>860407</td><td>13</td><td>57.8571</td><td>69.4286</td><td>1925-08-20</td></tr><tr><td>860492</td><td>4</td><td>63.1429</td><td>78.4286</td><td>1925-08-27</td></tr><tr><td>860576</td><td>4</td><td>52.7143</td><td>69.5714</td><td>1925-09-03</td></tr><tr><td>860661</td><td>12</td><td>47.5714</td><td>67.8571</td><td>1925-09-10</td></tr><tr><td>860745</td><td>21</td><td>46.8571</td><td>60.7143</td><td>1925-09-17</td></tr><tr><td>860830</td><td>25</td><td>40.8571</td><td>56.4286</td><td>1925-09-24</td></tr><tr><td>860915</td><td>33</td><td>44</td><td>62</td><td>1925-10-01</td></tr><tr><td>860999</td><td>63</td><td>40.1429</td><td>53.8571</td><td>1925-10-08</td></tr><tr><td>861084</td><td>48</td><td>33.8571</td><td>45.8571</td><td>1925-10-15</td></tr><tr><td>861169</td><td>57</td><td>37.5714</td><td>54.5714</td><td>1925-10-22</td></tr><tr><td>861253</td><td>93</td><td>43.1429</td><td>57.1429</td><td>1925-10-29</td></tr><tr><td>861338</td><td>85</td><td>35.7143</td><td>50.4286</td><td>1925-11-05</td></tr><tr><td>861423</td><td>152</td><td>28.1429</td><td>41.8571</td><td>1925-11-12</td></tr><tr><td>861507</td><td>143</td><td>38.4286</td><td>48.1429</td><td>1925-11-19</td></tr><tr><td>861592</td><td>158</td><td>25.2857</td><td>38.7143</td><td>1925-11-26</td></tr><tr><td>861676</td><td>116</td><td>30.7143</td><td>41</td><td>1925-12-03</td></tr><tr><td>861761</td><td>172</td><td>15.875</td><td>30.5</td><td>1925-12-10</td></tr><tr><td>861846</td><td>200</td><td>29.4286</td><td>41.2857</td><td>1925-12-17</td></tr><tr><td>861930</td><td>160</td><td>18.8571</td><td>32.1429</td><td>1925-12-24</td></tr><tr><td>862015</td><td>163</td><td>32.5714</td><td>46.8571</td><td>1925-12-31</td></tr><tr><td>862100</td><td>158</td><td>17.1429</td><td>34.2857</td><td>1926-01-07</td></tr><tr><td>862184</td><td>172</td><td>18.1429</td><td>33.4286</td><td>1926-01-14</td></tr><tr><td>862269</td><td>147</td><td>15.2857</td><td>31.1429</td><td>1926-01-21</td></tr><tr><td>862354</td><td>193</td><td>24.8571</td><td>39.4286</td><td>1926-01-28</td></tr><tr><td>862438</td><td>131</td><td>21.1429</td><td>35.1429</td><td>1926-02-04</td></tr><tr><td>862523</td><td>191</td><td>24.5714</td><td>39</td><td>1926-02-11</td></tr><tr><td>862608</td><td>157</td><td>21</td><td>37.5714</td><td>1926-02-18</td></tr><tr><td>862692</td><td>190</td><td>23.1429</td><td>36.7143</td><td>1926-02-25</td></tr><tr><td>862777</td><td>131</td><td>34.7143</td><td>50.1429</td><td>1926-03-04</td></tr><tr><td>862861</td><td>161</td><td>31.1429</td><td>43</td><td>1926-03-11</td></tr><tr><td>862946</td><td>180</td><td>34.7143</td><td>45.2857</td><td>1926-03-18</td></tr><tr><td>863031</td><td>191</td><td>32.2857</td><td>51.4286</td><td>1926-03-25</td></tr><tr><td>863115</td><td>174</td><td>33.5714</td><td>55.1429</td><td>1926-04-01</td></tr><tr><td>863200</td><td>186</td><td>43.2857</td><td>62.1429</td><td>1926-04-08</td></tr><tr><td>863285</td><td>166</td><td>45</td><td>65</td><td>1926-04-15</td></tr><tr><td>863369</td><td>158</td><td>45.4286</td><td>62.4286</td><td>1926-04-22</td></tr><tr><td>863454</td><td>128</td><td>50</td><td>63.4286</td><td>1926-04-29</td></tr><tr><td>863539</td><td>148</td><td>48.7143</td><td>66.1429</td><td>1926-05-06</td></tr><tr><td>863623</td><td>96</td><td>51.7143</td><td>67.4286</td><td>1926-05-13</td></tr><tr><td>863708</td><td>93</td><td>51.8571</td><td>67.8571</td><td>1926-05-20</td></tr><tr><td>863792</td><td>93</td><td>53.7143</td><td>70.5714</td><td>1926-05-27</td></tr><tr><td>863877</td><td>88</td><td>54.8571</td><td>73.4286</td><td>1926-06-03</td></tr><tr><td>863962</td><td>68</td><td>63.7143</td><td>82</td><td>1926-06-10</td></tr><tr><td>864046</td><td>48</td><td>63.4286</td><td>79.1429</td><td>1926-06-17</td></tr><tr><td>864131</td><td>32</td><td>59.2857</td><td>73.7143</td><td>1926-06-24</td></tr><tr><td>864216</td><td>16</td><td>64.7143</td><td>86.7143</td><td>1926-07-01</td></tr><tr><td>864300</td><td>20</td><td>64.2857</td><td>77.2857</td><td>1926-07-08</td></tr><tr><td>864385</td><td>18</td><td>63.8571</td><td>78.1429</td><td>1926-07-15</td></tr><tr><td>864470</td><td>23</td><td>65.7143</td><td>79.8571</td><td>1926-07-22</td></tr><tr><td>864554</td><td>15</td><td>62.1429</td><td>76.5714</td><td>1926-07-29</td></tr><tr><td>864639</td><td>13</td><td>59.7143</td><td>71</td><td>1926-08-05</td></tr><tr><td>864724</td><td>7</td><td>60.4286</td><td>77.5714</td><td>1926-08-12</td></tr><tr><td>864808</td><td>5</td><td>56.7143</td><td>70.5714</td><td>1926-08-19</td></tr><tr><td>864893</td><td>6</td><td>53.4286</td><td>71.4286</td><td>1926-08-26</td></tr><tr><td>864978</td><td>7</td><td>55.4286</td><td>68.8571</td><td>1926-09-02</td></tr><tr><td>865062</td><td>4</td><td>53.8571</td><td>68.7143</td><td>1926-09-09</td></tr><tr><td>865147</td><td>12</td><td>53.8571</td><td>71.7143</td><td>1926-09-16</td></tr><tr><td>865231</td><td>5</td><td>44.7143</td><td>62.7143</td><td>1926-09-23</td></tr><tr><td>865316</td><td>6</td><td>39.7143</td><td>53.8571</td><td>1926-09-30</td></tr><tr><td>865401</td><td>6</td><td>40.5714</td><td>59.4286</td><td>1926-10-07</td></tr><tr><td>865485</td><td>7</td><td>38.8571</td><td>55.8571</td><td>1926-10-14</td></tr><tr><td>865570</td><td>7</td><td>38</td><td>57.2857</td><td>1926-10-21</td></tr><tr><td>865655</td><td>2</td><td>39.8571</td><td>54</td><td>1926-10-28</td></tr><tr><td>865739</td><td>8</td><td>34.4286</td><td>47.2857</td><td>1926-11-04</td></tr><tr><td>865824</td><td>5</td><td>30</td><td>50.4286</td><td>1926-11-11</td></tr><tr><td>865909</td><td>14</td><td>14.4286</td><td>32.8571</td><td>1926-11-18</td></tr><tr><td>865993</td><td>12</td><td>27.2857</td><td>38.2857</td><td>1926-11-25</td></tr><tr><td>866078</td><td>15</td><td>17</td><td>32.2857</td><td>1926-12-02</td></tr><tr><td>866162</td><td>21</td><td>23.75</td><td>38.5</td><td>1926-12-09</td></tr><tr><td>866247</td><td>26</td><td>25.1429</td><td>36.1429</td><td>1926-12-16</td></tr><tr><td>866332</td><td>23</td><td>19</td><td>32.2857</td><td>1926-12-23</td></tr><tr><td>866416</td><td>37</td><td>26.2857</td><td>41</td><td>1926-12-30</td></tr><tr><td>866501</td><td>35</td><td>16.8571</td><td>38</td><td>1927-01-06</td></tr><tr><td>866586</td><td>43</td><td>30.4286</td><td>47</td><td>1927-01-13</td></tr><tr><td>866670</td><td>54</td><td>25.4286</td><td>37.5714</td><td>1927-01-20</td></tr><tr><td>866755</td><td>35</td><td>28</td><td>39.4286</td><td>1927-01-27</td></tr><tr><td>866840</td><td>44</td><td>23.7143</td><td>36.4286</td><td>1927-02-03</td></tr><tr><td>866924</td><td>41</td><td>22.7143</td><td>37</td><td>1927-02-10</td></tr><tr><td>867009</td><td>52</td><td>33.2857</td><td>49.4286</td><td>1927-02-17</td></tr><tr><td>867094</td><td>58</td><td>42.1429</td><td>62.4286</td><td>1927-02-24</td></tr><tr><td>867178</td><td>59</td><td>32</td><td>45.5714</td><td>1927-03-03</td></tr><tr><td>867263</td><td>71</td><td>35.8571</td><td>49.7143</td><td>1927-03-10</td></tr><tr><td>867348</td><td>88</td><td>32.7143</td><td>47.2857</td><td>1927-03-17</td></tr><tr><td>867432</td><td>82</td><td>35.7143</td><td>55.2857</td><td>1927-03-24</td></tr><tr><td>867517</td><td>93</td><td>45.7143</td><td>72.8571</td><td>1927-03-31</td></tr><tr><td>867601</td><td>108</td><td>40.4286</td><td>57.1429</td><td>1927-04-07</td></tr><tr><td>867686</td><td>92</td><td>43.1429</td><td>59.7143</td><td>1927-04-14</td></tr><tr><td>867771</td><td>127</td><td>47.7143</td><td>65</td><td>1927-04-21</td></tr><tr><td>867855</td><td>166</td><td>49</td><td>59.8571</td><td>1927-04-28</td></tr><tr><td>867940</td><td>152</td><td>49.8571</td><td>63.1429</td><td>1927-05-05</td></tr><tr><td>868025</td><td>124</td><td>50.8571</td><td>66.8571</td><td>1927-05-12</td></tr><tr><td>868109</td><td>152</td><td>57</td><td>79.5714</td><td>1927-05-19</td></tr><tr><td>868194</td><td>131</td><td>56.8571</td><td>72.8571</td><td>1927-05-26</td></tr><tr><td>868279</td><td>110</td><td>58</td><td>73.7143</td><td>1927-06-02</td></tr><tr><td>868363</td><td>116</td><td>56.5714</td><td>69.5714</td><td>1927-06-09</td></tr><tr><td>868448</td><td>111</td><td>59.1429</td><td>74.7143</td><td>1927-06-16</td></tr><tr><td>868532</td><td>87</td><td>66.2857</td><td>84.5714</td><td>1927-06-23</td></tr><tr><td>868617</td><td>63</td><td>65.4286</td><td>79.8571</td><td>1927-06-30</td></tr><tr><td>868702</td><td>68</td><td>66.4286</td><td>84.2857</td><td>1927-07-07</td></tr><tr><td>868786</td><td>33</td><td>60.7143</td><td>78.1429</td><td>1927-07-14</td></tr><tr><td>868871</td><td>22</td><td>61.7143</td><td>79</td><td>1927-07-21</td></tr><tr><td>868956</td><td>30</td><td>59.1429</td><td>74.2857</td><td>1927-07-28</td></tr><tr><td>869040</td><td>21</td><td>58.8571</td><td>71.7143</td><td>1927-08-04</td></tr><tr><td>869125</td><td>20</td><td>61</td><td>72.7143</td><td>1927-08-11</td></tr><tr><td>869210</td><td>22</td><td>61</td><td>79.4286</td><td>1927-08-18</td></tr><tr><td>869294</td><td>11</td><td>55.1429</td><td>71.1429</td><td>1927-08-25</td></tr><tr><td>869379</td><td>14</td><td>55.1429</td><td>70.8571</td><td>1927-09-01</td></tr><tr><td>869464</td><td>16</td><td>52.8571</td><td>71.8571</td><td>1927-09-08</td></tr><tr><td>869548</td><td>44</td><td>60.4286</td><td>78.8571</td><td>1927-09-15</td></tr><tr><td>869633</td><td>43</td><td>48.4286</td><td>64</td><td>1927-09-22</td></tr><tr><td>869718</td><td>76</td><td>48</td><td>61.2857</td><td>1927-09-29</td></tr><tr><td>869802</td><td>74</td><td>44.5714</td><td>64</td><td>1927-10-06</td></tr><tr><td>869887</td><td>92</td><td>47.5714</td><td>67.4286</td><td>1927-10-13</td></tr><tr><td>869971</td><td>116</td><td>35.1429</td><td>49.2857</td><td>1927-10-20</td></tr><tr><td>870056</td><td>138</td><td>47.5714</td><td>66.4286</td><td>1927-10-27</td></tr><tr><td>870141</td><td>160</td><td>35.4286</td><td>49.1429</td><td>1927-11-03</td></tr><tr><td>870225</td><td>188</td><td>39.1429</td><td>56</td><td>1927-11-10</td></tr><tr><td>870310</td><td>185</td><td>24.5714</td><td>43.7143</td><td>1927-11-17</td></tr><tr><td>870395</td><td>219</td><td>31.5714</td><td>45</td><td>1927-11-24</td></tr><tr><td>870479</td><td>197</td><td>26.5714</td><td>38.2857</td><td>1927-12-01</td></tr><tr><td>870564</td><td>266</td><td>28.625</td><td>45.375</td><td>1927-12-08</td></tr><tr><td>870649</td><td>324</td><td>22</td><td>39</td><td>1927-12-15</td></tr><tr><td>870733</td><td>336</td><td>40</td><td>48.7143</td><td>1927-12-22</td></tr><tr><td>870818</td><td>404</td><td>23.5714</td><td>38.4286</td><td>1927-12-29</td></tr><tr><td>870902</td><td>347</td><td>23.1429</td><td>38.8571</td><td>1928-01-05</td></tr><tr><td>870987</td><td>465</td><td>17.5714</td><td>33.4286</td><td>1928-01-12</td></tr><tr><td>871072</td><td>517</td><td>20.8571</td><td>37.5714</td><td>1928-01-19</td></tr><tr><td>871156</td><td>528</td><td>29.2857</td><td>41.8571</td><td>1928-01-26</td></tr><tr><td>871241</td><td>543</td><td>18.7143</td><td>36.7143</td><td>1928-02-02</td></tr><tr><td>871326</td><td>589</td><td>19</td><td>36.1429</td><td>1928-02-09</td></tr><tr><td>871410</td><td>455</td><td>21.1429</td><td>36.5714</td><td>1928-02-16</td></tr><tr><td>871495</td><td>649</td><td>31.8571</td><td>45.2857</td><td>1928-02-23</td></tr><tr><td>871580</td><td>409</td><td>32.7143</td><td>47.4286</td><td>1928-03-01</td></tr><tr><td>871664</td><td>472</td><td>33.7143</td><td>51.4286</td><td>1928-03-08</td></tr><tr><td>871749</td><td>353</td><td>40.8571</td><td>63.2857</td><td>1928-03-15</td></tr><tr><td>871834</td><td>332</td><td>38.2857</td><td>54.7143</td><td>1928-03-22</td></tr><tr><td>871918</td><td>260</td><td>34</td><td>55</td><td>1928-03-29</td></tr><tr><td>872003</td><td>229</td><td>37.1429</td><td>48.7143</td><td>1928-04-05</td></tr><tr><td>872088</td><td>173</td><td>46.2857</td><td>64.5714</td><td>1928-04-12</td></tr><tr><td>872172</td><td>151</td><td>46.4286</td><td>60.5714</td><td>1928-04-19</td></tr><tr><td>872257</td><td>113</td><td>47.4286</td><td>64.4286</td><td>1928-04-26</td></tr><tr><td>872341</td><td>96</td><td>46.8571</td><td>55.8571</td><td>1928-05-03</td></tr><tr><td>872426</td><td>87</td><td>53.2857</td><td>72.2857</td><td>1928-05-10</td></tr><tr><td>872511</td><td>51</td><td>55.2857</td><td>67.5714</td><td>1928-05-17</td></tr><tr><td>872595</td><td>31</td><td>55.2857</td><td>67.5714</td><td>1928-05-24</td></tr><tr><td>872680</td><td>47</td><td>56.8571</td><td>79.1429</td><td>1928-05-31</td></tr><tr><td>872765</td><td>39</td><td>55</td><td>64.7143</td><td>1928-06-07</td></tr><tr><td>872849</td><td>37</td><td>62.7143</td><td>77</td><td>1928-06-14</td></tr><tr><td>872934</td><td>26</td><td>67.7143</td><td>84.2857</td><td>1928-06-21</td></tr><tr><td>873019</td><td>17</td><td>66.4286</td><td>83.7143</td><td>1928-06-28</td></tr><tr><td>873103</td><td>16</td><td>64.1429</td><td>77</td><td>1928-07-05</td></tr><tr><td>873188</td><td>9</td><td>66.5714</td><td>85.2857</td><td>1928-07-12</td></tr><tr><td>873272</td><td>5</td><td>62.1429</td><td>76.5714</td><td>1928-07-19</td></tr><tr><td>873357</td><td>4</td><td>68</td><td>86</td><td>1928-07-26</td></tr><tr><td>873442</td><td>4</td><td>64</td><td>74.4286</td><td>1928-08-02</td></tr><tr><td>873526</td><td>4</td><td>58</td><td>73.2857</td><td>1928-08-09</td></tr><tr><td>873611</td><td>3</td><td>56.5714</td><td>73.2857</td><td>1928-08-16</td></tr><tr><td>873696</td><td>2</td><td>59.1429</td><td>73</td><td>1928-08-23</td></tr><tr><td>873780</td><td>8</td><td>46.8571</td><td>62</td><td>1928-08-30</td></tr><tr><td>873865</td><td>3</td><td>50.7143</td><td>66.4286</td><td>1928-09-06</td></tr><tr><td>873950</td><td>8</td><td>48.8571</td><td>71.2857</td><td>1928-09-13</td></tr><tr><td>874034</td><td>2</td><td>54</td><td>73.2857</td><td>1928-09-20</td></tr><tr><td>874119</td><td>6</td><td>43.4286</td><td>60.1429</td><td>1928-09-27</td></tr><tr><td>874204</td><td>3</td><td>38.7143</td><td>53.1429</td><td>1928-10-04</td></tr><tr><td>874288</td><td>1</td><td>39.5714</td><td>52.5714</td><td>1928-10-11</td></tr><tr><td>874373</td><td>1</td><td>43.1429</td><td>59.4286</td><td>1928-10-18</td></tr><tr><td>874457</td><td>16</td><td>35.4286</td><td>50.5714</td><td>1928-10-25</td></tr><tr><td>874542</td><td>6</td><td>28</td><td>43.8571</td><td>1928-11-01</td></tr><tr><td>874627</td><td>16</td><td>33.8571</td><td>44.4286</td><td>1928-11-08</td></tr><tr><td>874711</td><td>10</td><td>31.1429</td><td>42.7143</td><td>1928-11-15</td></tr><tr><td>874796</td><td>10</td><td>32.4286</td><td>48.2857</td><td>1928-11-22</td></tr><tr><td>874881</td><td>7</td><td>30.75</td><td>44</td><td>1928-11-29</td></tr><tr><td>874965</td><td>8</td><td>22.8571</td><td>41.1429</td><td>1928-12-06</td></tr><tr><td>875050</td><td>13</td><td>19.4286</td><td>35.1429</td><td>1928-12-13</td></tr><tr><td>875135</td><td>9</td><td>23.1429</td><td>40.1429</td><td>1928-12-20</td></tr><tr><td>875219</td><td>24</td><td>21.5714</td><td>34.7143</td><td>1928-12-27</td></tr><tr><td>875304</td><td>8</td><td>19.8571</td><td>31.2857</td><td>1929-01-03</td></tr><tr><td>875388</td><td>29</td><td>29.1429</td><td>41.8571</td><td>1929-01-10</td></tr><tr><td>875473</td><td>13</td><td>25.5714</td><td>39.4286</td><td>1929-01-17</td></tr><tr><td>875558</td><td>6</td><td>19.1429</td><td>34.2857</td><td>1929-01-24</td></tr><tr><td>875642</td><td>29</td><td>32.7143</td><td>44.7143</td><td>1929-01-31</td></tr><tr><td>875727</td><td>19</td><td>22.7143</td><td>39.5714</td><td>1929-02-07</td></tr><tr><td>875812</td><td>30</td><td>32.7143</td><td>50.7143</td><td>1929-02-14</td></tr><tr><td>875896</td><td>20</td><td>38.4286</td><td>58.1429</td><td>1929-02-21</td></tr><tr><td>875981</td><td>10</td><td>39.2857</td><td>54.2857</td><td>1929-02-28</td></tr><tr><td>876066</td><td>21</td><td>39.8571</td><td>61.8571</td><td>1929-03-07</td></tr><tr><td>876150</td><td>12</td><td>34.2857</td><td>44</td><td>1929-03-14</td></tr><tr><td>876235</td><td>17</td><td>38.5714</td><td>47.4286</td><td>1929-03-21</td></tr><tr><td>876320</td><td>29</td><td>45.8571</td><td>63</td><td>1929-03-28</td></tr><tr><td>876404</td><td>15</td><td>46.2857</td><td>64.5714</td><td>1929-04-04</td></tr><tr><td>876489</td><td>15</td><td>47</td><td>66.2857</td><td>1929-04-11</td></tr><tr><td>876574</td><td>31</td><td>46.2857</td><td>69.7143</td><td>1929-04-18</td></tr><tr><td>876658</td><td>37</td><td>48.5714</td><td>69.2857</td><td>1929-04-25</td></tr><tr><td>876743</td><td>54</td><td>58.2857</td><td>81.5714</td><td>1929-05-02</td></tr><tr><td>876827</td><td>55</td><td>58.2857</td><td>81.5714</td><td>1929-05-09</td></tr><tr><td>876912</td><td>37</td><td>59.8571</td><td>84.4286</td><td>1929-05-16</td></tr><tr><td>876997</td><td>26</td><td>64.5714</td><td>80.2857</td><td>1929-05-23</td></tr><tr><td>877081</td><td>44</td><td>65.3333</td><td>79.8333</td><td>1929-05-30</td></tr><tr><td>877166</td><td>32</td><td>63.4286</td><td>81.5714</td><td>1929-06-06</td></tr><tr><td>877251</td><td>41</td><td>61.7143</td><td>82.5714</td><td>1929-06-13</td></tr><tr><td>877335</td><td>23</td><td>59.5714</td><td>79.7143</td><td>1929-06-20</td></tr><tr><td>877420</td><td>22</td><td>65.4286</td><td>85</td><td>1929-06-27</td></tr><tr><td>877505</td><td>13</td><td>61.2857</td><td>80.7143</td><td>1929-07-04</td></tr><tr><td>877589</td><td>7</td><td>63.1429</td><td>78.1429</td><td>1929-07-11</td></tr><tr><td>877674</td><td>4</td><td>60.1429</td><td>78.4286</td><td>1929-07-18</td></tr><tr><td>877758</td><td>5</td><td>59.5714</td><td>80.2857</td><td>1929-07-25</td></tr><tr><td>877843</td><td>6</td><td>60.1429</td><td>79.4286</td><td>1929-08-01</td></tr><tr><td>877928</td><td>6</td><td>64.4286</td><td>77.5714</td><td>1929-08-08</td></tr><tr><td>878012</td><td>4</td><td>58.2857</td><td>75.8571</td><td>1929-08-15</td></tr><tr><td>878097</td><td>8</td><td>47</td><td>63.4286</td><td>1929-08-22</td></tr><tr><td>878182</td><td>2</td><td>54.5714</td><td>73.5714</td><td>1929-08-29</td></tr><tr><td>878266</td><td>5</td><td>48.5714</td><td>65.1429</td><td>1929-09-05</td></tr><tr><td>878351</td><td>4</td><td>41.1429</td><td>59.8571</td><td>1929-09-12</td></tr><tr><td>878436</td><td>9</td><td>42.8571</td><td>64.4286</td><td>1929-09-19</td></tr><tr><td>878520</td><td>3</td><td>47.8571</td><td>63.5714</td><td>1929-09-26</td></tr><tr><td>878605</td><td>2</td><td>46.5714</td><td>57.8571</td><td>1929-10-03</td></tr><tr><td>878690</td><td>5</td><td>39.4286</td><td>52.4286</td><td>1929-10-10</td></tr><tr><td>878774</td><td>7</td><td>45</td><td>58.4286</td><td>1929-10-17</td></tr><tr><td>878859</td><td>14</td><td>30.5714</td><td>42.4286</td><td>1929-10-24</td></tr><tr><td>878944</td><td>11</td><td>25.5714</td><td>40.5714</td><td>1929-10-31</td></tr><tr><td>879028</td><td>11</td><td>26.8571</td><td>39</td><td>1929-11-07</td></tr><tr><td>879113</td><td>16</td><td>22.1429</td><td>36.4286</td><td>1929-11-14</td></tr><tr><td>879197</td><td>13</td><td>25</td><td>39.1429</td><td>1929-11-21</td></tr><tr><td>879282</td><td>19</td><td>30.625</td><td>41.875</td><td>1929-11-28</td></tr><tr><td>879367</td><td>30</td><td>30.2857</td><td>48.5714</td><td>1929-12-05</td></tr><tr><td>879451</td><td></td><td></td><td></td><td>1929-12-12</td></tr><tr><td>879536</td><td></td><td></td><td></td><td>1929-12-19</td></tr> </tbody> 


	<h2>Data</h2>
	<script type="text/javascript">
		var mychart;
		var tsly;
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
				tsly = new Slider(slider, knob, {
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
			function playdates() {
				if(tsly.step < 1000) {
					window.setTimeout(playdates,50);
					tsly.set(tsly.step + 1);
				}
			}
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