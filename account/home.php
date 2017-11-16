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
				<section id="to_post_section">
					<form id="home_form" name="home_form" method="post" action="<?php $_SERVER['PHP_SELF']; ?>">
						<fieldset>
							<legend>Post to play</legend>
							<section id="to_post_section_fields">
    							<textarea id="to_post_info" name="to_post_info" maxlength="500" rows="3" placeholder="Write your post here..."></textarea>
    							<br/>
    							<img id="img_loc" src="../images/location_icon.png" alt="" />&nbsp;<a id="a_loc" href="_blank">Add Location</a>
    							<br/>
    							<input id="post_btn" name="post_btn" type="Submit" value="Post" />
    						</section>
						</fieldset>
					</form>
				</section>
				<hr class="main_hr"/>
				<section id="all_post_section">
					<fieldset>
						<legend>Nearby Activities</legend>
						<section id="all_post_section_fields">
							<textarea id="all_post_info" name="all_post_info" maxlength="500" rows="10" placeholder=""></textarea>
							<img id="all_post_img_loc" src="../images/location_icon.png" alt="location" />
							<hr class="sub_hr">
						</section>
					</fieldset>
				</section>
			</section>
		</section>
		<footer>
			<p>&copy; SportsBook</p>
		</footer>
	</body>
</html>
<?php ob_end_flush(); ?>