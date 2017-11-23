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
//$res=$conn->query("SELECT * FROM users WHERE userEmail='$userEmail'");
//$userRow=$res->fetch_assoc();

$error = false;

if ( isset($_POST['event_form']) || isset($_POST['event_btn']) )
{
    //echo "<script type='text/javascript'>alert('inside');</script>";
    $title = trim($_POST['title']);
    $title = strip_tags($title);
    $title = htmlspecialchars($title);
    
    $desc = trim($_POST['desc']);
    $desc = strip_tags($desc);
    $desc = htmlspecialchars($desc);
    
    $sport = trim($_POST['sport']);
    $sport = strip_tags($sport);
    $sport = htmlspecialchars($sport);
    
    $address1 = trim($_POST['address1']);
    $address1 = strip_tags($address1);
    $address1 = htmlspecialchars($address1);
    
    $address2 = trim($_POST['address2']);
    $address2 = strip_tags($address2);
    $address2 = htmlspecialchars($address2);
    
    $city = trim($_POST['city']);
    $city = strip_tags($city);
    $city = htmlspecialchars($city);
    
    $state = trim($_POST['state']);
    $state = strip_tags($state);
    $state = htmlspecialchars($state);
    
    $country = trim('');
    $country = strip_tags($country);
    $country = htmlspecialchars($country);
    
    $zipcode = trim($_POST['zipcode']);
    $zipcode = strip_tags($zipcode);
    $zipcode = htmlspecialchars($zipcode);
    
    $landmark = trim($_POST['landmark']);
    $landmark = strip_tags($landmark);
    $landmark = htmlspecialchars($landmark);
    
    $date = trim($_POST['date']);
    $date = strip_tags($date);
    $date = htmlspecialchars($date);
    
    $occupancy = trim($_POST['occupancy']);
    $occupancy = strip_tags($occupancy);
    $occupancy = htmlspecialchars($occupancy);
    
    $time_in = trim($_POST['time_in']);
    $time_in = strip_tags($time_in);
    $time_in = htmlspecialchars($time_in);
    
    $time_out = trim($_POST['time_out']);
    $time_out = strip_tags($time_out);
    $time_out = htmlspecialchars($time_out);
    
    $latitude = trim($_POST['latitude']);
    $latitude = strip_tags($latitude);
    $latitude = htmlspecialchars($latitude);
    //echo "<script type='text/javascript'>alert('$latitude');</script>";
    
    $longitude = trim($_POST['longitude']);
    $longitude = strip_tags($longitude);
    $longitude = htmlspecialchars($longitude);
    
    //echo "<script type='text/javascript'>alert('$time_out');</script>";
    
    // if there's no error, continue to post
    if( !$error )
    {
        $query = "INSERT INTO user_event(userEmail,eventTitle,eventDesc,eventSport,eventOccupancy,eventDate,eventInTime,eventOutTime) VALUES('$userEmail','$title','$desc','$sport','$occupancy','$date','$time_in','$time_out')";
        
        $query1 = "INSERT INTO event_address(userEmail,address1,address2,city,state,country,zipcode,landmark,latitude,longitude) VALUES('$userEmail','$address1','$address2','$city','$state','$country','$zipcode','$landmark',$latitude,$longitude)";
        
        if($conn->query($query) === TRUE && $conn->query($query1) === TRUE)
        {
            $errTyp = "success";
            $message = "Your event successfully posted!";
        }
        else
        {
            $errTyp = "danger";
            $message = "Something went wrong, try again later...";
        }
    }
    
    unset($_POST['event_form']);
    unset($_POST['event_btn']);
}

