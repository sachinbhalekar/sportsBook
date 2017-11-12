<?php
ob_start();
session_start();
if( isset($_SESSION['user'])!="" )
{
    header("Location: home.php");
}
include_once 'dbconnect.php';

$error = false;

if ( isset($_POST['signup_btn']) ) 
{
    // clean user inputs to prevent sql injections
    $name = trim($_POST['firstname']);
    $name = strip_tags($name);
    $name = htmlspecialchars($name);
    
    $email = trim($_POST['username']);
    $email = strip_tags($email);
    $email = htmlspecialchars($email);
    
    $pass = trim($_POST['password']);
    $pass = strip_tags($pass);
    $pass = htmlspecialchars($pass);
    
    // basic name validation
    if (empty($name)) {
        $error = true;
        $nameError = "Please enter your full name.";
    } else if (strlen($name) < 3) {
        $error = true;
        $nameError = "Name must have atleat 3 characters.";
    } else if (!preg_match("/^[a-zA-Z ]+$/",$name)) {
        $error = true;
        $nameError = "Name must contain alphabets and space.";
    }
    
    //basic email validation
    if ( !filter_var($email,FILTER_VALIDATE_EMAIL) ) {
        $error = true;
        $emailError = "Please enter valid email address.";
    } else {
        // check email exist or not
        $query = "SELECT userEmail FROM users WHERE userEmail='$email'";
        $result = $conn->query($query);
        
        /* $count = mysql_num_rows($result);
         if($count!=0){
         $error = true;
         $emailError = "Provided Email is already in use.";
         } */
    }
    // password validation
    if (empty($pass)){
        $error = true;
        $passError = "Please enter password.";
    } else if(strlen($pass) < 6) {
        $error = true;
        $passError = "Password must have atleast 6 characters.";
    }
    
    // password encrypt using SHA256();
    $password = hash('sha256', $pass);
    
    // if there's no error, continue to signup
    if( !$error ) {
        
        $query = "INSERT INTO users(userName,userEmail,userPass) VALUES('$name','$email','$password')";
        
        if ($conn->query($query) === TRUE) {
            $errTyp = "success";
            $errMSG = "Successfully registered, you may login now";
            unset($name);
            unset($email);
            unset($pass);
        } else {
            $errTyp = "danger";
            $errMSG = "Something went wrong, try again later...";
        }
        
    }
    
    
}
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
		<title>SportsBook</title>
		<link rel="stylesheet" type="text/css" href="../css/signup.css">
		<link href="https://fonts.googleapis.com/css?family=Zilla+Slab+Highlight" rel="stylesheet">
	</head>
	<body>
		<header id="body_header">
			<section id="header_title">
				<h1><a href="../index.html" class="a_header">SportsBook</a></h1>
			</section>
			<section id="header_nav_section">
				<ul>
					<li class="header_nav_list_item"><a href="../index.html" class="header_nav_list_item_a">Login</a></li>
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
				<form id="signup_form" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
					<?php
                    if ( isset($errMSG) ) 
                    {
                    ?>
                    <div class="form-group">
                             <div class="alert alert-<?php echo ($errTyp=="success") ? "success" : $errTyp; ?>">
                    <span class="glyphicon glyphicon-info-sign"></span> <?php echo $errMSG; ?>
                                </div>
                             </div>
                    <?php
                    }
                    ?>
					<table id="login_table">
						<tr>
							<td>First Name</td>
							<td><input id="firstname" type="text" maxlength="50" value="<?php echo $name ?>" /></td>
						</tr>
						<tr>
							<td>Last Name</td>
							<td><input id="lastname" type="text" maxlength="50" /></td>
						</tr>
						<tr>
							<td>Date of Birth</td>
							<td><input id="dob" type="date" /></td>
						</tr>
						<tr>
							<td>E-mail</td>
							<td><input id="username" type="text" maxlength="50" placeholder="Set your username" value="<?php echo $email ?>" /></td>
						</tr>
						<tr>
							<td>Set Password</td>
							<td><input id="password" type="password" placeholder="Set your password" /></td>
						</tr>
						<tr>
							<td>Confirm Password</td>
							<td><input id="password1" type="password" placeholder="Confirm your password" /></td>
						</tr>
						<tr>
							<td>Address Line 1</td>
							<td><input id="address1" type="text" maxlength="50" placeholder="" /></td>
						</tr>
						<tr>
							<td>Address Line 2</td>
							<td><input id="address2" type="text" maxlength="50" placeholder=""/></td>
						</tr>
						<tr>
							<td>City</td>
							<td><input id="city" type="text" maxlength="50" placeholder="" /></td>
						</tr>
						<tr>
							<td>State</td>
							<td><input id="state" type="text" maxlength="50" placeholder="" /></td>
						</tr>
						<tr>
							<td>ZipCode</td>
							<td><input id="zipcode" type="number" min="00001" max="99999" placeholder="" /></td>
						</tr>
						<tr>
							<td colspan="2">
								<p>Sports Interested</p>
								<ul>
									<li class="sports_list_item"><input id="football" type="checkbox" class="sports_checkbox"/><label for="football">&nbsp;Football</label></li>
									<li class="sports_list_item"><input id="tennis" type="checkbox" class="sports_checkbox"/><label for="tennis">&nbsp;Tennis</label></li>
									<li class="sports_list_item"><input id="cricket" type="checkbox" class="sports_checkbox"/><label for="cricket">&nbsp;Cricket</label></li>
								</ul>
							</td>
						</tr>
						<tr>
							<td>Bio</td>
							<td><textarea id="bio" maxlength="500" rows="3" placeholder="Write somthing about you to let the people know."></textarea></td>
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