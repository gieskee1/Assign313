
<?php
require("db_info.php");
//$username="username";
//$password="password";
//$database="egieskemaps";
//$link = 'egieskemaps.cmwlabj3peuu.us-east-2.rds.amazonaws.com';
//$username="root";
//$password="root";
//$database="cmdb_view";
//$link = 'localhost';

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

$country_url = $_GET["country"];
$type_url = $_GET["assetType"];
$serialNum = $_GET["serial"];
$region_url = $_GET["region"];

//seperate strings delimated by commas into elements of an array
$country_url = explode(',',$country_url);
$type_url = explode(',', $type_url);
$region_url = explode(',', $region_url);
//search by serial num
if($serialNum != ""){
	$query =  "SELECT * FROM marker WHERE `Serial number` LIKE '%" . $serialNum . "%' OR `Name` LIKE '%" . $serialNum ."%'";
}
//or filtered
else{
	//$assetTypeArr = array();
	//$curWord = "";
	//lists are seperated by '~'s
	/*for ($i = 0; $i < strlen($type_url); $i++) {
		if($type_url[$i] == "~"){
			array_push($assetTypeArr,$curWord);
			$curWord = "";
		}else{
		$curWord = $curWord . $type_url[$i];
		}
	}*/
	$query = "";
	//search by region
	if($region_url != "null"){
		$query = "SELECT * FROM marker_byasset WHERE ((Region LIKE '" . $region_url[0] . "'";
	}else{
		//	$query = "SELECT * FROM marker_byasset WHERE (Region LIKE '" . $region_url[0] . "'";// ."' AND `Asset type` LIKE '" . $type_url . "'";
		}
		//skip first
		for($i = 1; $i < count($region_url); $i++){
			$query = $query . " OR Region LIKE '" . $region_url[$i] ."'";
		}
	$query = $query . ")"; //close where clause parenthesis
	//and/or country
	if($country_url[0] != "null"){	
		if ($query != ""){
			$query = $query . " OR (Country LIKE '" . $country_url[0] . "'";
		}
		else{
			$query = "SELECT * FROM marker_byasset WHERE ((Country LIKE '" . $country_url[0] . "'";// ."' AND `Asset type` LIKE '" . $type_url . "'";
		}
		//skip first
		for($i = 1; $i < count($country_url); $i++){
			$query = $query . " OR Country LIKE '" . $country_url[$i] ."'";
		}
			$query = $query . ")"; //close where clause parenthesis
	}
	$query = $query . ")"; //close where clause parenthesis

	$query = $query . " AND (`Asset type` LIKE '" . $type_url[0] ."'";
	// Select the rows by asset type in the marker_byasset table
	//$query = $origquery . "' AND `Asset type` LIKE '" . $assetTypeArr[0] . "'";
	//if(count($type_url) > 1){
		for ($i = 1; $i < count($type_url); $i++) {
			$query = $query . " OR `Asset type` LIKE '" . $type_url[$i] ."'";
		}
		$query = $query . ")"; //close where clause parenthesis
	//}	
} //end of if serial search
$result = @mysqli_query($connection,$query);
if (!$result) {
die('Invalid query: ' . @mysqli_error());
}

header("Content-type: text/xml");
// Start XML file, echo parent node
echo '<markers>';

	//prepare for asset counts
	$latArr = array();
	$longArr = array();
	$countArr = array();
	$assetArr = array();

    // Iterate through the rows, printing XML nodes for each
    while ($row = @mysqli_fetch_assoc($result)){
		$city = $row['City'];
		$city = str_replace(' ', '+', $city);
		$state = $row['State / Province'];
		$state = str_replace(' ', '+', $state);
	    $prepAddr = $city . "+" . $state;
		// Add to XML document node
		$lat = $row['Latitude'];
		$long = $row['Longitude'];
		$repeated = 0;
		for($i = 0; $i < count($latArr); $i++){
			if( ($latArr[$i] == $lat) && ($longArr[$i] == $long)){
				$countArr[$i] = $countArr[$i] + $row['COUNT'] + 0;
				$assetArr[$i] = $assetArr[$i] . ", " . $row['Asset type'];
				$finalCount = $i;
				$i = count($latArr); //break;
			}  
		}
		if (in_array($lat,$latArr) && in_array($long,$longArr)){
			//already a location, do nothing
		}else{
			array_push($latArr,$lat);
			array_push($longArr,$long);
			array_push($countArr,$row['COUNT']);
			array_push($assetArr,$row['Asset type']);
			$finalCount = count($assetArr) - 1;
		}

		if ($city != ''){
		echo '<marker ';
		echo 'assetcount="' . $countArr[$finalCount] . '" ';
		echo 'address="' . $row['City'] . '" ';
		echo 'state="' . $state . '" ';
		echo 'lat="' . $row['Latitude'] . '" ';
		echo 'lng="' . $row['Longitude'] . '" ';
		if ($repeated == 0){
			echo 'assettype="' . $assetArr[$finalCount] . '" ';
		}
		echo '/>';
		}
    }

    // End XML file
    echo '</markers>';

?>
