<!DOCTYPE html >
<head>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
    <meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
    <script>src="https://maps.googleapis.com/maps/api/js"</script>
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"> </script>
	<link type="text/css" href="style.css" rel = "stylesheet">

    <title>Maps</title>
    <style>

    </style>

</head>

<body>

    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
    <link type="text/css" href="style.css" rel = "stylesheet">

<div class="container">
<div id="leftSide">
		<div id="top-right" >
			<label><</label>
		</div>
		<p>Something here from google </p>
		<div id="chart_div" class = "chart"></div>
		<script>google.load('visualization', '1', {'packages':['corechart']});

        // Set a callback to run when the Google Visualization API is loaded.
        google.setOnLoadCallback(drawChart);

        drawChart();
		</script>
</div>
<div id="map">


</div>
</div>
<script>
//var testVal = "Canada";
</script>

		<? 
		
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

<form id="myDiv" name="myDiv">
<div id="tabledata" name="tabledata"></div> <!--not used-->

<!--<button type="submit" >Submit</button>-->
</form>
<!--<?php require('cmdb_graph.php');?>
<div id="chart_div" class = "chart"></div>
<script>printCon();</script>-->
<script type="text/javascript">
		//close side panel
		 $("#top-right").on("click", function (event) {
			$("#leftSide").animate({
			width: 'toggle'
			}, 500);
		 });
		$('#click').click(function() {
		  $("#leftSide").animate({
			width: 'toggle'
		  }, 500);
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
/*function testResults (form) {
    var TestVar = form.inputbox.value;
    alert ("You typed: " + TestVar);
}*/

//downloadUrl(urlSearch, function(data) {
var myDiv = document.getElementById("myDiv");
			var label = document.createElement('label')
			label.htmlFor = "id";
			label.appendChild(document.createTextNode("Serial Number"));
			myDiv.appendChild(label);
			
			var serialNum = document.createElement("input");
			serialNum.id = "serialNum";
			serialNum.name = "serialNum";
			serialNum.style.margin = "10px 0 0 10px";
			myDiv.appendChild(serialNum);
			$("#serialNum").on("input", function() {
				//alert("Change to " + this.value);
				if(this.value != ""){
					document.getElementById("mySelect").disabled = true; 
					//disable asset type checkboxes
					for (var item in assetCheckboxArray){
						assetCheckboxArray[item].disabled = true;
					}					
				}else{
					document.getElementById("mySelect").disabled = false;
					//enable asset types
					for (var item in assetCheckboxArray){
						assetCheckboxArray[item].disabled = false;
					}	
					}
			});
			myDiv.appendChild(document.createElement("BR"));

downloadUrl("getRegions.php", function(data) {
	var xml = data.responseXML;
    var regions = xml.documentElement.getElementsByTagName('marker');
			var label = document.createElement('label')
			label.htmlFor = "id";
			label.appendChild(document.createTextNode("Region"));
			myDiv.appendChild(label);
	var regionArray = ["Select One"]; //select one is initial default
	Array.prototype.forEach.call(regions, function(regionElem) {
		var el = regionElem.getAttribute('region');
		if (el != ""){regionArray.push(el);}
	 });
	 var regionsselectList = document.createElement("select");
	regionsselectList.id = "regions";
	regionsselectList.name = "regions";
	regionsselectList.style.margin = "10px";
	myDiv.appendChild(regionsselectList);
		//Create and append the optionsn for country select list
		for (var i = 0; i < regionArray.length; i++) {
			var option = document.createElement("option");
			option.value = regionArray[i];
			option.text = regionArray[i];
			regionsselectList.appendChild(option);
		}
});

			
downloadUrl("getCountries.php", function(data) {
	var xml = data.responseXML;
    var countries = xml.documentElement.getElementsByTagName('marker');
			var label = document.createElement('label')
			label.htmlFor = "id";
			label.appendChild(document.createTextNode("Country"));
			myDiv.appendChild(label);
	var countryArray = ["Select One"]; //select one is initial default
	Array.prototype.forEach.call(countries, function(countryElem) {
		var el = countryElem.getAttribute('country');
		if (el != ""){countryArray.push(el);}
	 });
	 var selectList = document.createElement("select");
	selectList.id = "mySelect";
	selectList.name = "country";
	selectList.style.margin = "10px";
	myDiv.appendChild(selectList);
	
	countryLI = [];
	//Create and append the optionsn for country select list
	for (var i = 0; i < countryArray.length; i++) {
		countryLI.push(document.createElement("input"));
		countryLI[i].checked=true;
		countryLI[i].id = "assetType"
		countryLI[i].type = "checkbox";
		countryLI[i].style.margin = "0px 10px 10px 0 ";
		countryLI[i].name = "assetType";
		countryLI[i].value = countryArray[i];
		
		var option = document.createElement("option");
		option.value = countryArray[i];
		option.text = countryArray[i];
		selectList.appendChild(option);
	}
	var countryErrorMsg = document.createElement("span");
	myDiv.appendChild(countryErrorMsg);
	
	myDiv.appendChild(document.createElement("BR"));
	
	//var assetTypeCheckBoxArray = [];
	//var aaaaval = "<?echo 'this is a test'; ?>";
	//<?include 'getAssetTypes.php';?>
		//$val = test('This is a test');
	//	echo 'Check me out'; 
	//	echo $val;

	downloadUrl("getAssetTypes.php", function(data) {
		var xml = data.responseXML;
		var asset_types = xml.documentElement.getElementsByTagName('marker');
		var assetCheckArray = [];
		Array.prototype.forEach.call(asset_types, function(assetElem) { //asset element
			var el = assetElem.getAttribute('asset_type');
			if (el != ""){assetCheckArray.push(el);}
		});
		assetCheckboxArray = [];
		for (var i = 0; i < assetCheckArray.length; i++) {
			assetCheckboxArray.push(document.createElement("input"));
			assetCheckboxArray[i].checked=true;
			assetCheckboxArray[i].id = "assetType"
			assetCheckboxArray[i].type = "checkbox";
			assetCheckboxArray[i].style.margin = "0px 10px 10px 10px";
			assetCheckboxArray[i].name = "assetType";
			assetCheckboxArray[i].value = assetCheckArray[i];
			var label = document.createElement('label')
			label.htmlFor = "id";
			label.appendChild(document.createTextNode(assetCheckArray[i]));
			myDiv.appendChild(assetCheckboxArray[i]);
			myDiv.appendChild(label);
		}
				var AssetErrorMsg = document.createElement("span");
				myDiv.appendChild(AssetErrorMsg);
				//myDiv.appendChild(document.createElement("BR"));
			var button = document.createElement("button");
			button.id = "submitBtn";
			button.innerHTML = "Submit";
			var br = document.createElement("BR");
			//document.write("<br>");
			myDiv.appendChild(br);
			myDiv.appendChild(button);
			
				
	//myDiv.appendChild(document.createElement("BR"));
			var noneFoundErrorMsg = document.createElement("span");
	noneFoundErrorMsg.id = "errormsg";
	myDiv.appendChild(noneFoundErrorMsg);
	
	button.addEventListener ("click", function() {
	//	initMap();
		//testResults(this.form);
		//document.myDiv.submit();

		assetTypeSelectArr = document.getElementsByName("assetType");
		filterAsset = 0;
		checkedNumArr = [];
		for(var curEl = 0; curEl < assetTypeSelectArr.length; curEl++){
			if (assetTypeSelectArr[curEl].checked){
				checkedNumArr.push(assetTypeSelectArr[curEl]);
			}
		}
		if(checkedNumArr.length != assetTypeSelectArr.length){
			filterAsset = 1;
			AssetErrorMsg.innerHTML = "";

		}
		if(checkedNumArr.length == 0){
			filterAsset = -1;
			AssetErrorMsg.innerHTML = "*must select at least one asset type";
		}
		/*if (assetTypeSelectArr.length != asset_types.length){
			filterAsset = 1;
		}else if (assetTypeSelectArr.length == 0){
			filterAsset = -1;
		}*/
		
		//assetTypeSelect = checkType.value;
		serialNumber = serialNum.value;
		countrySelect = selectList.value;
		
		event.preventDefault(); //do not refresh page

		//if(switch1 == 0 && storage1 == 0){
		//	AssetErrorMsg.innerHTML = "*must select at least one asset type";
	//	}else{
			
	//		AssetErrorMsg.innerHTML = "";
	//	}
		//if(countrySelect == "Select One"){
		//	countryErrorMsg.innerHTML = "*must select a country";
		//}else{
			countryErrorMsg.innerHTML = "";
			initMap();
	//	}
	});
//	var AssetErrorMsg = document.createElement("span");
//	myDiv.appendChild(AssetErrorMsg);
//	myDiv.appendChild(document.createElement("BR"));
	
	/*var checkType = document.createElement("input");
	checkType.setAttribute('defaultChecked', 'defaultChecked');
	checkType.checked=true;
	checkType.id = "assetType"
	checkType.type = "checkbox";
	checkType.style.margin = "0px 10px 10px 0 ";
	checkType.name = "assetType";
	checkType.value = "Switch";
	var label = document.createElement('label')
	label.htmlFor = "id";
	label.appendChild(document.createTextNode('FAFA'));
	myDiv.appendChild(checkType);
	myDiv.appendChild(label);
	
	var checkType2 = document.createElement("input");
	checkType2.setAttribute('defaultChecked', 'defaultChecked');
	checkType2.checked=true;
	checkType2.id = "assetType"
	checkType2.type = "checkbox";
	checkType2.name = "assetType";
	checkType2.value = "Storage Device";
	checkType2.style.margin = "0px 10px 10px 10px";
	var label2 = document.createElement('label')
	label2.htmlFor = "id";
	label2.appendChild(document.createTextNode('FAFA'));
	myDiv.appendChild(checkType2);
	myDiv.appendChild(label2);
	
	var AssetErrorMsg = document.createElement("span");
	myDiv.appendChild(AssetErrorMsg);
	*/
	//create submit button
				//var button = document.createElement("button");
				//button.innerHTML = "Submit";
				//var br = document.createElement("BR");
				//document.write("<br>");
				//myDiv.appendChild(br);
				//myDiv.appendChild(button);
	
	var noneFoundErrorMsg = document.createElement("span");
	noneFoundErrorMsg.id = "errormsg";
	myDiv.appendChild(noneFoundErrorMsg);
	
	/*button.addEventListener ("click", function() {
	//	initMap();
		//testResults(this.form);
		//document.myDiv.submit();
		assetTypeSelectArr = document.getElementsByName("assetType");
		switch1 = 0;
		storage1 = 0;
		if(assetTypeSelectArr[0].checked){
			switch1 = assetTypeSelectArr[0].value;
		}
		if(assetTypeSelectArr[1].checked){
			storage1 = assetTypeSelectArr[1].value;
		}
		//assetTypeSelect = checkType.value;
		countrySelect = selectList.value;
		
		event.preventDefault(); //do not refresh page

		if(switch1 == 0 && storage1 == 0){
			AssetErrorMsg.innerHTML = "*must select at least one asset type";
		}else{
			AssetErrorMsg.innerHTML = "";
		}
		if(countrySelect == "Select One"){
			countryErrorMsg.innerHTML = "*must select a country";
		}else{
			countryErrorMsg.innerHTML = "";
			initMap();
		}*/
		
		///handleFireButton();
	});
	//myDiv.padding = "50px";
});


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
		var isSwitch = 0;
		var isStorage = 0;
		//var assetType2 = storage1;
		if (typeof switch1 !== 'undefined'){
			if(switch1 != 0){
				isSwitch = 1;
				assetType = switch1;
			}
		}
		if(typeof storage1 !== 'undefined'){
			if(storage1 != 0){
				isStorage = 1;
				assetType = storage1;
			}
		}
		if (typeof serialNumber == 'undefined'){
			serialNumber = "null";
		}
		if (typeof countrySelect !== 'undefined'){
			//var urlSearch = "db_connect.php?country=" + countrySelect;
			//if (typeof filterAsset !== 'undefined'){
			if (filterAsset == 1 || filterAsset == 0){
				var assetTypeArr = "";
				for(var i = 0; i < checkedNumArr.length; i++){
					assetTypeArr += checkedNumArr[i].value + "~";
				}
				var urlSearch = "db_connect_assetType.php?serial="+ serialNumber +"&country=" + countrySelect + "&assetType=" + assetTypeArr;
				//for (var i = 0; i < checkedNumArr.length; i++){
					//urlSearch += "&assetType=" + checkedNumArr[i].value;
				//}
				//urlSearch = "db_connect_assetType.php?country=" + countrySelect + "&assetType=" + checkedNumArr[0].value;
				//urlSearch += "&assetType=" + checkedNumArr[0].value;
			}
			//if((isSwitch == 1) ^ (isStorage == 1)){
			//urlSearch = "db_connect_assetType.php?country=" + countrySelect + "&assetType=" + assetType;
			//}
			//else if (isSwitch == 0 && isStorage == 0){
			//	return;
			//}
			else if (filterAsset == -1) return;
			//}
		}
		else {
			return;
		}
        downloadUrl(urlSearch, function(data) {
            var xml = data.responseXML;
            var markers = xml.documentElement.getElementsByTagName('marker');
			if(markers.length == 0){
				//alert("No assets found");
				var thisvar = document.getElementById("errormsg");
				thisvar.innerHTML = "No assets found";
				//myDiv.noneFoundErrorMsg.innerHTML("No assets found");
			}else{
			//map.setCenter(new google.maps.LatLng(markers[0].getAttribute('lat'), markers[0].getAttribute('lng')));
			var array = findCenter(markers);
			map.setCenter(array[0]); //center map using findCenter return value
			//map.setMaxZoom(5);
			//var x = findCenter(markers);
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
			map.fitBounds(bounds);
			if(markers.length == 1){
				map.setZoom(5);
			}
			//map.setZoom(array[1]);
			//map.panTo(new google.maps.LatLng(markers[0].getAttribute('lat'), markers[0].getAttribute('lng')));
			var listenerHash = {"key":"value"};
			var listenerNum = 0;
			}
					String.prototype.replaceAll = function (find, replace) {
						var str = this;
						return str.replace(new RegExp(find.replace(/+/g, '\\+'), 'g'), replace);
					};
            Array.prototype.forEach.call(markers, function(markerElem) {
				listenerNum++;
                var name = markerElem.getAttribute('name');
				var pic = 'http://maps.google.com/mapfiles/ms/icons/blue-dot.png';
				if (name > 1){
					pic = 'http://maps.google.com/mapfiles/ms/icons/green-dot.png';
				}
				if (name > 50){
					pic = 'http://maps.google.com/mapfiles/ms/icons/orange-dot.png';
				}
				if (name > 100){
					pic = 'http://maps.google.com/mapfiles/ms/icons/red-dot.png';

				}
                var address = markerElem.getAttribute('address');
				var state = markerElem.getAttribute('state');
				//var asset_type = markerElem.getAttribute('asset_type');
                var assettype = markerElem.getAttribute('assettype');
                var point = new google.maps.LatLng(
                    parseFloat(markerElem.getAttribute('lat')),
                    parseFloat(markerElem.getAttribute('lng')));

                var infowincontent = document.createElement('div');
				var addrNoSpace = address.replace(" ","");
				infowincontent.className = addrNoSpace;
				//infowincontent.appendChild(document.createElement('id = "contentInsideMap"'));
                var strong = document.createElement('strong');
                strong.textContent = "Asset Count: " + name;
                infowincontent.appendChild(strong);
                infowincontent.appendChild(document.createElement('br'));
						function replaceAll(str, find, replace) {
						  return str.replace(new RegExp(find, 'g'), replace);
						}
                var text = document.createElement('text');
				
				var re = new RegExp('\\+', 'g');
                text.textContent = address.replace("+"," ") + " , " + state.replace('+', " ");
                infowincontent.appendChild(text);
				infowincontent.appendChild(document.createElement('br'));
				
				if (assettype != null){
					var text = document.createElement('text');
					text.textContent = "Asset type: " + assettype;
					infowincontent.appendChild(text);
					infowincontent.appendChild(document.createElement('br'));
				}
				/*var text = document.createElement('text');
                text.textContent = "Asset Type: " + asset_type;
                infowincontent.appendChild(text);
				*/
                var marker = new google.maps.Marker({
                    map: map,
                    position: point,
					icon: pic
                });
								
					var listen = '.' + addrNoSpace;
					$(document).on('click',String(listen),function(){
						$("#leftSide").animate({
						width: 'show'
						}, 500);
			
						console.log("Hello, from " + address);
					});	
				// Marker marker = mMap.addMarker(new MarkerOptions().icon(BitmapDescriptorFactory.defaultMarker(BitmapDescriptorFactory.HUE_AZURE)));
                marker.addListener('click', function() {
						$("#leftSide").animate({
						width: 'show'
						}, 500);	
                    infoWindow.setContent(infowincontent);
                    infoWindow.open(map, marker);
					
                });
				marker.addListener('mouseover', function() {
                    infoWindow.setContent(infowincontent);
                    infoWindow.open(map, marker);
                });
				marker.addListener('mouseout', function() {
                   // infoWindow.setContent(infowincontent);
                    infoWindow.close(map, marker);
                });
            });
        });
    }

	//funtion findCenter(markers)
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