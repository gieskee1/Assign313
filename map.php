<!DOCTYPE html >
<head>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
    <meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
    <script>src="https://maps.googleapis.com/maps/api/js"</script>
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"> </script>
	<link type="text/css" href="map.css" rel = "stylesheet">

    <title>Asset Inventory Map</title>
    <style>

    </style>

</head>

<body>

    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
	<link type="text/css" href="map.css" rel = "stylesheet">

<div class="container">

<div id="leftSide" style="background-color:#FFFFFF;overflow:scroll;height:100%;overflow-x: hidden;">
		<div id="top-right" style="font-size:120%;color:#FFFFFF;margin: 0 10px 0 0;float: right;font-family:sans-serif;font-weight:bold">
			<label><</label>
		</div>
		<div style="height: 8%;background-color:#4286f4;"><img src="assets/ge-logo-white.png" alt="GE logo" style="width:25px;height:25px;padding:5px"></div>
		<div id="bluebox" style="height:10%;color:#FFFFFF;background-color:#4286f4;width:100%;font-family: sans-serif;">
			<script>
				sidelabel = document.createElement('text')
				sidelabel.id = "sidepaneltext";
				sidelabel.innerHTML = "";
				sidelabel.style.padding = "20px";
				bluebox.appendChild(sidelabel);
			</script>
			</div>
		<div id="chart5_div" class = "chart" style="background-color:#FFFFFF;overflow:hidden;"></div>
		<div id="table_div" class = "chart"></div>

		<script>
	//document.getElementById("leftSide").style.position = "fixed";

		</script>
</div>
<div id="map"></div>
</div>
<script>
</script>

		<? 
		//this is a test for php code functionality
		$name = "";
			  if (empty($_POST["name"])) {
				$nameErr = "Name is required";
			  } else {
				$name = test_input($_POST["name"]);
				// check if name only contains letters and whitespace
				if (!preg_match("/^[a-zA-Z ]*$/",$name)) {
				  $nameErr = "Only letters and white space allowed"; 
				}
			  }
		
		?>

<form id="filterDiv" name="filterDiv" style="background-color:#FFFFFF">
<div id="tabledata" name="tabledata"></div> <!--not used-->

<!--<button type="submit" >Submit</button>-->
</form>
<?php require('city_chart.php');?>
<?php require('tables.php');?>


<!--
<div id="chart_div" class = "chart"></div>
-->
<script type="text/javascript">
		//close side panel
		 $("#top-right").on("click", function (event) {
			$("#leftSide").animate({
			width: 'toggle'
			}, 600);
		 });
		$('#click').click(function() {
		  $("#leftSide").animate({
			width: 'toggle'
		  }, 600);
		});

function doNothing() {}
function downloadUrl(url, callback) {
        var request = window.ActiveXObject ?
            new ActiveXObject('Microsoft.XMLHTTP') :
            new XMLHttpRequest;

        request.onreadystatechange = function() {
            if (request.readyState == 4) {
                request.onreadystatechange = doNothing;
                callback(request, request.status);
            }
        };

        request.open('GET', url, true);
        request.send(null);
 }

//insert form components into filterDiv
var filterDiv = document.getElementById("filterDiv");
			//serial number search box
			var label = document.createElement('label')
			label.htmlFor = "id";
			label.appendChild(document.createTextNode("Identifier"));
			filterDiv.appendChild(label);
			//initalize serial number search box
			var serialNum = document.createElement("input");
			serialNum.id = "serialNum";
			serialNum.name = "serialNum";
			serialNum.placeholder = "serial number/name";
			serialNum.style.margin = "10px 0 0 10px";
			filterDiv.appendChild(serialNum);
			//listener to disable/enable other fields if serialNum has input
			$("#serialNum").on("input", function() {
				if(this.value != ""){	
					//disable
					document.getElementById("countrySelect").disabled = true; 
					document.getElementById("regionSelect").disabled = true; 
					document.getElementById("assetTypeSelect").disabled = true;		
				}else{
					//enable
					document.getElementById("countrySelect").disabled = false;
					document.getElementById("regionSelect").disabled = false;
					document.getElementById("assetTypeSelect").disabled = false;
				}
			});
			filterDiv.appendChild(document.createElement("BR"));
