
<?php
include_once("../submit/pword.php");
//include_once("census_data_helpers.php");
include_once("helper_functions.php");


set_time_limit ( 0 );

/* Connect to database */
mysql_connect("$server", "$username", "$password") or die(mysql_error()); 
mysql_select_db("cs1630History") or die("DB Connect Error: " . mysql_error()); 

/* Array of all files used */
//$files = array("Baltimore_MD_PT.csv");
$files = array( "Baltimore_MD_PT.csv", 
                "Boston_MA_PT.csv", 
                "Cambridge_MA_PT.csv",
                "Charleston_WV_PT.csv", 
                "Chicago_IL_PT.csv", 
                "Cincinnati_OH_PT.csv",
                "New York_NY_PT.csv");
                    
$pubdate = "2011-07-31"; /* Hard coded for now, as it was same for all files */

echo "<h2>Intialization Script for Climate Data Files</h2>";

//init_climate_locations();

/* Loop through files array */
foreach ($files as $filename)
{
    /* Get city, state from filename */
    $fileparse = explode("_", $filename);
    $city = $fileparse[0];
    $datasetname = explode(".", $filename);

    $city = strtoupper($fileparse[0]);
    $state = strtoupper(getStateNameByAbbreviation($fileparse[1]));

    
    $location = getLocationID($state, "", $city, LOCATION_CITY);
    
    //echo "<br />" . "Location: " . $location . "<br />";
     
    $datasetID =  getDatasetID($datasetname[0]);
     
    //echo "<br />" . "DatasetID: " . $datasetID . "<br />"; 
     
    /* Open the file */
    $fid = fopen("../submit/data/" . $filename,"r");
    if (!$fid)
    {
        exit("File $filename open failed");
    }
    
    /* Debugging display */
    //echo "$filename loaded...<br />";
    
    /* Read in titles */
    $title = fgets($fid);
    $titles = explode(",", $title);
    $data = fgets($fid);
    
    /* Read in data */
    while (!feof($fid))
    {
        
        
        /* Get line of data and split it */
        
        $data = rtrim($data);
        $data = str_replace('"','',$data);
        $blocks = explode(",", $data);
        
        /* Set important variables */
        $date = $blocks[6];
        $unit = $blocks[5];
        $value = $blocks[8];
        $datetype = strtolower($blocks[4]);
        /* Store in database */
         mysql_query("insert into $datetype values 
                    (NULL,			
                    '$date',
                    '$date',
                    '$pubdate',
                    'DAY',
                    1,
                    $location,
                    0,
                    $datasetID,
                    $value,
                    '$unit',
                    1,
                    'NONE',
                    1,
                    TRUE,
                    FALSE)") or die("MySQL Error: $blocks[4], $date, $unit, $value, $location" . mysql_error());
         
        //get next line
        $data = fgets($fid);
    }
    
    /* Affirm success */
    //echo "$filename completed!<br />";
}




?>
