<?php

/* Include the `fusioncharts.php` file that contains functions	to embed the charts. */



/* The following 4 code lines contain the database connection information. Alternatively, you can move these code lines to a separate file and include the file here. You can also modify this code based on your database connection. */

$hostdb = "localhost";  // MySQl host
$userdb = "root";  // MySQL username
$passdb = "root";  // MySQL password
$namedb = "cmdb_view";  // MySQL database name


// Establish a connection to the database
$dbhandle = mysqli_connect('localhost', $userdb, $passdb, $namedb);

/*Render an error message, to avoid abrupt failure, if the database connection parameters are incorrect */
if ($dbhandle->connect_error) {
    exit("There was an error with your connection
: ".$dbhandle->connect_error);
}

//Dynamically populate asset frequency data
$assets = mysqli_query($dbhandle,"SELECT DISTINCT (`Asset type`) as 'assets' from marker ");//Finds list of distinct asset names
$asset_list = array();//initialize array that will hold asset type names
$asset_count = 0;//initiallize count of asset categories
while($row = $assets -> fetch_assoc()){
    $asset_list[$asset_count] = $row['assets'];//fill up array of asset names (will be used to filter graphs)
    $asset_count = $asset_count + 1;
    echo("Hello");
}
//list holds all asset names
$asset_count = count($asset_list);//count = number of assets per category
$assets_sql = array();//holds sql result of total assets in asset category
$total_asset_count = array();//holds number of assets in each category
for($i=0;$i<$asset_count;$i++){
    $assets_sql[$i] = mysqli_query($dbhandle,"SELECT SUM(CASE WHEN `Asset type` = '$asset_list[$i]'  THEN 1 ELSE 0 END) as '$asset_list[$i]' FROM marker");
    $assets_hold = mysqli_fetch_assoc($assets_sql[$i]);//array of counts
    $total_asset_count[$i] = (int)$assets_hold[$asset_list[$i]];//array of counts of assets in categories
}

$asset_list_json = json_encode((array)$asset_list);//convert to json for javascript
$total_asset_count_json = json_encode((array)$total_asset_count);//convert to json for javascript


$countries = mysqli_query($dbhandle,"SELECT DISTINCT(Region) as 'h' from marker ");//Finds list of distinct country names
$list = array();//initialize array that will hold countries
$count = 0;//initiallize count of countries
while($row = $countries -> fetch_assoc()){
    $list[$count] = $row['h'];//fill up array of country names (will be used to filter graphs)
    $count = $count + 1;
}
//list holds all country names
$count = count($list);//count = number of countries
$country_assets = array();//holds sql result of total assets in countries
$total_count = array();//holds number of assets in each country
for($i=0;$i<$count;$i++){
    $country_assets[$i] = mysqli_query($dbhandle,"SELECT SUM(CASE WHEN Region = '$list[$i]'  THEN 1 ELSE 0 END) as '$list[$i]' FROM marker");
    $country_count = mysqli_fetch_assoc($country_assets[$i]);//array of counts
    $total_count[$i] = (int)$country_count[$list[$i]];//array of counts of assets in countries
}

$list_json = json_encode((array)$list);//convert to json for javascript
$total_count_json = json_encode((array)$total_count);//convert to json for javascript


$dbhandle->close();

?>

<html>
<head>
    <!--Load the Ajax API-->

    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
<!--    <link type="text/css" href="graph.css" rel = "stylesheet">-->
    <script type="text/javascript">
        google.load('visualization', '1', {'packages':['corechart']});

        // Set a callback to run when the Google Visualization API is loaded.
        google.setOnLoadCallback(drawChart);



        function drawChart() {//function that draws the actual chart

            // Data for Storage vs Switch Overall
            var data1 = new google.visualization.DataTable();
            var asset_list = <?=$asset_list_json?>;
            var total_asset_count = <?=$total_asset_count_json?>;
            data1.addColumn('string','Asset_type');
            data1.addColumn('number','Frequency');
            var i;
            var asset_count = <?=$asset_count?>;
            for(i = 0; i< asset_count; i++){
                data1.addRow([asset_list[i], total_asset_count[i]]);
            }
            var options = {
                title: 'Frequency of Assets',
                //is3D: 'true',
                width: 500,
                height: 400
            };

            var data2 = new google.visualization.DataTable();
            var list = <?=$list_json?>;
            var total_count = <?=$total_count_json?>;
            data2.addColumn('string','Region');
            data2.addColumn('number','Frequency');
            var i;
            var count = <?=$count?>;
            for(i = 0; i< count; i++){
                data2.addRow([list[i], total_count[i]]);
            }

            var options2 = {
                title: 'Location of Assets',
                //is3D: 'true',
                width: 500,
                height: 400
            };




            var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
            var chart2 = new google.visualization.PieChart(document.getElementById('chart2_div'));
            var chart3 = new google.visualization.PieChart(document.getElementById('chart3_div'));
            var data3 = new google.visualization.DataTable();
            var chart4 = new google.visualization.PieChart(document.getElementById('chart4_div'));
            var data4 = new google.visualization.DataTable();





            function selectHandler() {//add listener to graphs
                var selectedItem = chart.getSelection()[0];//add listener to chart 1
                var selectedItem2 = chart2.getSelection()[0];//add listener to chart 2


                if (selectedItem) {//Adds listener actions to the storage vs switch graph
                    var value = data1.getValue(selectedItem.row, 0);
                    //When this section is clicked, there should be a new graph created with the regional spread of that asset
                    //use ajax to call php script
                    var a_region_list;
                    var a_region_count;
                    $.ajax({
                        url: "asset_to_region_list.php",
                        type: "post",
                        data: {'Name':value},
                        dataType: 'json',
                        success: function(data){
                            //alert("what up peeps?");
                            a_region_list = data;
                        },
                        error:function(){
                            alert("error");
                        }
                    });
                    $.ajax({
                        url: "asset_to_region_count.php",
                        type: "post",
                        data: {'Name':value},
                        dataType: 'json',
                        success: function(data){
                            //alert("what up peeps?");
                            //document.write(data);
                            a_region_count = data;
                            data4.addColumn('string','Region');
                            data4.addColumn('number','Frequency');
                            var count = a_region_list.length;
                            for(var i = 0; i< count; i++){
                                data4.addRow([a_region_list[i], a_region_count[i]]);
                            }

                            var options4 = {
                                title: 'Location of ' + value + ' Regionally',
                                is3D: 'true',
                                width: 500,
                                height: 400
                            };
                            chart4.draw(data4,options4);
                        },
                        error:function(){
                            alert("error");
                        }
                    });

                }
                if (selectedItem2) {
                    var value2 = data2.getValue(selectedItem2.row, 0);
                    //alert(value2);
                    //When this section is clicked, there should be a new graph appear with the spread of the countries within the region that was clicked
                    //use ajax to call php script region_to_country
                    var r_country_list;
                    var r_country_count;
                    $.ajax({
                        url: "region_to_country.php",
                        type: "post",
                        data: {'Name':value2},
                        dataType: 'json',
                        success: function(data){
                            //alert("what up peeps?");
                            r_country_list = data;
                        },
                        error:function(){
                            alert("error");
                        }
                    });
                    $.ajax({
                        url: "r_to_c_count.php",
                        type: "post",
                        data: {'Name':value2},
                        dataType: 'json',
                        success: function(data){
                            //alert("what up peeps?");
                            //document.write(data);
                            r_country_count = data;
                            data3.addColumn('string','Country');
                            data3.addColumn('number','Frequency');
                            var count = r_country_list.length;
                            for(var i = 0; i< count; i++){
                                data3.addRow([r_country_list[i], r_country_count[i]]);
                            }

                            var options3 = {
                                title: 'Location of Assets within ' + value2,
                                is3D: 'true',
                                width: 500,
                                height: 400
                            };
                            chart3.draw(data3,options3);
                        },
                        error:function(){
                            alert("error");
                        }
                    });

                }
            }
            google.visualization.events.addListener(chart, 'select', selectHandler);
            google.visualization.events.addListener(chart2, 'select', selectHandler);

            //Begining of city graph code
            var data5 = new google.visualization.DataTable();
            var chart5 = new google.visualization.PieChart(document.getElementById('chart5_div'));
            var value = "Cincinnati";
            //When this section is clicked, there should be a new graph created with the regional spread of that asset
            //use ajax to call php script
            var city_asset_list;
            var city_asset_count;
            $.ajax({
                url: "city_asset_list.php",
                type: "post",
                data: {'Name':value},
                dataType: 'json',
                success: function(data){
                    //alert("what up peeps?");
                    city_asset_list = data;
                },
                error:function(){
                    alert("error");
                }
            });
            $.ajax({
                url: "city_asset_count.php",
                type: "post",
                data: {'Name':value},
                dataType: 'json',
                success: function(data){
                    //alert("what up peeps?");
                    //document.write(data);
                    city_asset_count = data;
                    data5.addColumn('string','Region');
                    data5.addColumn('number','Frequency');
                    var count = city_asset_list.length;
                    for(var i = 0; i< count; i++){
                        data5.addRow([city_asset_list[i], city_asset_count[i]]);
                    }

                    var options5 = {
                        title: 'Assets in'+' '+value,
                        is3D: 'true',
                        width: 500,
                        height: 400
                    };
                    chart5.draw(data5,options5);
                },
                error:function(){
                    alert("error");
                }
            });
            //End of city graph code

            chart.draw(data1, options);
            chart2.draw(data2,options2);




        }
    </script>
    <title>CMBD Graphs</title>
</head>

<body>
<div>
    <div id="chart_div"></div>
    <div id = "chart2_div" ></div>
</div>
<div>
    <div id = "chart3_div"></div>
    <div id = "chart4_div"></div>
</div>
<div id = "chart5_div"></div>

</body>

</html>