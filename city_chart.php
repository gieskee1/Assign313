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

		function drawAssetTable(assetType) {
			var data = new google.visualization.DataTable();
			data.addColumn('string', 'Name');
			data.addColumn('number', val);
			data.addColumn('boolean', 'Full Time Employee');
			
			/*$.ajax({
                url: "get_asset_details.php",
                type: "post",
                data: {'Lat':lat , 'Lng':lng, 'AssetType':assetType},
                dataType: 'json',
                success: function(data){
                    city_asset_list = data;
                },
                error:function(){
                    alert("error");
                }
            });*/
			
			data.addRows([
			  ['Mike',  {v: 10000, f: '$10,000'}, true],
			  ['Jim',   {v:8000,   f: '$8,000'},  false],
			  ['Alice', {v: 12500, f: '$12,500'}, true],
			  ['Bob',   {v: 7000,  f: '$7,000'},  true]
			]);

			table = new google.visualization.Table(document.getElementById('table_div'));

			table.draw(data, {showRowNumber: true, width: '100%', height: '100%'});
			
      }

        function drawCityChart(lat, lng) {//function that draws the actual chart
           // if (typeof table !== 'undefined'){
		//		table.clearChart();
		//	}
			var Assetdata5 = new google.visualization.DataTable();
            var Assettable5 = new google.visualization.PieChart(document.getElementById('chart5_div'));
			function selectCityHandler(){
				 var selectedItem = chart5.getSelection()[0];
				  var value = data5.getValue(selectedItem.row, 0);
				      google.charts.load('current', {'packages':['table','corechart']});
					//  google.charts.setOnLoadCallback(drawAssetTable);

					//  drawAssetTable(value);
			}
            /*function selectCityHandler() {//add listener to graphs
              //  var selectedItem = chart.getSelection()[0];//add listener to chart 1
                var selectedItem2 = chart5.getSelection()[0];//add listener to chart 2


               // if (selectedItem) {//Adds listener actions to the storage vs switch graph
                    var value = data5.getValue(selectedItem.row, 0);
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

                
         //   }*/
    
  //          google.visualization.events.addListener(chart2, 'select', selectHandler);
		
            //Begining of city graph code
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
                        data5.addRow([city_asset_list[i], city_asset_count[i]]);
                    }

                    var options5 = {
						title: 'Break Down of All Asset Types',
                        // title: 'Assets in'+' '+value,
                        //  is3D: 'true',
                        width: 500,
                        height: 400,
                        chartArea: {left:20}
                    };
                    chart5.draw(data5,options5);
                },
                error:function(){
                    alert("error");
                }
            });
//            //End of city graph code

            google.visualization.events.addListener(chart5, 'select', selectCityHandler);




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
