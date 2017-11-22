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
                  <li><a href="postEvent.php">Post an Event</a></li>
                  <li class="active"><a href="postEvent.php">Post an Event</a></li>
                  <li><a href="../location/location.php">Location</a></li>
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
                                <div class="form-group">
                                  	<label class="control-label col-sm-2" for="title">Event Title:</label>
                                  	<div class="col-sm-8">          
                                    	<input id="title" name="title" class="form-control" type="text" maxlength="50" required placeholder="Enter a title for the event" />
                                  	</div>
                                </div>
                                <div class="form-group">
                                  	<label class="control-label col-sm-2" for="desc">Description:</label>
                                  	<div class="col-sm-8">          
                                    	<textarea id="desc" name="desc" class="form-control" maxlength="500" rows="4" placeholder="Write your post here..."></textarea>
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
                                  	<div class="col-sm-offset-2 col-sm-10">
                                    	<button type="submit" class="btn btn-primary">Post it</button>
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