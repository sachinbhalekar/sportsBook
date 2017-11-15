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
// select loggedin users detail
$res=$conn->query("SELECT * FROM users WHERE userId=".$_SESSION['user']);
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
		<link rel="stylesheet" type="text/css" href="../css/account.css">
		<link href="https://fonts.googleapis.com/css?family=Zilla+Slab+Highlight" rel="stylesheet">
	</head>
	<body>
		<header id="body_header">
			<section id="header_title">
				<h1><a href="../index.php" class="a_header">SportsBook</a></h1>
			</section>
			<section id="header_nav_section">
				<ul>
					<li class="header_nav_list_item"><a href="../location/location.php" class="header_nav_list_item_a">Location</a></li>
					<li class="header_nav_list_item"><a href="personalInfo.php" class="header_nav_list_item_a">My details</a></li>
					<li class="header_nav_list_item"><a href="logout.php?logout" class="header_nav_list_item_a">Log out</a></li>
					<li class="header_nav_list_item"><a href="_blnak" target="_blank" class="header_nav_list_item_a">About Us</a></li>
				</ul>
			</section>
		</header>
		<section id="body_main">
			<section id="main_home_section">
				<form id="details_form" name="details_form" method="post" action="<?php $_SERVER['PHP_SELF']; ?>">
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
							<td colspan="2" class="td_center"><input id="update_btn" name="update_btn" class="input_regular" type="submit" value="Update Details"/></td>
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