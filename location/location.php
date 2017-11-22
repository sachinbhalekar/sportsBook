

<!DOCTYPE html>
<html>
  <head>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <title>Simple markers</title>
    <style>
      /* Always set the map height explicitly to define the size of the div
       * element that contains the map. */
      #map {
        height: 100%;
      }
      /* Optional: Makes the sample page fill the window. */
      html, body {
        height: 100%;
        margin: 0;
        padding: 0;
      }
    </style>
  </head>
  <body>
    <div id="map"></div>
    <script>

    var map;
function initMap()
{
	alert("ffff");
	var myLatLng = {lat: 33, lng: 34};
	      map = new google.maps.Map(document.getElementById('map'), {
        zoom: 10,
        center: myLatLng
      });

	               /* <?php 
	        		require_once './distance.php';
	        		fetchActivities(33,34,0.85);
	        		?> */
	        				plot_markers('40.714224','-73.961452');
	        		 plot_markers('41.714224','-73.961452')
	
}
 
      function plot_markers(arrLat,arrLng) {

    	
var geocoder = new google.maps.Geocoder;
          var infowindow = new google.maps.InfoWindow;

          
          var latlng = {lat: parseInt(arrLat), lng: parseInt(arrLng)};
    
		//var marker = new google.maps.Marker({
      //  position: myLatLng,
      //  map: map,
      //  title: 'Hello World!'
      //});
		
		geocoder.geocode({'location': latlng}, function(results, status) {
        
          if (!results[0]) {
			results[0]="Address Unknown";
			}
           
            var marker = new google.maps.Marker({
              position: latlng,
              map: map
            });
            infowindow.setContent(results[0].formatted_address);
            infowindow.open(map, marker);
           
         
      });
		
		
      }
	  
   
	
    </script>
	 
    <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBPSaH_Tq4dlXK_blEM9eD7YuTXPkFQw80&callback=initMap">
    </script>
  </body>
</html>