?>
<!DOCTYPE html>
<html lang="en">
	<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBPSaH_Tq4dlXK_blEM9eD7YuTXPkFQw80&callback=initMap" async defer></script>
	<script>
    function getLatLong()
    {
        //alert('getLatLong');
        //var vLat = 0;
        //var vLong = 0;
    	var vAddress1 = document.getElementById('address1').value.trim();
    	var vAddress2 = document.getElementById('address2').value.trim();
    	var vCity = document.getElementById('city').value.trim();
    	var vState = document.getElementById('state').value.trim();
    	var vZipcode = document.getElementById('zipcode').value.trim();
    	
    	var geocoder = new google.maps.Geocoder();
    	var address = vAddress1+", "+vAddress2+", "+vCity+", "+vState+", "+vZipcode;
    	if(vAddress1!='' && vCity!='' && vState!='' && vZipcode!='')
    	{
            geocoder.geocode( { 'address': address}, function(results, status) {
              if (status == 'OK') 
              {
         		 //vLat = results[0].geometry.location.lat();
         		 document.getElementById('latitude').value = results[0].geometry.location.lat();
        	  	 //vLong = results[0].geometry.location.lng();
        	  	 document.getElementById('longitude').value = results[0].geometry.location.lng();
        	   	 //alert(vLat);
        	   	 //alert( typeof vLat );
        	   	 //alert( typeof vLat.toString() );
        	   	 //alert(vLong);
              } 
            });
    	}
    	
    	//document.getElementById('latitude').value = vLat;
    	//document.getElementById('longitude').value = vLong;
    	//alert(document.getElementById('latitude').value);
    	//alert(document.getElementById('longitude').value);
    	//alert('before submit');
    	//document.getElementById('signup_form').submit();
    }

    function setSports()
    {
    	//alert(document.getElementById('sport').value);
    	if( document.getElementById('football').checked ) 
    	{
			//Football radio button is checked
    		document.getElementById('sport').value = 'football';
		}
		else if( document.getElementById('tennis').checked ) 
		{
			//Tennis radio button is checked
			document.getElementById('sport').value = 'tennis';
		}
		else if( document.getElementById('cricket').checked ) 
		{
			//Cricket radio button is checked
			document.getElementById('sport').value = 'cricket';
		}
		//alert(document.getElementById('sport').value);
    }
    </script>
    
     <script>

      // This example requires the Visualization library. Include the libraries=visualization
      // parameter when you first load the API. For example:
      // <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=visualization">

      var map, heatmap;

      function initMap() {
        map = new google.maps.Map(document.getElementById('map'), {
          zoom: 13,
          center: {lat: 37.775, lng: -122.434},
          
        });

        heatmap = new google.maps.visualization.HeatmapLayer({
          data: getPoints(),
          map: map
        });
      }

      function toggleHeatmap() {
        heatmap.setMap(heatmap.getMap() ? null : map);
      }

      function changeGradient() {
        var gradient = [
          'rgba(0, 255, 255, 0)',
          'rgba(0, 255, 255, 1)',
          'rgba(0, 191, 255, 1)',
          'rgba(0, 127, 255, 1)',
          'rgba(0, 63, 255, 1)',
          'rgba(0, 0, 255, 1)',
          'rgba(0, 0, 223, 1)',
          'rgba(0, 0, 191, 1)',
          'rgba(0, 0, 159, 1)',
          'rgba(0, 0, 127, 1)',
          'rgba(63, 0, 91, 1)',
          'rgba(127, 0, 63, 1)',
          'rgba(191, 0, 31, 1)',
          'rgba(255, 0, 0, 1)'
        ]
        heatmap.set('gradient', heatmap.get('gradient') ? null : gradient);
      }

      function changeRadius() {
        heatmap.set('radius', heatmap.get('radius') ? null : 20);
      }

      function changeOpacity() {
        heatmap.set('opacity', heatmap.get('opacity') ? null : 0.2);
      }

      // Heatmap data: 500 Points
      function getPoints() {
        return [
        	<?php 
        			require_once '../location/distance.php';
        			fetchTargetRegion();
        			?> 
        ];
      }
    </script>
    <script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBPSaH_Tq4dlXK_blEM9eD7YuTXPkFQw80&callback&libraries=visualization&callback=initMap">
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
		<link rel="stylesheet" type="text/css" href="../css/postEvent.css">
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
                  <li class="active"><a href="postEvent.php">Post an Event</a></li>
                
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
        			<h1>Post your Event here...</h1>
        			<hr>
        			<div class="panel panel-default text-left">
                        <div class="panel-body">
                        	<form id="event_form" name="event_form" class="form-horizontal event_form" method="post" action="<?php $_SERVER['PHP_SELF']; ?>">
                                <?php
                                if ( isset($message) ) 
                                {
                                ?>
                                	<div class="form-group">
                                    	<div id="message_div" class="alert alert-<?php echo ($errTyp=="success") ? "success" : $errTyp; ?>">
                                			<span class="glyphicon glyphicon-info-sign"></span> <?php echo $message; ?>
                                    	</div>
                                    </div>
                                <?php
                                }
                                ?>
                                <div class="form-group">
                                  	<label class="control-label col-sm-2" for="title">Event Title:</label>
                                  	<div class="col-sm-8">          
                                    	<input id="title" name="title" class="form-control" type="text" maxlength="50" required placeholder="Enter a title for the event" />
                                  	</div>
                                </div>
                                <div class="form-group">
                                  	<label class="control-label col-sm-2" for="desc">Description:</label>
                                  	<div class="col-sm-8">          
                                    	<textarea id="desc" name="desc" class="form-control" maxlength="500" rows="4" required placeholder="Write your post here..."></textarea>
                                  	</div>
                                </div>
                                <div class="form-group">
                                  	<label class="control-label col-sm-2">Sport Category:</label>
                                  	<div class="col-sm-10">
                                    	<label class="radio-inline"><input id="football" name="sportR" type="radio" onclick="setSports()"/>Football</label>
										<label class="radio-inline"><input id="tennis" name="sportR" type="radio" onclick="setSports()"/>Tennis</label>
										<label class="radio-inline"><input id="cricket" name="sportR" type="radio" onclick="setSports()"/>Cricket</label>
										<input id="sport" name="sport" type="text" hidden="">
                                  	</div>
                                </div>
                                <div class="form-group">
                                  	<label class="control-label col-sm-2" for="address1">Address Line 1:</label>
                                  	<div class="col-sm-8">          
                                    	<input id="address1" name="address1" class="form-control" type="text" maxlength="50" onblur="getLatLong();" required placeholder="Enter Street Address" /><input id="latitude" name="latitude" type="number" step="any" hidden=""/>
                                  	</div>
                                </div>
                                <div class="form-group">
                                  	<label class="control-label col-sm-2" for="address2">Address Line 2:</label>
                                  	<div class="col-sm-8">          
                                    	<input id="address2" name="address2" class="form-control" type="text" maxlength="50" required placeholder="Enter Apt/Unit" />
                                  	</div>
                                </div>
                                <div class="form-group">
                                  	<label class="control-label col-sm-2" for="city">City:</label>
                                  	<div class="col-sm-8">          
                                    	<input id="city" name="city" class="form-control" type="text" maxlength="50" required placeholder="Enter City" />
                                  	</div>
                                </div>
                                <div class="form-group">
                                  	<label class="control-label col-sm-2" for="state">State:</label>
                                  	<div class="col-sm-8">          
                                    	<input id="state" name="state" class="form-control" type="text" maxlength="50" required placeholder="Enter State" />
                                  	</div>
                                </div>
                                <div class="form-group">
                                  	<label class="control-label col-sm-2" for="zipcode">ZipCode:</label>
                                  	<div class="col-sm-8">          
                                    	<input id="zipcode" name="zipcode" class="form-control" type="number" min="00001" max="99999" onblur="getLatLong();" required placeholder="Enter ZipCode" /><input id="longitude" name="longitude" type="number" step="any" hidden=""/>
                                  	</div>
                                </div>
                                <div class="form-group">
                                  	<label class="control-label col-sm-2" for="landmark">Landmark:</label>
                                  	<div class="col-sm-8">          
                                    	<input id="landmark" name="landmark" class="form-control" type="text" maxlength="50" required placeholder="Enter Landmark" />
                                  	</div>
                                </div>
                                <div class="form-group">
                                  	<label class="control-label col-sm-2" for="date">Date:</label>
                                  	<div class="col-sm-2">          
                                    	<input id="date" name="date" class="form-control datepicker" data-date-format="mm/dd/yyyy" type="date" required  />
                                  	</div>
                                  	
                                  	<label class="control-label col-sm-2" for="occupancy">Max Occupancy:</label>
                                  	<div class="col-sm-2">          
                                    	<input id="occupancy" name="occupancy" class="form-control" type="number" min="50" required value="50" />
                                  	</div>
                                </div>
                                <div class="form-group">
                                  	<label class="control-label col-sm-2" for="time_in">Time In:</label>
                                  	<div class="col-sm-2">          
                                    	<input id="time_in" name="time_in" class="form-control timepicker" type="time" required  />
                                  	</div>
                                  	
                                  	<label class="control-label col-sm-2" for="time_out">Time Out:</label>
                                  	<div class="col-sm-2">          
                                    	<input id="time_out" name="time_out" class="form-control timepicker" type="time" required  />
                                  	</div>
                                </div>
                                <div class="form-group">
                                	<label class="control-label col-sm-2" for="">Area to scan:</label>
                                  	<div class="col-sm-8">          
                                    	<div class="panel panel-default">
                                            <!-- <div class="panel-heading">Panel Heading</div> -->
                                            <div class="panel-body" id="map"></div>
                                        </div>
                                  	</div>
                                </div>
                                <div class="form-group">        
                                  	<div class="col-sm-offset-2 col-sm-10">
                                    	<button id="event_btn" name="event_btn" type="submit" class="btn btn-primary">Post it</button>
                                  	</div>
                                </div> 
                        	</form>   
                        </div>
                    </div>
        		</div>
			</div>
		</div>
		<footer class="container-fluid text-center">
			<p>&copy; SportsBook</p>
		</footer>
	</body>
</html>
<?php ob_end_flush(); ?>