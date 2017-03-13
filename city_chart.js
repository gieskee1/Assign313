function drawCityChart(lat, lng) {//function that draws the actual chart

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
                            alert("error in ajax");
                        }
                    });

                }
            }
            google.visualization.events.addListener(chart, 'select', selectHandler);
            google.visualization.events.addListener(chart2, 'select', selectHandler);

            //Begining of city graph code
            var data5 = new google.visualization.DataTable();
            var chart5 = new google.visualization.PieChart(document.getElementById('chart5_div'));
            //var value = "Cincinnati";
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
                    var count = city_asset_list.length;
                    for(var i = 0; i< count; i++){
                        data5.addRow([city_asset_list[i], city_asset_count[i]]);
                    }

                    var options5 = {
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

            chart.draw(data1, options);
            chart2.draw(data2,options2);




        }