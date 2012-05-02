<?php

    define("LOCATION_ALL",           0);
    define("LOCATION_STATE",         1);
    define("LOCATION_CITY",          2);
    define("LOCATION_COUNTY",        3);

    
   /* Database information */
   //include_once("../submit/pword.php");
	


//getLocation("CONNECTICUT", "FAIRFIELD", "");

//getLocation("CONNECTICUT", "FAIRFIELD", NULL);




//test("NEW YORK", "NEW YORK", "NEW YORK");

//test("MASSACHUSETTS",  "MIDDLESEX", "CAMBRIDGE");
//test("MASSACHUSETTS",  "SUFFOLK", "BOSTON");
//test("SOUTH CAROLINA", "BERKELEY", "CHARLESTON");

//getLocation("NEW YORK", "", "NEW YORK");

function getLocationID($state, $county, $city, $choice = -1)
{



    if($state == null)
        return -1;
        
    if($city == null &&  $choice == LOCATION_CITY)
        return -1;
        
    if($county == null &&  $choice == LOCATION_COUNTY)
        return -1;
    
    
    //Connect to the database
/* 	$db = mysql_connect("$server", "$username", "$password") or die(mysql_error());
	mysql_select_db("cs1630History") or die(mysql_error()); */
    
    $city = strtoupper($city);
    $county = strtoupper($county);
    $state = strtoupper($state);
    
///////////////////////////////STATE//////////////////////////////
    //Get the state information
    $query = "SELECT _ID FROM locations 
               WHERE name = '$state' AND unit = 4 ";

    //echo $query . "<br />";
    
    $result = mysql_query($query) or die($query . mysql_error());
    
    //display_table($result);    

    $num = mysql_num_rows($result);
    //there should only be one of a state name, if there is less or more then there is nothing to do.    
    if($num != 1)
        return;
        
    
    $data = mysql_fetch_array($result, MYSQL_ASSOC);
 
    $state_ID = $data['_ID'];
    //echo "State ID  = " . $state_ID . "<br />";
    
    if ($choice == LOCATION_STATE)
        return $state_ID;

/////////////////////////////COUNTY/////////////////////////////////
    //Find all immediate children of the state
    $query = "SELECT child_ID FROM locations_map  
               WHERE parent_ID = '$state_ID'";

    //echo $query . "<br />";
    
    $result = mysql_query($query) or die($query . mysql_error());
    
    //display_table($result);    

    $num = mysql_num_rows($result);     
    
    
    $county_IDs = array();
    $city_IDs = array();
    
    // get all children ID's and put into an array
    for ($i = 0; $i < $num; $i++)
    {
        $data = mysql_fetch_array($result, MYSQL_ASSOC);
        
        array_push($county_IDs, (int)$data['child_ID']);
    }

    
    if($county != null)
    {
        
        $query = "SELECT _ID FROM locations WHERE
                   name = '$county' AND _ID IN (". implode(',', $county_IDs) .")"; 

        //echo $query . "<br />";
        
        $result = mysql_query($query) or die($query . mysql_error());
    
        $num = mysql_num_rows($result);
        
        //We can assume that a state will not have 2 counties named the same thing
        $data = mysql_fetch_array($result, MYSQL_ASSOC);
        //var_dump($data);    
        $county_ID = $data['_ID'];
        //echo "City ID  = " . $city_ID . "<br />";
    
        if($choice == LOCATION_COUNTY)
            return $county_ID;
    
        unset($county_IDs);
        
        $county_IDs = array($county_ID);
    }
    //var_dump($county_IDs);

///////////////////////////////CITY///////////////////////////////////    
    //Find all children of the children of the state.  These should be cities.
    $query = "SELECT child_ID FROM locations_map  WHERE parent_ID IN (". implode(',', $county_IDs) .")";
    
    //echo $query . "<br />";
     
    $result = mysql_query($query) or die($query . mysql_error());
    $num = mysql_num_rows($result);
    //echo $num . "<br />";
    
    for ($j = 0; $j < $num; $j++)
    {
        $data = mysql_fetch_array($result, MYSQL_ASSOC);
        
        array_push($city_IDs, (int)$data['child_ID']);  
        //echo $data['child_ID'] . "<br />";
            
    }
    

    
/*     for ($i = 0; $i < $num; $i++)
    {
        $query = "SELECT child_ID FROM locations_map  
               WHERE parent_ID = $county_IDs[$i]";
        
        //echo $query . "<br />";
        
        $result = mysql_query($query) or die(mysql_error());
        
        $num2 = mysql_num_rows($result);     
        
        //echo $i . " : " . $num2 . "<br />";    
        
        if ($num2 < 1)
            continue;
            
        // get all children ID's and put into an array
        for ($j = 0; $j < $num2; $j++)
        {
            $data = mysql_fetch_array($result, MYSQL_ASSOC);
            
            array_push($city_IDs, $data['child_ID']);
            //echo $data['child_ID'] . "<br />";
        }
        

        
    }     */
    
    //echo "<br />";
    //var_dump($city_IDs);
    
            //now look for doubles
       /*  for ($i = 0; $i < count($city_IDs); $i++)
        {
            //$current = $city_IDs[$i];
            
            for ($j = 0; $j < count($city_IDs); $j++)
            {
                if ($j == $i)
                    continue;
                    
                if($city_IDs[$i] == $city_IDs[$j])
                   unset($city_IDs[$j]);
            
            }    
        } */
        
    //Remove Duplicates and reindex array
    $city_IDs = array_values(array_unique($city_IDs));    
    
        
    //echo "<br />";
    //var_dump($city_IDs);
    
    //Ok at this point we should have the entire tree for the state down to cities
    if($county == null && $city == null && $choice == LOCATION_ALL)
        return array("STATE" => $state_ID, "COUNTY" => $county_IDs, "CITY" => $city_IDs);
    
    if($city == null && $choice == LOCATION_ALL)
        return array("STATE" => $state_ID, "COUNTY" => $county_IDs, "CITY" => $city_IDs);
    
     
    //Now we find the correct city.
    
    //var_dump($city_IDs);
    //echo "<br />";
    
    $num = count($city_IDs);
    
    $query = "SELECT _ID FROM locations WHERE
                   name = '$city' AND _ID IN (". implode(',', $city_IDs) .")"; 

    
        $result = mysql_query($query) or die(mysql_error());
    
    $num = mysql_num_rows($result);
    
    
    $data = mysql_fetch_array($result, MYSQL_ASSOC);
    //var_dump($data);    
    $city_ID = $data['_ID'];
    //echo "City ID  = " . $city_ID . "<br />";
    if($choice == LOCATION_CITY)
        return $city_ID;
    
    
    
    unset($city_IDs);
    $city_IDs = array($city_ID);
    //Now we know the city

    if($county != null && $choice == LOCATION_ALL)
        return array("STATE" => $state_ID, "COUNTY" => $county_IDs, "CITY" => $city_IDs);
    
    
    $query = "SELECT parent_ID FROM locations_map  WHERE child_ID ='$city_ID'";
    $result = mysql_query($query) or die($query . mysql_error());
    $num = mysql_num_rows($result);
    //echo $num . "<br />";
    
    unset($county_IDs);
    $county_IDs = array();
    
    for ($j = 0; $j < $num; $j++)
    {
        $data = mysql_fetch_array($result, MYSQL_ASSOC);
        
        array_push($county_IDs, (int)$data['parent_ID']);
        //echo $data['child_ID'] . "<br />";
    }
    
    return array("STATE" => $state_ID, "COUNTY" => $county_IDs, "CITY" => $city_IDs);
    
    //mysql_close($db); 
}

