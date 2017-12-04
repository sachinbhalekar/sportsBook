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

if (isset($_GET['eventId']))
{
    //echo "<script type='text/javascript'>alert('Found');</script>";
    $eventId = trim($_GET['eventId']);
    $eventId = strip_tags($eventId);
    $eventId = htmlspecialchars($eventId);
    
    $eventInterestCount = trim($_GET['eventInterestCount']);
    $eventInterestCount = strip_tags($eventInterestCount);
    $eventInterestCount = htmlspecialchars($eventInterestCount);
    //echo "<script type='text/javascript'>alert('$eventId');</script>";
    $res=$conn->query("SELECT * FROM user_event WHERE eventId='$eventId'");
    $userEvent=$res->fetch_assoc();
    
    $userEventEmail = $userEvent['userEmail'];
    $res=$conn->query("SELECT CONCAT(userName,' ',userLastName) as name FROM users WHERE userEmail='$userEventEmail'");
    $userEventRow=$res->fetch_assoc();
    $name = $userEventRow['name'];
    //echo "<script type='text/javascript'>alert('$name');</script>";
    
    $res=$conn->query("SELECT * FROM event_address WHERE eventId='$eventId'");
    $userEventAddress=$res->fetch_assoc();
    
    $address1 = $userEventAddress['address1'];
    $address2 = $userEventAddress['address2'];
    $city = $userEventAddress['city'];
    $state = $userEventAddress['state'];
    $zipcode = $userEventAddress['zipcode'];
    $country = $userEventAddress['country'];
    
    $location = '';
    $location = $address1 . ', ' . $address2 . ', ' . $address1 . ', ' . $city . ', ' . $state . ' - ' . $zipcode . ', ' . $country;
    
}

