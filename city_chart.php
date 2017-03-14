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

        function drawCityChart(lat, lng) {//function that draws the actual chart
		
            //Begining of city graph code
            google.charts.load('current', {'packages':['table','corechart']});
            var data5 = new google.visualization.DataTable();
            var chart5 = new google.visualization.PieChart(document.getElementById('chart5_div'));
            //When this section is clicked, there should be a new graph created with the regional spread of that asset
            //use ajax to call php script
            var city_asset_list;
            var city_asset_count;
            $.ajax({
                url: "city_asset_list.php",
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
                url: "city_asset_count.php",
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
						title: 'Break Down of All Asset Types',
                        // title: 'Assets in'+' '+value,
                        //  is3D: 'true',
                        width: 600,
                        height: 300,
                        chartArea: {left:20}
                    };
                    chart5.draw(data5,options5);
                },
                error:function(){
                    alert("error");
                }
            });
//            //End of city graph code



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
