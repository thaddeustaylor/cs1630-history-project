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
					if(chart == "Map_Motion_rpb"){
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
					
					//var e = document.getElementById("color");
					//e.disabled = true
				}
				
				
			</script>
			
		
	</select>
	<input type="submit" name="submit" id="submit" value="Graph" />

<?php
	//$tables should be passed to us
	$tables = array("Location ID", "X", "Y", "Population, Total", "Population, Urban");
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
</div>



<table id="data" hidden="true" title="Total and Urban Population - 1910">
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
        <tr><td>1199</td><td>1459</td><td>922</td><td>5599</td><td>0</td><tr>
<tr><td>1303</td><td>1461</td><td>705</td><td>9589</td><td>0</td><tr>
<tr><td>1272</td><td>1465</td><td>679</td><td>4993</td><td>0</td><tr>
<tr><td>1120</td><td>1466</td><td>1011</td><td>1444</td><td>0</td><tr>
<tr><td>1195</td><td>1468</td><td>978</td><td>8355</td><td>0</td><tr>
<tr><td>1169</td><td>1470</td><td>1046</td><td>1942</td><td>0</td><tr>
<tr><td>1279</td><td>1479</td><td>779</td><td>4458</td><td>0</td><tr>
<tr><td>1286</td><td>1480</td><td>816</td><td>7763</td><td>0</td><tr>
<tr><td>1253</td><td>1486</td><td>493</td><td>7616</td><td>0</td><tr>
<tr><td>1215</td><td>1488</td><td>521</td><td>4668</td><td>0</td><tr>
<tr><td>1221</td><td>1491</td><td>232</td><td>6015</td><td>0</td><tr>
<tr><td>1213</td><td>1495</td><td>429</td><td>10186</td><td>0</td><tr>
<tr><td>1236</td><td>1495</td><td>346</td><td>5720</td><td>0</td><tr>
<tr><td>1314</td><td>1501</td><td>743</td><td>4466</td><td>0</td><tr>
<tr><td>1178</td><td>1504</td><td>995</td><td>4584</td><td>0</td><tr>
<tr><td>1133</td><td>1516</td><td>1052</td><td>4551</td><td>0</td><tr>
<tr><td>1210</td><td>1540</td><td>534</td><td>5407</td><td>0</td><tr>
<tr><td>1222</td><td>1541</td><td>399</td><td>5302</td><td>0</td><tr>
<tr><td>1216</td><td>1547</td><td>242</td><td>9064</td><td>0</td><tr>
<tr><td>1230</td><td>1548</td><td>491</td><td>6557</td><td>0</td><tr>
<tr><td>1197</td><td>1555</td><td>889</td><td>7328</td><td>0</td><tr>
<tr><td>1240</td><td>1559</td><td>311</td><td>8491</td><td>0</td><tr>
<tr><td>1315</td><td>1560</td><td>567</td><td>14897</td><td>0</td><tr>
<tr><td>1141</td><td>1561</td><td>1061</td><td>1786</td><td>0</td><tr>
<tr><td>1151</td><td>1561</td><td>1025</td><td>3538</td><td>0</td><tr>
<tr><td>874</td><td>1594</td><td>1490</td><td>1333</td><td>0</td><tr>
<tr><td>845</td><td>1599</td><td>1337</td><td>1335</td><td>0</td><tr>
<tr><td>847</td><td>1599</td><td>1391</td><td>3360</td><td>0</td><tr>
<tr><td>909</td><td>1599</td><td>1296</td><td>2759</td><td>0</td><tr>
<tr><td>1266</td><td>1599</td><td>836</td><td>96</td><td>0</td><tr>
<tr><td>821</td><td>1600</td><td>1201</td><td>4248</td><td>0</td><tr>
<tr><td>903</td><td>1600</td><td>1436</td><td>1034</td><td>0</td><tr>
<tr><td>900</td><td>1601</td><td>1246</td><td>4549</td><td>0</td><tr>
<tr><td>1154</td><td>1601</td><td>965</td><td>1097</td><td>0</td><tr>
<tr><td>1167</td><td>1603</td><td>1056</td><td>3692</td><td>0</td><tr>
<tr><td>1238</td><td>1603</td><td>400</td><td>4747</td><td>0</td><tr>
<tr><td>1184</td><td>1605</td><td>1087</td><td>2570</td><td>0</td><tr>
<tr><td>1131</td><td>1608</td><td>1123</td><td>3613</td><td>0</td><tr>
<tr><td>1298</td><td>1609</td><td>784</td><td>12560</td><td>0</td><tr>
<tr><td>1145</td><td>1610</td><td>1166</td><td>4098</td><td>0</td><tr>
<tr><td>1290</td><td>1612</td><td>736</td><td>7475</td><td>0</td><tr>
<tr><td>1247</td><td>1613</td><td>248</td><td>7840</td><td>0</td><tr>
<tr><td>843</td><td>1627</td><td>1434</td><td>1087</td><td>0</td><tr>
<tr><td>911</td><td>1627</td><td>1337</td><td>2006</td><td>0</td><tr>
<tr><td>1242</td><td>1628</td><td>419</td><td>3577</td><td>0</td><tr>
<tr><td>904</td><td>1629</td><td>1476</td><td>2453</td><td>0</td><tr>
<tr><td>856</td><td>1635</td><td>1394</td><td>3206</td><td>0</td><tr>
<tr><td>1237</td><td>1637</td><td>376</td><td>14496</td><td>0</td><tr>
<tr><td>1283</td><td>1641</td><td>630</td><td>1145</td><td>0</td><tr>
<tr><td>1159</td><td>1646</td><td>1124</td><td>3011</td><td>0</td><tr>
<tr><td>886</td><td>1647</td><td>1197</td><td>6380</td><td>0</td><tr>
<tr><td>1162</td><td>1647</td><td>962</td><td>981</td><td>0</td><tr>
<tr><td>906</td><td>1648</td><td>1242</td><td>5455</td><td>0</td><tr>
<tr><td>1175</td><td>1649</td><td>1009</td><td>2470</td><td>0</td><tr>
<tr><td>1160</td><td>1650</td><td>1154</td><td>5415</td><td>0</td><tr>
<tr><td>1278</td><td>1651</td><td>563</td><td>2929</td><td>0</td><tr>
<tr><td>864</td><td>1655</td><td>1274</td><td>4240</td><td>0</td><tr>
<tr><td>895</td><td>1656</td><td>1338</td><td>3047</td><td>0</td><tr>
<tr><td>897</td><td>1656</td><td>1490</td><td>4091</td><td>0</td><tr>
<tr><td>850</td><td>1658</td><td>1443</td><td>993</td><td>0</td><tr>
<tr><td>1132</td><td>1664</td><td>882</td><td>10414</td><td>0</td><tr>
<tr><td>1310</td><td>1665</td><td>798</td><td>8695</td><td>0</td><tr>
<tr><td>1323</td><td>1665</td><td>831</td><td>2164</td><td>0</td><tr>
<tr><td>1214</td><td>1673</td><td>239</td><td>17295</td><td>0</td><tr>
<tr><td>1234</td><td>1674</td><td>305</td><td>17627</td><td>0</td><tr>
<tr><td>1202</td><td>1680</td><td>967</td><td>1191</td><td>0</td><tr>
<tr><td>829</td><td>1686</td><td>1198</td><td>8976</td><td>0</td><tr>
<tr><td>860</td><td>1686</td><td>1336</td><td>2603</td><td>0</td><tr>
<tr><td>1173</td><td>1686</td><td>1018</td><td>1521</td><td>0</td><tr>
<tr><td>899</td><td>1687</td><td>1244</td><td>5651</td><td>0</td><tr>
<tr><td>1321</td><td>1688</td><td>713</td><td>252</td><td>0</td><tr>
<tr><td>844</td><td>1690</td><td>1419</td><td>3121</td><td>0</td><tr>
<tr><td>841</td><td>1692</td><td>1279</td><td>6044</td><td>0</td><tr>
<tr><td>869</td><td>1692</td><td>1465</td><td>5055</td><td>0</td><tr>
<tr><td>1148</td><td>1692</td><td>1113</td><td>8572</td><td>0</td><tr>
<tr><td>1251</td><td>1696</td><td>370</td><td>8103</td><td>0</td><tr>
<tr><td>1295</td><td>1698</td><td>711</td><td>12319</td><td>0</td><tr>
<tr><td>1327</td><td>1699</td><td>590</td><td>6488</td><td>0</td><tr>
<tr><td>1224</td><td>1705</td><td>510</td><td>9796</td><td>0</td><tr>
<tr><td>1273</td><td>1712</td><td>558</td><td>5244</td><td>0</td><tr>
<tr><td>1322</td><td>1712</td><td>674</td><td>2462</td><td>0</td><tr>
<tr><td>1121</td><td>1718</td><td>974</td><td>1672</td><td>0</td><tr>
<tr><td>1244</td><td>1720</td><td>291</td><td>9740</td><td>0</td><tr>
<tr><td>1149</td><td>1724</td><td>1151</td><td>12083</td><td>0</td><tr>
<tr><td>877</td><td>1725</td><td>1336</td><td>5883</td><td>0</td><tr>
<tr><td>878</td><td>1726</td><td>1196</td><td>11614</td><td>0</td><tr>
<tr><td>1316</td><td>1726</td><td>636</td><td>6607</td><td>0</td><tr>
<tr><td>907</td><td>1727</td><td>1284</td><td>5398</td><td>0</td><tr>
<tr><td>1140</td><td>1727</td><td>1088</td><td>15961</td><td>0</td><tr>
<tr><td>822</td><td>1728</td><td>1467</td><td>4093</td><td>0</td><tr>
<tr><td>842</td><td>1728</td><td>1245</td><td>8700</td><td>0</td><tr>
<tr><td>851</td><td>1728</td><td>1380</td><td>2930</td><td>0</td><tr>
<tr><td>1125</td><td>1729</td><td>907</td><td>6083</td><td>0</td><tr>
<tr><td>1324</td><td>1729</td><td>820</td><td>8323</td><td>0</td><tr>
<tr><td>1153</td><td>1731</td><td>1115</td><td>4933</td><td>0</td><tr>
<tr><td>1249</td><td>1731</td><td>237</td><td>9558</td><td>0</td><tr>
<tr><td>1231</td><td>1732</td><td>437</td><td>5962</td><td>0</td><tr>
<tr><td>1261</td><td>1734</td><td>360</td><td>11814</td><td>0</td><tr>
<tr><td>1305</td><td>1735</td><td>758</td><td>8021</td><td>0</td><tr>
<tr><td>1168</td><td>1740</td><td>871</td><td>3452</td><td>0</td><tr>
<tr><td>1137</td><td>1741</td><td>1027</td><td>25668</td><td>0</td><tr>
<tr><td>1233</td><td>1751</td><td>486</td><td>6168</td><td>0</td><tr>
<tr><td>1191</td><td>1753</td><td>908</td><td>3627</td><td>0</td><tr>
<tr><td>1235</td><td>1753</td><td>524</td><td>7251</td><td>0</td><tr>
<tr><td>1297</td><td>1755</td><td>694</td><td>5120</td><td>0</td><tr>
<tr><td>1174</td><td>1758</td><td>983</td><td>2188</td><td>0</td><tr>
<tr><td>1158</td><td>1759</td><td>1161</td><td>9578</td><td>0</td><tr>
<tr><td>826</td><td>1762</td><td>1471</td><td>3281</td><td>0</td><tr>
<tr><td>833</td><td>1762</td><td>1399</td><td>7033</td><td>0</td><tr>
<tr><td>883</td><td>1763</td><td>1203</td><td>14150</td><td>0</td><tr>
<tr><td>1271</td><td>1763</td><td>745</td><td>1589</td><td>0</td><tr>
<tr><td>835</td><td>1764</td><td>1296</td><td>12170</td><td>0</td><tr>
<tr><td>891</td><td>1765</td><td>1249</td><td>11282</td><td>0</td><tr>
<tr><td>1307</td><td>1766</td><td>564</td><td>1700</td><td>0</td><tr>
<tr><td>858</td><td>1768</td><td>1432</td><td>6174</td><td>0</td><tr>
<tr><td>892</td><td>1768</td><td>1334</td><td>7826</td><td>0</td><tr>
<tr><td>1289</td><td>1768</td><td>838</td><td>13061</td><td>0</td><tr>
<tr><td>1212</td><td>1772</td><td>321</td><td>12681</td><td>0</td><tr>
<tr><td>1285</td><td>1773</td><td>596</td><td>7654</td><td>0</td><tr>
<tr><td>1270</td><td>1774</td><td>776</td><td>6451</td><td>0</td><tr>
<tr><td>1287</td><td>1779</td><td>637</td><td>6716</td><td>0</td><tr>
<tr><td>1152</td><td>1780</td><td>984</td><td>3417</td><td>0</td><tr>
<tr><td>1223</td><td>1783</td><td>356</td><td>4800</td><td>0</td><tr>
<tr><td>1225</td><td>1786</td><td>383</td><td>5313</td><td>0</td><tr>
<tr><td>1166</td><td>1787</td><td>1123</td><td>9106</td><td>0</td><tr>
<tr><td>1292</td><td>1787</td><td>694</td><td>6237</td><td>0</td><tr>
<tr><td>1198</td><td>1788</td><td>1046</td><td>8278</td><td>0</td><tr>
<tr><td>1204</td><td>1790</td><td>1010</td><td>9480</td><td>0</td><tr>
<tr><td>1147</td><td>1791</td><td>1157</td><td>10303</td><td>0</td><tr>
<tr><td>893</td><td>1799</td><td>1293</td><td>10800</td><td>0</td><tr>
<tr><td>901</td><td>1800</td><td>1201</td><td>15365</td><td>0</td><tr>
<tr><td>1256</td><td>1803</td><td>440</td><td>12545</td><td>0</td><tr>
<tr><td>1124</td><td>1804</td><td>869</td><td>8826</td><td>0</td><tr>
<tr><td>1161</td><td>1804</td><td>915</td><td>15545</td><td>0</td><tr>
<tr><td>902</td><td>1805</td><td>1388</td><td>12510</td><td>0</td><tr>
<tr><td>880</td><td>1806</td><td>1238</td><td>12827</td><td>0</td><tr>
<tr><td>813</td><td>1816</td><td>1473</td><td>9916</td><td>0</td><tr>
<tr><td>1208</td><td>1818</td><td>977</td><td>2292</td><td>0</td><tr>
<tr><td>1264</td><td>1818</td><td>783</td><td>6143</td><td>0</td><tr>
<tr><td>1232</td><td>1819</td><td>494</td><td>10724</td><td>0</td><tr>
<tr><td>1274</td><td>1819</td><td>838</td><td>14899</td><td>0</td><tr>
<tr><td>1155</td><td>1821</td><td>1011</td><td>8047</td><td>0</td><tr>
<tr><td>1163</td><td>1821</td><td>1050</td><td>10783</td><td>0</td><tr>
<tr><td>1207</td><td>1821</td><td>1157</td><td>12008</td><td>0</td><tr>
<tr><td>1219</td><td>1825</td><td>244</td><td>15659</td><td>0</td><tr>
<tr><td>1320</td><td>1826</td><td>654</td><td>14975</td><td>0</td><tr>
<tr><td>1220</td><td>1830</td><td>529</td><td>9839</td><td>0</td><tr>
<tr><td>1284</td><td>1830</td><td>818</td><td>6400</td><td>0</td><tr>
<tr><td>836</td><td>1836</td><td>1313</td><td>10444</td><td>0</td><tr>
<tr><td>854</td><td>1841</td><td>1200</td><td>18148</td><td>0</td><tr>
<tr><td>889</td><td>1841</td><td>1355</td><td>15106</td><td>0</td><tr>
<tr><td>1229</td><td>1841</td><td>384</td><td>6274</td><td>0</td><tr>
<tr><td>1241</td><td>1841</td><td>334</td><td>10140</td><td>0</td><tr>
<tr><td>862</td><td>1842</td><td>1279</td><td>10142</td><td>0</td><tr>
<tr><td>1318</td><td>1845</td><td>750</td><td>0</td><td>0</td><tr>
<tr><td>1118</td><td>1851</td><td>948</td><td>14003</td><td>0</td><tr>
<tr><td>1181</td><td>1851</td><td>1165</td><td>13019</td><td>0</td><tr>
<tr><td>1134</td><td>1852</td><td>1119</td><td>15729</td><td>0</td><tr>
<tr><td>1177</td><td>1852</td><td>1056</td><td>10379</td><td>0</td><tr>
<tr><td>1122</td><td>1853</td><td>998</td><td>13145</td><td>0</td><tr>
<tr><td>1179</td><td>1861</td><td>1027</td><td>8926</td><td>0</td><tr>
<tr><td>1267</td><td>1864</td><td>859</td><td>11061</td><td>0</td><tr>
<tr><td>1170</td><td>1869</td><td>899</td><td>18358</td><td>0</td><tr>
<tr><td>1293</td><td>1870</td><td>787</td><td>4228</td><td>0</td><tr>
<tr><td>1255</td><td>1872</td><td>383</td><td>8963</td><td>0</td><tr>
<tr><td>1296</td><td>1872</td><td>822</td><td>3307</td><td>0</td><tr>
<tr><td>1275</td><td>1874</td><td>661</td><td>10901</td><td>0</td><tr>
<tr><td>881</td><td>1875</td><td>1271</td><td>11811</td><td>0</td><tr>
<tr><td>888</td><td>1878</td><td>1196</td><td>17447</td><td>0</td><tr>
<tr><td>1246</td><td>1878</td><td>487</td><td>10345</td><td>0</td><tr>
<tr><td>1308</td><td>1879</td><td>564</td><td>7661</td><td>0</td><tr>
<tr><td>1201</td><td>1880</td><td>1158</td><td>14775</td><td>0</td><tr>
<tr><td>1186</td><td>1882</td><td>935</td><td>10122</td><td>0</td><tr>
<tr><td>1146</td><td>1883</td><td>1119</td><td>14674</td><td>0</td><tr>
<tr><td>1243</td><td>1883</td><td>242</td><td>14749</td><td>0</td><tr>
<tr><td>1250</td><td>1883</td><td>523</td><td>9202</td><td>0</td><tr>
<tr><td>1259</td><td>1883</td><td>284</td><td>19491</td><td>0</td><tr>
<tr><td>1188</td><td>1884</td><td>1052</td><td>10521</td><td>0</td><tr>
<tr><td>1281</td><td>1887</td><td>606</td><td>14372</td><td>0</td><tr>
<tr><td>1301</td><td>1894</td><td>711</td><td>12712</td><td>0</td><tr>
<tr><td>1306</td><td>1898</td><td>786</td><td>12640</td><td>0</td><tr>
<tr><td>1130</td><td>1905</td><td>902</td><td>15191</td><td>0</td><tr>
<tr><td>1200</td><td>1906</td><td>967</td><td>7542</td><td>0</td><tr>
<tr><td>1128</td><td>1913</td><td>1045</td><td>15403</td><td>0</td><tr>
<tr><td>1291</td><td>1913</td><td>682</td><td>7870</td><td>0</td><tr>
<tr><td>867</td><td>1914</td><td>1355</td><td>22415</td><td>0</td><tr>
<tr><td>1325</td><td>1914</td><td>826</td><td>13840</td><td>0</td><tr>
<tr><td>1196</td><td>1915</td><td>1084</td><td>15895</td><td>0</td><tr>
<tr><td>1302</td><td>1915</td><td>750</td><td>10848</td><td>0</td><tr>
<tr><td>1135</td><td>1917</td><td>1013</td><td>11610</td><td>0</td><tr>
<tr><td>1206</td><td>1918</td><td>940</td><td>10397</td><td>0</td><tr>
<tr><td>910</td><td>1919</td><td>1200</td><td>20229</td><td>0</td><tr>
<tr><td>1192</td><td>1920</td><td>1116</td><td>17866</td><td>0</td><tr>
<tr><td>1317</td><td>1925</td><td>579</td><td>292</td><td>0</td><tr>
<tr><td>1276</td><td>1926</td><td>877</td><td>8711</td><td>0</td><tr>
<tr><td>1142</td><td>1934</td><td>917</td><td>11477</td><td>0</td><tr>
<tr><td>949</td><td>1936</td><td>248</td><td>9669</td><td>0</td><tr>
<tr><td>1248</td><td>1938</td><td>511</td><td>19659</td><td>0</td><tr>
<tr><td>1136</td><td>1939</td><td>975</td><td>13782</td><td>0</td><tr>
<tr><td>1304</td><td>1941</td><td>820</td><td>6791</td><td>0</td><tr>
<tr><td>1312</td><td>1941</td><td>798</td><td>11348</td><td>0</td><tr>
<tr><td>1282</td><td>1946</td><td>672</td><td>7768</td><td>0</td><tr>
<tr><td>1288</td><td>1946</td><td>623</td><td>10303</td><td>0</td><tr>
<tr><td>1313</td><td>1946</td><td>749</td><td>6607</td><td>0</td><tr>
<tr><td>1326</td><td>1947</td><td>881</td><td>10676</td><td>0</td><tr>
<tr><td>1194</td><td>1951</td><td>1049</td><td>21179</td><td>0</td><tr>
<tr><td>818</td><td>1952</td><td>1352</td><td>7527</td><td>0</td><tr>
<tr><td>868</td><td>1952</td><td>1198</td><td>23880</td><td>0</td><tr>
<tr><td>992</td><td>1953</td><td>565</td><td>8049</td><td>0</td><tr>
<tr><td>959</td><td>1954</td><td>292</td><td>16338</td><td>0</td><tr>
<tr><td>1203</td><td>1954</td><td>948</td><td>8704</td><td>0</td><tr>
<tr><td>998</td><td>1955</td><td>505</td><td>9063</td><td>0</td><tr>
<tr><td>968</td><td>1958</td><td>399</td><td>13446</td><td>0</td><tr>
<tr><td>1138</td><td>1960</td><td>917</td><td>6564</td><td>0</td><tr>
<tr><td>920</td><td>1961</td><td>602</td><td>9367</td><td>0</td><tr>
<tr><td>1127</td><td>1967</td><td>979</td><td>12726</td><td>0</td><tr>
<tr><td>884</td><td>1969</td><td>1254</td><td>17522</td><td>0</td><tr>
<tr><td>973</td><td>1972</td><td>753</td><td>9553</td><td>0</td><tr>
<tr><td>955</td><td>1973</td><td>710</td><td>9874</td><td>0</td><tr>
<tr><td>819</td><td>1974</td><td>1484</td><td>11429</td><td>0</td><tr>
<tr><td>834</td><td>1974</td><td>1451</td><td>10128</td><td>0</td><tr>
<tr><td>1165</td><td>1974</td><td>1134</td><td>10187</td><td>0</td><tr>
<tr><td>846</td><td>1975</td><td>1404</td><td>16060</td><td>0</td><tr>
<tr><td>770</td><td>1976</td><td>817</td><td>14624</td><td>0</td><tr>
<tr><td>908</td><td>1978</td><td>1286</td><td>12721</td><td>0</td><tr>
<tr><td>1183</td><td>1978</td><td>1163</td><td>10582</td><td>0</td><tr>
<tr><td>794</td><td>1979</td><td>849</td><td>25248</td><td>0</td><tr>
<tr><td>951</td><td>1981</td><td>646</td><td>15435</td><td>0</td><tr>
<tr><td>1193</td><td>1991</td><td>1054</td><td>9274</td><td>0</td><tr>
<tr><td>777</td><td>1992</td><td>957</td><td>16633</td><td>0</td><tr>
<tr><td>875</td><td>1992</td><td>1195</td><td>19072</td><td>0</td><tr>
<tr><td>940</td><td>1994</td><td>544</td><td>9114</td><td>0</td><tr>
<tr><td>989</td><td>1995</td><td>583</td><td>8293</td><td>0</td><tr>
<tr><td>958</td><td>2001</td><td>399</td><td>3249</td><td>0</td><tr>
<tr><td>1001</td><td>2002</td><td>672</td><td>15406</td><td>0</td><tr>
<tr><td>956</td><td>2004</td><td>706</td><td>15722</td><td>0</td><tr>
<tr><td>825</td><td>2008</td><td>1364</td><td>15205</td><td>0</td><tr>
<tr><td>913</td><td>2008</td><td>1403</td><td>9450</td><td>0</td><tr>
<tr><td>965</td><td>2008</td><td>753</td><td>11755</td><td>0</td><tr>
<tr><td>879</td><td>2010</td><td>1315</td><td>19905</td><td>0</td><tr>
<tr><td>782</td><td>2012</td><td>817</td><td>8956</td><td>0</td><tr>
<tr><td>967</td><td>2012</td><td>789</td><td>15210</td><td>0</td><tr>
<tr><td>982</td><td>2013</td><td>238</td><td>11338</td><td>0</td><tr>
<tr><td>990</td><td>2014</td><td>615</td><td>12949</td><td>0</td><tr>
<tr><td>746</td><td>2017</td><td>1097</td><td>15623</td><td>0</td><tr>
<tr><td>757</td><td>2024</td><td>923</td><td>11296</td><td>0</td><tr>
<tr><td>975</td><td>2028</td><td>578</td><td>12746</td><td>0</td><tr>
<tr><td>1004</td><td>2029</td><td>1131</td><td>13604</td><td>0</td><tr>
<tr><td>853</td><td>2031</td><td>1260</td><td>15826</td><td>0</td><tr>
<tr><td>929</td><td>2032</td><td>372</td><td>6870</td><td>0</td><tr>
<tr><td>811</td><td>2040</td><td>1363</td><td>13829</td><td>0</td><tr>
<tr><td>1045</td><td>2044</td><td>1167</td><td>14539</td><td>0</td><tr>
<tr><td>978</td><td>2045</td><td>705</td><td>18425</td><td>0</td><tr>
<tr><td>721</td><td>2047</td><td>891</td><td>15981</td><td>0</td><tr>
<tr><td>740</td><td>2049</td><td>816</td><td>8137</td><td>0</td><tr>
<tr><td>931</td><td>2049</td><td>756</td><td>12651</td><td>0</td><tr>
<tr><td>946</td><td>2051</td><td>786</td><td>14491</td><td>0</td><tr>
<tr><td>791</td><td>2052</td><td>924</td><td>16555</td><td>0</td><tr>
<tr><td>831</td><td>2053</td><td>1199</td><td>14422</td><td>0</td><tr>
<tr><td>994</td><td>2055</td><td>483</td><td>8652</td><td>0</td><tr>
<tr><td>943</td><td>2062</td><td>426</td><td>9831</td><td>0</td><tr>
<tr><td>979</td><td>2062</td><td>674</td><td>23123</td><td>0</td><tr>
<tr><td>715</td><td>2064</td><td>998</td><td>12671</td><td>0</td><tr>
<tr><td>1003</td><td>2071</td><td>1184</td><td>15282</td><td>0</td><tr>
<tr><td>863</td><td>2072</td><td>1366</td><td>14735</td><td>0</td><tr>
<tr><td>712</td><td>2078</td><td>1069</td><td>10998</td><td>0</td><tr>
<tr><td>786</td><td>2079</td><td>884</td><td>14808</td><td>0</td><tr>
<tr><td>784</td><td>2080</td><td>847</td><td>13845</td><td>0</td><tr>
<tr><td>1084</td><td>2080</td><td>1255</td><td>14429</td><td>0</td><tr>
<tr><td>797</td><td>2081</td><td>1097</td><td>16312</td><td>0</td><tr>
<tr><td>723</td><td>2084</td><td>921</td><td>17090</td><td>0</td><tr>
<tr><td>997</td><td>2086</td><td>752</td><td>11382</td><td>0</td><tr>
<tr><td>961</td><td>2092</td><td>630</td><td>17022</td><td>0</td><tr>
<tr><td>711</td><td>2093</td><td>1034</td><td>14420</td><td>0</td><tr>
<tr><td>749</td><td>2096</td><td>999</td><td>17374</td><td>0</td><tr>
<tr><td>1039</td><td>2097</td><td>1156</td><td>16820</td><td>0</td><tr>
<tr><td>1114</td><td>2097</td><td>1125</td><td>8007</td><td>0</td><tr>
<tr><td>925</td><td>2098</td><td>446</td><td>11620</td><td>0</td><tr>
<tr><td>1020</td><td>2098</td><td>1311</td><td>22973</td><td>0</td><tr>
<tr><td>1061</td><td>2099</td><td>1536</td><td>13539</td><td>0</td><tr>
<tr><td>747</td><td>2101</td><td>961</td><td>16023</td><td>0</td><tr>
<tr><td>1033</td><td>2102</td><td>1195</td><td>12531</td><td>0</td><tr>
<tr><td>1007</td><td>2106</td><td>1443</td><td>16747</td><td>0</td><tr>
<tr><td>1589</td><td>2106</td><td>1814</td><td>16616</td><td>0</td><tr>
<tr><td>957</td><td>2108</td><td>660</td><td>18691</td><td>0</td><tr>
<tr><td>790</td><td>2110</td><td>1098</td><td>12904</td><td>0</td><tr>
<tr><td>756</td><td>2112</td><td>884</td><td>12182</td><td>0</td><tr>
<tr><td>1563</td><td>2113</td><td>1847</td><td>13597</td><td>0</td><tr>
<tr><td>986</td><td>2114</td><td>689</td><td>15540</td><td>0</td><tr>
<tr><td>1586</td><td>2120</td><td>1719</td><td>14302</td><td>0</td><tr>
<tr><td>1042</td><td>2127</td><td>1143</td><td>20466</td><td>0</td><tr>
<tr><td>1014</td><td>2128</td><td>1212</td><td>14605</td><td>0</td><tr>
<tr><td>1032</td><td>2128</td><td>1183</td><td>17605</td><td>0</td><tr>
<tr><td>936</td><td>2129</td><td>785</td><td>19949</td><td>0</td><tr>
<tr><td>1553</td><td>2132</td><td>1817</td><td>16898</td><td>0</td><tr>
<tr><td>1546</td><td>2134</td><td>1661</td><td>20638</td><td>0</td><tr>
<tr><td>1000</td><td>2135</td><td>625</td><td>28082</td><td>0</td><tr>
<tr><td>1030</td><td>2137</td><td>1452</td><td>15613</td><td>0</td><tr>
<tr><td>737</td><td>2139</td><td>1101</td><td>16347</td><td>0</td><tr>
<tr><td>730</td><td>2141</td><td>1066</td><td>10736</td><td>0</td><tr>
<tr><td>1094</td><td>2141</td><td>1383</td><td>16412</td><td>0</td><tr>
<tr><td>1564</td><td>2142</td><td>1684</td><td>26350</td><td>0</td><tr>
<tr><td>1566</td><td>2143</td><td>1597</td><td>16056</td><td>0</td><tr>
<tr><td>954</td><td>2145</td><td>710</td><td>18609</td><td>0</td><tr>
<tr><td>751</td><td>2146</td><td>848</td><td>12731</td><td>0</td><tr>
<tr><td>924</td><td>2147</td><td>662</td><td>17455</td><td>0</td><tr>
<tr><td>805</td><td>2148</td><td>821</td><td>11914</td><td>0</td><tr>
<tr><td>962</td><td>2152</td><td>561</td><td>10705</td><td>0</td><tr>
<tr><td>1571</td><td>2152</td><td>1760</td><td>12455</td><td>0</td><tr>
<tr><td>1577</td><td>2152</td><td>1797</td><td>12565</td><td>0</td><tr>
<tr><td>1066</td><td>2155</td><td>1131</td><td>12335</td><td>0</td><tr>
<tr><td>1559</td><td>2157</td><td>1890</td><td>13741</td><td>0</td><tr>
<tr><td>915</td><td>2159</td><td>477</td><td>10371</td><td>0</td><tr>
<tr><td>945</td><td>2159</td><td>398</td><td>17208</td><td>0</td><tr>
<tr><td>950</td><td>2161</td><td>271</td><td>6431</td><td>0</td><tr>
<tr><td>984</td><td>2162</td><td>676</td><td>14888</td><td>0</td><tr>
<tr><td>1558</td><td>2162</td><td>1658</td><td>19698</td><td>0</td><tr>
<tr><td>1105</td><td>2164</td><td>1525</td><td>11559</td><td>0</td><tr>
<tr><td>1085</td><td>2166</td><td>1431</td><td>21561</td><td>0</td><tr>
<tr><td>1044</td><td>2171</td><td>1399</td><td>8741</td><td>0</td><tr>
<tr><td>803</td><td>2173</td><td>1098</td><td>16184</td><td>0</td><tr>
<tr><td>947</td><td>2174</td><td>551</td><td>6461</td><td>0</td><tr>
<tr><td>1009</td><td>2174</td><td>1357</td><td>14881</td><td>0</td><tr>
<tr><td>1597</td><td>2174</td><td>1697</td><td>26323</td><td>0</td><tr>
<tr><td>944</td><td>2176</td><td>586</td><td>12615</td><td>0</td><tr>
<tr><td>808</td><td>2177</td><td>819</td><td>9950</td><td>0</td><tr>
<tr><td>1023</td><td>2177</td><td>1494</td><td>15832</td><td>0</td><tr>
<tr><td>1536</td><td>2178</td><td>1894</td><td>23820</td><td>0</td><tr>
<tr><td>1107</td><td>2182</td><td>1533</td><td>9134</td><td>0</td><tr>
<tr><td>1573</td><td>2182</td><td>1605</td><td>10612</td><td>0</td><tr>
<tr><td>1106</td><td>2187</td><td>1154</td><td>18598</td><td>0</td><tr>
<tr><td>1527</td><td>2188</td><td>1575</td><td>14318</td><td>0</td><tr>
<tr><td>1031</td><td>2190</td><td>1427</td><td>13181</td><td>0</td><tr>
<tr><td>1087</td><td>2196</td><td>1126</td><td>14308</td><td>0</td><tr>
<tr><td>1022</td><td>2199</td><td>1232</td><td>23503</td><td>0</td><tr>
<tr><td>927</td><td>2200</td><td>596</td><td>13537</td><td>0</td><tr>
<tr><td>1113</td><td>2201</td><td>1467</td><td>17377</td><td>0</td><tr>
<tr><td>972</td><td>2202</td><td>535</td><td>15878</td><td>0</td><tr>
<tr><td>1072</td><td>2204</td><td>1348</td><td>12863</td><td>0</td><tr>
<tr><td>934</td><td>2206</td><td>748</td><td>12094</td><td>0</td><tr>
<tr><td>776</td><td>2208</td><td>822</td><td>13435</td><td>0</td><tr>
<tr><td>1575</td><td>2208</td><td>1709</td><td>9402</td><td>0</td><tr>
<tr><td>722</td><td>2211</td><td>888</td><td>17119</td><td>0</td><tr>
<tr><td>748</td><td>2211</td><td>923</td><td>13574</td><td>0</td><tr>
<tr><td>1016</td><td>2211</td><td>1382</td><td>11582</td><td>0</td><tr>
<tr><td>1537</td><td>2214</td><td>1687</td><td>22729</td><td>0</td><tr>
<tr><td>1567</td><td>2217</td><td>1572</td><td>10203</td><td>0</td><tr>
<tr><td>1054</td><td>2218</td><td>1425</td><td>17363</td><td>0</td><tr>
<tr><td>1587</td><td>2218</td><td>1611</td><td>14825</td><td>0</td><tr>
<tr><td>1069</td><td>2221</td><td>1322</td><td>14375</td><td>0</td><tr>
<tr><td>1035</td><td>2222</td><td>1502</td><td>16664</td><td>0</td><tr>
<tr><td>686</td><td>2226</td><td>670</td><td>22079</td><td>0</td><tr>
<tr><td>796</td><td>2226</td><td>957</td><td>22156</td><td>0</td><tr>
<tr><td>1585</td><td>2226</td><td>1753</td><td>16657</td><td>0</td><tr>
<tr><td>1099</td><td>2227</td><td>1127</td><td>9062</td><td>0</td><tr>
<tr><td>1067</td><td>2228</td><td>1363</td><td>16717</td><td>0</td><tr>
<tr><td>1529</td><td>2229</td><td>1859</td><td>9894</td><td>0</td><tr>
<tr><td>687</td><td>2230</td><td>600</td><td>21367</td><td>0</td><tr>
<tr><td>1078</td><td>2233</td><td>1536</td><td>11926</td><td>0</td><tr>
<tr><td>1115</td><td>2233</td><td>1476</td><td>18315</td><td>0</td><tr>
<tr><td>646</td><td>2234</td><td>557</td><td>9026</td><td>0</td><tr>
<tr><td>736</td><td>2234</td><td>1095</td><td>13315</td><td>0</td><tr>
<tr><td>1549</td><td>2234</td><td>1783</td><td>9425</td><td>0</td><tr>
<tr><td>1593</td><td>2234</td><td>1648</td><td>13509</td><td>0</td><tr>
<tr><td>1525</td><td>2236</td><td>1567</td><td>10389</td><td>0</td><tr>
<tr><td>729</td><td>2240</td><td>853</td><td>15375</td><td>0</td><tr>
<tr><td>764</td><td>2250</td><td>1035</td><td>21160</td><td>0</td><tr>
<tr><td>1086</td><td>2250</td><td>1408</td><td>11438</td><td>0</td><tr>
<tr><td>1053</td><td>2252</td><td>1161</td><td>12403</td><td>0</td><tr>
<tr><td>1100</td><td>2252</td><td>1129</td><td>11869</td><td>0</td><tr>
<tr><td>1535</td><td>2252</td><td>1825</td><td>13481</td><td>0</td><tr>
<tr><td>1591</td><td>2252</td><td>1618</td><td>8946</td><td>0</td><tr>
<tr><td>1528</td><td>2255</td><td>1861</td><td>14518</td><td>0</td><tr>
<tr><td>937</td><td>2256</td><td>784</td><td>25680</td><td>0</td><tr>
<tr><td>1103</td><td>2257</td><td>1203</td><td>14864</td><td>0</td><tr>
<tr><td>758</td><td>2259</td><td>995</td><td>18409</td><td>0</td><tr>
<tr><td>1534</td><td>2260</td><td>1654</td><td>11903</td><td>0</td><tr>
<tr><td>685</td><td>2262</td><td>689</td><td>7577</td><td>0</td><tr>
<tr><td>1108</td><td>2264</td><td>1463</td><td>21458</td><td>0</td><tr>
<tr><td>1070</td><td>2265</td><td>1227</td><td>18304</td><td>0</td><tr>
<tr><td>1565</td><td>2265</td><td>1725</td><td>27983</td><td>0</td><tr>
<tr><td>799</td><td>2266</td><td>1098</td><td>15020</td><td>0</td><tr>
<tr><td>1555</td><td>2269</td><td>1589</td><td>14561</td><td>0</td><tr>
<tr><td>1064</td><td>2270</td><td>1371</td><td>10088</td><td>0</td><tr>
<tr><td>1077</td><td>2270</td><td>1341</td><td>14283</td><td>0</td><tr>
<tr><td>1524</td><td>2272</td><td>1903</td><td>25268</td><td>0</td><tr>
<tr><td>704</td><td>2273</td><td>554</td><td>8196</td><td>0</td><tr>
<tr><td>1544</td><td>2278</td><td>1855</td><td>21960</td><td>0</td><tr>
<tr><td>1547</td><td>2278</td><td>1561</td><td>12193</td><td>0</td><tr>
<tr><td>645</td><td>2279</td><td>711</td><td>16006</td><td>0</td><tr>
<tr><td>1082</td><td>2279</td><td>1396</td><td>15796</td><td>0</td><tr>
<tr><td>1562</td><td>2280</td><td>1817</td><td>15118</td><td>0</td><tr>
<tr><td>1595</td><td>2280</td><td>1682</td><td>28574</td><td>0</td><tr>
<tr><td>1024</td><td>2282</td><td>1133</td><td>12811</td><td>0</td><tr>
<tr><td>1057</td><td>2286</td><td>1167</td><td>15514</td><td>0</td><tr>
<tr><td>1034</td><td>2294</td><td>1429</td><td>13245</td><td>0</td><tr>
<tr><td>1581</td><td>2294</td><td>1725</td><td>13853</td><td>0</td><tr>
<tr><td>1590</td><td>2295</td><td>1583</td><td>11688</td><td>0</td><tr>
<tr><td>1038</td><td>2297</td><td>1340</td><td>12847</td><td>0</td><tr>
<tr><td>1071</td><td>2298</td><td>1288</td><td>15604</td><td>0</td><tr>
<tr><td>1088</td><td>2298</td><td>1223</td><td>12913</td><td>0</td><tr>
<tr><td>1076</td><td>2299</td><td>1537</td><td>14681</td><td>0</td><tr>
<tr><td>942</td><td>2300</td><td>781</td><td>14297</td><td>0</td><tr>
<tr><td>1102</td><td>2301</td><td>1488</td><td>11443</td><td>0</td><tr>
<tr><td>713</td><td>2302</td><td>829</td><td>17328</td><td>0</td><tr>
<tr><td>1543</td><td>2302</td><td>1839</td><td>15274</td><td>0</td><tr>
<tr><td>700</td><td>2306</td><td>719</td><td>22928</td><td>0</td><tr>
<tr><td>696</td><td>2307</td><td>546</td><td>6227</td><td>0</td><tr>
<tr><td>732</td><td>2308</td><td>873</td><td>25576</td><td>0</td><tr>
<tr><td>1029</td><td>2308</td><td>1384</td><td>13576</td><td>0</td><tr>
<tr><td>1531</td><td>2308</td><td>1886</td><td>21987</td><td>0</td><tr>
<tr><td>768</td><td>2313</td><td>1046</td><td>12855</td><td>0</td><tr>
<tr><td>1596</td><td>2313</td><td>1686</td><td>20049</td><td>0</td><tr>
<tr><td>308</td><td>2316</td><td>1131</td><td>30638</td><td>0</td><tr>
<tr><td>1570</td><td>2316</td><td>1733</td><td>19907</td><td>0</td><tr>
<tr><td>726</td><td>2321</td><td>989</td><td>17765</td><td>0</td><tr>
<tr><td>1110</td><td>2323</td><td>1306</td><td>9123</td><td>0</td><tr>
<tr><td>1560</td><td>2326</td><td>1595</td><td>20001</td><td>0</td><tr>
<tr><td>1091</td><td>2332</td><td>1459</td><td>9592</td><td>0</td><tr>
<tr><td>1583</td><td>2332</td><td>1570</td><td>18987</td><td>0</td><tr>
<tr><td>310</td><td>2334</td><td>1089</td><td>9724</td><td>0</td><tr>
<tr><td>666</td><td>2336</td><td>717</td><td>17075</td><td>0</td><tr>
<tr><td>1019</td><td>2336</td><td>1501</td><td>5504</td><td>0</td><tr>
<tr><td>1058</td><td>2336</td><td>1281</td><td>17033</td><td>0</td><tr>
<tr><td>349</td><td>2339</td><td>1217</td><td>28622</td><td>0</td><tr>
<tr><td>701</td><td>2341</td><td>793</td><td>28116</td><td>0</td><tr>
<tr><td>1092</td><td>2344</td><td>1536</td><td>13099</td><td>0</td><tr>
<tr><td>1111</td><td>2345</td><td>1396</td><td>13378</td><td>0</td><tr>
<tr><td>1541</td><td>2346</td><td>1681</td><td>14042</td><td>0</td><tr>
<tr><td>1584</td><td>2346</td><td>1707</td><td>22548</td><td>0</td><tr>
<tr><td>279</td><td>2348</td><td>1181</td><td>10397</td><td>0</td><tr>
<tr><td>1048</td><td>2349</td><td>1435</td><td>8563</td><td>0</td><tr>
<tr><td>340</td><td>2351</td><td>1048</td><td>19723</td><td>0</td><tr>
<tr><td>281</td><td>2355</td><td>1269</td><td>8610</td><td>0</td><tr>
<tr><td>359</td><td>2360</td><td>1162</td><td>14852</td><td>0</td><tr>
<tr><td>1578</td><td>2360</td><td>1645</td><td>12791</td><td>0</td><tr>
<tr><td>649</td><td>2361</td><td>668</td><td>30074</td><td>0</td><tr>
<tr><td>1112</td><td>2362</td><td>1484</td><td>15181</td><td>0</td><tr>
<tr><td>360</td><td>2367</td><td>1214</td><td>10067</td><td>0</td><tr>
<tr><td>699</td><td>2370</td><td>626</td><td>13641</td><td>0</td><tr>
<tr><td>689</td><td>2371</td><td>567</td><td>13795</td><td>0</td><tr>
<tr><td>1533</td><td>2372</td><td>1563</td><td>23690</td><td>0</td><tr>
<tr><td>930</td><td>2374</td><td>349</td><td>1336</td><td>0</td><tr>
<tr><td>1540</td><td>2383</td><td>1690</td><td>22447</td><td>0</td><tr>
<tr><td>665</td><td>2384</td><td>500</td><td>8306</td><td>0</td><tr>
<tr><td>341</td><td>2386</td><td>1353</td><td>13508</td><td>0</td><tr>
<tr><td>1097</td><td>2388</td><td>1396</td><td>10607</td><td>0</td><tr>
<tr><td>672</td><td>2389</td><td>894</td><td>20075</td><td>0</td><tr>
<tr><td>668</td><td>2390</td><td>769</td><td>19569</td><td>0</td><tr>
<tr><td>1010</td><td>2398</td><td>1461</td><td>14576</td><td>0</td><tr>
<tr><td>1104</td><td>2400</td><td>1513</td><td>27807</td><td>0</td><tr>
<tr><td>1080</td><td>2408</td><td>1420</td><td>14898</td><td>0</td><tr>
<tr><td>362</td><td>2412</td><td>1060</td><td>10098</td><td>0</td><tr>
<tr><td>640</td><td>2413</td><td>757</td><td>8604</td><td>0</td><tr>
<tr><td>1073</td><td>2421</td><td>1540</td><td>19488</td><td>0</td><tr>
<tr><td>702</td><td>2433</td><td>539</td><td>6019</td><td>0</td><tr>
<tr><td>678</td><td>2439</td><td>771</td><td>10741</td><td>0</td><tr>
<tr><td>369</td><td>2440</td><td>1351</td><td>18759</td><td>0</td><tr>
<tr><td>336</td><td>2444</td><td>1066</td><td>15679</td><td>0</td><tr>
<tr><td>534</td><td>2446</td><td>461</td><td>8650</td><td>0</td><tr>
<tr><td>376</td><td>2447</td><td>1094</td><td>20506</td><td>0</td><tr>
<tr><td>352</td><td>2448</td><td>1046</td><td>7561</td><td>0</td><tr>
<tr><td>318</td><td>2475</td><td>1446</td><td>14331</td><td>0</td><tr>
<tr><td>660</td><td>2480</td><td>584</td><td>6782</td><td>0</td><tr>
<tr><td>348</td><td>2494</td><td>1177</td><td>16376</td><td>0</td><tr>
<tr><td>307</td><td>2496</td><td>1380</td><td>18227</td><td>0</td><tr>
<tr><td>350</td><td>2497</td><td>1454</td><td>11215</td><td>0</td><tr>
<tr><td>475</td><td>2503</td><td>458</td><td>6127</td><td>0</td><tr>
<tr><td>321</td><td>2506</td><td>1000</td><td>10777</td><td>0</td><tr>
<tr><td>370</td><td>2506</td><td>1346</td><td>25697</td><td>0</td><tr>
<tr><td>510</td><td>2511</td><td>398</td><td>7156</td><td>0</td><tr>
<tr><td>292</td><td>2515</td><td>1254</td><td>14281</td><td>0</td><tr>
<tr><td>309</td><td>2515</td><td>1445</td><td>7015</td><td>0</td><tr>
<tr><td>295</td><td>2516</td><td>1201</td><td>19591</td><td>0</td><tr>
<tr><td>1467</td><td>2516</td><td>2025</td><td>18483</td><td>0</td><tr>
<tr><td>658</td><td>2517</td><td>554</td><td>3381</td><td>0</td><tr>
<tr><td>304</td><td>2518</td><td>1414</td><td>14628</td><td>0</td><tr>
<tr><td>647</td><td>2518</td><td>738</td><td>16701</td><td>0</td><tr>
<tr><td>1515</td><td>2518</td><td>1967</td><td>28699</td><td>0</td><tr>
<tr><td>1520</td><td>2521</td><td>2090</td><td>14454</td><td>0</td><tr>
<tr><td>314</td><td>2523</td><td>1283</td><td>18157</td><td>0</td><tr>
<tr><td>1493</td><td>2527</td><td>1840</td><td>17487</td><td>0</td><tr>
<tr><td>1509</td><td>2529</td><td>1891</td><td>25055</td><td>0</td><tr>
<tr><td>298</td><td>2531</td><td>1347</td><td>10049</td><td>0</td><tr>
<tr><td>1487</td><td>2539</td><td>1940</td><td>22717</td><td>0</td><tr>
<tr><td>1502</td><td>2542</td><td>1804</td><td>17495</td><td>0</td><tr>
<tr><td>312</td><td>2546</td><td>1096</td><td>35543</td><td>0</td><tr>
<tr><td>1468</td><td>2546</td><td>2062</td><td>30987</td><td>0</td><tr>
<tr><td>1485</td><td>2547</td><td>1767</td><td>19369</td><td>0</td><tr>
<tr><td>1501</td><td>2547</td><td>1993</td><td>39923</td><td>0</td><tr>
<tr><td>1484</td><td>2549</td><td>1845</td><td>16248</td><td>0</td><tr>
<tr><td>1457</td><td>2550</td><td>2179</td><td>18178</td><td>0</td><tr>
<tr><td>1488</td><td>2559</td><td>1947</td><td>27883</td><td>0</td><tr>
<tr><td>670</td><td>2563</td><td>695</td><td>16784</td><td>0</td><tr>
<tr><td>1522</td><td>2573</td><td>1797</td><td>12855</td><td>0</td><tr>
<tr><td>432</td><td>2576</td><td>1073</td><td>10504</td><td>0</td><tr>
<tr><td>1508</td><td>2577</td><td>1966</td><td>31222</td><td>0</td><tr>
<tr><td>1521</td><td>2577</td><td>2028</td><td>33810</td><td>0</td><tr>
<tr><td>1505</td><td>2578</td><td>2079</td><td>27155</td><td>0</td><tr>
<tr><td>462</td><td>2579</td><td>1144</td><td>10899</td><td>0</td><tr>
<tr><td>380</td><td>2582</td><td>1115</td><td>12688</td><td>0</td><tr>
<tr><td>1482</td><td>2583</td><td>2126</td><td>18889</td><td>0</td><tr>
<tr><td>1495</td><td>2583</td><td>1756</td><td>21984</td><td>0</td><tr>
<tr><td>437</td><td>2586</td><td>1203</td><td>22214</td><td>0</td><tr>
<tr><td>439</td><td>2586</td><td>1344</td><td>19684</td><td>0</td><tr>
<tr><td>413</td><td>2592</td><td>1065</td><td>13044</td><td>0</td><tr>
<tr><td>1459</td><td>2593</td><td>1919</td><td>22791</td><td>0</td><tr>
<tr><td>1473</td><td>2603</td><td>2090</td><td>21433</td><td>0</td><tr>
<tr><td>1497</td><td>2605</td><td>1728</td><td>26880</td><td>0</td><tr>
<tr><td>395</td><td>2608</td><td>1352</td><td>19843</td><td>0</td><tr>
<tr><td>427</td><td>2612</td><td>1317</td><td>12950</td><td>0</td><tr>
<tr><td>1477</td><td>2614</td><td>1798</td><td>28321</td><td>0</td><tr>
<tr><td>467</td><td>2615</td><td>1096</td><td>17602</td><td>0</td><tr>
<tr><td>436</td><td>2616</td><td>1250</td><td>14053</td><td>0</td><tr>
<tr><td>1514</td><td>2620</td><td>1892</td><td>26949</td><td>0</td><tr>
<tr><td>442</td><td>2623</td><td>1065</td><td>13312</td><td>0</td><tr>
<tr><td>1466</td><td>2623</td><td>1936</td><td>23187</td><td>0</td><tr>
<tr><td>451</td><td>2626</td><td>1040</td><td>10567</td><td>0</td><tr>
<tr><td>1498</td><td>2628</td><td>2012</td><td>31894</td><td>0</td><tr>
<tr><td>384</td><td>2630</td><td>1115</td><td>17970</td><td>0</td><tr>
<tr><td>1460</td><td>2631</td><td>1819</td><td>21456</td><td>0</td><tr>
<tr><td>1456</td><td>2635</td><td>1975</td><td>20038</td><td>0</td><tr>
<tr><td>435</td><td>2636</td><td>1329</td><td>17192</td><td>0</td><tr>
<tr><td>389</td><td>2641</td><td>1356</td><td>12057</td><td>0</td><tr>
<tr><td>408</td><td>2641</td><td>1202</td><td>20840</td><td>0</td><tr>
<tr><td>1475</td><td>2642</td><td>2105</td><td>32124</td><td>0</td><tr>
<tr><td>1513</td><td>2646</td><td>1851</td><td>20715</td><td>0</td><tr>
<tr><td>532</td><td>2649</td><td>790</td><td>18379</td><td>0</td><tr>
<tr><td>1476</td><td>2650</td><td>2056</td><td>23313</td><td>0</td><tr>
<tr><td>1503</td><td>2650</td><td>1782</td><td>28553</td><td>0</td><tr>
<tr><td>383</td><td>2655</td><td>1257</td><td>7975</td><td>0</td><tr>
<tr><td>1481</td><td>2656</td><td>1968</td><td>28245</td><td>0</td><tr>
<tr><td>1474</td><td>2660</td><td>1924</td><td>16634</td><td>0</td><tr>
<tr><td>407</td><td>2663</td><td>1364</td><td>20232</td><td>0</td><tr>
<tr><td>464</td><td>2663</td><td>1328</td><td>17445</td><td>0</td><tr>
<tr><td>478</td><td>2666</td><td>683</td><td>10638</td><td>0</td><tr>
<tr><td>1491</td><td>2674</td><td>1737</td><td>32918</td><td>0</td><tr>
<tr><td>1471</td><td>2676</td><td>2097</td><td>26119</td><td>0</td><tr>
<tr><td>1517</td><td>2679</td><td>1937</td><td>31034</td><td>0</td><tr>
<tr><td>530</td><td>2682</td><td>808</td><td>19220</td><td>0</td><tr>
<tr><td>1469</td><td>2682</td><td>1893</td><td>21006</td><td>0</td><tr>
<tr><td>1480</td><td>2683</td><td>1766</td><td>28261</td><td>0</td><tr>
<tr><td>1486</td><td>2683</td><td>2125</td><td>26230</td><td>0</td><tr>
<tr><td>511</td><td>2684</td><td>756</td><td>4939</td><td>0</td><tr>
<tr><td>448</td><td>2686</td><td>1315</td><td>8323</td><td>0</td><tr>
<tr><td>513</td><td>2688</td><td>654</td><td>10608</td><td>0</td><tr>
<tr><td>1478</td><td>2694</td><td>2094</td><td>21608</td><td>0</td><tr>
<tr><td>1465</td><td>2695</td><td>1796</td><td>20226</td><td>0</td><tr>
<tr><td>516</td><td>2701</td><td>502</td><td>4004</td><td>0</td><tr>
<tr><td>1470</td><td>2704</td><td>1855</td><td>13385</td><td>0</td><tr>
<tr><td>420</td><td>2707</td><td>1003</td><td>15148</td><td>0</td><tr>
<tr><td>1511</td><td>2710</td><td>1895</td><td>24659</td><td>0</td><tr>
<tr><td>535</td><td>2714</td><td>755</td><td>17889</td><td>0</td><tr>
<tr><td>1489</td><td>2720</td><td>2082</td><td>20943</td><td>0</td><tr>
<tr><td>445</td><td>2723</td><td>1266</td><td>19452</td><td>0</td><tr>
<tr><td>473</td><td>2724</td><td>647</td><td>15692</td><td>0</td><tr>
<tr><td>525</td><td>2726</td><td>719</td><td>10606</td><td>0</td><tr>
<tr><td>508</td><td>2727</td><td>674</td><td>8097</td><td>0</td><tr>
<tr><td>400</td><td>2733</td><td>1240</td><td>15335</td><td>0</td><tr>
<tr><td>454</td><td>2736</td><td>1303</td><td>9914</td><td>0</td><tr>
<tr><td>457</td><td>2743</td><td>1217</td><td>6260</td><td>0</td><tr>
<tr><td>434</td><td>2744</td><td>1288</td><td>4329</td><td>0</td><tr>
<tr><td>517</td><td>2747</td><td>539</td><td>9249</td><td>0</td><tr>
<tr><td>486</td><td>2750</td><td>757</td><td>9240</td><td>0</td><tr>
<tr><td>488</td><td>2760</td><td>681</td><td>3934</td><td>0</td><tr>
<tr><td>537</td><td>2761</td><td>643</td><td>6552</td><td>0</td><tr>
<tr><td>540</td><td>2762</td><td>712</td><td>2274</td><td>0</td><tr>
<tr><td>614</td><td>2766</td><td>1056</td><td>22730</td><td>0</td><tr>
<tr><td>494</td><td>2776</td><td>755</td><td>8413</td><td>0</td><tr>
<tr><td>564</td><td>2792</td><td>1273</td><td>29551</td><td>0</td><tr>
<tr><td>536</td><td>2796</td><td>677</td><td>2027</td><td>0</td><tr>
<tr><td>528</td><td>2798</td><td>644</td><td>3755</td><td>0</td><tr>
<tr><td>533</td><td>2798</td><td>720</td><td>8907</td><td>0</td><tr>
<tr><td>620</td><td>2798</td><td>1069</td><td>29972</td><td>0</td><tr>
<tr><td>559</td><td>2813</td><td>1290</td><td>24832</td><td>0</td><tr>
<tr><td>474</td><td>2814</td><td>747</td><td>9640</td><td>0</td><tr>
<tr><td>515</td><td>2816</td><td>903</td><td>17736</td><td>0</td><tr>
<tr><td>552</td><td>2839</td><td>1300</td><td>24755</td><td>0</td><tr>
<tr><td>503</td><td>2840</td><td>711</td><td>9753</td><td>0</td><tr>
<tr><td>469</td><td>2842</td><td>680</td><td>5703</td><td>0</td><tr>
<tr><td>547</td><td>2844</td><td>812</td><td>34913</td><td>0</td><tr>
<tr><td>1384</td><td>2866</td><td>1526</td><td>23840</td><td>0</td><tr>
<tr><td>500</td><td>2870</td><td>769</td><td>34758</td><td>0</td><tr>
<tr><td>617</td><td>2872</td><td>1274</td><td>15723</td><td>0</td><tr>
<tr><td>544</td><td>2888</td><td>818</td><td>33930</td><td>0</td><tr>
<tr><td>610</td><td>2888</td><td>1121</td><td>16815</td><td>0</td><tr>
<tr><td>1416</td><td>2901</td><td>1530</td><td>23814</td><td>0</td><tr>
<tr><td>633</td><td>2908</td><td>1258</td><td>13096</td><td>0</td><tr>
<tr><td>1357</td><td>2916</td><td>1481</td><td>9199</td><td>0</td><tr>
<tr><td>1415</td><td>2935</td><td>1502</td><td>23474</td><td>0</td><tr>
<tr><td>1345</td><td>2938</td><td>1468</td><td>12334</td><td>0</td><tr>
<tr><td>1427</td><td>2944</td><td>1527</td><td>32830</td><td>0</td><tr>
<tr><td>589</td><td>2950</td><td>1116</td><td>17909</td><td>0</td><tr>
<tr><td>609</td><td>2951</td><td>1217</td><td>16097</td><td>0</td><tr>
<tr><td>1424</td><td>2970</td><td>1480</td><td>24946</td><td>0</td><tr>
<tr><td>612</td><td>2977</td><td>1201</td><td>18601</td><td>0</td><tr>
<tr><td>579</td><td>2994</td><td>1018</td><td>14670</td><td>0</td><tr>
<tr><td>561</td><td>3002</td><td>1112</td><td>15761</td><td>0</td><tr>
<tr><td>1342</td><td>3003</td><td>1480</td><td>5154</td><td>0</td><tr>
<tr><td>585</td><td>3006</td><td>1144</td><td>19076</td><td>0</td><tr>
<tr><td>1349</td><td>3026</td><td>1526</td><td>21116</td><td>0</td><tr>
<tr><td>1367</td><td>3029</td><td>1462</td><td>11623</td><td>0</td><tr>
<tr><td>1392</td><td>3050</td><td>1476</td><td>17268</td><td>0</td><tr>
<tr><td>1402</td><td>3058</td><td>1533</td><td>17195</td><td>0</td><tr>
<tr><td>1354</td><td>3065</td><td>1445</td><td>4711</td><td>0</td><tr>
<tr><td>1365</td><td>3086</td><td>1495</td><td>26480</td><td>0</td><tr>
<tr><td>1343</td><td>3088</td><td>1447</td><td>17727</td><td>0</td><tr>
<tr><td>1340</td><td>3093</td><td>1388</td><td>6538</td><td>0</td><tr>
<tr><td>1377</td><td>3107</td><td>1348</td><td>5317</td><td>0</td><tr>
<tr><td>1403</td><td>3118</td><td>1519</td><td>50709</td><td>0</td><tr>
<tr><td>234</td><td>3126</td><td>1017</td><td>9435</td><td>0</td><tr>
<tr><td>1347</td><td>3134</td><td>1469</td><td>23043</td><td>0</td><tr>
<tr><td>1336</td><td>3138</td><td>1441</td><td>18932</td><td>0</td><tr>
<tr><td>1339</td><td>3143</td><td>1376</td><td>32445</td><td>0</td><tr>
<tr><td>1394</td><td>3154</td><td>1410</td><td>16821</td><td>0</td><tr>
<tr><td>1337</td><td>3157</td><td>1458</td><td>8904</td><td>0</td><tr>
<tr><td>1417</td><td>3177</td><td>1298</td><td>20942</td><td>0</td><tr>
<tr><td>1333</td><td>3178</td><td>1384</td><td>29871</td><td>0</td><tr>
<tr><td>1401</td><td>3179</td><td>1326</td><td>14147</td><td>0</td><tr>
<tr><td>212</td><td>3181</td><td>1171</td><td>38879</td><td>0</td><tr>
<tr><td>1346</td><td>3181</td><td>1434</td><td>15204</td><td>0</td><tr>
<tr><td>1390</td><td>3190</td><td>1528</td><td>28956</td><td>0</td><tr>
<tr><td>1364</td><td>3194</td><td>1404</td><td>8323</td><td>0</td><tr>
<tr><td>1356</td><td>3195</td><td>1445</td><td>9195</td><td>0</td><tr>
<tr><td>1388</td><td>3197</td><td>1349</td><td>10055</td><td>0</td><tr>
<tr><td>1387</td><td>3199</td><td>1500</td><td>12780</td><td>0</td><tr>
<tr><td>1366</td><td>3200</td><td>1265</td><td>12787</td><td>0</td><tr>
<tr><td>1425</td><td>3201</td><td>1291</td><td>8589</td><td>0</td><tr>
<tr><td>1410</td><td>3204</td><td>1316</td><td>8044</td><td>0</td><tr>
<tr><td>236</td><td>3208</td><td>1185</td><td>9703</td><td>0</td><tr>
<tr><td>1399</td><td>3208</td><td>1481</td><td>13462</td><td>0</td><tr>
<tr><td>1400</td><td>3212</td><td>1363</td><td>13486</td><td>0</td><tr>
<tr><td>1353</td><td>3214</td><td>1270</td><td>7468</td><td>0</td><tr>
<tr><td>1355</td><td>3214</td><td>1337</td><td>13472</td><td>0</td><tr>
<tr><td>1335</td><td>3215</td><td>1460</td><td>8720</td><td>0</td><tr>
<tr><td>1386</td><td>3216</td><td>1392</td><td>16578</td><td>0</td><tr>
<tr><td>1404</td><td>3222</td><td>1437</td><td>6099</td><td>0</td><tr>
<tr><td>1344</td><td>3223</td><td>1522</td><td>19244</td><td>0</td><tr>
<tr><td>1369</td><td>3224</td><td>1421</td><td>9237</td><td>0</td><tr>
<tr><td>1358</td><td>3243</td><td>1483</td><td>15442</td><td>0</td><tr>
<tr><td>1372</td><td>3243</td><td>1529</td><td>11890</td><td>0</td><tr>
<tr><td>1420</td><td>3243</td><td>1365</td><td>9935</td><td>0</td><tr>
<tr><td>1352</td><td>3245</td><td>1451</td><td>21299</td><td>0</td><tr>
<tr><td>1385</td><td>3247</td><td>1276</td><td>21167</td><td>0</td><tr>
<tr><td>1375</td><td>3248</td><td>1433</td><td>23437</td><td>0</td><tr>
<tr><td>1421</td><td>3251</td><td>1346</td><td>8070</td><td>0</td><tr>
<tr><td>1374</td><td>3253</td><td>1423</td><td>17200</td><td>0</td><tr>
<tr><td>1348</td><td>3254</td><td>1389</td><td>16596</td><td>0</td><tr>
<tr><td>1408</td><td>3256</td><td>1318</td><td>12026</td><td>0</td><tr>
<tr><td>241</td><td>3259</td><td>1116</td><td>15013</td><td>0</td><tr>
<tr><td>1406</td><td>3261</td><td>1473</td><td>7848</td><td>0</td><tr>
<tr><td>1361</td><td>3265</td><td>1300</td><td>20536</td><td>0</td><tr>
<tr><td>1423</td><td>3268</td><td>1501</td><td>13664</td><td>0</td><tr>
<tr><td>1381</td><td>3271</td><td>1359</td><td>6378</td><td>0</td><tr>
<tr><td>257</td><td>3272</td><td>1133</td><td>24136</td><td>0</td><tr>
<tr><td>1338</td><td>3275</td><td>1297</td><td>10231</td><td>0</td><tr>
<tr><td>1419</td><td>3276</td><td>1527</td><td>26302</td><td>0</td><tr>
<tr><td>1382</td><td>3279</td><td>1423</td><td>8547</td><td>0</td><tr>
<tr><td>1395</td><td>3279</td><td>1443</td><td>4682</td><td>0</td><tr>
<tr><td>262</td><td>3283</td><td>1093</td><td>16800</td><td>0</td><tr>
<tr><td>1360</td><td>3288</td><td>1399</td><td>9105</td><td>0</td><tr>
<tr><td>1380</td><td>3289</td><td>1422</td><td>9576</td><td>0</td><tr>
<tr><td>1422</td><td>3290</td><td>1483</td><td>9715</td><td>0</td><tr>
<tr><td>1428</td><td>3293</td><td>1374</td><td>9313</td><td>0</td><tr>
<tr><td>1411</td><td>3301</td><td>1396</td><td>7415</td><td>0</td><tr>
<tr><td>1378</td><td>3303</td><td>1505</td><td>14929</td><td>0</td><tr>
<tr><td>1391</td><td>3315</td><td>1432</td><td>8852</td><td>0</td><tr>
<tr><td>264</td><td>3316</td><td>1020</td><td>11293</td><td>0</td><tr>
<tr><td>1431</td><td>3316</td><td>1477</td><td>7757</td><td>0</td><tr>
<tr><td>1383</td><td>3320</td><td>1421</td><td>9752</td><td>0</td><tr>
<tr><td>1398</td><td>3321</td><td>1401</td><td>10777</td><td>0</td><tr>
<tr><td>1389</td><td>3327</td><td>1449</td><td>8922</td><td>0</td><tr>
<tr><td>273</td><td>3354</td><td>1013</td><td>15509</td><td>0</td><tr>
<tr><td>1397</td><td>3355</td><td>1455</td><td>16672</td><td>0</td><tr>
<tr><td>1332</td><td>3374</td><td>1413</td><td>36650</td><td>0</td><tr>
<tr><td>259</td><td>3420</td><td>1036</td><td>8033</td><td>0</td><tr>
<tr><td>129</td><td>3431</td><td>1272</td><td>19745</td><td>0</td><tr>
<tr><td>198</td><td>3437</td><td>995</td><td>33808</td><td>0</td><tr>
<tr><td>193</td><td>3456</td><td>895</td><td>23855</td><td>0</td><tr>
<tr><td>166</td><td>3459</td><td>791</td><td>4373</td><td>0</td><tr>
<tr><td>139</td><td>3471</td><td>1180</td><td>21318</td><td>0</td><tr>
<tr><td>114</td><td>3533</td><td>668</td><td>3761</td><td>0</td><tr>
<tr><td>108</td><td>3542</td><td>745</td><td>20010</td><td>0</td><tr>
<tr><td>115</td><td>3577</td><td>689</td><td>12585</td><td>0</td><tr>
<tr><td>116</td><td>3594</td><td>752</td><td>18703</td><td>0</td><tr>
<tr><td>112</td><td>3639</td><td>678</td><td>7384</td><td>0</td><tr>
<tr><td>94</td><td>3677</td><td>770</td><td>16316</td><td>0</td><tr>
<tr><td>82</td><td>3716</td><td>1025</td><td>4504</td><td>0</td><tr>
<tr><td>66</td><td>3742</td><td>677</td><td>19119</td><td>0</td><tr>
<tr><td>70</td><td>3787</td><td>748</td><td>18216</td><td>0</td><tr>
<tr><td>73</td><td>3807</td><td>619</td><td>19887</td><td>0</td><tr>
<tr><td>708</td><td>2450</td><td>740</td><td>18886</td><td>50</td><tr>
<tr><td>288</td><td>2435</td><td>1327</td><td>22832</td><td>329</td><tr>
<tr><td>985</td><td>2143</td><td>601</td><td>8136</td><td>809</td><tr>
<tr><td>161</td><td>3507</td><td>734</td><td>33458</td><td>1086</td><tr>
<tr><td>919</td><td>2120</td><td>577</td><td>11615</td><td>1180</td><tr>
<tr><td>124</td><td>3392</td><td>1319</td><td>46413</td><td>1414</td><tr>
<tr><td>607</td><td>3005</td><td>1205</td><td>24244</td><td>2502</td><tr>
<tr><td>1021</td><td>2132</td><td>1413</td><td>16080</td><td>2503</td><tr>
<tr><td>1341</td><td>3110</td><td>1462</td><td>29549</td><td>2508</td><tr>
<tr><td>1519</td><td>2585</td><td>1834</td><td>37013</td><td>2509</td><tr>
<tr><td>524</td><td>2786</td><td>789</td><td>14005</td><td>2527</td><tr>
<tr><td>981</td><td>1974</td><td>788</td><td>10222</td><td>2540</td><tr>
<tr><td>873</td><td>1951</td><td>1315</td><td>12397</td><td>2545</td><tr>
<tr><td>117</td><td>3606</td><td>659</td><td>23337</td><td>2548</td><tr>
<tr><td>185</td><td>3504</td><td>1027</td><td>14665</td><td>2549</td><tr>
<tr><td>991</td><td>2066</td><td>529</td><td>23407</td><td>2558</td><tr>
<tr><td>286</td><td>2547</td><td>1246</td><td>23517</td><td>2569</td><tr>
<tr><td>857</td><td>1847</td><td>1432</td><td>13386</td><td>2570</td><tr>
<tr><td>793</td><td>2037</td><td>999</td><td>16552</td><td>2570</td><tr>
<tr><td>1205</td><td>1979</td><td>1016</td><td>12738</td><td>2584</td><tr>
<tr><td>1046</td><td>2213</td><td>1268</td><td>15653</td><td>2586</td><tr>
<tr><td>339</td><td>2411</td><td>1176</td><td>12796</td><td>2587</td><tr>
<tr><td>1429</td><td>2900</td><td>1501</td><td>34162</td><td>2590</td><tr>
<tr><td>452</td><td>2737</td><td>1001</td><td>14274</td><td>2610</td><tr>
<tr><td>223</td><td>3117</td><td>1051</td><td>36638</td><td>2612</td><tr>
<tr><td>1095</td><td>2364</td><td>1407</td><td>35738</td><td>2613</td><tr>
<tr><td>745</td><td>2178</td><td>884</td><td>14780</td><td>2617</td><tr>
<tr><td>344</td><td>2492</td><td>1216</td><td>14630</td><td>2621</td><tr>
<tr><td>1157</td><td>1853</td><td>1083</td><td>13459</td><td>2630</td><tr>
<tr><td>1063</td><td>2378</td><td>1439</td><td>11273</td><td>2632</td><tr>
<tr><td>577</td><td>2800</td><td>1009</td><td>23914</td><td>2650</td><tr>
<tr><td>691</td><td>2371</td><td>820</td><td>18809</td><td>2652</td><tr>
<tr><td>755</td><td>2246</td><td>819</td><td>12920</td><td>2658</td><tr>
<tr><td>848</td><td>1851</td><td>1473</td><td>14748</td><td>2669</td><tr>
<tr><td>302</td><td>2469</td><td>1394</td><td>25943</td><td>2675</td><tr>
<tr><td>1139</td><td>1510</td><td>881</td><td>8254</td><td>2687</td><tr>
<tr><td>539</td><td>2815</td><td>607</td><td>11249</td><td>2702</td><tr>
<tr><td>287</td><td>2501</td><td>1313</td><td>18661</td><td>2704</td><tr>
<tr><td>1572</td><td>2170</td><td>1845</td><td>19344</td><td>2705</td><tr>
<tr><td>1379</td><td>3299</td><td>1465</td><td>6338</td><td>2714</td><tr>
<tr><td>1418</td><td>2970</td><td>1514</td><td>20326</td><td>2727</td><tr>
<tr><td>1180</td><td>2002</td><td>1134</td><td>13095</td><td>2729</td><tr>
<tr><td>345</td><td>2448</td><td>962</td><td>27864</td><td>2732</td><tr>
<tr><td>450</td><td>2601</td><td>1388</td><td>20676</td><td>2736</td><tr>
<tr><td>1523</td><td>2299</td><td>1772</td><td>16103</td><td>2740</td><tr>
<tr><td>1532</td><td>2186</td><td>1806</td><td>23686</td><td>2745</td><tr>
<tr><td>497</td><td>2763</td><td>822</td><td>28820</td><td>2757</td><tr>
<tr><td>738</td><td>2304</td><td>913</td><td>17888</td><td>2758</td><tr>
<tr><td>1552</td><td>2203</td><td>1778</td><td>15022</td><td>2778</td><tr>
<tr><td>1542</td><td>2226</td><td>1829</td><td>12621</td><td>2794</td><tr>
<tr><td>1545</td><td>2235</td><td>1698</td><td>23708</td><td>2794</td><tr>
<tr><td>752</td><td>2180</td><td>918</td><td>20921</td><td>2797</td><tr>
<tr><td>75</td><td>3778</td><td>663</td><td>36301</td><td>2801</td><tr>
<tr><td>1499</td><td>2690</td><td>1983</td><td>26049</td><td>2803</td><tr>
<tr><td>917</td><td>2006</td><td>447</td><td>18840</td><td>2807</td><tr>
<tr><td>365</td><td>2450</td><td>1446</td><td>21856</td><td>2809</td><tr>
<tr><td>694</td><td>2224</td><td>642</td><td>25910</td><td>2810</td><tr>
<tr><td>194</td><td>3290</td><td>923</td><td>14004</td><td>2817</td><tr>
<tr><td>771</td><td>2127</td><td>1034</td><td>15621</td><td>2818</td><tr>
<tr><td>1526</td><td>2110</td><td>1567</td><td>33389</td><td>2820</td><tr>
<tr><td>371</td><td>2521</td><td>1380</td><td>23052</td><td>2833</td><tr>
<tr><td>351</td><td>2456</td><td>1476</td><td>15650</td><td>2837</td><tr>
<tr><td>852</td><td>2007</td><td>1239</td><td>16861</td><td>2842</td><tr>
<tr><td>305</td><td>2372</td><td>1244</td><td>22363</td><td>2854</td><tr>
<tr><td>1319</td><td>1551</td><td>837</td><td>15981</td><td>2856</td><tr>
<tr><td>765</td><td>2111</td><td>841</td><td>21971</td><td>2908</td><tr>
<tr><td>882</td><td>1777</td><td>1371</td><td>8859</td><td>2911</td><tr>
<tr><td>301</td><td>2519</td><td>1120</td><td>17096</td><td>2912</td><tr>
<tr><td>1047</td><td>2271</td><td>1518</td><td>21065</td><td>2914</td><tr>
<tr><td>416</td><td>2694</td><td>1283</td><td>14203</td><td>2915</td><tr>
<tr><td>219</td><td>3197</td><td>1017</td><td>7644</td><td>2916</td><tr>
<tr><td>697</td><td>2486</td><td>667</td><td>31884</td><td>2923</td><tr>
<tr><td>664</td><td>2389</td><td>860</td><td>22497</td><td>2925</td><tr>
<tr><td>1413</td><td>3116</td><td>1413</td><td>21171</td><td>2931</td><tr>
<tr><td>1580</td><td>2188</td><td>1676</td><td>24527</td><td>2936</td><tr>
<tr><td>64</td><td>3888</td><td>460</td><td>74664</td><td>2938</td><tr>
<tr><td>170</td><td>3387</td><td>774</td><td>24849</td><td>2940</td><tr>
<tr><td>781</td><td>2012</td><td>844</td><td>17262</td><td>2941</td><tr>
<tr><td>271</td><td>3397</td><td>1011</td><td>29236</td><td>2945</td><tr>
<tr><td>470</td><td>2623</td><td>497</td><td>7675</td><td>2952</td><tr>
<tr><td>960</td><td>2092</td><td>787</td><td>17518</td><td>2958</td><tr>
<tr><td>88</td><td>3751</td><td>1041</td><td>2962</td><td>2962</td><tr>
<tr><td>1268</td><td>1937</td><td>717</td><td>14178</td><td>2971</td><tr>
<tr><td>1405</td><td>3185</td><td>1468</td><td>14266</td><td>2971</td><tr>
<tr><td>300</td><td>2464</td><td>1284</td><td>28075</td><td>2974</td><tr>
<tr><td>1026</td><td>2101</td><td>1219</td><td>15297</td><td>2980</td><tr>
<tr><td>705</td><td>2519</td><td>820</td><td>23784</td><td>2982</td><tr>
<tr><td>763</td><td>2317</td><td>950</td><td>19050</td><td>2983</td><tr>
<tr><td>935</td><td>2032</td><td>548</td><td>17669</td><td>3001</td><tr>
<tr><td>731</td><td>2048</td><td>844</td><td>12766</td><td>3005</td><tr>
<tr><td>613</td><td>2868</td><td>1014</td><td>22360</td><td>3007</td><tr>
<tr><td>1185</td><td>1759</td><td>1127</td><td>10451</td><td>3030</td><tr>
<tr><td>1036</td><td>2394</td><td>1567</td><td>30328</td><td>3033</td><tr>
<tr><td>995</td><td>2157</td><td>745</td><td>13466</td><td>3054</td><tr>
<tr><td>1430</td><td>3005</td><td>1505</td><td>20372</td><td>3054</td><tr>
<tr><td>926</td><td>2016</td><td>648</td><td>13458</td><td>3056</td><tr>
<tr><td>267</td><td>3284</td><td>1075</td><td>16249</td><td>3081</td><tr>
<tr><td>871</td><td>1842</td><td>1235</td><td>14089</td><td>3082</td><tr>
<tr><td>1123</td><td>1521</td><td>949</td><td>6131</td><td>3105</td><tr>
<tr><td>1262</td><td>1477</td><td>303</td><td>14234</td><td>3124</td><tr>
<tr><td>817</td><td>1924</td><td>1418</td><td>23059</td><td>3129</td><tr>
<tr><td>734</td><td>2034</td><td>961</td><td>20041</td><td>3133</td><tr>
<tr><td>1299</td><td>1816</td><td>742</td><td>10711</td><td>3137</td><tr>
<tr><td>1068</td><td>2442</td><td>1511</td><td>14557</td><td>3144</td><tr>
<tr><td>651</td><td>2330</td><td>840</td><td>16288</td><td>3149</td><tr>
<tr><td>487</td><td>2768</td><td>867</td><td>23129</td><td>3154</td><tr>
<tr><td>837</td><td>1660</td><td>1392</td><td>6908</td><td>3171</td><tr>
<tr><td>277</td><td>2437</td><td>1295</td><td>17075</td><td>3178</td><tr>
<tr><td>266</td><td>3267</td><td>983</td><td>42829</td><td>3183</td><tr>
<tr><td>753</td><td>2004</td><td>999</td><td>23162</td><td>3187</td><tr>
<tr><td>619</td><td>2763</td><td>1204</td><td>23834</td><td>3187</td><tr>
<tr><td>719</td><td>2237</td><td>884</td><td>15843</td><td>3205</td><tr>
<tr><td>838</td><td>1719</td><td>1416</td><td>11393</td><td>3214</td><tr>
<tr><td>1530</td><td>2156</td><td>1563</td><td>16829</td><td>3228</td><tr>
<tr><td>1434</td><td>3122</td><td>1418</td><td>3245</td><td>3245</td><tr>
<tr><td>121</td><td>3588</td><td>800</td><td>33681</td><td>3250</td><tr>
<tr><td>1190</td><td>2012</td><td>1166</td><td>17448</td><td>3255</td><tr>
<tr><td>855</td><td>2078</td><td>1289</td><td>18288</td><td>3272</td><tr>
<tr><td>801</td><td>2155</td><td>1028</td><td>18194</td><td>3283</td><tr>
<tr><td>885</td><td>1805</td><td>1427</td><td>11156</td><td>3302</td><tr>
<tr><td>1101</td><td>2427</td><td>1496</td><td>22372</td><td>3327</td><tr>
<tr><td>399</td><td>2583</td><td>1160</td><td>20439</td><td>3335</td><tr>
<tr><td>401</td><td>2655</td><td>1064</td><td>16879</td><td>3364</td><tr>
<tr><td>1376</td><td>3084</td><td>1529</td><td>18459</td><td>3368</td><tr>
<tr><td>438</td><td>2621</td><td>1390</td><td>18078</td><td>3369</td><tr>
<tr><td>1462</td><td>2625</td><td>2053</td><td>29030</td><td>3377</td><tr>
<tr><td>809</td><td>2143</td><td>886</td><td>17951</td><td>3387</td><tr>
<tr><td>1554</td><td>2289</td><td>1629</td><td>24776</td><td>3399</td><tr>
<tr><td>742</td><td>2075</td><td>816</td><td>9816</td><td>3404</td><tr>
<tr><td>823</td><td>1914</td><td>1245</td><td>15251</td><td>3438</td><tr>
<tr><td>468</td><td>2705</td><td>1053</td><td>16892</td><td>3448</td><tr>
<tr><td>1018</td><td>2160</td><td>1240</td><td>23098</td><td>3452</td><tr>
<tr><td>605</td><td>2765</td><td>1121</td><td>27536</td><td>3493</td><tr>
<tr><td>1373</td><td>3150</td><td>1521</td><td>40044</td><td>3516</td><tr>
<tr><td>720</td><td>2269</td><td>912</td><td>19748</td><td>3517</td><tr>
<tr><td>337</td><td>2405</td><td>1146</td><td>17377</td><td>3525</td><tr>
<tr><td>600</td><td>2848</td><td>1186</td><td>19902</td><td>3530</td><tr>
<tr><td>237</td><td>3069</td><td>1190</td><td>28882</td><td>3545</td><tr>
<tr><td>866</td><td>1878</td><td>1349</td><td>21521</td><td>3546</td><tr>
<tr><td>724</td><td>2067</td><td>960</td><td>20117</td><td>3546</td><tr>
<tr><td>67</td><td>3862</td><td>702</td><td>35575</td><td>3549</td><tr>
<tr><td>1556</td><td>2314</td><td>1643</td><td>23501</td><td>3557</td><tr>
<tr><td>759</td><td>2360</td><td>949</td><td>21258</td><td>3570</td><tr>
<tr><td>631</td><td>2850</td><td>1149</td><td>21871</td><td>3576</td><tr>
<tr><td>548</td><td>2668</td><td>936</td><td>33185</td><td>3577</td><tr>
<tr><td>1062</td><td>2227</td><td>1198</td><td>30868</td><td>3584</td><tr>
<tr><td>361</td><td>2479</td><td>1241</td><td>31693</td><td>3590</td><tr>
<tr><td>806</td><td>2275</td><td>828</td><td>21729</td><td>3592</td><tr>
<tr><td>1551</td><td>2152</td><td>1847</td><td>28285</td><td>3639</td><tr>
<tr><td>1079</td><td>2415</td><td>1583</td><td>19559</td><td>3655</td><tr>
<tr><td>1294</td><td>1480</td><td>579</td><td>6271</td><td>3656</td><tr>
<tr><td>1074</td><td>2099</td><td>1504</td><td>27136</td><td>3661</td><tr>
<tr><td>1090</td><td>2122</td><td>1248</td><td>21451</td><td>3664</td><tr>
<tr><td>1037</td><td>2330</td><td>1343</td><td>29830</td><td>3670</td><tr>
<tr><td>1252</td><td>1668</td><td>522</td><td>12504</td><td>3678</td><tr>
<tr><td>282</td><td>2400</td><td>956</td><td>18035</td><td>3691</td><tr>
<tr><td>971</td><td>1981</td><td>315</td><td>9376</td><td>3714</td><tr>
<tr><td>1189</td><td>1679</td><td>1155</td><td>11056</td><td>3765</td><tr>
<tr><td>504</td><td>2498</td><td>528</td><td>15164</td><td>3775</td><tr>
<tr><td>639</td><td>2853</td><td>1085</td><td>20760</td><td>3779</td><tr>
<tr><td>1330</td><td>1896</td><td>867</td><td>13135</td><td>3787</td><tr>
<tr><td>443</td><td>2613</td><td>1214</td><td>20520</td><td>3790</td><tr>
<tr><td>684</td><td>2537</td><td>824</td><td>17123</td><td>3792</td><tr>
<tr><td>769</td><td>2173</td><td>1068</td><td>13462</td><td>3794</td><tr>
<tr><td>1464</td><td>2720</td><td>1936</td><td>36056</td><td>3820</td><tr>
<tr><td>643</td><td>2324</td><td>475</td><td>15987</td><td>3830</td><tr>
<tr><td>426</td><td>2651</td><td>1033</td><td>24175</td><td>3838</td><tr>
<tr><td>1569</td><td>2399</td><td>1619</td><td>30468</td><td>3849</td><tr>
<tr><td>1412</td><td>3078</td><td>1467</td><td>19623</td><td>3849</td><tr>
<tr><td>1311</td><td>1884</td><td>749</td><td>12453</td><td>3854</td><tr>
<tr><td>291</td><td>2551</td><td>1283</td><td>26281</td><td>3863</td><tr>
<tr><td>1239</td><td>1647</td><td>452</td><td>25289</td><td>3873</td><tr>
<tr><td>754</td><td>2294</td><td>1072</td><td>18640</td><td>3874</td><tr>
<tr><td>1539</td><td>2107</td><td>1656</td><td>23942</td><td>3878</td><tr>
<tr><td>299</td><td>2495</td><td>1273</td><td>20055</td><td>3898</td><tr>
<tr><td>463</td><td>2579</td><td>1387</td><td>21911</td><td>3934</td><tr>
<tr><td>512</td><td>2856</td><td>850</td><td>26033</td><td>3946</td><tr>
<tr><td>1579</td><td>2109</td><td>1760</td><td>17216</td><td>3953</td><tr>
<tr><td>642</td><td>2274</td><td>598</td><td>29114</td><td>3968</td><tr>
<tr><td>916</td><td>2176</td><td>625</td><td>12493</td><td>3972</td><tr>
<tr><td>505</td><td>2752</td><td>793</td><td>23029</td><td>3972</td><tr>
<tr><td>1574</td><td>2205</td><td>1861</td><td>21774</td><td>3995</td><tr>
<tr><td>586</td><td>2801</td><td>1033</td><td>25119</td><td>4007</td><tr>
<tr><td>208</td><td>3270</td><td>1192</td><td>34319</td><td>4030</td><tr>
<tr><td>527</td><td>2727</td><td>827</td><td>32069</td><td>4045</td><tr>
<tr><td>775</td><td>2012</td><td>1066</td><td>15811</td><td>4052</td><tr>
<tr><td>1461</td><td>2690</td><td>2016</td><td>30196</td><td>4055</td><tr>
<tr><td>456</td><td>2667</td><td>1144</td><td>17459</td><td>4075</td><tr>
<tr><td>316</td><td>2376</td><td>1276</td><td>13954</td><td>4113</td><tr>
<tr><td>453</td><td>2575</td><td>1271</td><td>32439</td><td>4115</td><tr>
<tr><td>948</td><td>2057</td><td>629</td><td>18969</td><td>4135</td><tr>
<tr><td>1056</td><td>2140</td><td>1492</td><td>26583</td><td>4148</td><tr>
<tr><td>785</td><td>1977</td><td>884</td><td>23129</td><td>4157</td><tr>
<tr><td>966</td><td>2122</td><td>722</td><td>14125</td><td>4176</td><tr>
<tr><td>1006</td><td>2135</td><td>1524</td><td>23869</td><td>4177</td><tr>
<tr><td>1592</td><td>2219</td><td>1900</td><td>30723</td><td>4202</td><tr>
<tr><td>1448</td><td>3040</td><td>1482</td><td>4202</td><td>4202</td><tr>
<tr><td>1512</td><td>2733</td><td>1983</td><td>25937</td><td>4214</td><tr>
<tr><td>795</td><td>2154</td><td>961</td><td>24083</td><td>4223</td><tr>
<tr><td>1334</td><td>3080</td><td>1411</td><td>14173</td><td>4234</td><tr>
<tr><td>1028</td><td>2209</td><td>1293</td><td>20311</td><td>4252</td><tr>
<tr><td>1458</td><td>2718</td><td>2044</td><td>32728</td><td>4259</td><tr>
<tr><td>654</td><td>2578</td><td>655</td><td>18711</td><td>4262</td><tr>
<tr><td>1129</td><td>1986</td><td>1076</td><td>19786</td><td>4287</td><tr>
<tr><td>1254</td><td>1530</td><td>445</td><td>18189</td><td>4358</td><tr>
<tr><td>802</td><td>2283</td><td>1033</td><td>19925</td><td>4380</td><tr>
<tr><td>147</td><td>3213</td><td>940</td><td>41412</td><td>4382</td><tr>
<tr><td>476</td><td>2715</td><td>899</td><td>22633</td><td>4383</td><tr>
<tr><td>662</td><td>2427</td><td>894</td><td>21641</td><td>4410</td><tr>
<tr><td>824</td><td>1879</td><td>1226</td><td>18388</td><td>4415</td><tr>
<tr><td>419</td><td>2682</td><td>1042</td><td>27936</td><td>4430</td><tr>
<tr><td>406</td><td>2683</td><td>1197</td><td>19030</td><td>4448</td><tr>
<tr><td>661</td><td>2356</td><td>876</td><td>39007</td><td>4452</td><tr>
<tr><td>1083</td><td>2321</td><td>1244</td><td>22556</td><td>4454</td><tr>
<tr><td>143</td><td>3441</td><td>1061</td><td>26781</td><td>4467</td><tr>
<tr><td>1594</td><td>2114</td><td>1593</td><td>33889</td><td>4471</td><tr>
<tr><td>377</td><td>2742</td><td>1096</td><td>21840</td><td>4471</td><tr>
<tr><td>565</td><td>2817</td><td>1240</td><td>23680</td><td>4491</td><tr>
<tr><td>417</td><td>2662</td><td>1225</td><td>20394</td><td>4502</td><tr>
<tr><td>522</td><td>2711</td><td>787</td><td>19466</td><td>4519</td><tr>
<tr><td>431</td><td>2642</td><td>1229</td><td>21182</td><td>4529</td><tr>
<tr><td>725</td><td>2060</td><td>1031</td><td>19047</td><td>4560</td><tr>
<tr><td>663</td><td>2465</td><td>767</td><td>15491</td><td>4586</td><tr>
<tr><td>207</td><td>3276</td><td>896</td><td>18642</td><td>4597</td><tr>
<tr><td>1211</td><td>1852</td><td>440</td><td>18066</td><td>4606</td><tr>
<tr><td>76</td><td>3820</td><td>699</td><td>23383</td><td>4618</td><tr>
<tr><td>814</td><td>1803</td><td>1347</td><td>17876</td><td>4622</td><tr>
<tr><td>735</td><td>2125</td><td>997</td><td>23628</td><td>4630</td><tr>
<tr><td>132</td><td>3409</td><td>1203</td><td>37368</td><td>4642</td><tr>
<tr><td>338</td><td>2485</td><td>1477</td><td>14200</td><td>4655</td><tr>
<tr><td>1052</td><td>2143</td><td>1310</td><td>26297</td><td>4689</td><tr>
<tr><td>545</td><td>2655</td><td>537</td><td>8681</td><td>4722</td><tr>
<tr><td>1075</td><td>2067</td><td>1139</td><td>28833</td><td>4762</td><tr>
<tr><td>492</td><td>2744</td><td>598</td><td>18561</td><td>4778</td><tr>
<tr><td>1172</td><td>1665</td><td>1057</td><td>15684</td><td>4793</td><tr>
<tr><td>1409</td><td>3029</td><td>1487</td><td>17246</td><td>4807</td><tr>
<tr><td>1561</td><td>2343</td><td>1733</td><td>24252</td><td>4810</td><tr>
<tr><td>779</td><td>2047</td><td>1069</td><td>16604</td><td>4830</td><tr>
<tr><td>317</td><td>2378</td><td>920</td><td>22657</td><td>4835</td><tr>
<tr><td>928</td><td>1945</td><td>446</td><td>19640</td><td>4840</td><tr>
<tr><td>588</td><td>2911</td><td>1228</td><td>23650</td><td>4850</td><tr>
<tr><td>1414</td><td>3157</td><td>1341</td><td>34903</td><td>4879</td><tr>
<tr><td>728</td><td>2018</td><td>884</td><td>16741</td><td>4884</td><tr>
<tr><td>122</td><td>3380</td><td>1271</td><td>32721</td><td>4909</td><tr>
<tr><td>446</td><td>2706</td><td>1217</td><td>19349</td><td>4925</td><tr>
<tr><td>1510</td><td>2674</td><td>2051</td><td>30815</td><td>4961</td><tr>
<tr><td>778</td><td>2206</td><td>1066</td><td>25429</td><td>4969</td><tr>
<tr><td>761</td><td>2265</td><td>1069</td><td>15951</td><td>4970</td><tr>
<tr><td>433</td><td>2711</td><td>1026</td><td>24009</td><td>4981</td><tr>
<tr><td>466</td><td>2725</td><td>1095</td><td>22418</td><td>4987</td><tr>
<tr><td>952</td><td>2293</td><td>413</td><td>8011</td><td>4990</td><tr>
<tr><td>1043</td><td>2144</td><td>1347</td><td>27242</td><td>4992</td><tr>
<tr><td>498</td><td>2765</td><td>973</td><td>29673</td><td>5001</td><tr>
<tr><td>354</td><td>2528</td><td>1312</td><td>15970</td><td>5011</td><tr>
<tr><td>1187</td><td>1896</td><td>1020</td><td>19006</td><td>5014</td><tr>
<tr><td>789</td><td>2220</td><td>995</td><td>19589</td><td>5036</td><tr>
<tr><td>656</td><td>2269</td><td>654</td><td>25260</td><td>5036</td><tr>
<tr><td>405</td><td>2665</td><td>1175</td><td>27026</td><td>5073</td><tr>
<tr><td>482</td><td>2667</td><td>975</td><td>20624</td><td>5088</td><tr>
<tr><td>918</td><td>2068</td><td>369</td><td>19337</td><td>5099</td><tr>
<tr><td>1245</td><td>1798</td><td>309</td><td>15199</td><td>5157</td><tr>
<tr><td>294</td><td>2472</td><td>1158</td><td>18906</td><td>5165</td><tr>
<tr><td>750</td><td>2142</td><td>920</td><td>19242</td><td>5208</td><tr>
<tr><td>1015</td><td>2263</td><td>1304</td><td>24400</td><td>5228</td><tr>
<tr><td>1550</td><td>2363</td><td>1594</td><td>23852</td><td>5248</td><tr>
<tr><td>1164</td><td>1913</td><td>1159</td><td>16852</td><td>5294</td><tr>
<tr><td>165</td><td>3487</td><td>932</td><td>30214</td><td>5296</td><tr>
<tr><td>707</td><td>2471</td><td>704</td><td>32782</td><td>5352</td><tr>
<tr><td>634</td><td>2789</td><td>1236</td><td>24497</td><td>5357</td><tr>
<tr><td>392</td><td>2704</td><td>1249</td><td>18793</td><td>5420</td><tr>
<tr><td>71</td><td>3716</td><td>718</td><td>36256</td><td>5427</td><tr>
<tr><td>1217</td><td>1667</td><td>451</td><td>13087</td><td>5443</td><tr>
<tr><td>382</td><td>2641</td><td>1174</td><td>24673</td><td>5474</td><tr>
<tr><td>1182</td><td>1989</td><td>1106</td><td>19323</td><td>5488</td><tr>
<tr><td>594</td><td>2987</td><td>998</td><td>22927</td><td>5501</td><tr>
<tr><td>578</td><td>2924</td><td>1301</td><td>25745</td><td>5560</td><tr>
<tr><td>441</td><td>2546</td><td>1388</td><td>21670</td><td>5563</td><tr>
<tr><td>615</td><td>2926</td><td>1204</td><td>35396</td><td>5587</td><tr>
<tr><td>840</td><td>1934</td><td>1279</td><td>12681</td><td>5598</td><tr>
<tr><td>158</td><td>3417</td><td>938</td><td>45575</td><td>5610</td><tr>
<tr><td>681</td><td>2524</td><td>654</td><td>25657</td><td>5629</td><tr>
<tr><td>682</td><td>2434</td><td>570</td><td>11433</td><td>5637</td><tr>
<tr><td>922</td><td>2085</td><td>721</td><td>20134</td><td>5648</td><tr>
<tr><td>1008</td><td>2102</td><td>1361</td><td>25869</td><td>5649</td><tr>
<tr><td>1568</td><td>2127</td><td>1879</td><td>19555</td><td>5655</td><tr>
<tr><td>1041</td><td>2154</td><td>1167</td><td>16744</td><td>5656</td><tr>
<tr><td>988</td><td>2180</td><td>745</td><td>16146</td><td>5658</td><tr>
<tr><td>890</td><td>1946</td><td>1264</td><td>15783</td><td>5722</td><tr>
<tr><td>1436</td><td>3090</td><td>1409</td><td>5748</td><td>5748</td><tr>
<tr><td>993</td><td>2247</td><td>719</td><td>18554</td><td>5764</td><tr>
<tr><td>870</td><td>2068</td><td>1329</td><td>20030</td><td>5775</td><tr>
<tr><td>1265</td><td>1839</td><td>711</td><td>15776</td><td>5791</td><tr>
<tr><td>603</td><td>2952</td><td>1055</td><td>23598</td><td>5807</td><tr>
<tr><td>353</td><td>2411</td><td>1384</td><td>29120</td><td>5828</td><tr>
<tr><td>1516</td><td>2658</td><td>1884</td><td>37921</td><td>5854</td><tr>
<tr><td>1438</td><td>3249</td><td>1358</td><td>5874</td><td>5874</td><tr>
<tr><td>744</td><td>2211</td><td>850</td><td>17119</td><td>5892</td><tr>
<tr><td>912</td><td>2008</td><td>1441</td><td>19810</td><td>5912</td><tr>
<tr><td>325</td><td>2553</td><td>1313</td><td>22661</td><td>5938</td><tr>
<tr><td>1005</td><td>2274</td><td>1262</td><td>21687</td><td>5939</td><tr>
<tr><td>480</td><td>2735</td><td>971</td><td>25605</td><td>5945</td><tr>
<tr><td>1176</td><td>1891</td><td>964</td><td>19101</td><td>6025</td><tr>
<tr><td>743</td><td>2272</td><td>876</td><td>27919</td><td>6028</td><tr>
<tr><td>963</td><td>2104</td><td>540</td><td>24053</td><td>6078</td><tr>
<tr><td>283</td><td>2377</td><td>1179</td><td>17372</td><td>6107</td><tr>
<tr><td>1260</td><td>1628</td><td>296</td><td>25281</td><td>6188</td><tr>
<tr><td>938</td><td>2170</td><td>787</td><td>22282</td><td>6192</td><tr>
<tr><td>1126</td><td>1782</td><td>1098</td><td>21907</td><td>6202</td><tr>
<tr><td>773</td><td>2191</td><td>1033</td><td>22995</td><td>6211</td><tr>
<tr><td>109</td><td>3542</td><td>861</td><td>21378</td><td>6211</td><tr>
<tr><td>459</td><td>2572</td><td>1201</td><td>18865</td><td>6229</td><tr>
<tr><td>471</td><td>2678</td><td>901</td><td>39819</td><td>6231</td><tr>
<tr><td>1209</td><td>1881</td><td>1085</td><td>18721</td><td>6235</td><tr>
<tr><td>1433</td><td>2930</td><td>1538</td><td>6247</td><td>6247</td><tr>
<tr><td>1060</td><td>2157</td><td>1199</td><td>19453</td><td>6265</td><tr>
<tr><td>703</td><td>2496</td><td>892</td><td>29614</td><td>6303</td><tr>
<tr><td>412</td><td>2673</td><td>1291</td><td>24727</td><td>6305</td><tr>
<tr><td>1002</td><td>2223</td><td>1156</td><td>22700</td><td>6347</td><tr>
<tr><td>113</td><td>3553</td><td>661</td><td>29866</td><td>6381</td><tr>
<tr><td>637</td><td>2767</td><td>1014</td><td>25198</td><td>6400</td><tr>
<tr><td>402</td><td>2565</td><td>1356</td><td>30137</td><td>6448</td><tr>
<tr><td>716</td><td>2259</td><td>958</td><td>23156</td><td>6457</td><tr>
<tr><td>1280</td><td>1852</td><td>783</td><td>11625</td><td>6515</td><tr>
<tr><td>816</td><td>2021</td><td>1197</td><td>21314</td><td>6574</td><tr>
<tr><td>626</td><td>2793</td><td>1143</td><td>24663</td><td>6607</td><tr>
<tr><td>141</td><td>3391</td><td>1216</td><td>26999</td><td>6614</td><tr>
<tr><td>1494</td><td>2560</td><td>1723</td><td>30936</td><td>6689</td><tr>
<tr><td>110</td><td>3616</td><td>702</td><td>26031</td><td>6693</td><tr>
<tr><td>171</td><td>3229</td><td>883</td><td>38037</td><td>6720</td><tr>
<tr><td>616</td><td>2874</td><td>1212</td><td>26158</td><td>6744</td><tr>
<tr><td>1435</td><td>3180</td><td>1386</td><td>6765</td><td>6765</td><tr>
<tr><td>554</td><td>2922</td><td>1087</td><td>22975</td><td>6795</td><tr>
<tr><td>484</td><td>2771</td><td>588</td><td>17872</td><td>6859</td><tr>
<tr><td>1025</td><td>2093</td><td>1258</td><td>20302</td><td>6880</td><tr>
<tr><td>970</td><td>2004</td><td>496</td><td>46036</td><td>6887</td><tr>
<tr><td>526</td><td>2841</td><td>974</td><td>32917</td><td>6893</td><tr>
<tr><td>1013</td><td>2371</td><td>1523</td><td>20624</td><td>6916</td><tr>
<tr><td>798</td><td>2105</td><td>1065</td><td>16616</td><td>6924</td><tr>
<tr><td>367</td><td>2548</td><td>1344</td><td>14913</td><td>6934</td><tr>
<tr><td>415</td><td>2708</td><td>1309</td><td>20483</td><td>6934</td><tr>
<tr><td>964</td><td>2201</td><td>787</td><td>22640</td><td>6960</td><tr>
<tr><td>440</td><td>2595</td><td>1015</td><td>20540</td><td>6987</td><tr>
<tr><td>1277</td><td>1914</td><td>654</td><td>14092</td><td>7010</td><tr>
<tr><td>1490</td><td>2712</td><td>2112</td><td>32414</td><td>7016</td><tr>
<tr><td>923</td><td>2226</td><td>469</td><td>17559</td><td>7031</td><tr>
<tr><td>905</td><td>1895</td><td>1464</td><td>30654</td><td>7034</td><tr>
<tr><td>1538</td><td>2353</td><td>1620</td><td>27627</td><td>7123</td><tr>
<tr><td>760</td><td>2190</td><td>998</td><td>27034</td><td>7140</td><tr>
<tr><td>1109</td><td>2103</td><td>1407</td><td>28827</td><td>7176</td><tr>
<tr><td>584</td><td>2828</td><td>1103</td><td>30407</td><td>7185</td><tr>
<tr><td>673</td><td>2459</td><td>625</td><td>17062</td><td>7196</td><tr>
<tr><td>326</td><td>2439</td><td>984</td><td>27750</td><td>7216</td><tr>
<tr><td>604</td><td>2941</td><td>1277</td><td>25594</td><td>7217</td><tr>
<tr><td>306</td><td>2509</td><td>1036</td><td>24162</td><td>7230</td><tr>
<tr><td>278</td><td>2477</td><td>933</td><td>15481</td><td>7253</td><tr>
<tr><td>1051</td><td>2366</td><td>1353</td><td>27878</td><td>7277</td><tr>
<tr><td>575</td><td>2843</td><td>1225</td><td>21744</td><td>7277</td><tr>
<tr><td>571</td><td>2776</td><td>1039</td><td>24498</td><td>7327</td><tr>
<tr><td>330</td><td>2511</td><td>933</td><td>32509</td><td>7339</td><tr>
<tr><td>134</td><td>3424</td><td>1116</td><td>33569</td><td>7350</td><tr>
<tr><td>830</td><td>1913</td><td>1297</td><td>24361</td><td>7391</td><tr>
<tr><td>680</td><td>2355</td><td>757</td><td>28881</td><td>7392</td><tr>
<tr><td>154</td><td>3379</td><td>913</td><td>35575</td><td>7422</td><tr>
<tr><td>444</td><td>2738</td><td>1159</td><td>29013</td><td>7475</td><tr>
<tr><td>254</td><td>3307</td><td>1071</td><td>14868</td><td>7517</td><tr>
<tr><td>102</td><td>3603</td><td>819</td><td>19337</td><td>7529</td><tr>
<tr><td>206</td><td>3199</td><td>887</td><td>31880</td><td>7594</td><tr>
<tr><td>1500</td><td>2629</td><td>1737</td><td>47041</td><td>7611</td><tr>
<tr><td>839</td><td>2041</td><td>1326</td><td>20884</td><td>7650</td><tr>
<tr><td>297</td><td>2553</td><td>1215</td><td>27336</td><td>7664</td><tr>
<tr><td>518</td><td>2876</td><td>904</td><td>32606</td><td>7707</td><tr>
<tr><td>252</td><td>3397</td><td>1068</td><td>22941</td><td>7709</td><tr>
<tr><td>638</td><td>2833</td><td>1023</td><td>46330</td><td>7725</td><tr>
<tr><td>221</td><td>3224</td><td>1087</td><td>43424</td><td>7730</td><tr>
<tr><td>483</td><td>2730</td><td>619</td><td>19157</td><td>7734</td><tr>
<tr><td>397</td><td>2728</td><td>1215</td><td>14415</td><td>7738</td><tr>
<tr><td>562</td><td>2822</td><td>1164</td><td>26351</td><td>7739</td><tr>
<tr><td>491</td><td>2755</td><td>895</td><td>30499</td><td>7779</td><tr>
<tr><td>570</td><td>2764</td><td>1164</td><td>42933</td><td>7832</td><tr>
<tr><td>969</td><td>2231</td><td>749</td><td>22497</td><td>7844</td><tr>
<tr><td>390</td><td>2595</td><td>1315</td><td>27747</td><td>7854</td><tr>
<tr><td>849</td><td>1896</td><td>1384</td><td>19200</td><td>7862</td><tr>
<tr><td>1055</td><td>2138</td><td>1276</td><td>30154</td><td>7870</td><tr>
<tr><td>650</td><td>2441</td><td>808</td><td>31129</td><td>7963</td><tr>
<tr><td>414</td><td>2735</td><td>1132</td><td>24961</td><td>8001</td><tr>
<tr><td>315</td><td>2472</td><td>1356</td><td>29111</td><td>8007</td><tr>
<tr><td>393</td><td>2736</td><td>1030</td><td>25054</td><td>8068</td><tr>
<tr><td>1098</td><td>2180</td><td>1271</td><td>29448</td><td>8107</td><tr>
<tr><td>251</td><td>3240</td><td>1113</td><td>27785</td><td>8166</td><tr>
<tr><td>69</td><td>3815</td><td>737</td><td>28981</td><td>8174</td><tr>
<tr><td>347</td><td>2444</td><td>1384</td><td>22088</td><td>8176</td><tr>
<tr><td>1472</td><td>2555</td><td>1738</td><td>24802</td><td>8189</td><tr>
<tr><td>597</td><td>2821</td><td>1135</td><td>30084</td><td>8238</td><tr>
<tr><td>391</td><td>2743</td><td>1269</td><td>21396</td><td>8340</td><tr>
<tr><td>551</td><td>2706</td><td>719</td><td>20769</td><td>8375</td><tr>
<tr><td>329</td><td>2353</td><td>1127</td><td>26887</td><td>8393</td><tr>
<tr><td>1518</td><td>2566</td><td>1899</td><td>47559</td><td>8407</td><tr>
<tr><td>1017</td><td>2425</td><td>1459</td><td>27621</td><td>8475</td><tr>
<tr><td>587</td><td>2834</td><td>1259</td><td>28711</td><td>8524</td><tr>
<tr><td>932</td><td>2116</td><td>493</td><td>16861</td><td>8526</td><tr>
<tr><td>327</td><td>2495</td><td>1080</td><td>40465</td><td>8595</td><tr>
<tr><td>388</td><td>2635</td><td>1145</td><td>26674</td><td>8634</td><tr>
<tr><td>357</td><td>2498</td><td>1416</td><td>30204</td><td>8675</td><tr>
<tr><td>461</td><td>2683</td><td>1086</td><td>26926</td><td>8687</td><tr>
<tr><td>688</td><td>2430</td><td>698</td><td>30945</td><td>8692</td><tr>
<tr><td>107</td><td>3649</td><td>1021</td><td>24942</td><td>8696</td><tr>
<tr><td>580</td><td>2807</td><td>1206</td><td>29733</td><td>8706</td><tr>
<tr><td>543</td><td>2702</td><td>976</td><td>25499</td><td>8707</td><tr>
<tr><td>1143</td><td>1954</td><td>1019</td><td>22145</td><td>8718</td><tr>
<tr><td>1576</td><td>2350</td><td>1760</td><td>33535</td><td>8772</td><tr>
<tr><td>783</td><td>2045</td><td>1097</td><td>24002</td><td>8808</td><tr>
<tr><td>379</td><td>2677</td><td>1260</td><td>24813</td><td>8813</td><tr>
<tr><td>429</td><td>2633</td><td>1266</td><td>23426</td><td>8838</td><tr>
<tr><td>695</td><td>2407</td><td>811</td><td>32869</td><td>8939</td><tr>
<tr><td>79</td><td>3735</td><td>997</td><td>27542</td><td>9045</td><tr>
<tr><td>939</td><td>2217</td><td>703</td><td>31637</td><td>9048</td><tr>
<tr><td>865</td><td>1978</td><td>1345</td><td>24927</td><td>9058</td><tr>
<tr><td>572</td><td>2872</td><td>1150</td><td>27182</td><td>9076</td><tr>
<tr><td>593</td><td>2910</td><td>1134</td><td>30181</td><td>9087</td><tr>
<tr><td>368</td><td>2355</td><td>1082</td><td>23313</td><td>9128</td><tr>
<tr><td>521</td><td>2646</td><td>754</td><td>21832</td><td>9132</td><tr>
<tr><td>381</td><td>2714</td><td>1127</td><td>15820</td><td>9133</td><tr>
<tr><td>502</td><td>2732</td><td>862</td><td>33550</td><td>9149</td><tr>
<tr><td>820</td><td>2075</td><td>1484</td><td>38162</td><td>9160</td><tr>
<tr><td>404</td><td>2601</td><td>1278</td><td>36873</td><td>9201</td><tr>
<tr><td>265</td><td>3365</td><td>982</td><td>37746</td><td>9227</td><tr>
<tr><td>636</td><td>2951</td><td>1087</td><td>38058</td><td>9237</td><tr>
<tr><td>876</td><td>2032</td><td>1429</td><td>23754</td><td>9272</td><tr>
<tr><td>1496</td><td>2712</td><td>1964</td><td>32867</td><td>9289</td><tr>
<tr><td>239</td><td>3137</td><td>1111</td><td>66210</td><td>9321</td><tr>
<tr><td>1117</td><td>1826</td><td>1115</td><td>20900</td><td>9338</td><tr>
<tr><td>387</td><td>2594</td><td>1233</td><td>32535</td><td>9340</td><tr>
<tr><td>430</td><td>2609</td><td>1173</td><td>29296</td><td>9371</td><tr>
<tr><td>342</td><td>2432</td><td>1262</td><td>35311</td><td>9395</td><tr>
<tr><td>74</td><td>3766</td><td>756</td><td>18574</td><td>9396</td><tr>
<tr><td>1093</td><td>2356</td><td>1307</td><td>24695</td><td>9437</td><tr>
<tr><td>409</td><td>2711</td><td>1184</td><td>29758</td><td>9446</td><tr>
<tr><td>772</td><td>2219</td><td>1037</td><td>29860</td><td>9466</td><tr>
<tr><td>296</td><td>2530</td><td>980</td><td>33432</td><td>9473</td><tr>
<tr><td>199</td><td>3329</td><td>951</td><td>25624</td><td>9488</td><tr>
<tr><td>184</td><td>3413</td><td>904</td><td>47216</td><td>9491</td><tr>
<tr><td>449</td><td>2684</td><td>1226</td><td>26802</td><td>9500</td><tr>
<tr><td>714</td><td>2203</td><td>1098</td><td>28701</td><td>9599</td><tr>
<tr><td>567</td><td>2951</td><td>1146</td><td>30121</td><td>9603</td><tr>
<tr><td>632</td><td>2767</td><td>1086</td><td>29119</td><td>9639</td><tr>
<tr><td>546</td><td>2796</td><td>863</td><td>33246</td><td>9639</td><tr>
<tr><td>1011</td><td>2241</td><td>1287</td><td>30533</td><td>9662</td><tr>
<tr><td>1059</td><td>2190</td><td>1198</td><td>25253</td><td>9669</td><tr>
<tr><td>894</td><td>1881</td><td>1303</td><td>20338</td><td>9688</td><tr>
<tr><td>97</td><td>3624</td><td>768</td><td>41652</td><td>9787</td><tr>
<tr><td>618</td><td>2991</td><td>1052</td><td>30307</td><td>9798</td><tr>
<tr><td>364</td><td>2429</td><td>1113</td><td>34027</td><td>9897</td><tr>
<tr><td>260</td><td>3218</td><td>982</td><td>29729</td><td>10068</td><tr>
<tr><td>95</td><td>3603</td><td>868</td><td>30659</td><td>10068</td><tr>
<tr><td>762</td><td>2293</td><td>999</td><td>25914</td><td>10091</td><tr>
<tr><td>974</td><td>1952</td><td>348</td><td>36001</td><td>10092</td><tr>
<tr><td>372</td><td>2410</td><td>987</td><td>34507</td><td>10124</td><tr>
<tr><td>93</td><td>3659</td><td>802</td><td>21309</td><td>10183</td><tr>
<tr><td>996</td><td>2200</td><td>645</td><td>26013</td><td>10198</td><tr>
<tr><td>238</td><td>3214</td><td>1132</td><td>38304</td><td>10199</td><tr>
<tr><td>411</td><td>2705</td><td>1085</td><td>28982</td><td>10272</td><tr>
<tr><td>1156</td><td>1829</td><td>1079</td><td>20361</td><td>10326</td><tr>
<tr><td>1507</td><td>2607</td><td>1760</td><td>33781</td><td>10346</td><tr>
<tr><td>718</td><td>2133</td><td>961</td><td>27626</td><td>10347</td><tr>
<tr><td>921</td><td>2126</td><td>738</td><td>29337</td><td>10365</td><tr>
<tr><td>303</td><td>2390</td><td>1122</td><td>49549</td><td>10453</td><tr>
<tr><td>815</td><td>2075</td><td>1406</td><td>24007</td><td>10463</td><tr>
<tr><td>523</td><td>2562</td><td>610</td><td>25648</td><td>10507</td><tr>
<tr><td>195</td><td>3293</td><td>875</td><td>26972</td><td>10519</td><tr>
<tr><td>1452</td><td>3140</td><td>1373</td><td>10604</td><td>10604</td><tr>
<tr><td>182</td><td>3198</td><td>831</td><td>32000</td><td>10699</td><tr>
<tr><td>1269</td><td>1824</td><td>593</td><td>25867</td><td>10753</td><tr>
<tr><td>514</td><td>2802</td><td>972</td><td>47907</td><td>10763</td><tr>
<tr><td>328</td><td>2442</td><td>1162</td><td>30216</td><td>10892</td><tr>
<tr><td>428</td><td>2665</td><td>1099</td><td>29350</td><td>10910</td><tr>
<tr><td>1089</td><td>2231</td><td>1239</td><td>26182</td><td>10923</td><tr>
<tr><td>61</td><td>3596</td><td>980</td><td>26459</td><td>11036</td><tr>
<tr><td>77</td><td>3931</td><td>658</td><td>42905</td><td>11077</td><tr>
<tr><td>269</td><td>3130</td><td>980</td><td>39573</td><td>11080</td><tr>
<tr><td>557</td><td>2788</td><td>1119</td><td>31246</td><td>11081</td><tr>
<tr><td>933</td><td>2184</td><td>668</td><td>25171</td><td>11153</td><tr>
<tr><td>280</td><td>2437</td><td>1029</td><td>43975</td><td>11166</td><tr>
<tr><td>987</td><td>2101</td><td>585</td><td>47733</td><td>11202</td><tr>
<tr><td>727</td><td>2178</td><td>843</td><td>25011</td><td>11230</td><tr>
<tr><td>653</td><td>2485</td><td>811</td><td>47436</td><td>11280</td><tr>
<tr><td>120</td><td>3580</td><td>862</td><td>26932</td><td>11400</td><tr>
<tr><td>156</td><td>3507</td><td>934</td><td>43658</td><td>11417</td><tr>
<tr><td>285</td><td>2449</td><td>1227</td><td>34594</td><td>11501</td><tr>
<tr><td>172</td><td>3369</td><td>859</td><td>39289</td><td>11564</td><tr>
<tr><td>648</td><td>2308</td><td>646</td><td>32103</td><td>11568</td><tr>
<tr><td>810</td><td>2033</td><td>1401</td><td>27640</td><td>11580</td><tr>
<tr><td>641</td><td>2345</td><td>490</td><td>21965</td><td>11594</td><tr>
<tr><td>674</td><td>2419</td><td>614</td><td>19064</td><td>11596</td><tr>
<tr><td>96</td><td>3665</td><td>692</td><td>30753</td><td>11780</td><tr>
<tr><td>706</td><td>2518</td><td>854</td><td>37100</td><td>11794</td><tr>
<tr><td>1027</td><td>2247</td><td>1330</td><td>21957</td><td>11850</td><tr>
<tr><td>58</td><td>3582</td><td>1019</td><td>45637</td><td>11851</td><tr>
<tr><td>1150</td><td>1942</td><td>1148</td><td>30325</td><td>11969</td><tr>
<tr><td>335</td><td>2464</td><td>1327</td><td>35094</td><td>12020</td><tr>
<tr><td>1300</td><td>1672</td><td>761</td><td>19694</td><td>12045</td><tr>
<tr><td>496</td><td>2697</td><td>674</td><td>23784</td><td>12115</td><tr>
<tr><td>423</td><td>2636</td><td>1300</td><td>30625</td><td>12154</td><tr>
<tr><td>980</td><td>2177</td><td>712</td><td>25911</td><td>12266</td><tr>
<tr><td>710</td><td>2400</td><td>700</td><td>30583</td><td>12304</td><tr>
<tr><td>591</td><td>2901</td><td>1279</td><td>30791</td><td>12343</td><tr>
<tr><td>832</td><td>2041</td><td>1289</td><td>24724</td><td>12374</td><tr>
<tr><td>519</td><td>2656</td><td>719</td><td>26688</td><td>12381</td><tr>
<tr><td>225</td><td>3250</td><td>1055</td><td>31545</td><td>12393</td><tr>
<tr><td>859</td><td>2041</td><td>1468</td><td>31423</td><td>12463</td><tr>
<tr><td>1227</td><td>1912</td><td>334</td><td>27888</td><td>12478</td><tr>
<tr><td>311</td><td>2389</td><td>1034</td><td>41736</td><td>12506</td><tr>
<tr><td>127</td><td>3429</td><td>1179</td><td>66565</td><td>12586</td><tr>
<tr><td>485</td><td>2779</td><td>499</td><td>24472</td><td>12615</td><tr>
<tr><td>472</td><td>2840</td><td>639</td><td>19965</td><td>12706</td><tr>
<tr><td>1463</td><td>2682</td><td>1845</td><td>39115</td><td>12794</td><tr>
<tr><td>313</td><td>2448</td><td>1417</td><td>35143</td><td>12896</td><tr>
<tr><td>635</td><td>2975</td><td>1239</td><td>45422</td><td>12923</td><tr>
<tr><td>189</td><td>3484</td><td>1057</td><td>46873</td><td>12951</td><tr>
<tr><td>667</td><td>2481</td><td>854</td><td>34306</td><td>12983</td><tr>
<tr><td>574</td><td>2898</td><td>1201</td><td>39201</td><td>13093</td><tr>
<tr><td>595</td><td>2904</td><td>1336</td><td>39488</td><td>13147</td><tr>
<tr><td>386</td><td>2688</td><td>1351</td><td>30260</td><td>13155</td><tr>
<tr><td>774</td><td>2199</td><td>960</td><td>30279</td><td>13374</td><tr>
<tr><td>204</td><td>3274</td><td>842</td><td>50179</td><td>13382</td><tr>
<tr><td>162</td><td>3462</td><td>678</td><td>45717</td><td>13431</td><tr>
<tr><td>175</td><td>3513</td><td>1101</td><td>83930</td><td>13467</td><tr>
<tr><td>1479</td><td>2600</td><td>1985</td><td>53401</td><td>13649</td><tr>
<tr><td>155</td><td>3517</td><td>674</td><td>48230</td><td>13775</td><tr>
<tr><td>320</td><td>2545</td><td>1056</td><td>40752</td><td>13986</td><tr>
<tr><td>556</td><td>2935</td><td>1246</td><td>47798</td><td>14072</td><tr>
<tr><td>1309</td><td>1497</td><td>718</td><td>29631</td><td>14094</td><tr>
<tr><td>590</td><td>2900</td><td>1052</td><td>34206</td><td>14110</td><tr>
<tr><td>490</td><td>2533</td><td>556</td><td>20524</td><td>14190</td><tr>
<tr><td>157</td><td>3339</td><td>900</td><td>29249</td><td>14199</td><tr>
<tr><td>827</td><td>1923</td><td>1478</td><td>31790</td><td>14208</td><tr>
<tr><td>1218</td><td>1932</td><td>445</td><td>33935</td><td>14331</td><tr>
<tr><td>263</td><td>3145</td><td>1173</td><td>67717</td><td>14366</td><tr>
<tr><td>1548</td><td>2189</td><td>1761</td><td>27271</td><td>14434</td><tr>
<tr><td>581</td><td>2972</td><td>1175</td><td>42716</td><td>14483</td><tr>
<tr><td>215</td><td>3313</td><td>982</td><td>54526</td><td>14503</td><tr>
<tr><td>622</td><td>2873</td><td>1247</td><td>40069</td><td>14508</td><tr>
<tr><td>531</td><td>2854</td><td>902</td><td>49576</td><td>14532</td><tr>
<tr><td>276</td><td>2448</td><td>1483</td><td>22741</td><td>14548</td><tr>
<tr><td>293</td><td>2484</td><td>972</td><td>33457</td><td>14585</td><tr>
<tr><td>677</td><td>2545</td><td>621</td><td>33812</td><td>14610</td><tr>
<tr><td>623</td><td>2867</td><td>1034</td><td>35171</td><td>14661</td><tr>
<tr><td>200</td><td>3317</td><td>915</td><td>33647</td><td>14802</td><tr>
<tr><td>1557</td><td>2260</td><td>1791</td><td>52734</td><td>15102</td><tr>
<tr><td>103</td><td>3670</td><td>994</td><td>17602</td><td>15150</td><tr>
<tr><td>202</td><td>3505</td><td>815</td><td>32223</td><td>15243</td><tr>
<tr><td>240</td><td>3148</td><td>1061</td><td>63090</td><td>15250</td><tr>
<tr><td>343</td><td>2382</td><td>1206</td><td>34420</td><td>15326</td><tr>
<tr><td>1432</td><td>3275</td><td>1302</td><td>15329</td><td>15329</td><tr>
<tr><td>164</td><td>3202</td><td>857</td><td>37615</td><td>15384</td><tr>
<tr><td>804</td><td>2114</td><td>913</td><td>34629</td><td>15543</td><tr>
<tr><td>231</td><td>3171</td><td>1025</td><td>35871</td><td>16088</td><tr>
<tr><td>333</td><td>2407</td><td>1262</td><td>50685</td><td>16165</td><tr>
<tr><td>780</td><td>2325</td><td>1021</td><td>29505</td><td>16178</td><tr>
<tr><td>538</td><td>2668</td><td>867</td><td>45301</td><td>16346</td><tr>
<tr><td>887</td><td>1859</td><td>1384</td><td>37853</td><td>16364</td><tr>
<tr><td>583</td><td>2830</td><td>1066</td><td>37860</td><td>16403</td><tr>
<tr><td>812</td><td>2046</td><td>1224</td><td>28107</td><td>16429</td><tr>
<tr><td>676</td><td>2418</td><td>654</td><td>55054</td><td>16560</td><tr>
<tr><td>410</td><td>2661</td><td>1126</td><td>33177</td><td>17010</td><tr>
<tr><td>289</td><td>2516</td><td>1231</td><td>34517</td><td>17340</td><tr>
<tr><td>1483</td><td>2668</td><td>1814</td><td>39109</td><td>17383</td><tr>
<tr><td>495</td><td>2397</td><td>490</td><td>23333</td><td>17404</td><tr>
<tr><td>489</td><td>2598</td><td>560</td><td>30108</td><td>17405</td><tr>
<tr><td>363</td><td>2422</td><td>930</td><td>36821</td><td>17567</td><tr>
<tr><td>418</td><td>2571</td><td>1315</td><td>39183</td><td>17689</td><tr>
<tr><td>203</td><td>3522</td><td>826</td><td>47778</td><td>17788</td><tr>
<tr><td>1081</td><td>2178</td><td>1315</td><td>33913</td><td>17822</td><tr>
<tr><td>675</td><td>2553</td><td>739</td><td>44978</td><td>17877</td><tr>
<tr><td>197</td><td>3545</td><td>1090</td><td>96138</td><td>17947</td><tr>
<tr><td>828</td><td>2076</td><td>1449</td><td>51178</td><td>18151</td><tr>
<tr><td>228</td><td>3275</td><td>1155</td><td>54479</td><td>18229</td><tr>
<tr><td>602</td><td>2865</td><td>1115</td><td>33971</td><td>18232</td><tr>
<tr><td>226</td><td>3323</td><td>1066</td><td>48467</td><td>18282</td><tr>
<tr><td>657</td><td>2299</td><td>667</td><td>32721</td><td>18310</td><tr>
<tr><td>1065</td><td>2300</td><td>1205</td><td>30572</td><td>18341</td><tr>
<tr><td>210</td><td>3111</td><td>1095</td><td>67880</td><td>18566</td><tr>
<tr><td>999</td><td>2282</td><td>748</td><td>33398</td><td>18583</td><tr>
<tr><td>119</td><td>3582</td><td>725</td><td>41702</td><td>18590</td><tr>
<tr><td>142</td><td>3446</td><td>1116</td><td>38820</td><td>18819</td><tr>
<tr><td>118</td><td>3550</td><td>793</td><td>48139</td><td>18856</td><tr>
<tr><td>235</td><td>3237</td><td>1189</td><td>59775</td><td>18999</td><tr>
<tr><td>1437</td><td>3118</td><td>1540</td><td>19020</td><td>19020</td><tr>
<tr><td>385</td><td>2647</td><td>1097</td><td>36368</td><td>19050</td><tr>
<tr><td>216</td><td>3417</td><td>1152</td><td>76530</td><td>19140</td><tr>
<tr><td>568</td><td>2882</td><td>1092</td><td>34036</td><td>19143</td><tr>
<tr><td>245</td><td>3319</td><td>1140</td><td>59565</td><td>19240</td><tr>
<tr><td>861</td><td>2062</td><td>1255</td><td>41207</td><td>19363</td><tr>
<tr><td>606</td><td>2790</td><td>1171</td><td>45047</td><td>19510</td><tr>
<tr><td>180</td><td>3265</td><td>869</td><td>52286</td><td>19663</td><tr>
<tr><td>625</td><td>2860</td><td>1056</td><td>42421</td><td>19946</td><tr>
<tr><td>573</td><td>2899</td><td>1027</td><td>38327</td><td>19989</td><tr>
<tr><td>374</td><td>2468</td><td>1415</td><td>45098</td><td>20173</td><tr>
<tr><td>145</td><td>3416</td><td>1092</td><td>43187</td><td>20185</td><tr>
<tr><td>1444</td><td>3316</td><td>1487</td><td>20205</td><td>20205</td><tr>
<tr><td>479</td><td>2642</td><td>965</td><td>53622</td><td>20277</td><tr>
<tr><td>150</td><td>3172</td><td>941</td><td>65919</td><td>20535</td><tr>
<tr><td>398</td><td>2680</td><td>1356</td><td>30293</td><td>20629</td><tr>
<tr><td>284</td><td>2519</td><td>1162</td><td>51829</td><td>20666</td><tr>
<tr><td>217</td><td>3082</td><td>1087</td><td>72689</td><td>20728</td><tr>
<tr><td>62</td><td>3622</td><td>985</td><td>48361</td><td>20801</td><tr>
<tr><td>549</td><td>2825</td><td>936</td><td>44714</td><td>21047</td><tr>
<tr><td>249</td><td>3174</td><td>978</td><td>47868</td><td>21170</td><tr>
<tr><td>100</td><td>3683</td><td>864</td><td>52188</td><td>21289</td><tr>
<tr><td>227</td><td>3071</td><td>1000</td><td>61565</td><td>21313</td><tr>
<tr><td>669</td><td>2540</td><td>903</td><td>32929</td><td>21371</td><tr>
<tr><td>800</td><td>2234</td><td>1069</td><td>37743</td><td>22012</td><tr>
<tr><td>224</td><td>3179</td><td>1072</td><td>93768</td><td>22023</td><tr>
<tr><td>322</td><td>2376</td><td>1077</td><td>46159</td><td>22089</td><tr>
<tr><td>683</td><td>2507</td><td>718</td><td>49102</td><td>22310</td><tr>
<tr><td>465</td><td>2741</td><td>1194</td><td>43757</td><td>22324</td><tr>
<tr><td>84</td><td>3583</td><td>902</td><td>43600</td><td>22575</td><tr>
<tr><td>766</td><td>2303</td><td>1117</td><td>36702</td><td>22908</td><tr>
<tr><td>629</td><td>3026</td><td>1045</td><td>52766</td><td>23178</td><tr>
<tr><td>57</td><td>3541</td><td>992</td><td>70260</td><td>23237</td><tr>
<tr><td>624</td><td>2877</td><td>1307</td><td>48463</td><td>23481</td><tr>
<tr><td>1096</td><td>2373</td><td>1320</td><td>82417</td><td>23539</td><tr>
<tr><td>78</td><td>3714</td><td>813</td><td>68526</td><td>23662</td><tr>
<tr><td>659</td><td>2501</td><td>776</td><td>51610</td><td>23681</td><tr>
<tr><td>455</td><td>2610</td><td>1132</td><td>40063</td><td>23948</td><tr>
<tr><td>1588</td><td>2102</td><td>1674</td><td>52278</td><td>23975</td><tr>
<tr><td>394</td><td>2711</td><td>1155</td><td>51414</td><td>24005</td><tr>
<tr><td>529</td><td>2655</td><td>832</td><td>40577</td><td>24062</td><tr>
<tr><td>1446</td><td>3254</td><td>1473</td><td>24127</td><td>24127</td><tr>
<tr><td>739</td><td>2321</td><td>1088</td><td>36145</td><td>24324</td><tr>
<tr><td>111</td><td>3543</td><td>700</td><td>42447</td><td>24988</td><tr>
<tr><td>403</td><td>2694</td><td>1121</td><td>51426</td><td>25089</td><tr>
<tr><td>542</td><td>2904</td><td>868</td><td>52341</td><td>25266</td><tr>
<tr><td>596</td><td>2909</td><td>1170</td><td>55590</td><td>25404</td><tr>
<tr><td>268</td><td>3094</td><td>1027</td><td>56359</td><td>25424</td><tr>
<tr><td>733</td><td>2376</td><td>979</td><td>45394</td><td>25577</td><tr>
<tr><td>621</td><td>2905</td><td>1095</td><td>47667</td><td>25671</td><tr>
<tr><td>555</td><td>3025</td><td>984</td><td>59547</td><td>26585</td><tr>
<tr><td>191</td><td>3500</td><td>856</td><td>61917</td><td>26710</td><tr>
<tr><td>499</td><td>2497</td><td>418</td><td>88098</td><td>26842</td><tr>
<tr><td>630</td><td>2978</td><td>1126</td><td>57035</td><td>26865</td><tr>
<tr><td>105</td><td>3671</td><td>1012</td><td>39335</td><td>27149</td><tr>
<tr><td>99</td><td>3649</td><td>831</td><td>53335</td><td>27629</td><tr>
<tr><td>396</td><td>2676</td><td>1002</td><td>49008</td><td>27796</td><tr>
<tr><td>220</td><td>3368</td><td>1085</td><td>52846</td><td>27847</td><tr>
<tr><td>611</td><td>2942</td><td>1181</td><td>57488</td><td>28026</td><tr>
<tr><td>101</td><td>3693</td><td>831</td><td>38951</td><td>28819</td><tr>
<tr><td>788</td><td>2005</td><td>1040</td><td>55832</td><td>29292</td><tr>
<tr><td>698</td><td>2547</td><td>779</td><td>54888</td><td>29492</td><tr>
<tr><td>1442</td><td>3133</td><td>1453</td><td>29494</td><td>29494</td><tr>
<tr><td>422</td><td>2616</td><td>1002</td><td>45797</td><td>29552</td><tr>
<tr><td>644</td><td>2532</td><td>698</td><td>54098</td><td>29713</td><tr>
<tr><td>190</td><td>3407</td><td>681</td><td>89005</td><td>29749</td><tr>
<tr><td>331</td><td>2469</td><td>1124</td><td>68008</td><td>29792</td><tr>
<tr><td>104</td><td>3657</td><td>996</td><td>36378</td><td>30049</td><tr>
<tr><td>233</td><td>3097</td><td>1182</td><td>167449</td><td>30132</td><tr>
<tr><td>558</td><td>3018</td><td>1172</td><td>76856</td><td>30286</td><tr>
<tr><td>652</td><td>2439</td><td>850</td><td>77435</td><td>30292</td><tr>
<tr><td>168</td><td>3357</td><td>749</td><td>80382</td><td>30293</td><tr>
<tr><td>671</td><td>2316</td><td>767</td><td>43996</td><td>30417</td><tr>
<tr><td>592</td><td>3031</td><td>1138</td><td>65423</td><td>30711</td><tr>
<tr><td>872</td><td>2012</td><td>1482</td><td>49474</td><td>31068</td><tr>
<tr><td>332</td><td>2470</td><td>1193</td><td>54186</td><td>31140</td><tr>
<tr><td>501</td><td>2772</td><td>890</td><td>53310</td><td>31229</td><tr>
<tr><td>196</td><td>3259</td><td>935</td><td>83362</td><td>31231</td><tr>
<tr><td>163</td><td>3463</td><td>851</td><td>44534</td><td>31264</td><tr>
<tr><td>506</td><td>2778</td><td>938</td><td>53426</td><td>31433</td><tr>
<tr><td>692</td><td>2464</td><td>895</td><td>55538</td><td>31532</td><tr>
<tr><td>717</td><td>2237</td><td>911</td><td>44865</td><td>31705</td><tr>
<tr><td>323</td><td>2537</td><td>932</td><td>55058</td><td>31722</td><tr>
<tr><td>130</td><td>3412</td><td>1237</td><td>55153</td><td>31942</td><tr>
<tr><td>167</td><td>3418</td><td>850</td><td>56356</td><td>32194</td><tr>
<tr><td>520</td><td>2569</td><td>488</td><td>46739</td><td>32411</td><tr>
<tr><td>138</td><td>3452</td><td>1085</td><td>74704</td><td>32546</td><tr>
<tr><td>68</td><td>3775</td><td>709</td><td>62863</td><td>32844</td><tr>
<tr><td>201</td><td>3479</td><td>980</td><td>91769</td><td>32951</td><tr>
<tr><td>553</td><td>2798</td><td>1096</td><td>56580</td><td>33064</td><tr>
<tr><td>1447</td><td>3326</td><td>1514</td><td>33190</td><td>33190</td><tr>
<tr><td>183</td><td>3328</td><td>816</td><td>71664</td><td>33848</td><tr>
<tr><td>151</td><td>3311</td><td>864</td><td>67106</td><td>34668</td><tr>
<tr><td>1450</td><td>3080</td><td>1466</td><td>34874</td><td>34874</td><tr>
<tr><td>366</td><td>2557</td><td>1161</td><td>77996</td><td>35176</td><tr>
<tr><td>1040</td><td>2174</td><td>1475</td><td>63831</td><td>35201</td><tr>
<tr><td>481</td><td>2731</td><td>933</td><td>56638</td><td>35336</td><tr>
<tr><td>174</td><td>3462</td><td>864</td><td>57567</td><td>36565</td><tr>
<tr><td>275</td><td>2308</td><td>1183</td><td>64588</td><td>36587</td><tr>
<tr><td>72</td><td>3840</td><td>647</td><td>85285</td><td>36787</td><tr>
<tr><td>767</td><td>2286</td><td>963</td><td>60720</td><td>37211</td><tr>
<tr><td>373</td><td>2533</td><td>1012</td><td>84371</td><td>37225</td><tr>
<tr><td>137</td><td>3476</td><td>1145</td><td>94734</td><td>37633</td><tr>
<tr><td>1506</td><td>2652</td><td>1991</td><td>82178</td><td>38136</td><tr>
<tr><td>741</td><td>2347</td><td>911</td><td>57450</td><td>38494</td><tr>
<tr><td>493</td><td>2826</td><td>855</td><td>64555</td><td>38550</td><tr>
<tr><td>424</td><td>2690</td><td>1163</td><td>65224</td><td>38600</td><tr>
<tr><td>250</td><td>3054</td><td>1042</td><td>77699</td><td>38677</td><tr>
<tr><td>507</td><td>2699</td><td>936</td><td>60427</td><td>39437</td><tr>
<tr><td>153</td><td>3294</td><td>952</td><td>54662</td><td>39908</td><tr>
<tr><td>244</td><td>3055</td><td>1072</td><td>70032</td><td>40182</td><tr>
<tr><td>655</td><td>2260</td><td>470</td><td>47422</td><td>40384</td><tr>
<tr><td>248</td><td>3282</td><td>1044</td><td>80813</td><td>40975</td><tr>
<tr><td>690</td><td>2540</td><td>886</td><td>57424</td><td>41214</td><tr>
<tr><td>63</td><td>3743</td><td>739</td><td>59822</td><td>41311</td><tr>
<tr><td>211</td><td>3057</td><td>1104</td><td>78353</td><td>41520</td><tr>
<tr><td>159</td><td>3496</td><td>997</td><td>87661</td><td>41760</td><tr>
<tr><td>222</td><td>3372</td><td>1177</td><td>109213</td><td>42322</td><tr>
<tr><td>792</td><td>2359</td><td>1011</td><td>60000</td><td>43028</td><tr>
<tr><td>60</td><td>3615</td><td>1024</td><td>91253</td><td>43049</td><tr>
<tr><td>898</td><td>2011</td><td>1279</td><td>61874</td><td>43684</td><tr>
<tr><td>709</td><td>2498</td><td>740</td><td>62116</td><td>44877</td><tr>
<tr><td>477</td><td>2811</td><td>790</td><td>68238</td><td>45166</td><tr>
<tr><td>375</td><td>2461</td><td>932</td><td>63153</td><td>45401</td><tr>
<tr><td>566</td><td>3028</td><td>1095</td><td>76619</td><td>46385</td><tr>
<tr><td>86</td><td>3582</td><td>931</td><td>63327</td><td>46735</td><tr>
<tr><td>563</td><td>2817</td><td>1185</td><td>66435</td><td>46921</td><tr>
<tr><td>807</td><td>1967</td><td>912</td><td>67616</td><td>47828</td><tr>
<tr><td>598</td><td>2933</td><td>1029</td><td>76037</td><td>48073</td><tr>
<tr><td>560</td><td>2771</td><td>1239</td><td>70271</td><td>48431</td><tr>
<tr><td>1171</td><td>1945</td><td>1091</td><td>73793</td><td>49853</td><tr>
<tr><td>541</td><td>2807</td><td>815</td><td>89290</td><td>50510</td><tr>
<tr><td>270</td><td>3068</td><td>1156</td><td>143680</td><td>50599</td><tr>
<tr><td>355</td><td>2364</td><td>1018</td><td>70404</td><td>51199</td><tr>
<tr><td>1504</td><td>2524</td><td>2168</td><td>80854</td><td>51521</td><tr>
<tr><td>358</td><td>2422</td><td>1200</td><td>91024</td><td>51678</td><tr>
<tr><td>274</td><td>3298</td><td>1183</td><td>136405</td><td>51807</td><tr>
<tr><td>148</td><td>3493</td><td>1086</td><td>78809</td><td>52218</td><tr>
<tr><td>896</td><td>1899</td><td>1424</td><td>73095</td><td>52450</td><tr>
<tr><td>324</td><td>2472</td><td>1034</td><td>90132</td><td>53600</td><tr>
<tr><td>334</td><td>2395</td><td>1304</td><td>89847</td><td>54280</td><tr>
<tr><td>230</td><td>3394</td><td>1185</td><td>117906</td><td>55625</td><tr>
<tr><td>125</td><td>3446</td><td>1238</td><td>71894</td><td>55628</td><tr>
<tr><td>1582</td><td>2242</td><td>1733</td><td>86751</td><td>57079</td><tr>
<tr><td>1050</td><td>2096</td><td>1483</td><td>89673</td><td>57912</td><tr>
<tr><td>152</td><td>3124</td><td>938</td><td>105126</td><td>59300</td><tr>
<tr><td>177</td><td>3155</td><td>843</td><td>92036</td><td>60370</td><tr>
<tr><td>460</td><td>2575</td><td>1234</td><td>87930</td><td>61240</td><tr>
<tr><td>256</td><td>3303</td><td>1084</td><td>111420</td><td>61867</td><tr>
<tr><td>181</td><td>3469</td><td>1025</td><td>116001</td><td>62425</td><tr>
<tr><td>378</td><td>2730</td><td>1061</td><td>93386</td><td>63933</td><tr>
<tr><td>243</td><td>3330</td><td>1169</td><td>167029</td><td>64460</td><tr>
<tr><td>447</td><td>2654</td><td>999</td><td>84312</td><td>65570</td><tr>
<tr><td>421</td><td>2574</td><td>1012</td><td>82864</td><td>65938</td><tr>
<tr><td>319</td><td>2512</td><td>973</td><td>91862</td><td>67048</td><tr>
<tr><td>253</td><td>3397</td><td>1160</td><td>169590</td><td>67055</td><tr>
<tr><td>1445</td><td>3332</td><td>1507</td><td>67452</td><td>67452</td><tr>
<tr><td>214</td><td>3188</td><td>1125</td><td>108858</td><td>68322</td><tr>
<tr><td>346</td><td>2423</td><td>1098</td><td>100255</td><td>69618</td><tr>
<tr><td>458</td><td>2564</td><td>1391</td><td>77438</td><td>69647</td><tr>
<tr><td>246</td><td>3383</td><td>1113</td><td>118832</td><td>72260</td><tr>
<tr><td>136</td><td>3459</td><td>1124</td><td>114426</td><td>73074</td><tr>
<tr><td>192</td><td>3489</td><td>878</td><td>88235</td><td>75783</td><tr>
<tr><td>80</td><td>3539</td><td>914</td><td>105259</td><td>77198</td><tr>
<tr><td>1012</td><td>2070</td><td>1203</td><td>93020</td><td>77403</td><tr>
<tr><td>232</td><td>3073</td><td>956</td><td>115517</td><td>78872</td><tr>
<tr><td>255</td><td>3395</td><td>1102</td><td>127667</td><td>78904</td><tr>
<tr><td>627</td><td>2984</td><td>1088</td><td>122987</td><td>79179</td><tr>
<tr><td>272</td><td>3105</td><td>1141</td><td>231304</td><td>79228</td><tr>
<tr><td>65</td><td>3737</td><td>778</td><td>112014</td><td>79664</td><tr>
<tr><td>356</td><td>2397</td><td>1330</td><td>119870</td><td>79669</td><tr>
<tr><td>218</td><td>3159</td><td>1134</td><td>166131</td><td>81720</td><tr>
<tr><td>628</td><td>2975</td><td>1060</td><td>108253</td><td>82497</td><tr>
<tr><td>126</td><td>3481</td><td>1079</td><td>138002</td><td>82646</td><tr>
<tr><td>188</td><td>3476</td><td>1114</td><td>85969</td><td>85969</td><tr>
<tr><td>601</td><td>3031</td><td>1064</td><td>116151</td><td>87408</td><tr>
<tr><td>914</td><td>2079</td><td>1272</td><td>100068</td><td>88291</td><tr>
<tr><td>787</td><td>2151</td><td>1005</td><td>110438</td><td>88941</td><tr>
<tr><td>229</td><td>3295</td><td>1144</td><td>136152</td><td>89653</td><tr>
<tr><td>123</td><td>3375</td><td>1208</td><td>123188</td><td>90762</td><tr>
<tr><td>187</td><td>3510</td><td>889</td><td>122276</td><td>93056</td><tr>
<tr><td>178</td><td>3393</td><td>842</td><td>154157</td><td>94916</td><tr>
<tr><td>98</td><td>3653</td><td>870</td><td>126072</td><td>96068</td><tr>
<tr><td>213</td><td>3356</td><td>1138</td><td>183222</td><td>99001</td><tr>
<tr><td>135</td><td>3437</td><td>1150</td><td>125657</td><td>101951</td><tr>
<tr><td>90</td><td>3699</td><td>961</td><td>144337</td><td>109561</td><tr>
<tr><td>509</td><td>2695</td><td>861</td><td>159145</td><td>112571</td><tr>
<tr><td>128</td><td>3415</td><td>1191</td><td>142029</td><td>112937</td><tr>
<tr><td>983</td><td>2240</td><td>421</td><td>163274</td><td>116063</td><tr>
<tr><td>608</td><td>2792</td><td>1203</td><td>163763</td><td>120848</td><tr>
<tr><td>144</td><td>3465</td><td>1107</td><td>140197</td><td>123079</td><tr>
<tr><td>261</td><td>3336</td><td>1100</td><td>207894</td><td>123353</td><tr>
<tr><td>1449</td><td>3250</td><td>1439</td><td>127628</td><td>127628</td><tr>
<tr><td>1492</td><td>2614</td><td>1866</td><td>226476</td><td>143549</td><tr>
<tr><td>146</td><td>3498</td><td>892</td><td>173666</td><td>144773</td><tr>
<tr><td>179</td><td>3338</td><td>851</td><td>200298</td><td>148761</td><tr>
<tr><td>1144</td><td>1988</td><td>1043</td><td>168546</td><td>153525</td><tr>
<tr><td>56</td><td>3572</td><td>989</td><td>250182</td><td>156072</td><tr>
<tr><td>89</td><td>3680</td><td>942</td><td>187506</td><td>158510</td><tr>
<tr><td>599</td><td>2833</td><td>1000</td><td>192728</td><td>168497</td><tr>
<tr><td>55</td><td>3529</td><td>1049</td><td>245322</td><td>175082</td><tr>
<tr><td>576</td><td>2874</td><td>1177</td><td>221567</td><td>181511</td><tr>
<tr><td>140</td><td>3472</td><td>1078</td><td>215902</td><td>189052</td><tr>
<tr><td>85</td><td>3582</td><td>950</td><td>231369</td><td>210883</td><tr>
<tr><td>976</td><td>2187</td><td>645</td><td>223675</td><td>214744</td><tr>
<tr><td>173</td><td>3239</td><td>840</td><td>283212</td><td>224840</td><tr>
<tr><td>205</td><td>3498</td><td>1066</td><td>283055</td><td>229287</td><tr>
<tr><td>247</td><td>3354</td><td>1048</td><td>343186</td><td>233235</td><tr>
<tr><td>425</td><td>2661</td><td>1198</td><td>263661</td><td>233650</td><tr>
<tr><td>242</td><td>3374</td><td>1023</td><td>259570</td><td>236478</td><tr>
<tr><td>1049</td><td>2094</td><td>1281</td><td>283522</td><td>258240</td><tr>
<tr><td>186</td><td>3497</td><td>1100</td><td>284041</td><td>284041</td><tr>
<tr><td>81</td><td>3682</td><td>987</td><td>318573</td><td>290666</td><tr>
<tr><td>59</td><td>3557</td><td>1028</td><td>337282</td><td>290669</td><tr>
<tr><td>941</td><td>2170</td><td>648</td><td>333480</td><td>307103</td><tr>
<tr><td>92</td><td>3634</td><td>931</td><td>399657</td><td>311142</td><tr>
<tr><td>679</td><td>2537</td><td>853</td><td>433187</td><td>393631</td><tr>
<tr><td>582</td><td>2771</td><td>1264</td><td>460732</td><td>407259</td><tr>
<tr><td>83</td><td>3690</td><td>898</td><td>436477</td><td>411914</td><tr>
<tr><td>106</td><td>3659</td><td>979</td><td>424353</td><td>412894</td><tr>
<tr><td>160</td><td>3159</td><td>869</td><td>528985</td><td>457620</td><tr>
<tr><td>550</td><td>2861</td><td>927</td><td>531591</td><td>485895</td><tr>
<tr><td>131</td><td>3471</td><td>1095</td><td>512886</td><td>486230</td><tr>
<tr><td>133</td><td>3481</td><td>1098</td><td>537231</td><td>537231</td><tr>
<tr><td>569</td><td>2964</td><td>1022</td><td>637425</td><td>599579</td><tr>
<tr><td>87</td><td>3672</td><td>916</td><td>669915</td><td>613160</td><tr>
<tr><td>1116</td><td>2381</td><td>1323</td><td>687029</td><td>687029</td><tr>
<tr><td>91</td><td>3684</td><td>929</td><td>731388</td><td>731388</td><tr>
<tr><td>209</td><td>3080</td><td>1130</td><td>1018463</td><td>828524</td><tr>
<tr><td>258</td><td>3408</td><td>1176</td><td>1549008</td><td>1549008</td><tr>
<tr><td>169</td><td>3488</td><td>1107</td><td>1634351</td><td>1634351</td><tr>
<tr><td>290</td><td>2551</td><td>979</td><td>2405233</td><td>2321589</td><tr>
<tr><td>176</td><td>3488</td><td>1094</td><td>2762522</td><td>2762522</td><tr>
<tr><td>977</td><td>1981</td><td>339</td><td>6564</td><td>0</td><tr>
<tr><td>693</td><td>2322</td><td>597</td><td>11160</td><td>0</td><tr>
</tbody>
</table>


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
					$chartStr = sprintf("%s: %d, %s: %d, %s: %d, %s: %d", $options[3], $_GET["$options[3]"], $options[5], $_GET["$options[5]"], 
										$options[7], $_GET["$options[7]"], $options[9], $_GET["$options[9]"]);
				}
				//I am not sure how you want to store the hidden fields so I just put -1 for now.
				else if($chart_types[$index] == "Map_Motion_rpb"){
					$chartStr = sprintf("%s: %d, %s: %d, %s: %d, %s: %d, %s: %d", $options[3], $_GET["$options[3]"], $options[5], $_GET["$options[5]"], 
										$options[7], $_GET["$options[7]"], $options[9], $_GET["$options[9]"], $options[11], $_GET["$options[11]"]); 
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