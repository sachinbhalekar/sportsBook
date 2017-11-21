<?php
ob_start();
session_start();

include_once '../connection/dbconnect.php';

$error = false;

if ( isset($_POST['signup_form']) || isset($_POST['signup_btn']) ) 
{
    //echo "<script type='text/javascript'>alert('inside');</script>";
    // clean user inputs to prevent sql injections
    $name = trim($_POST['firstname']);
    $name = strip_tags($name);
    $name = htmlspecialchars($name);
    //echo "<script type='text/javascript'>alert('$name');</script>";
    
    $lastname = trim($_POST['lastname']);
    $lastname = strip_tags($lastname);
    $lastname = htmlspecialchars($lastname);
    //echo "<script type='text/javascript'>alert('$lastname');</script>";
    
    $userDOB = trim($_POST['dob']);
    $userDOB = strip_tags($userDOB);
    $userDOB = htmlspecialchars($userDOB);
    //echo "<script type='text/javascript'>alert('$userDOB');</script>";
    
    $gender = trim($_POST['gender']);
    $gender = strip_tags($gender);
    $gender = htmlspecialchars($gender);
    //echo "<script type='text/javascript'>alert('$gender');</script>";
    
    $email = trim($_POST['username']);
    $email = strip_tags($email);
    $email = htmlspecialchars($email);
    //echo "<script type='text/javascript'>alert('$email');</script>";
    
    $pass = trim($_POST['password']);
    $pass = strip_tags($pass);
    $pass = htmlspecialchars($pass);
    //echo "<script type='text/javascript'>alert('$pass');</script>";
    
    $address1 = trim($_POST['address1']);
    $address1 = strip_tags($address1);
    $address1 = htmlspecialchars($address1);
    //echo "<script type='text/javascript'>alert('$address1');</script>";
    
    $address2 = trim($_POST['address2']);
    $address2 = strip_tags($address2);
    $address2 = htmlspecialchars($address2);
    //echo "<script type='text/javascript'>alert('$address2');</script>";
    
    $city = trim($_POST['city']);
    $city = strip_tags($city);
    $city = htmlspecialchars($city);
    //echo "<script type='text/javascript'>alert('$city');</script>";
    
    $state = trim($_POST['state']);
    $state = strip_tags($state);
    $state = htmlspecialchars($state);
    //echo "<script type='text/javascript'>alert('$state');</script>";
    
    $country = trim('');
    $country = strip_tags($country);
    $country = htmlspecialchars($country);
    //echo "<script type='text/javascript'>alert('$country');</script>";
    
    $zipcode = trim($_POST['zipcode']);
    $zipcode = strip_tags($zipcode);
    $zipcode = htmlspecialchars($zipcode);
    //echo "<script type='text/javascript'>alert('$zipcode');</script>";
    
    $sports = trim($_POST['sports']);
    $sports = strip_tags($sports);
    $sports = htmlspecialchars($sports);
    //echo "<script type='text/javascript'>alert('$sports');</script>";
    
    $userbio = trim($_POST['bio']);
    $userbio = strip_tags($userbio);
    $userbio = htmlspecialchars($userbio);
    //echo "<script type='text/javascript'>alert('$userbio');</script>";
    
    $latitude = trim($_POST['latitude']);
    $latitude = strip_tags($latitude);
    $latitude = htmlspecialchars($latitude);
    //echo "<script type='text/javascript'>alert('$latitude');</script>";
    
    $longitude = trim($_POST['longitude']);
    $longitude = strip_tags($longitude);
    $longitude = htmlspecialchars($longitude);
    //echo "<script type='text/javascript'>alert('$longitude');</script>";
    
    //basic email validation
    if ( !filter_var($email,FILTER_VALIDATE_EMAIL) ) 
    {
        $error = true;
        $errTyp = "danger";
        $message = "Please enter valid email address.";
        echo "<script type='text/javascript'>alert('$message');</script>";
    } 
    else 
    {
        // check email exist or not
        $query = "SELECT userEmail FROM users WHERE userEmail='$email'";
        //echo "<script type='text/javascript'>alert('$query');</script>";
        $result = $conn->query($query);
        $count = $result->num_rows;
        //echo "<script type='text/javascript'>alert('$count');</script>";
        if($count==1)
        {
            $error = true;
            $errTyp = "danger";
            $message = "Email address already registered.";
            echo "<script type='text/javascript'>alert(conunt = '$message');</script>";
        }
    }
    
    //echo "<script type='text/javascript'>alert(Error : '$error');</script>";
    // if there's no error, continue to signup
    if( !$error ) 
    {
        //echo "<script type='text/javascript'>alert('inside last if...');</script>";
        // password encrypt using SHA256();
        $password = hash('sha256', $pass);
        //echo "<script type='text/javascript'>alert('$password');</script>";
        
        $query = "INSERT INTO users(userName,userEmail,userPass,userLastName,userGender,userDoB,userBio) VALUES('$name','$email','$password','$lastname','$gender','$userDOB','$userbio')";
        //echo "<script type='text/javascript'>alert(Query : '$query');</script>";
        $query1 = "INSERT INTO user_address(userEmail,address1,address2,city,state,country,zipcode,latitude,longitude) VALUES('$email','$address1','$address2','$city','$state','$country','$zipcode',$latitude,$longitude)";        
        //echo "<script type='text/javascript'>alert(Query1 : '$query1');</script>";
        
        if($conn->query($query) === TRUE && $conn->query($query1) === TRUE) 
        {
            $arrSports = explode("|", $sports);
            foreach ($arrSports as &$value)
            {
                if(!empty($value))
                {
                    //echo "<script type='text/javascript'>alert('$value');</script>";
                    $query2 = "INSERT INTO user_sports(userEmail,sports_activity) VALUES('$email','$value')";
                    if( $conn->query($query2) === FALSE )
                    {
                        $error = true;
                        $errTyp = "danger";
                        $message = "Something went wrong, try again later...";
                        break;
                    }
                }
            }
            if( !$error )
            {
                $errTyp = "success";
                $message = "Successfully registered, you may login now!";
                unset($name);
                unset($email);
                unset($pass);
            }
        } 
        else
        {
            $errTyp = "danger";
            $message = "Something went wrong, try again later...";
        }
        
        //Delete inserted records if any error occurs...
        if( $error )
        {
            $queryD2 = "DELETE FROM user_address WHERE userEmail='$email'";
            $conn->query($queryD2);
            $queryD3 = "DELETE FROM user_sports WHERE userEmail='$email'";            
            $conn->query($queryD3);
            $queryD1 = "DELETE FROM users WHERE userEmail='$email'";
            $conn->query($queryD1);          
        }
    }
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

    function setGender()
    {
        //alert('setGender');
    	if( document.getElementById('male').checked ) 
    	{
			//Male radio button is checked
    		document.getElementById('gender').value = 'M';
		}
		else if( document.getElementById('female').checked ) 
		{
			//Female radio button is checked
			document.getElementById('gender').value = 'F';
		}
		//alert(document.getElementById('gender').value);
    }

    function setSports()
    {
    	var vSports = '';
    	if(document.getElementById('football').checked) 
    	{
    		vSports = vSports + 'football|';
		}
		if(document.getElementById('tennis').checked) 
		{
			vSports = vSports + 'tennis|';
		}
		if(document.getElementById('cricket').checked) 
		{
			vSports = vSports + 'cricket|';
		}
    	document.getElementById('sports').value = vSports;
    	//alert(document.getElementById('sports').value);
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
		<title>SportsBook - Sign Up</title>
		<link rel="stylesheet" type="text/css" href="../css/signup.css">
		<link href="https://fonts.googleapis.com/css?family=Zilla+Slab+Highlight" rel="stylesheet">
	</head>
	<body>
		<header>
			<nav class="navbar navbar-inverse navbar-fixed-top">
              <div class="container-fluid">
                <div class="navbar-header">
                  <a class="navbar-brand" href="../index.php">SportsBook</a>
                </div>
                <ul class="nav navbar-nav">
                  <li><a href="#">About Us</a></li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                  <li><a href="#main_signup_section"><span class="glyphicon glyphicon-user"></span> Sign Up</a></li>
                  <li><a href="../index.php"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
                </ul>
              </div>
            </nav>
		</header>
    	<div class="container">
			<section id="main_intro_section">
				<h2>Join now and never play your favorite sports alone!</h2>
			</section>
			<hr>
			<section id="main_signup_section">
				<form id="signup_form" name="signup_form" method="post" action="<?php $_SERVER['PHP_SELF']; ?>">
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
					<table id="login_table">
						<tr>
							<td>First Name <span style="color:red">*</span></td>
							<td><input id="firstname" name="firstname" class="form-control" type="text" maxlength="50" required placeholder="Enter First Name" value="<?php echo $name ?>" /></td>
						</tr>
						<tr>
							<td>Last Name</td>
							<td><input id="lastname" name="lastname" class="form-control" type="text" maxlength="50" placeholder="Enter Last Name" /></td>
						</tr>
						<tr>
							<td>Date of Birth <span style="color:red">*</span></td>
							<td><input id="dob" name="dob" class="form-control datepicker" data-date-format="mm/dd/yyyy" type="date" required /></td>
						</tr>
						<tr>
							<td>Gender <span style="color:red">*</span></td>
							<td>
								<label class="radio-inline"><input id="male" name="genderR" type="radio" class="gender_radio" onclick="setGender()"/>Male</label>
								<label class="radio-inline"><input id="female" name="genderR" type="radio" class="gender_radio" onclick="setGender()"/>Female</label>	
								<input id="gender" name="gender" type="text" hidden="">
							</td>
						</tr>
						<tr>
							<td>E-mail <span style="color:red">*</span></td>
							<td><input id="username" name="username" class="form-control" type="text" maxlength="50" required pattern="[^@]+@[^@]+\.[a-zA-Z]{2,6}" placeholder="Set your username" value="<?php echo $email ?>" /></td>
						</tr>
						<tr>
							<td>Set Password <span style="color:red">*</span></td>
							<td><input id="password" name="password" class="form-control" type="password" required placeholder="Set your password" /></td>
						</tr>
						<tr>
							<td>Confirm Password <span style="color:red">*</span></td>
							<td><input id="password1" name="password1" class="form-control" type="password" required placeholder="Confirm your password" /></td>
						</tr>
						<tr>
							<td>Address Line 1 <span style="color:red">*</span></td>
							<td><input id="address1" name="address1" class="form-control" type="text" maxlength="50" onblur="getLatLong();" required placeholder="Enter Street Address" /><input id="latitude" name="latitude" type="number" step="any" hidden=""/></td>
						</tr>
						<tr>
							<td>Address Line 2</td>
							<td><input id="address2" name="address2" class="form-control" type="text" maxlength="50" onblur="getLatLong();" placeholder="Enter Apt/Unit"/></td>
						</tr>
						<tr>
							<td>City <span style="color:red">*</span></td>
							<td><input id="city" name="city" class="form-control" type="text" maxlength="50" onblur="getLatLong();" required placeholder="Enter City" /></td>
						</tr>
						<tr>
							<td>State <span style="color:red">*</span></td>
							<td><input id="state" name="state" class="form-control" type="text" maxlength="50" onblur="getLatLong();" required placeholder="Enter State" /></td>
						</tr>
						<tr>
							<td>ZipCode <span style="color:red">*</span></td>
							<td><input id="zipcode" name="zipcode" class="form-control" type="number" min="00001" max="99999" onblur="getLatLong();" required placeholder="Enter ZipCode" /><input id="longitude" name="longitude" type="number" step="any" hidden=""/></td>
						</tr>
						<tr>
							<td>Sports Interested <span style="color:red">*</span></td>
							<td>
								<div class="checkbox">
									<label><input id="football" name="football" class="checkbox" type="checkbox" onclick="setSports()"/>Football</label>
								</div>
								<div class="checkbox">
									<label><input id="tennis" name="tennis" class="checkbox" type="checkbox" onclick="setSports()"/>Tennis</label>
								</div>
								<div class="checkbox">
									<label><input id="cricket" name="cricket" class="checkbox" type="checkbox" onclick="setSports()"/>Cricket</label>
								</div>
								<input id="sports" name="sports" type="text" hidden=""/>
							</td>
						</tr>
						<tr>
							<td>Bio</td>
							<td><textarea id="bio" name="bio" class="form-control" maxlength="500" rows="4" placeholder="Write somthing about you to let the people know."></textarea></td>
						</tr>
						<tr>
							<td colspan="2" class="td_center"><input id="signup_btn" name="signup_btn" class="btn btn-primary" type="submit" value="Create Account"/></td>
						</tr>
					</table>
				</form>
			</section>
		</div>
		<footer>
			<p>&copy; SportsBook</p>
		</footer>
	</body>
</html>
<?php ob_end_flush(); ?>