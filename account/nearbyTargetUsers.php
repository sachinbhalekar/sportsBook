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
     
    $locationArray= array();;
    $lat=37.782551;
    $lng=-122.445368;
    
 
   
    for ($x = 0; $x < $occupancy; $x++) {
        array_push($locationArray,array( $lat, $lng));
        $lat=$lat+0.000010;
        $lng=$lng+0.000010;
 } 
 $someJSON = json_encode($locationArray);
 echo $someJSON; 
 
    
    
}

?>


<?php ob_end_flush(); ?>