<?php 
require_once '../connection/dbconnect.php';

function distance($lat1, $lon1, $lat2, $lon2, $unit) {
    
    $theta = $lon1 - $lon2;
    $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
    $dist = acos($dist);
    $dist = rad2deg($dist);
    $miles = $dist * 60 * 1.1515;
    $unit = strtoupper($unit);
    
    if ($unit == "K") {
        return ($miles * 1.609344);
    } else if ($unit == "N") {
        return ($miles * 0.8684);
    } else {
        return $miles;
    }
}



function fetchActivities($lat,$lng,$range)
{
    define('DBHOST', 'localhost');
    define('DBUSER', 'sportsbook');
    define('DBPASS', 'sportsbook');
    define('DBNAME', 'sportsbook');
    
    $conn = new mysqli(DBHOST,DBUSER,DBPASS,DBNAME);
    $range=0.85;
    $lngLowerRange=$lng-$range;
    $lngUpperRange=$lng+$range;
    $latLowerRange=$lat-$range;
    $latUpperRange=$lat+$range;
    
    $query = "SELECT * FROM activity WHERE lng between '$lngLowerRange' and '$lngUpperRange' and lat between '$latLowerRange' and '$latUpperRange'";
 
    $res=$conn->query($query);
    
    $count = $res->num_rows; // if uname/pass correct it returns must be 1 row
   // echo '<script type="text/javascript"> alert(\'Hi\'); </script>';
    if($count > 0 )
    {
        while( $row=$res->fetch_assoc())
        {
            
                //$errTyp = "success";
            $tempLat=$row['lat'];
            $tempLng=$row['lng'];
            $s="plot_markers('$tempLat','$tempLng');";
            echo $s;
             //   $_SESSION['user'] = $row['userEmail'];
                //header("Location: ./account/home.php");
            
        }
    }
    
}

function fetchTargetRegion()
{
    $Lat=array(37.782551);
    $Lng=array(-122.445368);
    
    $arrlength = count($Lat);
    
    for($x = 0; $x < $arrlength; $x++) {
        $tempLat=$Lat[$x];
        $tempLng=$Lng[$x];
    $s="new google.maps.LatLng('$tempLat','$tempLng'),";
    if($x == ($arrlength-1))
    {
        $s="new google.maps.LatLng('$tempLat','$tempLng')";
    }
    
    echo $s;
    }
    
}

?>
