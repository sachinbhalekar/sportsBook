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
/*
$res=$conn->query("SELECT * FROM user_activity");

$count = 0;
while ($userActivity=$res->fetch_assoc())
{
    $count++;
    echo "<script type='text/javascript'>alert('$count');</script>";
}

$res=$conn->query("SELECT * FROM user_event");

$count = 0;
while ($userActivity=$res->fetch_assoc())
{
    $count++;
    echo "<script type='text/javascript'>alert('$count');</script>";
}
*/
?>
<!DOCTYPE html>
<html lang="en">
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
          				
          				<?php 
          				
          				$res=$conn->query("SELECT * FROM user_activity");

                        //$count = 0;
                        while ($userActivity=$res->fetch_assoc())
                        {
                            
                            $userActivityEmail = $userActivity['userEmail'];
                            $res1=$conn->query("SELECT CONCAT(userName,' ',userLastName) as name FROM users WHERE userEmail='$userActivityEmail'");
                            $userActivityRow=$res1->fetch_assoc();
                            $name = $userActivityRow['name'];
                            
                            $userActivityId = $userActivity['activityId'];
                            $res2=$conn->query("SELECT count(activityId) as actIdCount FROM user_interested_activity WHERE activityId = '$userActivityId'");
                            $userActivityInterest=$res2->fetch_assoc();
                            $activityInterestCount = $userActivityInterest['actIdCount'];
                            
                            //$activityId = $userActivity['activityId'];
                            //$count++;
                            //echo "<script type='text/javascript'>alert('$count');</script>";
                            ?>
                            <div class="well activity_post<?php echo $userActivityId; ?>">
                            	<p><strong><?php echo $name; ?></strong></p>
                                <p id="all_post_info" ><?php echo $userActivity['activityDesc']; ?></p>
                                <label>Sport:</label><span> <?php echo $userActivity['activitySport']; ?></span><br/>
                                <a href="activityInfo.php?activityId=<?php echo $userActivityId; ?>&activityUserName=<?php echo $name; ?>&activityInterestCount=<?php echo $activityInterestCount; ?>"><span class="glyphicon glyphicon-info-sign"></span> View this post</a>
                                <br/>
                                <a href="#" data-toggle="modal" data-target="#activityModal<?php echo $userActivityId; ?>">Interested <span id="activity_post_interested<?php echo $userActivityId; ?>" class="badge"><?php echo $activityInterestCount; ?></span></a>
                                <button type="button" class="btn btn-primary" onclick="addInterested('activity', '<?php echo $userActivityId; ?>')"><span class="glyphicon glyphicon-thumbs-up"></span>  I'm interested!</button>
              				</div>
              				
              				<div class="modal fade" id="activityModal<?php echo $userActivityId; ?>" role="dialog">
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
                                            $res3=$conn->query("SELECT CONCAT(userName,' ',userLastName) as name FROM users WHERE userEmail in (SELECT userEmail FROM user_interested_activity WHERE activityId = '$userActivityId')");
                                            while ($userActivityInterestedName=$res3->fetch_assoc())
                                            {
                                                ?>
                                                <p><strong><?php echo $userActivityInterestedName['name']; ?></strong></p>
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
                    
                    $count = 0;
                    while ($userEvent=$res->fetch_assoc())
                    {
                        
                        $userEventId = $userEvent['eventId'];
                        $res2=$conn->query("SELECT count(eventId) as eventIdCount FROM user_interested_event WHERE eventId = '$userEventId'");
                        $userEventInterest=$res2->fetch_assoc();
                        $eventInterestCount = $userEventInterest['eventIdCount'];
                        //$count++;
                        //echo "<script type='text/javascript'>alert('$count');</script>";
                        ?>
                        <div class="thumbnail event_post">
                        	<p><strong><?php echo $userEvent['eventTitle']; ?></strong></p>
                            <img id="events_img" src="../images/location_icon.png" alt="location" width="400" height="300">
                            <p><?php echo $userEvent['eventDate']; ?></p>
                            <a href="eventInfo.php?eventId=<?php echo $userEvent['eventId']; ?>&eventInterestCount=<?php echo $eventInterestCount; ?>"><span class="glyphicon glyphicon-info-sign"></span> Event Details</a>
                            <br/>
                            <a href="#" data-toggle="modal" data-target="#eventModal<?php echo $userEventId; ?>">Interested <span id="event_post_interested<?php echo $userEventId; ?>" class="badge"><?php echo $eventInterestCount; ?></span></a>
                            <button type="button" class="btn btn-primary" onclick="addInterested('event', '<?php echo $userEventId; ?>')"><span class="glyphicon glyphicon-thumbs-up"></span>  I'm interested!</button>
                        </div>
                        
                        <div class="modal fade" id="eventModal<?php echo $userEventId; ?>" role="dialog">
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
                                    $res3=$conn->query("SELECT CONCAT(userName,' ',userLastName) as name FROM users WHERE userEmail in (SELECT userEmail FROM user_interested_event WHERE eventId = '$userEventId')");
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
          			<?php
                    }
                    ?>
                    
 				</div>
			</div>
		</div>
		<footer class="container-fluid text-center">
			<p>&copy; SportsBook</p>
		</footer>
	</body>
</html>
<?php ob_end_flush(); ?>