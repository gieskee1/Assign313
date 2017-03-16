<html>
<head>
    <!--Load the Ajax API-->

    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
	<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
	
    <!--    <link type="text/css" href="graph.css" rel = "stylesheet">-->
    <script type="text/javascript">
        google.load('visualization', '1', {'packages':['corechart','table']});

        // Set a callback to run when the Google Visualization API is loaded.
        google.setOnLoadCallback(drawCityChart);
        var asset_filter_name = "";

        function drawCityChart(lat, lng) {//function that draws the actual chart

            asset_filter_name = "";
            //Begining of city graph code
            google.charts.load('current', {'packages':['table','corechart']});
            var data5 = new google.visualization.DataTable();
            var chart5 = new google.visualization.PieChart(document.getElementById('chart5_div'));
            //When this section is clicked, there should be a new graph created with the regional spread of that asset
            //use ajax to call php script
            var city_asset_list;
            var city_asset_count;
            $.ajax({
                url: "side_panel_charts/city_asset_list.php",
                type: "post",
                data: {'Lat':lat , 'Lng':lng },
                dataType: 'json',
                success: function(data){
                    city_asset_list = data;
                },
                error:function(){
                    alert("error");
                }
            });
            $.ajax({
                url: "side_panel_charts/city_asset_count.php",
                type: "post",
                data: {'Lat':lat , 'Lng':lng},
                dataType: 'json',
                success: function(data){
                    //alert("what up peeps?");
                    //document.write(data);
                    city_asset_count = data;
                    data5.addColumn('string','Region');
                    data5.addColumn('number','Frequency');
					if (city_asset_list != null){
						var count = city_asset_list.length;
					}else{
						var count = 0;
					}
                    for(var i = 0; i< count; i++){
                        data5.addRow([city_asset_list[i] + ' - '+ city_asset_count[i], city_asset_count[i]]);
                    }
                    var options5 = {
						//title: 'Break Down of All Asset Types',
                        //is3D: 'true',
                        height: 250,
                        width: 450,
                        chartArea: {bottom:20, left: 20, top: 20, right: 0}
                    };
                    chart5.draw(data5,options5);
                },
                error:function(){
                    alert("error");
                }
            });
//            //End of city graph code
            function selectHandler() {//add listener to graphs
                var selectedItem = chart5.getSelection()[0];//add listener to chart 1


                if (selectedItem) {//Adds listener actions to the storage vs switch graph
                    var value = data5.getValue(selectedItem.row, 0);

                    asset_filter_name = value.split(" -")[0];
                    //alert(asset_filter_name);
                    drawCityTable(lat, lng);
                }

            }
            google.visualization.events.addListener(chart5, 'select', selectHandler);


        }

        google.setOnLoadCallback(drawCityTable);
        function drawCityTable(lat, lng) {

            //collect data for creating table based on location
            var data6 = new google.visualization.DataTable();
            var chart6 = new google.visualization.Table(document.getElementById('table_div'));
            $.ajax({
                url: "side_panel_charts/city_table.php",
                type: "post",
                data: {'Lat': lat, 'Lng': lng, 'Filter': asset_filter_name},
                dataType: 'json',
                success: function (data) {
                    //alert("what up peeps?");
                    data6.addColumn('string', 'Name');
                    data6.addColumn('string', 'Asset Type');
                    data6.addColumn('string', 'Function');
                    //data6.addColumn('string', 'Install Date');
                    data6.addColumn('string', 'Serial #');

                    var name = data['Name'];
                    var type = data['Asset Type'];
                    var funct = data['Function'];
                    //var install = data['Install'];
                    var serial = data['Serial Number'];

                    var count = name.length;
                    for (var i = 0; i < count; i++) {
                        data6.addRow([name[i], type[i], funct[i],serial[i]]); //install[i], serial[i]]);
                    }
                    var options6 = {
                        //title: 'ASSET INFORMATION',
                        // title: 'Assets in'+' '+value,
                        //  is3D: 'true',
                        chartArea: {left: 20, top: 20}
                    };
                    chart6.draw(data6, options6);
                },
                error: function () {
                    alert("error");
                }
            });
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
<div id = "table_div"></div>

</body>

</html>
