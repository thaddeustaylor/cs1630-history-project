<html>
<body>
<?php
        /*      This script should be used to create clean tables.
                If this script is ran after data has been inserted into the tables
                that data will be lost.
        */
    
    set_time_limit ( 0 );
    $start_time = gettimeofday(true);
    
    echo date("d M Y : hi:s.u", $start_time)  . "<br />";
    
    /* Database information */
    include_once("../submit/pword.php");
    include_once("location_fuctions.php");
    
	
	/* Connect to the database */
	mysql_connect("$server", "$username", "$password") or die(mysql_error()); 
	mysql_select_db("cs1630History") or die(mysql_error()); 
 
 
    $freq_conv['Year']['Week'] = 1/52;

    
 
 
    $data = array();
 
    $query = "SELECT * FROM totpop WHERE location = 91 AND NOT (start_date > '1926-01-01' OR end_date  < '1925-01-01')";
    
    
    
    $result = mysql_query($query) or die(mysql_error());
    $num = mysql_num_rows($result);
    echo $num . "<br />";
    if ($num != 0)
        display_table($result);
    
    //handle where we only have one datapoint
    if ($num == 1)
    {
        $data['One'] = array();
        
        $data['One'][] = mysql_fetch_array($result, MYSQL_ASSOC);
 
        $endDate = $data['One'][0]['end_date'];
    
        $query = "SELECT * FROM totpop WHERE location = 91 AND end_date < '$endDate' ORDER BY end_date DESC LIMIT 1";
        
        $result = mysql_query($query) or die(mysql_error());
        $num = mysql_num_rows($result);
        echo $num . "<br />";
    
        $data['One'][] = mysql_fetch_array($result, MYSQL_ASSOC);
        
        mysql_data_seek($result, 0);
        
        if ($num != 0)
            display_table($result);
        
        print_r($data);
    }else
    {
        $data['One'] = array();
        for ($i = 0; $i < $num; $i++)
            $data['One'][] = mysql_fetch_array($result, MYSQL_ASSOC);
    }
    
   
    

    
    
    
    
    $query = "SELECT * FROM prcp WHERE location = 3164 AND NOT (start_date > '1926-01-01' OR end_date  < '1925-01-01')";
    
    
    
    $result = mysql_query($query) or die(mysql_error());
    $num = mysql_num_rows($result);
    echo $num . "<br />";
    if ($num != 0)
        display_table($result);
        
        
    //handle where we only have one datapoint, get the datapoint before this one and append it.
    if ($num == 1)
    {
        $data['Two'] = array();
        
        $data[] = mysql_fetch_array($result, MYSQL_ASSOC);
 
        $endDate = $data['Two']['end_date'];
    
        $query = "SELECT * FROM prcp WHERE location = 3164 AND end_date < '$endDate' ORDER BY end_date DESC LIMIT 1";
        
        $result = mysql_query($query) or die(mysql_error());
        $num = mysql_num_rows($result);
        echo $num . "<br />";
    
        $data[] = mysql_fetch_array($result, MYSQL_ASSOC);
        
        mysql_data_seek($result, 0);
        
        if ($num != 0)
            display_table($result);
        
       
    }else
    {
        $data['Two'] = array();
        
        for ($i = 0; $i < $num; $i++)
            $data['Two'][] = mysql_fetch_array($result, MYSQL_ASSOC);
    }
        
        
        
     print_r($data);    
        
   
    //Look at the frequency in the tables.

    
    $freq_list = array(array());
    $i = 0;
    
    foreach($data as $table)
    {
        
        foreach($table as $row)
        {
            $freq_list[$i][] = $row['frequency_unit'];
        }
        $freq_list[$i] = array_unique($freq_list[$i]);
        $i++;
    }

    //TODO deal with multiple frequencies in a dataset
    
    
    $freq = array();
    
    foreach($freq_list as $table)
    {
        $freq[] = $table[0];
    }
    
    //var_dump($freq);
    
    //get the multiplyer and the increment for the interpolation
    //This is hard coded for now because we know it.
    
    
    
    
   
?>