function getDatasetID($data_set_name)
{
    $query = "INSERT into dataset_master values (NULL, 
                                                '$data_set_name')";
                                                              
    mysql_query($query) or die ("locations Invalid insert " . mysql_error());

    return mysql_insert_id();    
    
}







function test ($state, $county, $city)
{
//Test no state
echo "<hr /><b> Should fail </b><br />";
echo "<br /> Nothing State Only = " . getLocation("", "", "", LOCATION_STATE) . "<br /> ";
echo "<br /> Nothing County Only = " . getLocation("", "", "", LOCATION_COUNTY) . "<br /> ";
echo "<br /> Nothing City Only = " . getLocation("", "", "", LOCATION_CITY) . "<br /> ";
echo "<br /> Nothing All = " . getLocation("", "", "", LOCATION_ALL) . "<br /> ";


echo "<br /> $county County, $city City State Only = " . getLocation("", $county, $city, LOCATION_STATE) . "<br /> ";
echo "<br /> $county County, $city City County Only = " . getLocation("", $county, $city,LOCATION_COUNTY) . "<br /> ";
echo "<br /> $county County, $city City City Only = " . getLocation("", $county, $city, LOCATION_CITY) . "<br /> "; 
echo "<br /> $county County, $city City ALL = " . getLocation("", $county, $city, LOCATION_ALL) . "<br /> ";


echo "<br /> $city City State Only" . getLocation("", "", $city, LOCATION_STATE) . "<br /> ";
echo "<br /> $city City County Only = " . getLocation("", "", $city, LOCATION_COUNTY) . "<br /> ";
echo "<br /> $city City City Only = " . getLocation("", "", $city, LOCATION_CITY) . "<br /> ";
echo "<br /> $city City All = " . getLocation("", "", $city, LOCATION_ALL) . "<br /> ";


echo "<br /> $state State County Only = " . getLocation($state, "", "", LOCATION_COUNTY) . "<br /> ";

echo "<br /> $state State, $city City County Only = " . getLocation($state, "", $city, LOCATION_COUNTY) . "<br /> ";

echo "<br /> $state State City Only = " . getLocation($state, "", "", LOCATION_CITY) . "<br /> ";

echo "<br /> $state State, $county County City Only = " . getLocation($state, $county, "", LOCATION_CITY) . "<br /> ";


//Test State only
echo "<hr /><b> Should return State ID </b><br />";
echo "<br /> $state State State Only = " . getLocation($state, "", "", LOCATION_STATE) . "<br /> ";
echo "<br /> $state State, $county County State Only = " . getLocation($state, $county, "", LOCATION_STATE) . "<br /> ";
echo "<br /> $state State, $county County, $city City State Only = " . getLocation($state, $county, $city, LOCATION_STATE) . "<br /> ";
echo "<br /> $state State, $city City State Only = " . getLocation($state, "", $city, LOCATION_STATE) . "<br /> ";


//Test entire tree state only
echo "<hr /> <b>Should return the StateID, any counties and any cities in the counties </b><br />";
echo "<br /> $state State ALL = "; 
print_r(getLocation($state, "", "", LOCATION_ALL));


//Test county only////////////////////////////////////////////////////////////////
echo "<hr /><b> County Should County ID </b><br />";

echo "<br /> $state State, $county County County Only = " . getLocation($state, $county, "", LOCATION_COUNTY) . "<br /> ";

echo "<br /> $state State, $county County, $city City County Only = " . getLocation($state, $county, $city, LOCATION_COUNTY) . "<br /> ";

//Test city only////////////////////////////////////////////////////////////////
echo "<hr /><b> City only Should City ID </b><br />";

echo "<br /> $state State, $city City City Only = " . getLocation($state, "", $city, LOCATION_CITY) . "<br /> ";

echo "<br /> $state State, $county County, $city City City Only = " . getLocation($state, $county, $city, LOCATION_CITY) . "<br /> ";



//Test county all
echo "<hr /> <b>Should return the StateID, CountyID and any cities in the county </b><br />";

echo "<br /> $state State, $county County ALL = ";
print_r(getLocation($state, $county, "", LOCATION_ALL));


//Test state county city all
echo "<hr /> <b>Should return the StateID, CountyID and CityID </b><br />";

echo "<br /> $state State, $county County, $city City ALL = ";
print_r(getLocation($state, $county, $city, LOCATION_ALL));
 
 
//Test state city all
echo "<hr /> <b>Should return the StateID, any counties in the city and CityID </b><br />";

echo "<br /> $state State, $city City ALL = ";
print_r(getLocation($state, "", $city, LOCATION_ALL));
 



}























