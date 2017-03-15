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
        google.setOnLoadCallback(drawCityTable);

        function drawCityTable(lat, lng) {

            //collect data for creating table based on location
            var data6 = new google.visualization.DataTable();
            var chart6 = new google.visualization.Table(document.getElementById('table_div'));
            $.ajax({
                url: "side_panel_charts/city_table.php",
                type: "post",
                data: {'Lat': lat, 'Lng': lng},
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
                    var install = data['Install'];
                    var serial = data['Serial Number'];

                    var count = name.length;
                    for (var i = 0; i < count; i++) {
                        data6.addRow([name[i], type[i], funct[i],serial[i]]); //install[i], serial[i]]);
                    }
                    var options6 = {
                        //title: 'ASSET INFORMATION',
                        // title: 'Assets in'+' '+value,
                        //  is3D: 'true',
                        width: 650,
                        height: 300,
                        chartArea: {left: 20}
                    };
                    chart6.draw(data6, options6);
                },
                error: function () {
                    alert("error");
                }
            });
        }
    </script>
    <title>CMBD Table</title>
</head>

<body>

<div id = "table_div"></div>

</body>

</html>