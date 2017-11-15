<?php
ob_start();
session_start();
if( isset($_SESSION['user'])!="" )
{
    //header("Location: home.php");
}
include_once '../connection/dbconnect.php';

$error = false;

/*
echo "<script type='text/javascript'>alert('before...');</script>";

$form = $_POST['signup_form'];
echo "<script type='text/javascript'>alert('$form');</script>";

$butt = $_POST['signup_btn'];
echo "<script type='text/javascript'>alert('$butt');</script>";
//echo "<script type='text/javascript'>alert('before...');</script>";
*/

if ( isset($_POST['signup_form']) || isset($_POST['signup_btn']) ) 
{
    echo "<script type='text/javascript'>alert('inside');</script>";
    // clean user inputs to prevent sql injections
    $name = trim($_POST['firstname']);
    $name = strip_tags($name);
    $name = htmlspecialchars($name);
    //echo "<script type='text/javascript'>alert('$name');</script>";
    
    $email = trim($_POST['username']);
    $email = strip_tags($email);
    $email = htmlspecialchars($email);
    //echo "<script type='text/javascript'>alert('$email');</script>";
    
    $pass = trim($_POST['password']);
    $pass = strip_tags($pass);
    $pass = htmlspecialchars($pass);
    //echo "<script type='text/javascript'>alert('$pass');</script>";
    
    
    $sports = trim($_POST['sports']);
    $sports = strip_tags($sports);
    $sports = htmlspecialchars($sports);
    echo "<script type='text/javascript'>alert('$sports');</script>";
    
    $gender = trim($_POST['gender']);
    $gender = strip_tags($gender);
    $gender = htmlspecialchars($gender);
    echo "<script type='text/javascript'>alert('$gender');</script>";
    
    
    // basic name validation
    /*
    if (empty($name)) 
    {
        $error = true;
        $nameError = "Please enter your full name.";
    } 
    else if (strlen($name) < 3) 
    {
        $error = true;
        $nameError = "Name must have atleat 3 characters.";
    } 
    else if (!preg_match("/^[a-zA-Z ]+$/",$name)) 
    {
        $error = true;
        $nameError = "Name must contain alphabets and space.";
    }
    */
    
    //basic email validation
    /*
    if ( !filter_var($email,FILTER_VALIDATE_EMAIL) ) 
    {
        $error = true;
        $emailError = "Please enter valid email address.";
    } 
    else 
    {
        // check email exist or not
        $query = "SELECT userEmail FROM users WHERE userEmail='$email'";
        $result = $conn->query($query);
        
    }
    */
    
    // password validation
    /*
    if (empty($pass))
    {
        $error = true;
        $passError = "Please enter password.";
    } 
    else if(strlen($pass) < 6) 
    {
        $error = true;
        $passError = "Password must have atleast 6 characters.";
    }
    */
    
    // if there's no error, continue to signup
    if( !$error ) 
    {
        // password encrypt using SHA256();
        $password = hash('sha256', $pass);
        
        $query = "INSERT INTO users(userName,userEmail,userPass) VALUES('$name','$email','$password')";
        if ($conn->query($query) === TRUE) 
        {
            $errTyp = "success";
            $message = "Successfully registered, you may login now!";
            unset($name);
            unset($email);
            unset($pass);
        } 
        else 
        {
            $errTyp = "danger";
            $message = "Something went wrong, try again later...";
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
        var vLat = '';
        var vLong = '';
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
              if (status == 'OK') {
        	  //alert(results[0].geometry.location);
               
              } 
            });

            document.getElementById('latitude').value = vLat;
        	document.getElementById('longitude').value = vLong;
    	}
    	//alert('before submit');
    	//document.getElementById('signup_form').submit();
    }

    function setGender()
    {
        //alert('setGender');
    	if(document.getElementById('male').checked) 
    	{
			//Male radio button is checked
    		document.getElementById('gender').value = 'M';
		}
		else if(document.getElementById('female').checked) 
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
		<header id="body_header">
			<section id="header_title">
				<h1><a href="../index.php" class="a_header">SportsBook</a></h1>
			</section>
			<section id="header_nav_section">
				<ul>
					<li class="header_nav_list_item"><a href="../index.php" class="header_nav_list_item_a">Login</a></li>
					<li class="header_nav_list_item"><a href="#main_signup_section" class="header_nav_list_item_a">Sign Up</a></li>
					<li class="header_nav_list_item"><a href="_blnak" target="_blank" class="header_nav_list_item_a">About Us</a></li>
				</ul>
			</section>
		</header>
		<section id="body_main">
			<section id="main_intro_section">
				<h2>Join now and never play your favorite sports alone!</h2>
			</section>
			<hr>
			<section id="main_signup_section">
				<!-- <form id="signup_form" name="signup_form" method="post" action="<?php //echo htmlspecialchars($_SERVER['PHP_SELF']);?>">  -->
				<form id="signup_form" name="signup_form" method="post" action="<?php $_SERVER['PHP_SELF']; ?>">
					<?php
                    if ( isset($message) ) 
                    {
                    ?>
                    	<div class="form-group">
                        	<div class="alert alert-<?php echo ($errTyp=="success") ? "success" : $errTyp; ?>">
                    			<span class="glyphicon glyphicon-info-sign"></span> <?php echo $message; ?>
                    			<span class="glyphicon glyphicon-info-sign"></span> <?php echo $query; ?>
                        	</div>
                        </div>
                    <?php
                    }
                    ?>
					<table id="login_table">
						<tr>
							<td>First Name <span style="color:red">*</span></td>
							<td><input id="firstname" name="firstname" type="text" maxlength="50" required value="<?php echo $name ?>" /></td>
						</tr>
						<tr>
							<td>Last Name</td>
							<td><input id="lastname" name="lastname" type="text" maxlength="50" /></td>
						</tr>
						<tr>
							<td>Date of Birth <span style="color:red">*</span></td>
							<td><input id="dob" name="dob" type="date" required /></td>
						</tr>
						<tr>
							<td colspan="2">
								<p>Gender <span style="color:red">*</span></p>
								<ul>
									<li class="list_item_regular"><input id="male" name="genderR" type="radio" class="gender_radio" onclick="setGender()"/><label for="male">&nbsp;Male</label></li>
									<li class="list_item_regular"><input id="female" name="genderR" type="radio" class="gender_radio" onclick="setGender()"/><label for="female">&nbsp;Female</label></li>
								</ul>
								<input id="gender" name="gender" type="text" hidden="">
							</td>
						</tr>
						<tr>
							<td>E-mail <span style="color:red">*</span></td>
							<td><input id="username" name="username" type="text" maxlength="50" required pattern="[^@]+@[^@]+\.[a-zA-Z]{2,6}" placeholder="Set your username" value="<?php echo $email ?>" /></td>
						</tr>
						<tr>
							<td>Set Password <span style="color:red">*</span></td>
							<td><input id="password" name="password" type="password" required placeholder="Set your password" /></td>
						</tr>
						<tr>
							<td>Confirm Password <span style="color:red">*</span></td>
							<td><input id="password1" name="password1" type="password" required placeholder="Confirm your password" /></td>
						</tr>
						<tr>
							<td>Address Line 1 <span style="color:red">*</span></td>
							<td><input id="address1" name="address1" type="text" maxlength="50" onblur="getLatLong();" required placeholder="Street Address" /><input id="latitude" name="latitude" type="text" hidden=""/></td>
						</tr>
						<tr>
							<td>Address Line 2</td>
							<td><input id="address2" name="address2" type="text" maxlength="50" onblur="getLatLong();" placeholder="Apt/Unit"/></td>
						</tr>
						<tr>
							<td>City <span style="color:red">*</span></td>
							<td><input id="city" name="city" type="text" maxlength="50" onblur="getLatLong();" required placeholder="" /></td>
						</tr>
						<tr>
							<td>State <span style="color:red">*</span></td>
							<td><input id="state" name="state" type="text" maxlength="50" onblur="getLatLong();" required placeholder="" /></td>
						</tr>
						<tr>
							<td>ZipCode <span style="color:red">*</span></td>
							<td><input id="zipcode" name="zipcode" type="number" min="00001" max="99999" onblur="getLatLong();" required placeholder="" /><input id="longitude" name="longitude" type="text" hidden=""/></td>
						</tr>
						<tr>
							<td colspan="2">
								<p>Sports Interested <span style="color:red">*</span></p>
								<ul>
									<li class="list_item_regular"><input id="football" name="football" type="checkbox" class="sports_checkbox" onclick="setSports()"/><label for="football">&nbsp;Football</label></li>
									<li class="list_item_regular"><input id="tennis" name="tennis" type="checkbox" class="sports_checkbox" onclick="setSports()"/><label for="tennis">&nbsp;Tennis</label></li>
									<li class="list_item_regular"><input id="cricket" name="cricket" type="checkbox" class="sports_checkbox" onclick="setSports()"/><label for="cricket">&nbsp;Cricket</label></li>
								</ul>
								<input id="sports" name="sports" type="text" hidden=""/>
							</td>
						</tr>
						<tr>
							<td>Bio</td>
							<td><textarea id="bio" name="bio" maxlength="500" rows="3" placeholder="Write somthing about you to let the people know."></textarea></td>
						</tr>
						<tr>
							<td colspan="2" class="td_center"><input id="signup_btn" name="signup_btn" class="input_regular" type="submit" value="Create Account"/></td>
						</tr>
					</table>
				</form>
			</section>
		</section>
		<footer>
			<p>&copy; SportsBook</p>
		</footer>
	</body>
</html>
<?php ob_end_flush(); ?>