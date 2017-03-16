<?php
$lat = $_POST['Lat'];
$lng = $_POST['Lng'];
$asset_filter = $_POST['Filter'];


$hostdb = "localhost";  // MySQl host
$userdb = "root";  // MySQL username
$passdb = "root";  // MySQL password
$namedb = "cmdb_view";  // MySQL database name

// Establish a connection to the database
$dbhandle = mysqli_connect('localhost', $userdb, $passdb, $namedb);

if ($asset_filter == "") {
    $names_hold = mysqli_query($dbhandle, "SELECT `Name` as 'Name' from marker WHERE Latitude = '$lat' AND Longitude = '$lng'");//Finds list of names
    $names = array();

    $types_hold = mysqli_query($dbhandle, "SELECT `Asset type` as 'Asset Type' from marker WHERE Latitude = '$lat' AND Longitude = '$lng'");//Finds list of Assets
    $types = array();//initialize array

    $functions_hold = mysqli_query($dbhandle, "SELECT Function as 'Function' from marker WHERE Latitude = '$lat' AND Longitude = '$lng'");//Finds list of Functions
    $functions = array();//initialize array

    $install_dates_hold = mysqli_query($dbhandle, "SELECT Installed as 'Install Date' from marker WHERE Latitude = '$lat' AND Longitude = '$lng'");//Finds list of Installs
    $install_dates = array();//initialize array

    $serials_hold = mysqli_query($dbhandle, "SELECT `Serial number` as 'Serial number' from marker WHERE Latitude = '$lat' AND Longitude = '$lng'");//Finds list of Serials
    $serials = array();//initialize array
}
else{
    $names_hold = mysqli_query($dbhandle, "SELECT `Name` as 'Name' from marker WHERE Latitude = '$lat' AND Longitude = '$lng' AND `Asset Type` = '$asset_filter'");//Finds list of names
    $names = array();

    $types_hold = mysqli_query($dbhandle, "SELECT `Asset type` as 'Asset Type' from marker WHERE Latitude = '$lat' AND Longitude = '$lng'AND `Asset Type` = '$asset_filter'");//Finds list of Assets
    $types = array();//initialize array

    $functions_hold = mysqli_query($dbhandle, "SELECT Function as 'Function' from marker WHERE Latitude = '$lat' AND Longitude = '$lng'AND `Asset Type` = '$asset_filter'");//Finds list of Functions
    $functions = array();//initialize array

    $install_dates_hold = mysqli_query($dbhandle, "SELECT Installed as 'Install Date' from marker WHERE Latitude = '$lat' AND Longitude = '$lng'AND `Asset Type` = '$asset_filter'");//Finds list of Installs
    $install_dates = array();//initialize array

    $serials_hold = mysqli_query($dbhandle, "SELECT `Serial number` as 'Serial number' from marker WHERE Latitude = '$lat' AND Longitude = '$lng'AND `Asset Type` = '$asset_filter'");//Finds list of Serials
    $serials = array();//initialize array
}


$count = 0;//initiallize count of countries
while(($row = $names_hold -> fetch_assoc())!==null){
    $names[$count] = $row['Name'];//fill up array of country names (will be used to filter graphs)
    $count = $count + 1;
}
$count = 0;//initiallize count of countries
while(($row = $types_hold -> fetch_assoc())!==null){
    $types[$count] = $row['Asset Type'];//fill up array of country names (will be used to filter graphs)
    $count = $count + 1;
}
$count = 0;//initiallize count of countries
while(($row = $functions_hold -> fetch_assoc())!==null){
    $functions[$count] = $row['Function'];//fill up array of country names (will be used to filter graphs)
    $count = $count + 1;
}
$count = 0;//initiallize count of countries
while(($row = $install_dates_hold -> fetch_assoc())!==null){
    $install_dates[$count] = $row['Install Date'];//fill up array of country names (will be used to filter graphs)
    $count = $count + 1;
}
$count = 0;//initiallize count of countries\
while(($row = $serials_hold -> fetch_assoc())!==null){
    $serials[$count] = $row['Serial number'];//fill up array of country names (will be used to filter graphs)
    $count = $count + 1;
}


$table_data = array();
$table_data['Name'] = $names;
$table_data['Asset Type'] = $types;
$table_data['Function'] = $functions;
$table_data['Install Date'] = $names;
$table_data['Serial Number'] = $serials;

echo json_encode($table_data);

?>