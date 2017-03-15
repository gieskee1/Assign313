<html>
<head>


    <script>
        function displaySpecAssetDetails(serialNumber,lat,lng){
            var assetName = "<strong>Asset Name: </strong>";
            $("#chart5_div").append("<br>","<br>",assetName);
            var asset_details;
            $.ajax({
                url: "side_panel_charts/get_spec_asset_details.php",
                type: "post",
                data: {'Lat':lat , 'Lng':lng, 'SerialNum': serialNumber },
                dataType: 'json',
                success: function(data){
                   asset_details = data;
                   var ex = asset_details[0];
                    $("#chart5_div").append(ex);
                },
                error:function(){
                    alert("error");
                }
            });



        }


    </script>



</head>
<body>
</body>
</html>