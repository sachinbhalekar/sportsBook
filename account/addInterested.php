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
//$userEmail = $_SESSION['user'];

$json_emp = file_get_contents('php://input');
//echo $json_emp;
$obj = json_decode($json_emp); // parse JSON to object

$userEmail = $obj->{'userEmail'};
$postId = $obj->{'postId'};
$post = $obj->{'post'};

if( $post === 'activity' )
{
    $res = $conn->query(" SELECT count(activityId) FROM user_interested_activity where activityId = '$postId' and userEmail = '$userEmail' ");
    $userActivity = $res->fetch_assoc();
    $count = $userActivity['count(activityId)'];
    
    if($count == 0)
    {
        $query = " INSERT INTO user_interested_activity(userEmail,activityId) VALUES('$userEmail','$postId') ";
                
        if($conn->query($query) === TRUE)
        {
            echo "success";
        }
        else
        {
            echo "failed";
        }
    }
}
else if( $post === 'event' )
{
    $res = $conn->query(" SELECT count(eventId) FROM user_interested_event where eventId = '$postId' and userEmail = '$userEmail' ");
    $userActivity = $res->fetch_assoc();
    $count = $userActivity['count(eventId)'];
    
    if($count == 0)
    {
        $query = " INSERT INTO user_interested_event(userEmail,eventId) VALUES('$userEmail','$postId') ";
        
        if($conn->query($query) === TRUE)
        {
            echo "success";
        }
        else
        {
            echo "failed";
        }
    }
}

ob_end_flush();
?>