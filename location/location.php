<?php
ob_start();
session_start();
require_once '../connection/dbconnect.php';

// if session is not set this will redirect to login page
if( !isset($_SESSION['user']) )
{
    header("Location: ../index.php");
    exit;
}
$userEmail = $_SESSION['user'];
// select loggedin users detail
$res=$conn->query("SELECT * FROM users WHERE userEmail='$userEmail'");
$userRow=$res->fetch_assoc();
?>

<!DOCTYPE html>
<html>
  <head>
  <meta charset="utf-8">
		<meta name="description" content="SportsBook">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>	
		<link rel="icon" href="../images/favicon.ico" type="image/ico" sizes="16x16" />
		<title>SportsBook - <?php echo $userRow['userName']; ?></title>
		<link rel="stylesheet" type="text/css" href="../css/home.css">
		<link href="https://fonts.googleapis.com/css?family=Zilla+Slab+Highlight" rel="stylesheet">
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <title>Simple markers</title>
    <style>
      /* Always set the map height explicitly to define the size of the div
       * element that contains the map. */
      #map {
        height: 60%;
        width: 40%;
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
  <header>
			<nav class="navbar navbar-inverse navbar-fixed-top">
              <div class="container-fluid">
                <div class="navbar-header">
                  <a class="navbar-brand" href="../index.php"><i><strong>SportsBook</strong></i></a>
                </div>
                <ul class="nav navbar-nav">
                  <li ><a href="../account/home.php">Home</a></li>
                  <li><a href="../account/postActivity.php">Post an Activity</a></li>
                  <li><a href="../account/postEvent.php">Post an Event</a></li>
                 
                </ul>
                <ul class="nav navbar-nav navbar-right">
                  <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#"><span class="glyphicon glyphicon-user"></span> Profile <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                      <li><a href="../account/personalInfo.php">My Profile</a></li>
                      <li><a href="../account/logout.php?logout">Sign Out</a></li>
                    </ul>
                  </li>
                </ul>
              </div>
            </nav>
		</header>
    <div id="map"></div>
    <script>

    var map;
function initMap()
{
	//alert("ffff");
	var myLatLng = {lat: 33, lng: 34};
	      map = new google.maps.Map(document.getElementById('map'), {
        zoom: 10,
        center: myLatLng
      });

	               /* <?php 
	        		require_once './distance.php';
	        		fetchActivities(33,34,0.85);
	        		?> */

	    	        		var sampleLat=  ['40.82212357516945','40.73581157695217'];
	        		var sampleLng=['-78.167724609375','-78.52409362792969'];

	        		var ran=Math.random()*1;
	        		alert(ran.toFixed(0));
	        		plot_markers(sampleLat[ran.toFixed(0)],sampleLng[ran.toFixed(0)]);
	        		//plot_markers(sampleLat[3],sampleLng[3]);
	
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
    
    <footer class="container-fluid text-center">
			<p>&copy; SportsBook</p>
		</footer>
  </body>
</html>