?>
<!DOCTYPE html>
<html lang="en">
	<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBPSaH_Tq4dlXK_blEM9eD7YuTXPkFQw80&callback=initMap" async defer></script>
	<script>
    	var xmlhttp;
    	var vSelectedPost;
    	var vSelectedPostId;
    	
    	function respond() 
    	{
    		if (xmlhttp.readyState == 4 && xmlhttp.status == 200) 
    		{
    			if(xmlhttp.responseText === 'success')
    			{
    				var vInterested;
    				if(vSelectedPost === 'activity')
    				{
        				vInterested = parseInt(document.getElementById('activity_post_interested'+vSelectedPostId).innerHTML) + 1;
    					document.getElementById('activity_post_interested'+vSelectedPostId).innerHTML = vInterested;
    				}
    				else if(vSelectedPost === 'event')
    				{
        				vInterested = parseInt(document.getElementById('event_post_interested'+vSelectedPostId).innerHTML) + 1;
    					document.getElementById('event_post_interested'+vSelectedPostId).innerHTML = vInterested;
    				}
    			}
    		}
    	}
    	
    	function addInterested( vPost, vPostId )
    	{
    		vSelectedPost = vPost;
    		vSelectedPostId = vPostId;
    		
    		var vObj = {
    				userEmail: '<?php echo $userEmail; ?>',
    				postId: vPostId,
    			 	post: vPost
    			};
    		
    		var vJSONObj = JSON.stringify(vObj);
    		//console.log(vJSONObj);
    		
    		if (window.XMLHttpRequest) 
    		{
    			xmlhttp = new XMLHttpRequest();
    		}
    		else 
    		{
    			xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    		}
    		
    		xmlhttp.onreadystatechange = respond;
    		xmlhttp.open("POST", "addInterested.php", true);
    		xmlhttp.send(vJSONObj);
    	  
    		return false;
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
        			<h1>Event Info</h1>
        			<hr>
        			<div class="panel panel-default text-left">
                        <div class="panel-body">
                        	<form id="event_form" name="event_form" class="form-horizontal event_form" method="post" action="<?php $_SERVER['PHP_SELF']; ?>">
                                <div class="form-group">
                                  	<label class="control-label col-sm-2" >Posted By:</label>
                                  	<div class="col-sm-8">          
                                    	<p class="form-control" ><?php echo $name; ?></p>
                                  	</div>
                                </div>
                                <div class="form-group">
                                  	<label class="control-label col-sm-2" for="title">Event Title:</label>
                                  	<div class="col-sm-8">          
                                    	<p class="form-control"><?php echo $userEvent['eventDesc']; ?></p>
                                  	</div>
                                </div>
                                <div class="form-group">
                                  	<label class="control-label col-sm-2" for="desc">Description:</label>
                                  	<div class="col-sm-8">          
                                    	<p class="form-control"><?php echo $userEvent['eventDesc']; ?></p>
                                  	</div>
                                </div>
                                <div class="form-group">
                                  	<label class="control-label col-sm-2">Sport Category:</label>
                                  	<div class="col-sm-10">
                                    	<label class="radio-inline"><input id="football" name="sportR" type="radio" />Football</label>
										<label class="radio-inline"><input id="tennis" name="sportR" type="radio" />Tennis</label>
										<label class="radio-inline"><input id="cricket" name="sportR" type="radio" />Cricket</label>
										<script type="text/javascript">
											var sport = '<?php echo $userEvent['eventSport']; ?>';
											//alert(sport);
											if( sport == 'football')
												document.getElementById('football').checked=true;
											else if( sport == 'tennis')
												document.getElementById('tennis').checked=true;
											else if( sport == 'cricket')
												document.getElementById('cricket').checked=true;
										</script>
                                  	</div>
                                </div>
                                <div class="form-group">
                                  	<label class="control-label col-sm-2" >Location:</label>
                                  	<div class="col-sm-8">          
                                    	<p class="form-control"><?php echo $location; ?></p>
                                    	
                                    	<div class="panel panel-default">
                                            <!-- <div class="panel-heading">Panel Heading</div> -->
                                            <div class="panel-body" id="map"></div>
                                        </div>
                                  	</div>
                                </div>
                                <div class="form-group">
                                  	<label class="control-label col-sm-2" for="landmark">Landmark:</label>
                                  	<div class="col-sm-8">          
                                    	<p class="form-control"><?php echo $userEventAddress['landmark']; ?></p>
                                  	</div>
                                </div>
                                <div class="form-group">
                                  	<label class="control-label col-sm-2" for="date">Date:</label>
                                  	<div class="col-sm-2">          
                                    	<p class="form-control"><?php echo $userEvent['eventDate']; ?></p>
                                  	</div>
                                  	
                                  	<label class="control-label col-sm-2" for="occupancy">Max Occupancy:</label>
                                  	<div class="col-sm-2">          
                                    	<p class="form-control"><?php echo $userEvent['eventOccupancy']; ?></p>
                                  	</div>
                                </div>
                                <div class="form-group">
                                  	<label class="control-label col-sm-2" for="time_in">Time In:</label>
                                  	<div class="col-sm-2">          
                                    	<p class="form-control"><?php echo $userEvent['eventInTime']; ?></p>
                                  	</div>
                                  	
                                  	<label class="control-label col-sm-2" for="time_out">Time Out:</label>
                                  	<div class="col-sm-2">          
                                    	<p class="form-control"><?php echo $userEvent['eventOutTime']; ?></p>
                                  	</div>
                                </div>
                                <div class="form-group">        
                                  	<div class="col-sm-offset-2 col-sm-10">
                                  		<a href="#" data-toggle="modal" data-target="#eventModal">Interested <span id="event_post_interested<?php echo $eventId; ?>" class="badge"><?php echo $eventInterestCount; ?></span></a>
                                    	<button type="button" class="btn btn-primary" onclick="addInterested('event', '<?php echo $eventId; ?>')"><span class="glyphicon glyphicon-thumbs-up"></span>  I'm interested!</button>
                                  	</div>
                                </div> 
                                
                                <div class="modal fade" id="eventModal" role="dialog">
                                    <div class="modal-dialog modal-sm">
                                      <div class="modal-content">
                                        <div class="modal-header">
                                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                                          <h4 class="modal-title">People Interested</h4>
                                        </div>
                                        <div class="modal-body">
                                        <?php 
                                        if($eventInterestCount >= 1)
                                        {
                                            $res3=$conn->query("SELECT CONCAT(userName,' ',userLastName) as name FROM users WHERE userEmail in (SELECT userEmail FROM user_interested_event WHERE eventId = '$eventId')");
                                            while ($userEventInterestedName=$res3->fetch_assoc())
                                            {
                                                ?>
                                                <p><strong><?php echo $userEventInterestedName['name']; ?></strong></p>
                                                <?php
                                            }
                                        }
                                        else 
                                        {
                                            ?>
                                            <p>No one interested yet.</p>
                                            <?php
                                        }
                                        ?>
                                          
                                        </div>
                                        <div class="modal-footer">
                                          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                        </div>
                                      </div>
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
            	               
    	        var lat = "<?php echo $userEventAddress['latitude']; ?>";
        		var lng = "<?php echo $userEventAddress['longitude']; ?>";
				//alert(lat);
				//alert(lng);
        		plot_markers( lat, lng );
        		//plot_markers(sampleLat[3],sampleLng[3]);
            	
            }
             
            function plot_markers( arrLat, arrLng ) 
            {              	
            	var geocoder = new google.maps.Geocoder;
                var infowindow = new google.maps.InfoWindow;
                var latlng = {lat: parseFloat(arrLat), lng: parseFloat(arrLng)};
                
                geocoder.geocode({'location': latlng}, function(results, status) {
                    if (status === 'OK') {
                      if (results[0]) {
                        map.setZoom(11);
                        var marker = new google.maps.Marker({
                          position: latlng,
                          map: map
                        });
                        infowindow.setContent(results[0].formatted_address);
                        infowindow.open(map, marker);
                      } else {
                        window.alert('No results found');
                      }
                    } else {
                      window.alert('Geocoder failed due to: ' + status);
                    }
                  });
             }     
    	
        </script>
    	 
        <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBPSaH_Tq4dlXK_blEM9eD7YuTXPkFQw80&callback=initMap"></script>
        
		<footer class="container-fluid text-center">
			<p>&copy; SportsBook</p>
		</footer>
	</body>
</html>
<?php ob_end_flush(); ?>