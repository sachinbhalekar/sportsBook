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
<html lang="en">
	<script>
		/*
		function openLocWin()
		{
			var locWindow = window.open('location.php', 'location', 'width=300,height=250');
			locWindow.focus();
            return true;
		}
		*/
    </script>
	<head>
		<meta charset="utf-8">
		<meta name="description" content="SportsBook">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>	
		<link rel="icon" href="../images/favicon.ico" type="image/ico" sizes="16x16" />
		<title>SportsBook - <?php echo $userRow['userName']; ?></title>
		<link rel="stylesheet" type="text/css" href="../css/activityInfo.css">
		<link href="https://fonts.googleapis.com/css?family=Zilla+Slab+Highlight" rel="stylesheet">
	</head>
	<body>
		<header>
			<nav class="navbar navbar-inverse navbar-fixed-top">
              <div class="container-fluid">
                <div class="navbar-header">
                  <a class="navbar-brand" href="../index.php"><i><strong>SportsBook</strong></i></a>
                </div>
                <ul class="nav navbar-nav">
                  <li><a href="home.php">Home</a></li>
                  <li><a href="postActivity.php">Post an Activity</a></li>
                  <li><a href="postEvent.php">Post an Event</a></li>
                
                </ul>
                <ul class="nav navbar-nav navbar-right">
                  <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#"><span class="glyphicon glyphicon-user"></span> Profile <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                      <li><a href="personalInfo.php">My Profile</a></li>
                      <li><a href="logout.php?logout">Sign Out</a></li>
                    </ul>
                  </li>
                </ul>
              </div>
            </nav>
		</header>
		
		<div class="container">
	
			<div class="row">
        		<div class="col-sm-12 text-left">
        			<h1>Activity Info...</h1>
        			<hr>
        			<div class="panel panel-default text-left">
                        <div class="panel-body">
                        	<form id="activityInfo_form" name="activityInfo_form" class="form-horizontal" method="post" action="<?php $_SERVER['PHP_SELF']; ?>">
                                <div class="form-group">
                                  	<label class="control-label col-sm-2" for="desc">Name:</label>
                                  	<div class="col-sm-8">          
                                    	<p class="form-control" >Sumit Jawale</p>
                                  	</div>
                                </div>
                                <div class="form-group">
                                  	<label class="control-label col-sm-2" for="desc">Description:</label>
                                  	<div class="col-sm-8">          
                                    	<p class="form-control">I am going to play for an hour. Let me know if anybody interested.</p>
                                  	</div>
                                </div>
                                <div class="form-group">
                                  	<label class="control-label col-sm-2">Sport Category:</label>
                                  	<div class="col-sm-10">
                                    	<label class="radio-inline"><input id="football" name="sportR" type="radio"  disabled/>Football</label>
										<label class="radio-inline"><input id="tennis" name="sportR" type="radio"  disabled checked/>Tennis</label>
										<label class="radio-inline"><input id="cricket" name="sportR" type="radio"  disabled/>Cricket</label>
										<input id="sport" name="sport" type="text" hidden="">
                                  	</div>
                                </div>
                                <div class="form-group">
                                  	<label class="control-label col-sm-2" for="address1">Location:</label>
                                  	<div class="col-sm-8">          
                                    	<p class="form-control">4250-4800 State Rte1003, Mcconnellsburg, PA 17233, USA</p>
                                    	
                                    	<div class="panel panel-default">
                                            <!-- <div class="panel-heading">Panel Heading</div> -->
                                            <div class="panel-body" id="map"></div>
                                        </div>
                                  	</div>
                                </div>
                                <div class="form-group">
                                  	<label class="control-label col-sm-2" for="landmark">Landmark:</label>
                                  	<div class="col-sm-8">          
                                    	<p class="form-control">Near USPS office</p>
                                  	</div>
                                </div>
                                <div class="form-group">
                                  	<label class="control-label col-sm-2" for="date">Date:</label>
                                  	<div class="col-sm-2">          
                                    	<p class="form-control">27th November 2017</p>
                                  	</div>
                                </div>
                                <div class="form-group">
                                  	<label class="control-label col-sm-2" for="time_in">Time In:</label>
                                  	<div class="col-sm-2">          
                                    	<p class="form-control">5:00 PM</p>
                                  	</div>
                                  	
                                  	<label class="control-label col-sm-2" for="time_out">Time Out:</label>
                                  	<div class="col-sm-2">          
                                    	<p class="form-control">6:00 PM</p>
                                  	</div>
                                </div>
                                <div class="form-group">        
                                  	<div class="col-sm-offset-2 col-sm-10">
                                  		<a href="#">Interested <span class="badge">5</span></a><br/><br/>
                                    	<button type="button" class="btn btn-primary"><span class="glyphicon glyphicon-thumbs-up"></span>  I'm interested!</button>
                                  	</div>
                                </div> 
                        	</form>   
                        </div>
                    </div>
        		</div>
			</div>
		</div>
		
		
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
            
            	               
            	    	        		var sampleLat=  ['40.82212357516945','40.73581157695217'];
            	        		var sampleLng=['-78.167724609375','-78.52409362792969'];
            
            	        		var ran=Math.random()*1;
            	        		//alert(ran.toFixed(0));
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
<?php ob_end_flush(); ?>