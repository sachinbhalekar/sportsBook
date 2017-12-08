var xmlhttp;
var map, heatmap;

//respond function for the AJAX call
function respond() 
{
	if (xmlhttp.readyState == 4 && xmlhttp.status == 200) //if processing is done and http response is OK
	{
        //alert(xmlhttp.responseText);
        console.log(xmlhttp.responseText);   
        var JSONObject = JSON.parse(xmlhttp.responseText);
        console.log(JSONObject);     
        
        var location =new Array(JSONObject.length);
        for (var i = 0; i <JSONObject.length; i++) 
        {
        	 location.push(new google.maps.LatLng(JSONObject[i][0], JSONObject[i][1]));
        }
        initHeatMap(location,JSONObject[0][0],JSONObject[0][1]);
	}
}

function showUser() 
{
	'use strict';
	
	var vOccupancy = document.getElementById("occupancy").value;
	
	getLatLong();
	var vlat= document.getElementById('latitude').value ;
	var vlng= document.getElementById('longitude').value;
	
	var nearByRegion ={
			occupancy: vOccupancy,
			latitude: vlat,
			longitude: vlng 		
		};

	//creating JSON object
	var vJSONObj = JSON.stringify(nearByRegion);
	console.log(vJSONObj);

	//set XML HTTP request
	if (window.XMLHttpRequest) 
	{
		xmlhttp = new XMLHttpRequest();
	}
	else 
	{
		xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	}
	
	xmlhttp.onreadystatechange = respond;//setting return function 
	xmlhttp.open("POST", "nearbyTargetUsers.php", true);//calling the php via AJAX
	xmlhttp.send(vJSONObj);//send JSON data to the called php
  
	return false;
}


//Map on which target users will be shown using heat map
function initMap() 
{
	map = new google.maps.Map(document.getElementById('map'), {
    	zoom: 13,
        center: {lat: 37.775, lng: -122.434},
    });

}

//Update Map with the heat marked points denoting target users
function initHeatMap(location,lat1,lng1) 
{	  
	map = new google.maps.Map(document.getElementById('map'), {
    	zoom: 13,
      	center: {lat: parseFloat(lat1), lng: parseFloat(lng1)},
    });

    heatmap = new google.maps.visualization.HeatmapLayer({
    	data: location,
      	map: map
    });
}

