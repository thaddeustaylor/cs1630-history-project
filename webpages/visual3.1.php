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
	$tables = array("Date", "Temperature, Low", "Temperature, High", "Measles Cases", "Precipitation");
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



<table id="data" hidden="true" title="Measles in Boston 1907-1952">
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
        <tr><td>1/1/1920</td><td>15.5714</td><td>30.8571</td><td>254</td><td>0</td><tr>
<tr><td>1/8/1920</td><td>18.5714</td><td>33.1429</td><td>266</td><td>73</td><tr>
<tr><td>1/15/1920</td><td>7.14286</td><td>23.5714</td><td>337</td><td>77</td><tr>
<tr><td>1/22/1920</td><td>12.5714</td><td>31.8571</td><td>303</td><td>122</td><tr>
<tr><td>1/29/1920</td><td>12.2857</td><td>31.4286</td><td>278</td><td>0</td><tr>
<tr><td>2/5/1920</td><td>24.7143</td><td>34.8571</td><td>326</td><td>283</td><tr>
<tr><td>2/12/1920</td><td>21.8571</td><td>38.1429</td><td>264</td><td>140</td><tr>
<tr><td>2/19/1920</td><td>22.4286</td><td>34.5714</td><td>248</td><td>162</td><tr>
<tr><td>2/26/1920</td><td>12.5714</td><td>31</td><td>236</td><td>3</td><tr>
<tr><td>3/4/1920</td><td>21.7143</td><td>39.1429</td><td>199</td><td>119</td><tr>
<tr><td>3/11/1920</td><td>31.8571</td><td>48.4286</td><td>209</td><td>121</td><tr>
<tr><td>3/18/1920</td><td>33</td><td>50.7143</td><td>192</td><td>100</td><tr>
<tr><td>3/25/1920</td><td>41.5714</td><td>58.5714</td><td>246</td><td>32</td><tr>
<tr><td>4/1/1920</td><td>35.4286</td><td>47.7143</td><td>210</td><td>172</td><tr>
<tr><td>4/8/1920</td><td>33.7143</td><td>48</td><td>273</td><td>36</td><tr>
<tr><td>4/15/1920</td><td>40.1429</td><td>57.1429</td><td>193</td><td>118</td><tr>
<tr><td>4/22/1920</td><td>41</td><td>53.5714</td><td>214</td><td>242</td><tr>
<tr><td>4/29/1920</td><td>41.4286</td><td>53.2857</td><td>245</td><td>58</td><tr>
<tr><td>5/6/1920</td><td>46.7143</td><td>63.4286</td><td>242</td><td>77</td><tr>
<tr><td>5/13/1920</td><td>48</td><td>62.7143</td><td>230</td><td>36</td><tr>
<tr><td>5/20/1920</td><td>48.2857</td><td>59.2857</td><td>253</td><td>355</td><tr>
<tr><td>5/27/1920</td><td>56.2857</td><td>77.4286</td><td>191</td><td>0</td><tr>
<tr><td>6/3/1920</td><td>53.8571</td><td>65.8571</td><td>189</td><td>259</td><tr>
<tr><td>6/10/1920</td><td>58.2857</td><td>78.8571</td><td>116</td><td>65</td><tr>
<tr><td>6/17/1920</td><td>52.5714</td><td>66.2857</td><td>102</td><td>254</td><tr>
<tr><td>6/24/1920</td><td>64.4286</td><td>80.8571</td><td>58</td><td>0</td><tr>
<tr><td>7/1/1920</td><td>60.5714</td><td>77.5714</td><td>70</td><td>76</td><tr>
<tr><td>7/8/1920</td><td>67.5714</td><td>86.4286</td><td>36</td><td>0</td><tr>
<tr><td>7/15/1920</td><td>63</td><td>81.4286</td><td>51</td><td>47</td><tr>
<tr><td>7/22/1920</td><td>61.5714</td><td>78.2857</td><td>18</td><td>32</td><tr>
<tr><td>7/29/1920</td><td>64.4286</td><td>80.2857</td><td>14</td><td>49</td><tr>
<tr><td>8/5/1920</td><td>68.1429</td><td>84.5714</td><td>13</td><td>133</td><tr>
<tr><td>8/12/1920</td><td>69.2857</td><td>80.4286</td><td>5</td><td>17</td><tr>
<tr><td>8/19/1920</td><td>60.2857</td><td>72.1429</td><td>9</td><td>18</td><tr>
<tr><td>8/26/1920</td><td>63</td><td>79.2857</td><td>8</td><td>22</td><tr>
<tr><td>9/2/1920</td><td>57.4286</td><td>74.1429</td><td>4</td><td>18</td><tr>
<tr><td>9/9/1920</td><td>58.7143</td><td>70.8571</td><td>5</td><td>114</td><tr>
<tr><td>9/16/1920</td><td>51.5714</td><td>68.2857</td><td>5</td><td>2</td><tr>
<tr><td>9/23/1920</td><td>61.7143</td><td>78</td><td>6</td><td>0</td><tr>
<tr><td>9/30/1920</td><td>52.5714</td><td>70</td><td>10</td><td>120</td><tr>
<tr><td>10/7/1920</td><td>50.2857</td><td>71</td><td>7</td><td>0</td><tr>
<tr><td>10/14/1920</td><td>54.5714</td><td>66.7143</td><td>6</td><td>0</td><tr>
<tr><td>10/21/1920</td><td>51.7143</td><td>71.4286</td><td>9</td><td>0</td><tr>
<tr><td>10/28/1920</td><td>43.4286</td><td>61.7143</td><td>7</td><td>176</td><tr>
<tr><td>11/4/1920</td><td>40.1429</td><td>56.7143</td><td>14</td><td>2</td><tr>
<tr><td>11/11/1920</td><td>30.5714</td><td>44.5714</td><td>10</td><td>197</td><tr>
<tr><td>11/18/1920</td><td>34.7143</td><td>45.7143</td><td>23</td><td>249</td><tr>
<tr><td>11/25/1920</td><td>31.5714</td><td>41</td><td>22</td><td>74</td><tr>
<tr><td>12/2/1920</td><td>32.4286</td><td>44.7143</td><td>26</td><td>81</td><tr>
<tr><td>12/9/1920</td><td>34.8571</td><td>44.8571</td><td>34</td><td>128</td><tr>
<tr><td>12/16/1920</td><td>29.1429</td><td>39.4286</td><td>36</td><td>0</td><tr>
<tr><td>12/23/1920</td><td>23</td><td>37.5556</td><td>41</td><td>122</td><tr>
<tr><td>1/1/1921</td><td>32</td><td>46.2857</td><td>54</td><td>54</td><tr>
<tr><td>1/8/1921</td><td>26</td><td>40.8571</td><td>58</td><td>124</td><tr>
<tr><td>1/15/1921</td><td>19.4286</td><td>37.4286</td><td>62</td><td>4</td><tr>
<tr><td>1/22/1921</td><td>17.7143</td><td>36.7143</td><td>70</td><td>1</td><tr>
<tr><td>1/29/1921</td><td>25.8571</td><td>35.8571</td><td>54</td><td>41</td><tr>
<tr><td>2/5/1921</td><td>30</td><td>42.1429</td><td>113</td><td>85</td><tr>
<tr><td>2/12/1921</td><td>26.4286</td><td>44.1429</td><td>69</td><td>2</td><tr>
<tr><td>2/19/1921</td><td>19</td><td>34.4286</td><td>109</td><td>133</td><tr>
<tr><td>2/26/1921</td><td>32.5714</td><td>46.8571</td><td>77</td><td>57</td><tr>
<tr><td>3/5/1921</td><td>36.8571</td><td>55.2857</td><td>85</td><td>42</td><tr>
<tr><td>3/12/1921</td><td>37.5714</td><td>54.2857</td><td>101</td><td>59</td><tr>
<tr><td>3/19/1921</td><td>37.7143</td><td>60.1429</td><td>93</td><td>51</td><tr>
<tr><td>3/26/1921</td><td>35.8571</td><td>56.2857</td><td>155</td><td>63</td><tr>
<tr><td>4/2/1921</td><td>40.7143</td><td>60</td><td>131</td><td>3</td><tr>
<tr><td>4/9/1921</td><td>45.1429</td><td>61.7143</td><td>123</td><td>94</td><tr>
<tr><td>4/16/1921</td><td>43.5714</td><td>61.5714</td><td>134</td><td>90</td><tr>
<tr><td>4/23/1921</td><td>47.1429</td><td>56.2857</td><td>115</td><td>95</td><tr>
<tr><td>4/30/1921</td><td>44.1429</td><td>52.1429</td><td>110</td><td>327</td><tr>
<tr><td>5/7/1921</td><td>45.8571</td><td>59.1429</td><td>107</td><td>91</td><tr>
<tr><td>5/14/1921</td><td>51.4286</td><td>70.5714</td><td>100</td><td>21</td><tr>
<tr><td>5/21/1921</td><td>53.1429</td><td>73.7143</td><td>87</td><td>63</td><tr>
<tr><td>5/28/1921</td><td>56</td><td>75.4286</td><td>117</td><td>6</td><tr>
<tr><td>6/4/1921</td><td>56.2857</td><td>76.4286</td><td>111</td><td>0</td><tr>
<tr><td>6/11/1921</td><td>58.4286</td><td>78.2857</td><td>77</td><td>4</td><tr>
<tr><td>6/18/1921</td><td>62.5714</td><td>81.5714</td><td>105</td><td>14</td><tr>
<tr><td>6/25/1921</td><td>62.1429</td><td>71.4286</td><td>94</td><td>464</td><tr>
<tr><td>7/2/1921</td><td>65.2857</td><td>79.8571</td><td>85</td><td>30</td><tr>
<tr><td>7/9/1921</td><td>66.1429</td><td>78.1429</td><td>60</td><td>630</td><tr>
<tr><td>7/16/1921</td><td>65.1429</td><td>80</td><td>43</td><td>226</td><tr>
<tr><td>7/23/1921</td><td>69.5714</td><td>87.8571</td><td>37</td><td>151</td><tr>
<tr><td>7/30/1921</td><td>61.2857</td><td>73.7143</td><td>21</td><td>8</td><tr>
<tr><td>8/6/1921</td><td>65.4286</td><td>82.1429</td><td>13</td><td>18</td><tr>
<tr><td>8/13/1921</td><td>61.8571</td><td>79.2857</td><td>16</td><td>145</td><tr>
<tr><td>8/20/1921</td><td>58.2857</td><td>73.5714</td><td>11</td><td>0</td><tr>
<tr><td>8/27/1921</td><td>62.7143</td><td>82.7143</td><td>10</td><td>0</td><tr>
<tr><td>9/3/1921</td><td>63.2857</td><td>78.8571</td><td>16</td><td>31</td><tr>
<tr><td>9/10/1921</td><td>59</td><td>77</td><td>9</td><td>22</td><tr>
<tr><td>9/17/1921</td><td>58.5714</td><td>73.8571</td><td>10</td><td>54</td><tr>
<tr><td>9/24/1921</td><td>58.4286</td><td>75</td><td>12</td><td>15</td><tr>
<tr><td>10/1/1921</td><td>52.7143</td><td>70.5714</td><td>23</td><td>53</td><tr>
<tr><td>10/8/1921</td><td>46</td><td>65</td><td>11</td><td>14</td><tr>
<tr><td>10/15/1921</td><td>50.4286</td><td>65.1429</td><td>21</td><td>48</td><tr>
<tr><td>10/22/1921</td><td>39.1429</td><td>57.2857</td><td>21</td><td>9</td><tr>
<tr><td>10/29/1921</td><td>43.1429</td><td>54.4286</td><td>48</td><td>29</td><tr>
<tr><td>11/5/1921</td><td>33.1429</td><td>46</td><td>32</td><td>124</td><tr>
<tr><td>11/12/1921</td><td>36.5714</td><td>47.7143</td><td>54</td><td>102</td><tr>
<tr><td>11/19/1921</td><td>34.8571</td><td>52.1429</td><td>51</td><td>76</td><tr>
<tr><td>11/26/1921</td><td>32.1429</td><td>43.5714</td><td>61</td><td>328</td><tr>
<tr><td>12/3/1921</td><td>28.2857</td><td>40</td><td>45</td><td>13</td><tr>
<tr><td>12/10/1921</td><td>26.2857</td><td>37.2857</td><td>58</td><td>59</td><tr>
<tr><td>12/17/1921</td><td>21.2857</td><td>41.5714</td><td>47</td><td>65</td><tr>
<tr><td>12/24/1921</td><td>18.125</td><td>32.625</td><td>51</td><td>55</td><tr>
<tr><td>1/1/1922</td><td>19</td><td>33.5714</td><td>72</td><td>7</td><tr>
<tr><td>1/8/1922</td><td>23.1429</td><td>35.8571</td><td>63</td><td>108</td><tr>
<tr><td>1/15/1922</td><td>26.8571</td><td>39.2857</td><td>65</td><td>25</td><tr>
<tr><td>1/22/1922</td><td>9.85714</td><td>26.5714</td><td>96</td><td>1</td><tr>
<tr><td>1/29/1922</td><td>29.2857</td><td>42.8571</td><td>106</td><td>47</td><tr>
<tr><td>2/5/1922</td><td>25.4286</td><td>37</td><td>124</td><td>27</td><tr>
<tr><td>2/12/1922</td><td>12.5714</td><td>30.7143</td><td>123</td><td>75</td><tr>
<tr><td>2/19/1922</td><td>29.8571</td><td>46.5714</td><td>152</td><td>60</td><tr>
<tr><td>2/26/1922</td><td>24</td><td>39.7143</td><td>154</td><td>130</td><tr>
<tr><td>3/5/1922</td><td>34.8571</td><td>49.1429</td><td>149</td><td>102</td><tr>
<tr><td>3/12/1922</td><td>30.5714</td><td>46.8571</td><td>125</td><td>0</td><tr>
<tr><td>3/19/1922</td><td>32.5714</td><td>47.7143</td><td>140</td><td>136</td><tr>
<tr><td>3/26/1922</td><td>34.2857</td><td>51</td><td>185</td><td>260</td><tr>
<tr><td>4/2/1922</td><td>37.8571</td><td>51.4286</td><td>215</td><td>29</td><tr>
<tr><td>4/9/1922</td><td>43.2857</td><td>63.1429</td><td>218</td><td>58</td><tr>
<tr><td>4/16/1922</td><td>38.7143</td><td>57.5714</td><td>256</td><td>23</td><tr>
<tr><td>4/23/1922</td><td>40.1429</td><td>61.7143</td><td>227</td><td>0</td><tr>
<tr><td>4/30/1922</td><td>46.2857</td><td>65.1429</td><td>190</td><td>412</td><tr>
<tr><td>5/7/1922</td><td>51.2857</td><td>70.7143</td><td>207</td><td>0</td><tr>
<tr><td>5/14/1922</td><td>51</td><td>69.7143</td><td>236</td><td>122</td><tr>
<tr><td>5/21/1922</td><td>55.7143</td><td>71.1429</td><td>201</td><td>0</td><tr>
<tr><td>5/28/1922</td><td>57.1429</td><td>78</td><td>206</td><td>36</td><tr>
<tr><td>6/4/1922</td><td>66.1429</td><td>86</td><td>188</td><td>16</td><tr>
<tr><td>6/11/1922</td><td>55.2857</td><td>71.7143</td><td>160</td><td>136</td><tr>
<tr><td>6/18/1922</td><td>58.1429</td><td>70.5714</td><td>145</td><td>520</td><tr>
<tr><td>6/25/1922</td><td>65.2857</td><td>79.5714</td><td>144</td><td>97</td><tr>
<tr><td>7/2/1922</td><td>64.8571</td><td>80.2857</td><td>98</td><td>130</td><tr>
<tr><td>7/9/1922</td><td>63.1429</td><td>78.1429</td><td>105</td><td>47</td><tr>
<tr><td>7/16/1922</td><td>67.2857</td><td>82.8571</td><td>58</td><td>42</td><tr>
<tr><td>7/23/1922</td><td>62.5714</td><td>75.2857</td><td>38</td><td>44</td><tr>
<tr><td>7/30/1922</td><td>63.7143</td><td>77.8571</td><td>40</td><td>49</td><tr>
<tr><td>8/6/1922</td><td>62</td><td>73</td><td>35</td><td>48</td><tr>
<tr><td>8/13/1922</td><td>67</td><td>85.5714</td><td>24</td><td>29</td><tr>
<tr><td>8/20/1922</td><td>61.2857</td><td>78</td><td>26</td><td>122</td><tr>
<tr><td>8/27/1922</td><td>61.8571</td><td>74.2857</td><td>14</td><td>227</td><tr>
<tr><td>9/3/1922</td><td>61.4286</td><td>74.8571</td><td>8</td><td>196</td><tr>
<tr><td>9/10/1922</td><td>63</td><td>78.7143</td><td>11</td><td>170</td><tr>
<tr><td>9/17/1922</td><td>51.1429</td><td>65.8571</td><td>15</td><td>0</td><tr>
<tr><td>9/24/1922</td><td>51.5714</td><td>72.1429</td><td>34</td><td>0</td><tr>
<tr><td>10/1/1922</td><td>57.1429</td><td>74.8571</td><td>19</td><td>31</td><tr>
<tr><td>10/8/1922</td><td>51.2857</td><td>66</td><td>37</td><td>67</td><tr>
<tr><td>10/15/1922</td><td>41.7143</td><td>60.2857</td><td>25</td><td>0</td><tr>
<tr><td>10/22/1922</td><td>38.8571</td><td>58.5714</td><td>41</td><td>99</td><tr>
<tr><td>10/29/1922</td><td>39.4286</td><td>53.2857</td><td>71</td><td>0</td><tr>
<tr><td>11/5/1922</td><td>42.7143</td><td>54.2857</td><td>56</td><td>30</td><tr>
<tr><td>11/12/1922</td><td>39.5714</td><td>56.1429</td><td>63</td><td>2</td><tr>
<tr><td>11/19/1922</td><td>33.8571</td><td>44.8571</td><td>45</td><td>44</td><tr>
<tr><td>11/26/1922</td><td>31.7143</td><td>46</td><td>53</td><td>8</td><tr>
<tr><td>12/3/1922</td><td>25.5714</td><td>36.5714</td><td>75</td><td>57</td><tr>
<tr><td>12/10/1922</td><td>22</td><td>35.7143</td><td>62</td><td>73</td><tr>
<tr><td>12/17/1922</td><td>21.1429</td><td>32.4286</td><td>81</td><td>79</td><tr>
<tr><td>12/24/1922</td><td>25.25</td><td>38.375</td><td>70</td><td>92</td><tr>
<tr><td>1/1/1923</td><td>23.4286</td><td>36.1429</td><td>63</td><td>135</td><tr>
<tr><td>1/8/1923</td><td>19.8571</td><td>32.2857</td><td>53</td><td>230</td><tr>
<tr><td>1/15/1923</td><td>21.7143</td><td>39.2857</td><td>86</td><td>53</td><tr>
<tr><td>1/22/1923</td><td>16</td><td>31.8571</td><td>52</td><td>189</td><tr>
<tr><td>1/29/1923</td><td>19.7143</td><td>33.8571</td><td>91</td><td>39</td><tr>
<tr><td>2/5/1923</td><td>16.8571</td><td>29.8571</td><td>121</td><td>35</td><tr>
<tr><td>2/12/1923</td><td>9.85714</td><td>23.8571</td><td>142</td><td>60</td><tr>
<tr><td>2/19/1923</td><td>12.7143</td><td>30.7143</td><td>116</td><td>0</td><tr>
<tr><td>2/26/1923</td><td>32</td><td>42.7143</td><td>105</td><td>14</td><tr>
<tr><td>3/5/1923</td><td>19.5714</td><td>35</td><td>115</td><td>89</td><tr>
<tr><td>3/12/1923</td><td>28.4286</td><td>42.1429</td><td>116</td><td>139</td><tr>
<tr><td>3/19/1923</td><td>28.8571</td><td>50.2857</td><td>111</td><td>21</td><tr>
<tr><td>3/26/1923</td><td>17.5714</td><td>38.1429</td><td>145</td><td>0</td><tr>
<tr><td>4/2/1923</td><td>39.2857</td><td>62.4286</td><td>178</td><td>162</td><tr>
<tr><td>4/9/1923</td><td>31.5714</td><td>47.4286</td><td>185</td><td>47</td><tr>
<tr><td>4/16/1923</td><td>41</td><td>64.7143</td><td>150</td><td>10</td><tr>
<tr><td>4/23/1923</td><td>43.7143</td><td>59.5714</td><td>334</td><td>246</td><tr>
<tr><td>4/30/1923</td><td>47.7143</td><td>60.8571</td><td>242</td><td>63</td><tr>
<tr><td>5/7/1923</td><td>44.2857</td><td>63.5714</td><td>78</td><td>50</td><tr>
<tr><td>5/14/1923</td><td>49.4286</td><td>69.7143</td><td>278</td><td>3</td><tr>
<tr><td>5/21/1923</td><td>52.8571</td><td>72.2857</td><td>270</td><td>28</td><tr>
<tr><td>5/28/1923</td><td>53.4286</td><td>73</td><td>306</td><td>0</td><tr>
<tr><td>6/4/1923</td><td>56.4286</td><td>75</td><td>203</td><td>124</td><tr>
<tr><td>6/11/1923</td><td>55</td><td>72.5714</td><td>210</td><td>0</td><tr>
<tr><td>6/18/1923</td><td>64.7143</td><td>85.1429</td><td>140</td><td>12</td><tr>
<tr><td>6/25/1923</td><td>62.5714</td><td>80.7143</td><td>110</td><td>67</td><tr>
<tr><td>7/2/1923</td><td>61.1429</td><td>74.8571</td><td>68</td><td>65</td><tr>
<tr><td>7/9/1923</td><td>65.1429</td><td>83.4286</td><td>49</td><td>0</td><tr>
<tr><td>7/16/1923</td><td>65.2857</td><td>87.4286</td><td>69</td><td>90</td><tr>
<tr><td>7/23/1923</td><td>59</td><td>72.5714</td><td>36</td><td>181</td><tr>
<tr><td>7/30/1923</td><td>62.8571</td><td>78.1429</td><td>20</td><td>0</td><tr>
<tr><td>8/6/1923</td><td>63.4286</td><td>79.7143</td><td>28</td><td>27</td><tr>
<tr><td>8/20/1923</td><td>55.8571</td><td>73.8571</td><td>14</td><td>43</td><tr>
<tr><td>8/27/1923</td><td>61.8571</td><td>76.7143</td><td>11</td><td>88</td><tr>
<tr><td>9/3/1923</td><td>59</td><td>73.5714</td><td>8</td><td>2</td><tr>
<tr><td>9/10/1923</td><td>54.4286</td><td>68.4286</td><td>8</td><td>2</td><tr>
<tr><td>9/17/1923</td><td>55.7143</td><td>71.4286</td><td>11</td><td>29</td><tr>
<tr><td>9/24/1923</td><td>56.5714</td><td>72.1429</td><td>12</td><td>5</td><tr>
<tr><td>10/1/1923</td><td>46.7143</td><td>66.5714</td><td>9</td><td>0</td><tr>
<tr><td>10/8/1923</td><td>49.5714</td><td>66.5714</td><td>10</td><td>0</td><tr>
<tr><td>10/15/1923</td><td>49.2857</td><td>63.8571</td><td>25</td><td>111</td><tr>
<tr><td>10/22/1923</td><td>45.7143</td><td>58</td><td>43</td><td>214</td><tr>
<tr><td>10/29/1923</td><td>38.7143</td><td>56.8571</td><td>32</td><td>18</td><tr>
<tr><td>11/5/1923</td><td>38.8571</td><td>52</td><td>39</td><td>20</td><tr>
<tr><td>11/12/1923</td><td>41.2857</td><td>48.5714</td><td>37</td><td>0</td><tr>
<tr><td>11/19/1923</td><td>36.5714</td><td>51.5714</td><td>43</td><td>202</td><tr>
<tr><td>11/26/1923</td><td>37.2857</td><td>53.1429</td><td>46</td><td>68</td><tr>
<tr><td>12/3/1923</td><td>43.1429</td><td>53</td><td>51</td><td>254</td><tr>
<tr><td>12/10/1923</td><td>32.5714</td><td>47.7143</td><td>52</td><td>59</td><tr>
<tr><td>12/17/1923</td><td>33</td><td>45.5714</td><td>34</td><td>81</td><tr>
<tr><td>12/24/1923</td><td>27.25</td><td>39.25</td><td>57</td><td>104</td><tr>
<tr><td>1/1/1924</td><td>20.8571</td><td>35.5714</td><td>118</td><td>102</td><tr>
<tr><td>1/8/1924</td><td>32.1429</td><td>46.4286</td><td>99</td><td>37</td><tr>
<tr><td>1/15/1924</td><td>25.5714</td><td>43.7143</td><td>117</td><td>80</td><tr>
<tr><td>1/15/1924</td><td>25.5714</td><td>43.7143</td><td>1</td><td>80</td><tr>
<tr><td>1/22/1924</td><td>11.5714</td><td>32.4286</td><td>105</td><td>108</td><tr>
<tr><td>1/29/1924</td><td>26.2857</td><td>41.7143</td><td>150</td><td>26</td><tr>
<tr><td>2/5/1924</td><td>20.2857</td><td>32.4286</td><td>157</td><td>82</td><tr>
<tr><td>2/12/1924</td><td>15.4286</td><td>30</td><td>180</td><td>1</td><tr>
<tr><td>2/19/1924</td><td>17.5714</td><td>32.1429</td><td>197</td><td>152</td><tr>
<tr><td>2/26/1924</td><td>26</td><td>39.1429</td><td>233</td><td>0</td><tr>
<tr><td>3/4/1924</td><td>35</td><td>44.2857</td><td>181</td><td>13</td><tr>
<tr><td>3/11/1924</td><td>26.1429</td><td>38</td><td>242</td><td>142</td><tr>
<tr><td>3/18/1924</td><td>34</td><td>46.8571</td><td>197</td><td>0</td><tr>
<tr><td>3/25/1924</td><td>34.2857</td><td>46.5714</td><td>198</td><td>49</td><tr>
<tr><td>4/1/1924</td><td>35.7143</td><td>51.2857</td><td>149</td><td>219</td><tr>
<tr><td>4/8/1924</td><td>40.5714</td><td>56.2857</td><td>149</td><td>4</td><tr>
<tr><td>4/15/1924</td><td>39.5714</td><td>53.8571</td><td>156</td><td>110</td><tr>
<tr><td>4/22/1924</td><td>42.2857</td><td>57.4286</td><td>185</td><td>23</td><tr>
<tr><td>4/29/1924</td><td>45.7143</td><td>63.1429</td><td>194</td><td>45</td><tr>
<tr><td>5/6/1924</td><td>44.2857</td><td>52.2857</td><td>193</td><td>204</td><tr>
<tr><td>5/13/1924</td><td>53.2857</td><td>69.8571</td><td>164</td><td>3</td><tr>
<tr><td>5/20/1924</td><td>47.7143</td><td>62.2857</td><td>183</td><td>52</td><tr>
<tr><td>5/27/1924</td><td>51.8571</td><td>71</td><td>117</td><td>0</td><tr>
<tr><td>6/3/1924</td><td>55.4286</td><td>70.5714</td><td>165</td><td>19</td><tr>
<tr><td>6/10/1924</td><td>53.4286</td><td>66.1429</td><td>104</td><td>19</td><tr>
<tr><td>6/17/1924</td><td>61.8571</td><td>80.8571</td><td>111</td><td>33</td><tr>
<tr><td>6/24/1924</td><td>63.7143</td><td>83.1429</td><td>70</td><td>36</td><tr>
<tr><td>7/1/1924</td><td>61.5714</td><td>75</td><td>45</td><td>0</td><tr>
<tr><td>7/8/1924</td><td>68.8571</td><td>85.8571</td><td>41</td><td>82</td><tr>
<tr><td>7/15/1924</td><td>61.8571</td><td>82.7143</td><td>22</td><td>50</td><tr>
<tr><td>7/22/1924</td><td>66.4286</td><td>86.2857</td><td>18</td><td>2</td><tr>
<tr><td>7/29/1924</td><td>61.8571</td><td>79.8571</td><td>21</td><td>70</td><tr>
<tr><td>8/5/1924</td><td>69.7143</td><td>87.7143</td><td>3</td><td>101</td><tr>
<tr><td>8/12/1924</td><td>60.7143</td><td>72.2857</td><td>17</td><td>137</td><tr>
<tr><td>8/19/1924</td><td>62.2857</td><td>76</td><td>18</td><td>33</td><tr>
<tr><td>8/26/1924</td><td>68</td><td>86.4286</td><td>16</td><td>453</td><tr>
<tr><td>9/2/1924</td><td>55.8571</td><td>73</td><td>8</td><td>92</td><tr>
<tr><td>9/9/1924</td><td>56.5714</td><td>71.7143</td><td>9</td><td>428</td><tr>
<tr><td>9/16/1924</td><td>53</td><td>65.8571</td><td>4</td><td>27</td><tr>
<tr><td>9/23/1924</td><td>48.4286</td><td>66</td><td>6</td><td>51</td><tr>
<tr><td>9/30/1924</td><td>53</td><td>70.8571</td><td>10</td><td>60</td><tr>
<tr><td>10/7/1924</td><td>48.4286</td><td>63.7143</td><td>19</td><td>6</td><tr>
<tr><td>10/14/1924</td><td>42.2857</td><td>60.2857</td><td>17</td><td>0</td><tr>
<tr><td>10/21/1924</td><td>44.4286</td><td>63.7143</td><td>18</td><td>0</td><tr>
<tr><td>10/28/1924</td><td>43</td><td>58.5714</td><td>27</td><td>0</td><tr>
<tr><td>11/4/1924</td><td>41.1429</td><td>57.7143</td><td>29</td><td>0</td><tr>
<tr><td>11/11/1924</td><td>36.4286</td><td>52.1429</td><td>28</td><td>0</td><tr>
<tr><td>11/18/1924</td><td>33.7143</td><td>49.1429</td><td>41</td><td>114</td><tr>
<tr><td>11/25/1924</td><td>32.4286</td><td>42.7143</td><td>39</td><td>79</td><tr>
<tr><td>12/2/1924</td><td>31.5714</td><td>46.1429</td><td>41</td><td>58</td><tr>
<tr><td>12/9/1924</td><td>26.5714</td><td>40.7143</td><td>59</td><td>21</td><tr>
<tr><td>12/16/1924</td><td>20.5714</td><td>35.7143</td><td>36</td><td>32</td><tr>
<tr><td>12/23/1924</td><td>16.8889</td><td>34.8889</td><td>41</td><td>37</td><tr>
<tr><td>1/1/1925</td><td>23.8571</td><td>34.8571</td><td>80</td><td>18</td><tr>
<tr><td>1/8/1925</td><td>22.8571</td><td>36.8571</td><td>88</td><td>70</td><tr>
<tr><td>1/15/1925</td><td>16.4286</td><td>31.2857</td><td>135</td><td>141</td><tr>
<tr><td>1/22/1925</td><td>13.7143</td><td>34.5714</td><td>117</td><td>33</td><tr>
<tr><td>1/29/1925</td><td>22.2857</td><td>36.4286</td><td>148</td><td>140</td><tr>
<tr><td>2/5/1925</td><td>36.8571</td><td>51.5714</td><td>175</td><td>37</td><tr>
<tr><td>2/12/1925</td><td>31.5714</td><td>45.8571</td><td>199</td><td>100</td><tr>
<tr><td>2/19/1925</td><td>34.8571</td><td>50</td><td>143</td><td>3</td><tr>
<tr><td>2/26/1925</td><td>17.2857</td><td>39.5714</td><td>225</td><td>46</td><tr>
<tr><td>3/5/1925</td><td>38.4286</td><td>50</td><td>147</td><td>115</td><tr>
<tr><td>3/12/1925</td><td>33.2857</td><td>51.4286</td><td>220</td><td>92</td><tr>
<tr><td>3/19/1925</td><td>36</td><td>52.8571</td><td>215</td><td>96</td><tr>
<tr><td>3/26/1925</td><td>40.8571</td><td>56.5714</td><td>266</td><td>182</td><tr>
<tr><td>4/2/1925</td><td>37</td><td>55.5714</td><td>344</td><td>0</td><tr>
<tr><td>4/9/1925</td><td>40.8571</td><td>58.5714</td><td>277</td><td>127</td><tr>
<tr><td>4/16/1925</td><td>38</td><td>55.2857</td><td>402</td><td>116</td><tr>
<tr><td>4/23/1925</td><td>49.7143</td><td>66.4286</td><td>302</td><td>0</td><tr>
<tr><td>4/30/1925</td><td>45.4286</td><td>62</td><td>296</td><td>11</td><tr>
<tr><td>5/7/1925</td><td>48.4286</td><td>66.1429</td><td>286</td><td>34</td><tr>
<tr><td>5/14/1925</td><td>49</td><td>67</td><td>264</td><td>40</td><tr>
<tr><td>5/21/1925</td><td>47.1429</td><td>65</td><td>235</td><td>58</td><tr>
<tr><td>5/28/1925</td><td>55.8571</td><td>76.4286</td><td>220</td><td>135</td><tr>
<tr><td>6/4/1925</td><td>64.8571</td><td>85.8571</td><td>188</td><td>0</td><tr>
<tr><td>6/11/1925</td><td>59.4286</td><td>80.7143</td><td>136</td><td>58</td><tr>
<tr><td>6/18/1925</td><td>60.1429</td><td>78.2857</td><td>75</td><td>124</td><tr>
<tr><td>7/2/1925</td><td>62.8571</td><td>81.4286</td><td>59</td><td>112</td><tr>
<tr><td>7/9/1925</td><td>66.1429</td><td>82.5714</td><td>52</td><td>2</td><tr>
<tr><td>7/16/1925</td><td>67.4286</td><td>81.5714</td><td>28</td><td>46</td><tr>
<tr><td>7/23/1925</td><td>63</td><td>77.2857</td><td>30</td><td>193</td><tr>
<tr><td>7/30/1925</td><td>63.1429</td><td>80.8571</td><td>30</td><td>80</td><tr>
<tr><td>8/6/1925</td><td>64.1429</td><td>78</td><td>18</td><td>40</td><tr>
<tr><td>8/13/1925</td><td>65.1429</td><td>79.7143</td><td>11</td><td>21</td><tr>
<tr><td>8/20/1925</td><td>60.1429</td><td>81.8571</td><td>10</td><td>0</td><tr>
<tr><td>8/27/1925</td><td>59</td><td>80</td><td>6</td><td>0</td><tr>
<tr><td>9/3/1925</td><td>57.8571</td><td>69.4286</td><td>13</td><td>212</td><tr>
<tr><td>9/10/1925</td><td>63.1429</td><td>78.4286</td><td>4</td><td>131</td><tr>
<tr><td>9/17/1925</td><td>52.7143</td><td>69.5714</td><td>4</td><td>1</td><tr>
<tr><td>9/24/1925</td><td>47.5714</td><td>67.8571</td><td>12</td><td>1</td><tr>
<tr><td>10/1/1925</td><td>46.8571</td><td>60.7143</td><td>21</td><td>135</td><tr>
<tr><td>10/8/1925</td><td>40.8571</td><td>56.4286</td><td>25</td><td>92</td><tr>
<tr><td>10/15/1925</td><td>44</td><td>62</td><td>33</td><td>47</td><tr>
<tr><td>10/22/1925</td><td>40.1429</td><td>53.8571</td><td>63</td><td>129</td><tr>
<tr><td>10/29/1925</td><td>33.8571</td><td>45.8571</td><td>48</td><td>0</td><tr>
<tr><td>11/5/1925</td><td>37.5714</td><td>54.5714</td><td>57</td><td>44</td><tr>
<tr><td>11/12/1925</td><td>43.1429</td><td>57.1429</td><td>93</td><td>240</td><tr>
<tr><td>11/19/1925</td><td>35.7143</td><td>50.4286</td><td>85</td><td>46</td><tr>
<tr><td>11/26/1925</td><td>28.1429</td><td>41.8571</td><td>152</td><td>62</td><tr>
<tr><td>12/3/1925</td><td>38.4286</td><td>48.1429</td><td>143</td><td>373</td><tr>
<tr><td>12/10/1925</td><td>25.2857</td><td>38.7143</td><td>158</td><td>1</td><tr>
<tr><td>12/17/1925</td><td>30.7143</td><td>41</td><td>116</td><td>110</td><tr>
<tr><td>12/24/1925</td><td>15.875</td><td>30.5</td><td>172</td><td>10</td><tr>
<tr><td>1/1/1926</td><td>29.4286</td><td>41.2857</td><td>200</td><td>26</td><tr>
<tr><td>1/8/1926</td><td>18.8571</td><td>32.1429</td><td>160</td><td>47</td><tr>
<tr><td>1/15/1926</td><td>32.5714</td><td>46.8571</td><td>163</td><td>102</td><tr>
<tr><td>1/22/1926</td><td>17.1429</td><td>34.2857</td><td>158</td><td>40</td><tr>
<tr><td>1/29/1926</td><td>18.1429</td><td>33.4286</td><td>172</td><td>257</td><tr>
<tr><td>2/5/1926</td><td>15.2857</td><td>31.1429</td><td>147</td><td>75</td><tr>
<tr><td>2/12/1926</td><td>24.8571</td><td>39.4286</td><td>193</td><td>117</td><tr>
<tr><td>2/19/1926</td><td>21.1429</td><td>35.1429</td><td>131</td><td>145</td><tr>
<tr><td>2/26/1926</td><td>24.5714</td><td>39</td><td>191</td><td>38</td><tr>
<tr><td>3/5/1926</td><td>21</td><td>37.5714</td><td>157</td><td>91</td><tr>
<tr><td>3/12/1926</td><td>23.1429</td><td>36.7143</td><td>190</td><td>0</td><tr>
<tr><td>3/19/1926</td><td>34.7143</td><td>50.1429</td><td>131</td><td>47</td><tr>
<tr><td>3/26/1926</td><td>31.1429</td><td>43</td><td>161</td><td>115</td><tr>
<tr><td>4/2/1926</td><td>34.7143</td><td>45.2857</td><td>180</td><td>106</td><tr>
<tr><td>4/9/1926</td><td>32.2857</td><td>51.4286</td><td>191</td><td>1</td><tr>
<tr><td>4/16/1926</td><td>33.5714</td><td>55.1429</td><td>174</td><td>2</td><tr>
<tr><td>4/23/1926</td><td>43.2857</td><td>62.1429</td><td>186</td><td>64</td><tr>
<tr><td>4/30/1926</td><td>45</td><td>65</td><td>166</td><td>14</td><tr>
<tr><td>5/7/1926</td><td>45.4286</td><td>62.4286</td><td>158</td><td>7</td><tr>
<tr><td>5/14/1926</td><td>50</td><td>63.4286</td><td>128</td><td>239</td><tr>
<tr><td>5/21/1926</td><td>48.7143</td><td>66.1429</td><td>148</td><td>70</td><tr>
<tr><td>5/28/1926</td><td>51.7143</td><td>67.4286</td><td>96</td><td>12</td><tr>
<tr><td>6/4/1926</td><td>51.8571</td><td>67.8571</td><td>93</td><td>51</td><tr>
<tr><td>6/11/1926</td><td>53.7143</td><td>70.5714</td><td>93</td><td>31</td><tr>
<tr><td>6/18/1926</td><td>54.8571</td><td>73.4286</td><td>88</td><td>9</td><tr>
<tr><td>6/25/1926</td><td>63.7143</td><td>82</td><td>68</td><td>31</td><tr>
<tr><td>7/2/1926</td><td>63.4286</td><td>79.1429</td><td>48</td><td>3</td><tr>
<tr><td>7/9/1926</td><td>59.2857</td><td>73.7143</td><td>32</td><td>49</td><tr>
<tr><td>7/16/1926</td><td>64.7143</td><td>86.7143</td><td>16</td><td>65</td><tr>
<tr><td>7/23/1926</td><td>64.2857</td><td>77.2857</td><td>20</td><td>259</td><tr>
<tr><td>7/30/1926</td><td>63.8571</td><td>78.1429</td><td>18</td><td>286</td><tr>
<tr><td>8/6/1926</td><td>65.7143</td><td>79.8571</td><td>23</td><td>129</td><tr>
<tr><td>8/13/1926</td><td>62.1429</td><td>76.5714</td><td>15</td><td>199</td><tr>
<tr><td>8/20/1926</td><td>59.7143</td><td>71</td><td>13</td><td>7</td><tr>
<tr><td>8/27/1926</td><td>60.4286</td><td>77.5714</td><td>7</td><td>0</td><tr>
<tr><td>9/3/1926</td><td>56.7143</td><td>70.5714</td><td>5</td><td>23</td><tr>
<tr><td>9/10/1926</td><td>53.4286</td><td>71.4286</td><td>6</td><td>8</td><tr>
<tr><td>9/17/1926</td><td>55.4286</td><td>68.8571</td><td>7</td><td>8</td><tr>
<tr><td>9/24/1926</td><td>53.8571</td><td>68.7143</td><td>4</td><td>69</td><tr>
<tr><td>10/1/1926</td><td>53.8571</td><td>71.7143</td><td>12</td><td>22</td><tr>
<tr><td>10/8/1926</td><td>44.7143</td><td>62.7143</td><td>5</td><td>48</td><tr>
<tr><td>10/15/1926</td><td>39.7143</td><td>53.8571</td><td>6</td><td>95</td><tr>
<tr><td>10/22/1926</td><td>40.5714</td><td>59.4286</td><td>6</td><td>155</td><tr>
<tr><td>10/29/1926</td><td>38.8571</td><td>55.8571</td><td>7</td><td>44</td><tr>
<tr><td>11/5/1926</td><td>38</td><td>57.2857</td><td>7</td><td>103</td><tr>
<tr><td>11/12/1926</td><td>39.8571</td><td>54</td><td>2</td><td>20</td><tr>
<tr><td>11/19/1926</td><td>34.4286</td><td>47.2857</td><td>8</td><td>171</td><tr>
<tr><td>11/26/1926</td><td>30</td><td>50.4286</td><td>5</td><td>107</td><tr>
<tr><td>12/3/1926</td><td>14.4286</td><td>32.8571</td><td>14</td><td>131</td><tr>
<tr><td>12/10/1926</td><td>27.2857</td><td>38.2857</td><td>12</td><td>21</td><tr>
<tr><td>12/17/1926</td><td>17</td><td>32.2857</td><td>15</td><td>1</td><tr>
<tr><td>12/24/1926</td><td>23.75</td><td>38.5</td><td>21</td><td>243</td><tr>
<tr><td>1/1/1927</td><td>25.1429</td><td>36.1429</td><td>26</td><td>22</td><tr>
<tr><td>1/8/1927</td><td>19</td><td>32.2857</td><td>23</td><td>129</td><tr>
<tr><td>1/15/1927</td><td>26.2857</td><td>41</td><td>37</td><td>93</td><tr>
<tr><td>1/22/1927</td><td>16.8571</td><td>38</td><td>35</td><td>14</td><tr>
<tr><td>1/29/1927</td><td>30.4286</td><td>47</td><td>43</td><td>9</td><tr>
<tr><td>2/5/1927</td><td>25.4286</td><td>37.5714</td><td>54</td><td>9</td><tr>
<tr><td>2/12/1927</td><td>28</td><td>39.4286</td><td>35</td><td>98</td><tr>
<tr><td>2/19/1927</td><td>23.7143</td><td>36.4286</td><td>44</td><td>153</td><tr>
<tr><td>2/26/1927</td><td>22.7143</td><td>37</td><td>41</td><td>68</td><tr>
<tr><td>3/5/1927</td><td>33.2857</td><td>49.4286</td><td>52</td><td>33</td><tr>
<tr><td>3/12/1927</td><td>42.1429</td><td>62.4286</td><td>58</td><td>2</td><tr>
<tr><td>3/19/1927</td><td>32</td><td>45.5714</td><td>59</td><td>82</td><tr>
<tr><td>3/26/1927</td><td>35.8571</td><td>49.7143</td><td>71</td><td>2</td><tr>
<tr><td>4/2/1927</td><td>32.7143</td><td>47.2857</td><td>88</td><td>32</td><tr>
<tr><td>4/9/1927</td><td>35.7143</td><td>55.2857</td><td>82</td><td>0</td><tr>
<tr><td>4/16/1927</td><td>45.7143</td><td>72.8571</td><td>93</td><td>26</td><tr>
<tr><td>4/23/1927</td><td>40.4286</td><td>57.1429</td><td>108</td><td>78</td><tr>
<tr><td>4/30/1927</td><td>43.1429</td><td>59.7143</td><td>92</td><td>44</td><tr>
<tr><td>5/7/1927</td><td>47.7143</td><td>65</td><td>127</td><td>50</td><tr>
<tr><td>5/14/1927</td><td>49</td><td>59.8571</td><td>166</td><td>82</td><tr>
<tr><td>5/21/1927</td><td>49.8571</td><td>63.1429</td><td>152</td><td>70</td><tr>
<tr><td>5/28/1927</td><td>50.8571</td><td>66.8571</td><td>124</td><td>4</td><tr>
<tr><td>6/4/1927</td><td>57</td><td>79.5714</td><td>152</td><td>73</td><tr>
<tr><td>6/11/1927</td><td>56.8571</td><td>72.8571</td><td>131</td><td>36</td><tr>
<tr><td>6/18/1927</td><td>58</td><td>73.7143</td><td>110</td><td>30</td><tr>
<tr><td>6/25/1927</td><td>56.5714</td><td>69.5714</td><td>116</td><td>106</td><tr>
<tr><td>7/2/1927</td><td>59.1429</td><td>74.7143</td><td>111</td><td>49</td><tr>
<tr><td>7/9/1927</td><td>66.2857</td><td>84.5714</td><td>87</td><td>51</td><tr>
<tr><td>7/16/1927</td><td>65.4286</td><td>79.8571</td><td>63</td><td>62</td><tr>
<tr><td>7/23/1927</td><td>66.4286</td><td>84.2857</td><td>68</td><td>270</td><tr>
<tr><td>7/30/1927</td><td>60.7143</td><td>78.1429</td><td>33</td><td>233</td><tr>
<tr><td>8/6/1927</td><td>61.7143</td><td>79</td><td>22</td><td>49</td><tr>
<tr><td>8/13/1927</td><td>59.1429</td><td>74.2857</td><td>30</td><td>135</td><tr>
<tr><td>8/20/1927</td><td>58.8571</td><td>71.7143</td><td>21</td><td>131</td><tr>
<tr><td>8/27/1927</td><td>61</td><td>72.7143</td><td>20</td><td>255</td><tr>
<tr><td>9/3/1927</td><td>61</td><td>79.4286</td><td>22</td><td>0</td><tr>
<tr><td>9/10/1927</td><td>55.1429</td><td>71.1429</td><td>11</td><td>128</td><tr>
<tr><td>9/17/1927</td><td>55.1429</td><td>70.8571</td><td>14</td><td>28</td><tr>
<tr><td>9/24/1927</td><td>52.8571</td><td>71.8571</td><td>16</td><td>0</td><tr>
<tr><td>10/1/1927</td><td>60.4286</td><td>78.8571</td><td>44</td><td>61</td><tr>
<tr><td>10/8/1927</td><td>48.4286</td><td>64</td><td>43</td><td>266</td><tr>
<tr><td>10/15/1927</td><td>48</td><td>61.2857</td><td>76</td><td>50</td><tr>
<tr><td>10/22/1927</td><td>44.5714</td><td>64</td><td>74</td><td>0</td><tr>
<tr><td>10/29/1927</td><td>47.5714</td><td>67.4286</td><td>92</td><td>181</td><tr>
<tr><td>11/5/1927</td><td>35.1429</td><td>49.2857</td><td>116</td><td>7</td><tr>
<tr><td>11/12/1927</td><td>47.5714</td><td>66.4286</td><td>138</td><td>175</td><tr>
<tr><td>11/19/1927</td><td>35.4286</td><td>49.1429</td><td>160</td><td>56</td><tr>
<tr><td>11/26/1927</td><td>39.1429</td><td>56</td><td>188</td><td>146</td><tr>
<tr><td>12/3/1927</td><td>24.5714</td><td>43.7143</td><td>185</td><td>161</td><tr>
<tr><td>12/10/1927</td><td>31.5714</td><td>45</td><td>219</td><td>224</td><tr>
<tr><td>12/17/1927</td><td>26.5714</td><td>38.2857</td><td>197</td><td>0</td><tr>
<tr><td>12/24/1927</td><td>28.625</td><td>45.375</td><td>266</td><td>43</td><tr>
<tr><td>1/1/1928</td><td>22</td><td>39</td><td>324</td><td>0</td><tr>
<tr><td>1/8/1928</td><td>40</td><td>48.7143</td><td>336</td><td>12</td><tr>
<tr><td>1/15/1928</td><td>23.5714</td><td>38.4286</td><td>404</td><td>56</td><tr>
<tr><td>1/22/1928</td><td>23.1429</td><td>38.8571</td><td>347</td><td>75</td><tr>
<tr><td>1/29/1928</td><td>17.5714</td><td>33.4286</td><td>465</td><td>23</td><tr>
<tr><td>2/5/1928</td><td>20.8571</td><td>37.5714</td><td>517</td><td>123</td><tr>
<tr><td>2/12/1928</td><td>29.2857</td><td>41.8571</td><td>528</td><td>116</td><tr>
<tr><td>2/19/1928</td><td>18.7143</td><td>36.7143</td><td>543</td><td>27</td><tr>
<tr><td>2/26/1928</td><td>19</td><td>36.1429</td><td>589</td><td>1</td><tr>
<tr><td>3/4/1928</td><td>21.1429</td><td>36.5714</td><td>455</td><td>55</td><tr>
<tr><td>3/11/1928</td><td>31.8571</td><td>45.2857</td><td>649</td><td>10</td><tr>
<tr><td>3/18/1928</td><td>32.7143</td><td>47.4286</td><td>409</td><td>65</td><tr>
<tr><td>3/25/1928</td><td>33.7143</td><td>51.4286</td><td>472</td><td>25</td><tr>
<tr><td>4/1/1928</td><td>40.8571</td><td>63.2857</td><td>353</td><td>0</td><tr>
<tr><td>4/8/1928</td><td>38.2857</td><td>54.7143</td><td>332</td><td>80</td><tr>
<tr><td>4/15/1928</td><td>34</td><td>55</td><td>260</td><td>20</td><tr>
<tr><td>4/22/1928</td><td>37.1429</td><td>48.7143</td><td>229</td><td>365</td><tr>
<tr><td>4/29/1928</td><td>46.2857</td><td>64.5714</td><td>173</td><td>3</td><tr>
<tr><td>5/6/1928</td><td>46.4286</td><td>60.5714</td><td>151</td><td>2</td><tr>
<tr><td>5/13/1928</td><td>47.4286</td><td>64.4286</td><td>113</td><td>44</td><tr>
<tr><td>5/20/1928</td><td>46.8571</td><td>55.8571</td><td>96</td><td>210</td><tr>
<tr><td>5/27/1928</td><td>53.2857</td><td>72.2857</td><td>87</td><td>62</td><tr>
<tr><td>6/3/1928</td><td>55.2857</td><td>67.5714</td><td>51</td><td>185</td><tr>
<tr><td>6/3/1928</td><td>55.2857</td><td>67.5714</td><td>31</td><td>185</td><tr>
<tr><td>6/10/1928</td><td>56.8571</td><td>79.1429</td><td>47</td><td>103</td><tr>
<tr><td>6/17/1928</td><td>55</td><td>64.7143</td><td>39</td><td>209</td><tr>
<tr><td>6/24/1928</td><td>62.7143</td><td>77</td><td>37</td><td>49</td><tr>
<tr><td>7/8/1928</td><td>67.7143</td><td>84.2857</td><td>26</td><td>92</td><tr>
<tr><td>7/15/1928</td><td>66.4286</td><td>83.7143</td><td>17</td><td>56</td><tr>
<tr><td>7/22/1928</td><td>64.1429</td><td>77</td><td>16</td><td>112</td><tr>
<tr><td>7/29/1928</td><td>66.5714</td><td>85.2857</td><td>9</td><td>20</td><tr>
<tr><td>8/5/1928</td><td>62.1429</td><td>76.5714</td><td>5</td><td>81</td><tr>
<tr><td>8/12/1928</td><td>68</td><td>86</td><td>4</td><td>46</td><tr>
<tr><td>8/19/1928</td><td>64</td><td>74.4286</td><td>4</td><td>27</td><tr>
<tr><td>9/2/1928</td><td>58</td><td>73.2857</td><td>4</td><td>146</td><tr>
<tr><td>9/9/1928</td><td>56.5714</td><td>73.2857</td><td>3</td><td>3</td><tr>
<tr><td>9/16/1928</td><td>59.1429</td><td>73</td><td>2</td><td>250</td><tr>
<tr><td>9/23/1928</td><td>46.8571</td><td>62</td><td>8</td><td>48</td><tr>
<tr><td>9/30/1928</td><td>50.7143</td><td>66.4286</td><td>3</td><td>0</td><tr>
<tr><td>10/7/1928</td><td>48.8571</td><td>71.2857</td><td>8</td><td>9</td><tr>
<tr><td>10/14/1928</td><td>54</td><td>73.2857</td><td>2</td><td>164</td><tr>
<tr><td>10/21/1928</td><td>43.4286</td><td>60.1429</td><td>6</td><td>108</td><tr>
<tr><td>10/28/1928</td><td>38.7143</td><td>53.1429</td><td>3</td><td>55</td><tr>
<tr><td>11/4/1928</td><td>39.5714</td><td>52.5714</td><td>1</td><td>47</td><tr>
<tr><td>11/11/1928</td><td>43.1429</td><td>59.4286</td><td>1</td><td>1</td><tr>
<tr><td>11/18/1928</td><td>35.4286</td><td>50.5714</td><td>16</td><td>16</td><tr>
<tr><td>11/25/1928</td><td>28</td><td>43.8571</td><td>6</td><td>74</td><tr>
<tr><td>12/2/1928</td><td>33.8571</td><td>44.4286</td><td>16</td><td>23</td><tr>
<tr><td>12/9/1928</td><td>31.1429</td><td>42.7143</td><td>10</td><td>77</td><tr>
<tr><td>12/16/1928</td><td>32.4286</td><td>48.2857</td><td>10</td><td>40</td><tr>
<tr><td>12/23/1928</td><td>30.75</td><td>44</td><td>7</td><td>120</td><tr>
<tr><td>1/1/1929</td><td>22.8571</td><td>41.1429</td><td>8</td><td>186</td><tr>
<tr><td>1/8/1929</td><td>19.4286</td><td>35.1429</td><td>13</td><td>63</td><tr>
<tr><td>1/15/1929</td><td>23.1429</td><td>40.1429</td><td>9</td><td>73</td><tr>
<tr><td>1/22/1929</td><td>21.5714</td><td>34.7143</td><td>24</td><td>53</td><tr>
<tr><td>1/29/1929</td><td>19.8571</td><td>31.2857</td><td>8</td><td>28</td><tr>
<tr><td>2/5/1929</td><td>29.1429</td><td>41.8571</td><td>29</td><td>127</td><tr>
<tr><td>2/12/1929</td><td>25.5714</td><td>39.4286</td><td>13</td><td>12</td><tr>
<tr><td>2/19/1929</td><td>19.1429</td><td>34.2857</td><td>6</td><td>114</td><tr>
<tr><td>2/26/1929</td><td>32.7143</td><td>44.7143</td><td>29</td><td>162</td><tr>
<tr><td>3/5/1929</td><td>22.7143</td><td>39.5714</td><td>19</td><td>133</td><tr>
<tr><td>3/12/1929</td><td>32.7143</td><td>50.7143</td><td>30</td><td>79</td><tr>
<tr><td>3/19/1929</td><td>38.4286</td><td>58.1429</td><td>20</td><td>13</td><tr>
<tr><td>3/26/1929</td><td>39.2857</td><td>54.2857</td><td>10</td><td>13</td><tr>
<tr><td>4/2/1929</td><td>39.8571</td><td>61.8571</td><td>21</td><td>20</td><tr>
<tr><td>4/9/1929</td><td>34.2857</td><td>44</td><td>12</td><td>154</td><tr>
<tr><td>4/16/1929</td><td>38.5714</td><td>47.4286</td><td>17</td><td>460</td><tr>
<tr><td>4/23/1929</td><td>45.8571</td><td>63</td><td>29</td><td>109</td><tr>
<tr><td>4/29/1928</td><td>46.2857</td><td>64.5714</td><td>15</td><td>3</td><tr>
<tr><td>5/7/1929</td><td>47</td><td>66.2857</td><td>15</td><td>32</td><tr>
<tr><td>5/14/1929</td><td>46.2857</td><td>69.7143</td><td>31</td><td>102</td><tr>
<tr><td>5/21/1929</td><td>48.5714</td><td>69.2857</td><td>37</td><td>86</td><tr>
<tr><td>5/28/1929</td><td>58.2857</td><td>81.5714</td><td>54</td><td>0</td><tr>
<tr><td>5/28/1929</td><td>58.2857</td><td>81.5714</td><td>55</td><td>0</td><tr>
<tr><td>6/11/1929</td><td>59.8571</td><td>84.4286</td><td>37</td><td>24</td><tr>
<tr><td>6/18/1929</td><td>64.5714</td><td>80.2857</td><td>26</td><td>114</td><tr>
<tr><td>6/25/1929</td><td>65.3333</td><td>79.8333</td><td>44</td><td>77</td><tr>
<tr><td>7/2/1929</td><td>63.4286</td><td>81.5714</td><td>32</td><td>10</td><tr>
<tr><td>7/9/1929</td><td>61.7143</td><td>82.5714</td><td>41</td><td>14</td><tr>
<tr><td>7/16/1929</td><td>59.5714</td><td>79.7143</td><td>23</td><td>64</td><tr>
<tr><td>7/23/1929</td><td>65.4286</td><td>85</td><td>22</td><td>47</td><tr>
<tr><td>7/30/1929</td><td>61.2857</td><td>80.7143</td><td>13</td><td>75</td><tr>
<tr><td>8/6/1929</td><td>63.1429</td><td>78.1429</td><td>7</td><td>6</td><tr>
<tr><td>8/13/1929</td><td>60.1429</td><td>78.4286</td><td>4</td><td>24</td><tr>
<tr><td>8/20/1929</td><td>59.5714</td><td>80.2857</td><td>5</td><td>116</td><tr>
<tr><td>8/27/1929</td><td>60.1429</td><td>79.4286</td><td>6</td><td>1</td><tr>
<tr><td>9/3/1929</td><td>64.4286</td><td>77.5714</td><td>6</td><td>32</td><tr>
<tr><td>9/10/1929</td><td>58.2857</td><td>75.8571</td><td>4</td><td>11</td><tr>
<tr><td>9/17/1929</td><td>47</td><td>63.4286</td><td>8</td><td>3</td><tr>
<tr><td>9/24/1929</td><td>54.5714</td><td>73.5714</td><td>2</td><td>30</td><tr>
<tr><td>10/1/1929</td><td>48.5714</td><td>65.1429</td><td>5</td><td>197</td><tr>
<tr><td>10/8/1929</td><td>41.1429</td><td>59.8571</td><td>4</td><td>0</td><tr>
<tr><td>10/15/1929</td><td>42.8571</td><td>64.4286</td><td>9</td><td>1</td><tr>
<tr><td>10/22/1929</td><td>47.8571</td><td>63.5714</td><td>3</td><td>40</td><tr>
<tr><td>10/29/1929</td><td>46.5714</td><td>57.8571</td><td>2</td><td>86</td><tr>
<tr><td>11/5/1929</td><td>39.4286</td><td>52.4286</td><td>5</td><td>2</td><tr>
<tr><td>11/12/1929</td><td>45</td><td>58.4286</td><td>7</td><td>190</td><tr>
<tr><td>11/19/1929</td><td>30.5714</td><td>42.4286</td><td>14</td><td>21</td><tr>
<tr><td>11/26/1929</td><td>25.5714</td><td>40.5714</td><td>11</td><td>54</td><tr>
<tr><td>12/3/1929</td><td>26.8571</td><td>39</td><td>11</td><td>17</td><tr>
<tr><td>12/10/1929</td><td>22.1429</td><td>36.4286</td><td>16</td><td>37</td><tr>
<tr><td>12/17/1929</td><td>25</td><td>39.1429</td><td>13</td><td>259</td><tr>
<tr><td>12/24/1929</td><td>30.625</td><td>41.875</td><td>19</td><td>78</td><tr>
<tr><td>1/1/1930</td><td>30.2857</td><td>48.5714</td><td>30</td><td>30</td><tr>
</table>


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