
<?php
//require("db_info.php");
//$username="username";
//$password="password";
//$database="egieskemaps";
//$link = 'egieskemaps.cmwlabj3peuu.us-east-2.rds.amazonaws.com';
$username="root";
$password="root";
$database="cmdb_view";
$link = 'localhost';

function parseToXML($htmlStr)
{
$xmlStr=str_replace('<','&lt;',$htmlStr);
$xmlStr=str_replace('>','&gt;',$xmlStr);
$xmlStr=str_replace('"','&quot;',$xmlStr);
$xmlStr=str_replace("'",'&#39;',$xmlStr);
$xmlStr=str_replace("&",'&amp;',$xmlStr);
return $xmlStr;
}
// Opens a connection to a MySQL server
$connection = @mysqli_connect('localhost', $username, $password, $database);
if (!$connection) {
die('Not connected : ' . @mysql_error());
}

// Set the active MySQL database
$db_selected = @mysqli_select_db($connection, $database);
if (!$db_selected) {
die ('Can\'t use db : ' . @mysql_error());
}
 //echo '<script>console.log("Your stuff here")</script>';
include 'action_test.php';

$country_url = $_GET["country"];
// Select all the rows in the markers table
$query = "SELECT * FROM marker_bycity WHERE Country LIKE '" . $country_url ."'";
//$query = "SELECT * FROM marker_byLocation WHERE Country NOT LIKE ' '";

$result = @mysqli_query($connection,$query);
if (!$result) {
die('Invalid query: ' . @mysqli_error());
}
//$prevCity = "";
//$assetCnt = 0;
header("Content-type: text/xml");
// Start XML file, echo parent node
echo '<markers>';

    // Iterate through the rows, printing XML nodes for each
    while ($row = @mysqli_fetch_assoc($result)){
		$city = $row['City'];
		$city = str_replace(' ', '+', $city);
		$state = $row['State / Province'];
		$state = str_replace(' ', '+', $state);
	    $prepAddr = $city . "+" . $state;
        //$geocode=file_get_contents('https://maps.google.com/maps/api/geocode/json?address='.$prepAddr.'&sensor=false');
        //$output= json_decode($geocode);
        //$latitude = $output->results[0]->geometry->location->lat;
        //$longitude = $output->results[0]->geometry->location->lng;
		/*if ($prevCity == $city){
			$assetCnt +=  $row['COUNT'];
		}else{
			$assetCnt =  $row['COUNT'];
		}
		$prevCity = $city;*/
		// Add to XML document node
		if ($city != ''){
		echo '<marker ';
		echo 'name="' . $row['COUNT'] . '" ';
		echo 'address="' . $row['City'] . '" ';
		echo 'state="' . $state . '" ';
		//echo 'asset_type="' . $row['Asset type'] . '" ';
		echo 'lat="' . $row['Latitude'] . '" ';
		echo 'lng="' . $row['Longitude'] . '" ';
		echo '/>';
		}
    }

    // End XML file
    echo '</markers>';

?>