function display_table($query_result)
{
    echo "<hr />";
    
    $num = mysql_num_rows($query_result);
    
    if ($num <= 0)
    {
        echo "No Results <br />";
        return;
    }
    //echo $num;
    //echo "<br /><br />";
?>
   <table border = 1 cellpadding = 5>
   <tr align = center>

<?php   
    
    $data = mysql_fetch_array($query_result, MYSQL_ASSOC);
    $keys = array_keys($data);
        
    
    foreach ($keys as $next_key):
             echo "<th>$next_key</th>";
    endforeach;
    echo "</tr>"; 
    
    //var_dump($keys);
    
    for( $i = 0; $i < $num; $i++)
    {
        echo "<tr align = center>";
        foreach ($data as $col)
        {
                  echo "<td> $col </td>";
        }
        $data = mysql_fetch_array($query_result, MYSQL_ASSOC);
        //echo "<br />";
        echo "</tr>";
    } 
    
    echo "</table><br />";

    mysql_data_seek($query_result, 0);
}

function getStateNameByAbbreviation($state){  
        if ($state=="AK"){ return "Alaska"; }  
        if ($state=="AL"){ return "Alabama"; }  
        if ($state=="AR"){ return "Arkansas"; }  
        if ($state=="AZ"){ return "Arizona"; }  
        if ($state=="CA"){ return "California"; }  
        if ($state=="CO"){ return "Colorado"; }  
        if ($state=="CT"){ return "Connecticut"; }  
        if ($state=="DC"){ return "District of Columbia"; }  
        if ($state=="DE"){ return "Delaware"; }  
        if ($state=="FL"){ return "Florida"; }  
        if ($state=="GA"){ return "Georgia"; }  
        if ($state=="HI"){ return "Hawaii"; }  
        if ($state=="IA"){ return "Iowa"; }  
        if ($state=="ID"){ return "Idaho"; }  
        if ($state=="IL"){ return "Illinois"; }  
        if ($state=="IN"){ return "Indiana"; }  
        if ($state=="KS"){ return "Kansas"; }  
        if ($state=="KY"){ return "Kentucky"; }  
        if ($state=="LA"){ return "Louisiana"; }  
        if ($state=="MA"){ return "Massachusetts"; }  
        if ($state=="MD"){ return "Maryland"; }  
        if ($state=="ME"){ return "Maine"; }  
        if ($state=="MI"){ return "Michigan"; }  
        if ($state=="MN"){ return "Minnesota"; }  
        if ($state=="MO"){ return "Missouri"; }  
        if ($state=="MS"){ return "Mississippi"; }  
        if ($state=="MT"){ return "Montana"; }  
        if ($state=="NC"){ return "North Carolina"; }  
        if ($state=="ND"){ return "North Dakota"; }  
        if ($state=="NE"){ return "Nebraska"; }  
        if ($state=="NH"){ return "New Hampshire"; }  
        if ($state=="NJ"){ return "New Jersey"; }  
        if ($state=="NM"){ return "New Mexico"; }  
        if ($state=="NV"){ return "Nevada"; }  
        if ($state=="NY"){ return "New York"; }  
        if ($state=="OH"){ return "Ohio"; }  
        if ($state=="OK"){ return "Oklahoma"; }  
        if ($state=="OR"){ return "Oregon"; }  
        if ($state=="PA"){ return "Pennsylvania"; }  
        if ($state=="RI"){ return "Rhode Island"; }  
        if ($state=="SC"){ return "South Carolina"; }  
        if ($state=="SD"){ return "South Dakota"; }  
        if ($state=="TN"){ return "Tennessee"; }  
        if ($state=="TX"){ return "Texas"; }  
        if ($state=="UT"){ return "Utah"; }  
        if ($state=="VA"){ return "Virginia"; }  
        if ($state=="VT"){ return "Vermont"; }  
        if ($state=="WA"){ return "Washington"; }  
        if ($state=="WI"){ return "Wisconsin"; }  
        if ($state=="WV"){ return "West Virginia"; }  
        if ($state=="WY"){ return "Wyoming"; }  
  
  }

?>

