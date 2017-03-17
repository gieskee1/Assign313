<?php
$lat = $_POST['Lat'];
$lng = $_POST['Lng'];
$serialNum = $_POST['SerialNum'];
//$lat ='34.0964446';
//$lng ='-84.2374395';
//$serialNum='CK';
$hostdb = "localhost";  // MySQl host
$userdb = "root";  // MySQL username
$passdb = "root";  // MySQL password
$namedb = "cmdb_view";  // MySQL database name

// Establish a connection to the database
$dbhandle = mysqli_connect('localhost', $userdb, $passdb, $namedb);


$names_hold = mysqli_query($dbhandle,"SELECT `Name` as 'Name' from marker WHERE Latitude = '$lat' AND Longitude = '$lng' AND (`Serial Number` LIKE  '%$serialNum%' OR `Name` LIKE '%$serialNum%')");//Finds list of distinct asset names
$names = array();//initialize array that will hold countries
$count = 0;

while(($row = $names_hold -> fetch_assoc())!==null){
    $names[$count] = $row['Name'];//fill up array of country names (will be used to filter graphs)
    $count = $count + 1;
}

//$table_data = array();
//$table_data['Name'] = $names;
//$table_data['Asset Type'] = $types;
//$table_data['Function'] = $functions;
//$table_data['Install Date'] = $names;
//$table_data['Serial Number'] = $serials;

echo json_encode($names);

?>