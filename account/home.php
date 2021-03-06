<?php
ob_start();
session_start();
require_once '../connection/dbconnect.php';

// if session is not set this will redirect to login page
if( !isset($_SESSION['user']) )
{
    header("Location: ../index.php?logout");
    exit;
}
$userEmail = $_SESSION['user'];//get user from session

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
          				
          				<?php 
          				
          				$res=$conn->query("SELECT * FROM user_activity");

                        //displaying all activities dynamically from the database
                        while ($activityRow=$res->fetch_assoc())
                        {
                            
                            $activityUserEmail = $activityRow['userEmail'];
                            $res1=$conn->query("SELECT CONCAT(userName,' ',userLastName) as name FROM users WHERE userEmail='$activityUserEmail'");
                            $userRow=$res1->fetch_assoc();
                            $activityUserName = $userRow['name'];
                            
                            $activityId = $activityRow['activityId'];
                            $res2=$conn->query("SELECT count(activityId) as actIdCount FROM user_interested_activity WHERE activityId = '$activityId'");
                            $activityInterestRow=$res2->fetch_assoc();
                            $activityInterestCount = $activityInterestRow['actIdCount'];
                            
                            //echo "<script type='text/javascript'>alert('$count');</script>";
                            ?>
                            <div class="well activity_post<?php echo $activityId; ?>">
                            	<p><strong><?php echo $activityUserName; ?></strong></p>
                                <p id="all_post_info" ><?php echo $activityRow['activityDesc']; ?></p>
                                <label>Sport:</label><span> <?php echo $activityRow['activitySport']; ?></span><br/>
                                <a href="activityInfo.php?activityId=<?php echo $activityId; ?>&activityUserName=<?php echo $activityUserName; ?>"><span class="glyphicon glyphicon-info-sign"></span> View this post</a>
                                <br/>
                                <a href="#" data-toggle="modal" data-target="#activityModal<?php echo $activityId; ?>">Interested <span id="activity_post_interested<?php echo $activityId; ?>" class="badge"><?php echo $activityInterestCount; ?></span></a>
                                <button type="button" class="btn btn-primary" onclick="addInterested('activity', '<?php echo $activityId; ?>', '<?php echo $userEmail; ?>')"><span class="glyphicon glyphicon-thumbs-up"></span>  I'm interested!</button>
              				</div>
              				
              				<div class="modal fade" id="activityModal<?php echo $activityId; ?>" role="dialog">
                                <div class="modal-dialog modal-sm">
                                  <div class="modal-content">
                                    <div class="modal-header">
                                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                                      <h4 class="modal-title">People Interested</h4>
                                        </div>
                                        <div class="modal-body">
                                        <?php 
                                        if($activityInterestCount >= 1)
                                        {
                                            $res3=$conn->query("SELECT CONCAT(userName,' ',userLastName) as name FROM users WHERE userEmail in (SELECT userEmail FROM user_interested_activity WHERE activityId = '$activityId')");
                                            while ($activityInterestedRow=$res3->fetch_assoc())
                                            {
                                                ?>
                                                <p><strong><?php echo $activityInterestedRow['name']; ?></strong></p>
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
              			<?php
                        }
                        ?>
          				
          			</div>
        		</div>
 				
 				<div class="col-sm-4 sidenav text-center">
 					<h1>Events</h1>
 					<hr>
 					
                    <?php 
          				
                    $res=$conn->query("SELECT * FROM user_event");
                    
                    //displaying all events dynamically from the database
                    while ($eventRow=$res->fetch_assoc())
                    {
                        
                        $eventId = $eventRow['eventId'];
                        $res2=$conn->query("SELECT count(eventId) as eventIdCount FROM user_interested_event WHERE eventId = '$eventId'");
                        $eventInterestRow=$res2->fetch_assoc();
                        $eventInterestCount = $eventInterestRow['eventIdCount'];

                        //echo "<script type='text/javascript'>alert('$count');</script>";
                        ?>
                        <div class="thumbnail event_post">
                        	<p><strong><?php echo $eventRow['eventTitle']; ?></strong></p>
                            <!-- <img id="events_img" src="../images/location_icon.png" alt="location" width="400" height="300"> -->
                            <p><?php echo $eventRow['eventDesc']; ?></p>
                            <p><?php echo $eventRow['eventDate']; ?></p>
                            <a href="eventInfo.php?eventId=<?php echo $eventRow['eventId']; ?>"><span class="glyphicon glyphicon-info-sign"></span> Event Details</a>
                            <br/>
                            <a href="#" data-toggle="modal" data-target="#eventModal<?php echo $eventId; ?>">Interested <span id="event_post_interested<?php echo $eventId; ?>" class="badge"><?php echo $eventInterestCount; ?></span></a>
                            <button type="button" class="btn btn-primary" onclick="addInterested('event', '<?php echo $eventId; ?>', '<?php echo $userEmail; ?>')"><span class="glyphicon glyphicon-thumbs-up"></span>  I'm interested!</button>
                        </div>
                        
                        <div class="modal fade" id="eventModal<?php echo $eventId; ?>" role="dialog">
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
                                    while ($eventInterestedRow=$res3->fetch_assoc())
                                    {
                                        ?>
                                        <p><strong><?php echo $eventInterestedRow['name']; ?></strong></p>
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
          			<?php
                    }
                    ?>
                    
 				</div>
			</div>
		</div>
		<footer class="container-fluid text-center">
			<p>&copy; SportsBook</p>
		</footer>
		<script src="../scripts/addInterest.js"></script>
	</body>
</html>
<?php ob_end_flush(); ?>