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
	</head>
	<body>
		<header>
			<nav class="navbar navbar-inverse navbar-fixed-top">
              <div class="container-fluid">
                <div class="navbar-header">
                  <a class="navbar-brand" href="../index.php"><i><strong>SportsBook</strong></i></a>
                </div>
                <ul class="nav navbar-nav">
                  <li class="active"><a href="home.php">Home</a></li>
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
        		<div class="col-sm-8 text-left"> 
        			<h1>Nearby Activities</h1>
        			<hr>
        			<div class="col-sm-11">
          				<div class="well activity_post">
          					<p id="all_post_info" >Come lets play!!</p>
          					<a href="#">Interested <span class="badge">5</span></a><br/><br/>
          					  <li><a href="../location/targetRegions.php">View Location</a></li>
          					<button type="button" class="btn btn-primary"><span class="glyphicon glyphicon-thumbs-up"></span>  I'm interested!</button>
          				</div>
          				
          				<div class="well activity_post">
          					<p id="all_post_info" >Come lets play!!</p>
          					<a href="#">Interested <span class="badge">5</span></a><br/><br/>
          						  <li><a href="../location/location.php">View Location</a></li>
          					<button type="button" class="btn btn-primary"><span class="glyphicon glyphicon-thumbs-up"></span>  I'm interested!</button>
          				</div>
          				<div class="well activity_post">
          					<p id="all_post_info" >Come lets play!!</p>
          					<a href="#">Interested <span class="badge">5</span></a><br/><br/>
          						  <li><a href="../location/location.php">View Location</a></li>
          					<button type="button" class="btn btn-primary"><span class="glyphicon glyphicon-thumbs-up"></span>  I'm interested!</button>
          				</div>
          				<div class="well activity_post">
          					<p id="all_post_info" >Come lets play!!</p>
          					<a href="#">Interested <span class="badge">5</span></a><br/><br/>
          						  <li><a href="../location/location.php">View Location</a></li>
          					<button type="button" class="btn btn-primary"><span class="glyphicon glyphicon-thumbs-up"></span>  I'm interested!</button>
          				</div>
          				<div class="well activity_post">
          					<p id="all_post_info" >Come lets play!!</p>
          					<a href="#">Interested <span class="badge">5</span></a><br/><br/>
          						  <li><a href="../location/location.php">View Location</a></li>
          					<button type="button" class="btn btn-primary"><span class="glyphicon glyphicon-thumbs-up"></span>  I'm interested!</button>
          				</div>
          				<div class="well activity_post">
          					<p id="all_post_info" >Come lets play!!</p>
          					<a href="#">Interested <span class="badge">5</span></a><br/><br/>
          						  <li><a href="../location/location.php">View Location</a></li>
          					<button type="button" class="btn btn-primary"><span class="glyphicon glyphicon-thumbs-up"></span>  I'm interested!</button>
          				</div>
          				
          			</div>
        		</div>
 				
 				<div class="col-sm-4 sidenav text-center">
 					<h1>Events</h1>
 					<hr>
 					<div class="thumbnail event_post">
                    	<p><strong>Event 100:</strong></p>
                        <img id="events_img" src="../images/location_icon.png" alt="location" width="400" height="300">
                        <p>Fri. 27 November 2015</p>
                        <button class="btn btn-info"><span class="glyphicon glyphicon-info-sign"></span> Info</button>
                    </div>
                    
                    <div class="thumbnail event_post">
                    	<p><strong>Event 101:</strong></p>
                        <img id="events_img" src="../images/location_icon.png" alt="location" width="400" height="300">
                        <p>Fri. 27 November 2015</p>
                        <button class="btn btn-info"><span class="glyphicon glyphicon-info-sign"></span> Info</button>
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