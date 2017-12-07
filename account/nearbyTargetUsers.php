<?php

ob_start();
session_start();
//$err_msg = '';
//$employees_arr = array();

$nearByRegion=file_get_contents("php://input");

findRegion($nearByRegion);

function findRegion($nearByRegion) {
   
    $obj = json_decode($nearByRegion);
    
    $occupancy = $obj->{'occupancy'};
    $latitude = $obj->{'latitude'};
    $longitude = $obj->{'longitude'};
    
    
    $locationArray= array();;
    
    $lat= $latitude;
    $lng=$longitude;
    
    
    if($lat!=null && $lng!=null)
    {
        for ($x = 0; $x < $occupancy; $x++) {
            array_push($locationArray,array( $lat, $lng));
            $lat=$lat+(mt_rand(-100,100)/10000);
            $lng=$lng+(mt_rand(-100,100)/10000);
        } 
    }
    $someJSON = json_encode($locationArray);
    echo $someJSON; 
  
}

ob_end_flush();
?>