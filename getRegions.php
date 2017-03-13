<?php
require("db_info.php");
//$username="username";
//$password="password";
//$database="egieskemaps";
//$link = 'egieskemaps.cmwlabj3peuu.us-east-2.rds.amazonaws.com';
//require("db_info");

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
$query = "SELECT * FROM regions WHERE 1";

$result = @mysqli_query($connection,$query);
if (!$result) {
die('Invalid query: ' . @mysqli_error());
}

header("Content-type: text/xml");
// Start XML file, echo parent node
echo '<markers>';

    // Iterate through the rows, printing XML nodes for each
    while ($row = @mysqli_fetch_assoc($result)){
		// Add to XML document node
		echo '<marker ';
		echo 'region="' . $row['Region'] . '" ';
		echo '/>';
    }

    // End XML file
    echo '</markers>';

?>