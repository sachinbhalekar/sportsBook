var map;
function initMap()
{
      
	var myLatLng = {lat: 33 , lng: 34};
	map = new google.maps.Map(document.getElementById('map'), {
        zoom: 10,
        center: myLatLng
	});
	               
   	//alert(lat);
	//alert(lng);
	plot_markers( valLat, valLng );
	//plot_markers(sampleLat[3],sampleLng[3]);
	
}
 
function plot_markers( arrLat, arrLng ) 
{              	
	var geocoder = new google.maps.Geocoder;
    var infowindow = new google.maps.InfoWindow;
    var latlng = {lat: parseFloat(arrLat), lng: parseFloat(arrLng)};
    
    geocoder.geocode({'location': latlng}, function(results, status) {
        if (status === 'OK') 
        {    
       		if (results[0]) 
           	{
            	map.setZoom(11);
            	var marker = new google.maps.Marker({
              		position: latlng,
              		map: map
            	});
            	infowindow.setContent(results[0].formatted_address);
            	infowindow.open(map, marker);
          	}
        }
     });
 }   