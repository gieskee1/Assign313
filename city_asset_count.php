<?php

$lat = $_POST['Lat'];
$lng = $_POST['Lng'];

$hostdb = "localhost";  // MySQl host
$userdb = "root";  // MySQL username
$passdb = "root";  // MySQL password
$namedb = "cmdb_view";  // MySQL database name

// Establish a connection to the database
$dbhandle = mysqli_connect('localhost', $userdb, $passdb, $namedb);
$assets = mysqli_query($dbhandle,"SELECT DISTINCT(`Asset type`) as 'Assets' from marker WHERE Latitude = '$lat' AND Longitude = '$lng'");//Finds list of distinct asset names
$list = array();//initialize array that will hold countries
$count = 0;//initiallize count of countries

if (!$assets) {
    echo(" error");
}

while(($row = $assets -> fetch_assoc())!==null){
    $list[$count] = $row['Assets'];//fill up array of country names (will be used to filter graphs)
    $count = $count + 1;
}

$count = count($list);//count = number of countries
$asset_types = array();//holds sql result of total assets in countries
$total_count = array();//holds number of assets in each country
for($i=0;$i<$count;$i++){
    $asset_types[$i] = mysqli_query($dbhandle,"SELECT SUM(CASE WHEN `Asset type` = '$list[$i]' AND Latitude = '$lat' AND Longitude = '$lng'  THEN 1 ELSE 0 END) as '$list[$i]' FROM marker");
    $asset_count = mysqli_fetch_assoc($asset_types[$i]);//array of counts
    $total_count[$i] = (int)$asset_count[$list[$i]];//array of counts of assets in countries
}

echo json_encode((array)$total_count);



?>