//Regions select box
downloadUrl("getRegions.php", function(data) {
	var xml = data.responseXML;
    var regions = xml.documentElement.getElementsByTagName('marker');
			var label = document.createElement('label')
			label.htmlFor = "id";
			label.appendChild(document.createTextNode("Region"));
			filterDiv.appendChild(label);
	var regionArray = []; //array to hold return values from xml 
	Array.prototype.forEach.call(regions, function(regionElem) {
		var el = regionElem.getAttribute('region');
		if (el != ""){regionArray.push(el);}
	 });
	//initialize region select box
	var regionsselectList = document.createElement("select");
	regionsselectList.id = "regionSelect";
	regionsselectList.multiple = true;
	regionsselectList.size = 3;
	regionsselectList.name = "regionSelect";
	regionsselectList.style.margin = "10px";
	filterDiv.appendChild(regionsselectList);
		//Create and append the options for region select list
		for (var i = 0; i < regionArray.length; i++) {
			var option = document.createElement("option");
			option.value = regionArray[i];
			option.text = regionArray[i];
			regionsselectList.appendChild(option);
		}
});

//Countries select box			
downloadUrl("getCountries.php", function(data) {
	var xml = data.responseXML;
    var countries = xml.documentElement.getElementsByTagName('marker');
			var label = document.createElement('label')
			label.htmlFor = "id";
			label.appendChild(document.createTextNode("Country"));
			filterDiv.appendChild(label);
	var countryArray = []; //array to hold return values from xml 
	Array.prototype.forEach.call(countries, function(countryElem) {
		var el = countryElem.getAttribute('country');
		if (el != ""){countryArray.push(el);}
	 });
	//initialize country select box
	var countryselectList = document.createElement("select");
	countryselectList.id = "countrySelect";
	countryselectList.name = "country";
	countryselectList.multiple = true;
	countryselectList.size = 5;
	countryselectList.style.margin = "10px";
	filterDiv.appendChild(countryselectList);
	//Create and append the options for country select list
	for (var i = 0; i < countryArray.length; i++) {
		var option = document.createElement("option");
		option.value = countryArray[i];
		option.text = countryArray[i];
		countryselectList.appendChild(option);
	}
	//error message associated with country
	var countryErrorMsg = document.createElement("span");
	filterDiv.appendChild(countryErrorMsg);
	
	//filterDiv.appendChild(document.createElement("BR"));
	
//Asset Types select box			
	downloadUrl("getAssetTypes.php", function(data) {
		var xml = data.responseXML;
		var asset_types = xml.documentElement.getElementsByTagName('marker');
		var assetTypeArray = [];
			var label = document.createElement('label')
			label.htmlFor = "id";
			label.appendChild(document.createTextNode("Asset Type"));
			filterDiv.appendChild(label);
		var assetTypeArray = []; //array to hold return values from xml 
		Array.prototype.forEach.call(asset_types, function(assetTypeElem) {
			var el = assetTypeElem.getAttribute('asset_type');
			if (el != ""){assetTypeArray.push(el);}
		 });
		 //initialize asset type select box
		var assetTypeselectList = document.createElement("select");
		assetTypeselectList.id = "assetTypeSelect";
		assetTypeselectList.name = "assetTypeSelect";
		assetTypeselectList.multiple = true;
		assetTypeselectList.size = 5;
		assetTypeselectList.style.margin = "10px";
		filterDiv.appendChild(assetTypeselectList);
		//Create and append the optionsn for country select list
		for (var i = 0; i < assetTypeArray.length; i++) {
			var option = document.createElement("option");
			option.value = assetTypeArray[i];
			option.text = assetTypeArray[i];
			assetTypeselectList.appendChild(option);
		}
			var AssetErrorMsg = document.createElement("span");
			filterDiv.appendChild(AssetErrorMsg);

	//Create submit button	
	var submit_button = document.createElement("button");
	submit_button.id = "submitBtn";
	submit_button.innerHTML = "Submit";
	submit_button.style.margin = "10px 0px 0px 0px";
	var br = document.createElement("BR");
	filterDiv.appendChild(br);
	filterDiv.appendChild(submit_button);

	//error message for when no assets were found
	var noneFoundErrorMsg = document.createElement("span");
	noneFoundErrorMsg.id = "errormsg";
	filterDiv.appendChild(noneFoundErrorMsg);
	//listener for when submit button is clicked

        //repopulate country if region is clicked


	submit_button.addEventListener ("click", function() {

		//global variables, to be used in initmap
		serialNumber = serialNum.value;
		regionSelect = $('#regionSelect').val();
		countrySelect = $('#countrySelect').val();
		assetTypeSelect = $('#assetTypeSelect').val();
		event.preventDefault(); //do not refresh page (will prevent url to be visibly changed)
		
		if(assetTypeSelect == null){
					//filterAsset = -1;
					AssetErrorMsg.innerHTML = "*must select at least one asset type";
		}else{
					AssetErrorMsg.innerHTML = "";
		}
		
			countryErrorMsg.innerHTML = ""; //reset error machine
			initMap();

	});
	var noneFoundErrorMsg = document.createElement("span");
	noneFoundErrorMsg.id = "errormsg";
	filterDiv.appendChild(noneFoundErrorMsg);
	

	});
	//filterDiv.padding = "50px";
});

	//custom label are no longer used 
    var customLabel = {
        restaurant: {
            label: 'R'
        },
        bar: {
            label: 'B'
        },
		test: {
			label: 'T'
		}
    };
	//this function paints the map and markers
    function initMap() {
        var map = new google.maps.Map(document.getElementById('map'), {
            center: new google.maps.LatLng(20, 0),
            zoom: 3
        });
        var infoWindow = new google.maps.InfoWindow;
		
			//var thisvar = document.getElementById("errormsg");
			//thisvar.innerHTML = null;
			$('#errormsg').empty();
        // Change this depending on the name of your PHP or XML file
		//var urlSearch = document.getElementById('search_name').value();
		//var testEl = document.getElementById("mySelect").value;
		//var url = window.location.href 
		//var captured = /country=([^&]+)/.exec(url)[1]; 
		//var result = captured ? captured : '-1';
		assetType = "";
		//checks to avoid error messages for undefined variables
		if (typeof serialNumber == 'undefined'){
			serialNumber = "null";
		}
		if (typeof countrySelect !== 'undefined' && typeof regionSelect !=='undefined'){
			//if (filterAsset == 1 || filterAsset == 0){
				/*var assetTypeArr = "";
				for(var i = 0; i < checkedNumArr.length; i++){
					assetTypeArr += checkedNumArr[i].value + "~";
				}*/
				//build url for php file to read from
				var urlSearch = "db_connect_assetType.php?serial=" + serialNumber + "&region=" + regionSelect +"&country=" + countrySelect + "&assetType=" + assetTypeSelect;
			//}

			//else if (filterAsset == -1) return;

		}
		else {
			return; //input fields are not filled in properly
		}
		//create markers, using db_connect_assetType file
        downloadUrl(urlSearch, function(data) {
            var xml = data.responseXML;
            var markers = xml.documentElement.getElementsByTagName('marker');
			//no assets found
			if(markers.length == 0){
				var thisvar = document.getElementById("errormsg");
				thisvar.innerHTML = "No assets found";
			}else{
			var array = findCenter(markers);
			map.setCenter(array[0]); //center map using findCenter return value
			//set the boundaries of the map
			var bounds = new google.maps.LatLngBounds();
			var latb = 0;
			var longb = 0;
			var curLoc;
			for (var cur = 0; cur < markers.length; cur++) {	
				latb = markers[0].getAttribute('lat');
				longb =  markers[0].getAttribute('lng');
				curLoc = new google.maps.LatLng(markers[cur].getAttribute('lat'), markers[cur].getAttribute('lng'));
				bounds.extend(curLoc);
			}
			map.fitBounds(bounds);//finished setting the boundaries of the map
			//map zooms way too much if there is only one marker on the map, this avoids that
			if(markers.length == 1){
				map.setZoom(5);
			}
			} //end of if markers exist else clause
					//this was an attempt to replace all '+' in city names
					/*String.prototype.replaceAll = function (find, replace) {
						var str = this;
						return str.replace(new RegExp(find.replace(/+/g, '\\+'), 'g'), replace);
					};*/
			//loop through all markers returned in xml 
            Array.prototype.forEach.call(markers, function(markerElem) {
                var assetcount = markerElem.getAttribute('assetcount');
				//potential for heat map characteristics by chaning pin color, currently all are red
				var pic = 'http://maps.google.com/mapfiles/ms/icons/red-dot.png';
				if (assetcount > 1){
					pic = 'http://maps.google.com/mapfiles/ms/icons/red-dot.png';
				}
				if (assetcount > 50){
					pic = 'http://maps.google.com/mapfiles/ms/icons/red-dot.png';
				}
				if (assetcount > 100){
					pic = 'http://maps.google.com/mapfiles/ms/icons/red-dot.png';

				}
				//extract data
                var address = markerElem.getAttribute('address');
				var state = markerElem.getAttribute('state');
                var assettype = markerElem.getAttribute('assettype');
                var point = new google.maps.LatLng( parseFloat(markerElem.getAttribute('lat')), parseFloat(markerElem.getAttribute('lng')));
                var lat = markerElem.getAttribute('lat');
                var lng = markerElem.getAttribute('lng');
				var infowincontent = document.createElement('div');
				var addrNoSpace = address.replace(" ","");
				infowincontent.className = addrNoSpace;
                var boldAssetCount = document.createElement('strong'); //bold
                boldAssetCount.textContent = "Asset Count: " + assetcount; 
                infowincontent.appendChild(boldAssetCount);
                infowincontent.appendChild(document.createElement('br'));
						function replaceAll(str, find, replace) {
						  return str.replace(new RegExp(find, 'g'), replace);
						}//attempt to replace '+', does not work!
                var text = document.createElement('text');
				//attempt to replace '+', does not work!
				var re = new RegExp('\\+', 'g');
                text.textContent = address.replace("+"," ") + " , " + state.replace('+', " ");
                infowincontent.appendChild(text);
				infowincontent.appendChild(document.createElement('br'));
				
				if (assettype != null){ //avoids error messages if there is no asset type, should never occur
					var text = document.createElement('text');
					text.textContent = "Asset type: " + assettype;
					infowincontent.appendChild(text);
					infowincontent.appendChild(document.createElement('br'));
				}
				//create marker
                var marker = new google.maps.Marker({
                    map: map,
                    position: point,
					icon: pic
                });
					//set listener on dialog box when clicked
					//this no longer occurs since dialog boxes only appear when mouse hovers over marker
					var listen = '.' + addrNoSpace;
					$(document).on('click',String(listen),function(){
						$("#leftSide").animate({
						width: 'show'
						}, 500);
						console.log(address);
					});	
				//add listener to marker when clicked
                marker.addListener('click', function() {
					//show side panel
						$("#leftSide").animate({
						width: 'show'
						}, 500);	
					sidelabel.innerHTML = address;
							google.load('visualization', '1', {'packages':['corechart','table']});

							// Set a callback to run when the Google Visualization API is loaded.
							google.setOnLoadCallback(drawCityChart);
							google.setOnLoadCallback(drawCityTable);
							//getValue(address);
							drawCityChart(lat,lng);
							drawCityTable(lat,lng);
                    infoWindow.setContent(infowincontent);
                    infoWindow.open(map, marker);
					
                });
				//add listener to marker when hovered over
				//set dialog box content
				marker.addListener('mouseover', function() {
                    infoWindow.setContent(infowincontent);
                    infoWindow.open(map, marker);
                });
				//close dialog box when mouse hovers off of marker
				marker.addListener('mouseout', function() {
                    infoWindow.close(map, marker);
                });
            });
        });
    }
	//sends customized url to php files for data querying 
    function downloadUrl(url, callback) {
        var request = window.ActiveXObject ?
            new ActiveXObject('Microsoft.XMLHTTP') :
            new XMLHttpRequest;

        request.onreadystatechange = function() {
            if (request.readyState == 4) {
                request.onreadystatechange = doNothing;
                callback(request, request.status);
            }
        };

        request.open('GET', url, true);
        request.send(null);
    }

    function doNothing() {}
	//find center between two markers
	function findCenter(arr){
		var latArr = [];
		var longArr = [];
		var i = 0;
		for (i = 0; i < arr.length; i++){
			latArr.push(arr[i].getAttribute('lat'));
			longArr.push(arr[i].getAttribute('lng'));
		}
		
		var minLatit = Math.min.apply( Math, latArr );
		var minLongit = Math.min.apply( Math, longArr );
		var maxLatit = Math.max.apply( Math, latArr );
		var maxLongit = Math.max.apply( Math, longArr );
		
		var centerLat = (maxLatit + minLatit) / 2;
		var centerLong = (maxLongit + minLongit) / 2;
		var distanceLat = (maxLatit - minLatit);
		var distanceLong = (maxLongit - minLongit);
		var returnZoom;
		var mapHeight = document.getElementById('map').clientHeight;
		var mapWidth = document.getElementById('map').clientWidth;
		if ( (distanceLat > 40) || (distanceLong > 40)){
			returnZoom = 4;
		} else{
			returnZoom = 5;
		}
		//returnVal = centerLong;
		var returnLoc = new google.maps.LatLng(centerLat,centerLong);
		var returnVal = [returnLoc,returnZoom];
		return returnVal;
		
		
		
	}
</script>
<script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDVKf8jt-n81FRXhuE1_LilaEBHsn1EDsY&callback=initMap">
</script>
</body>
</html>