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


echo json_encode((array)$list);

?>