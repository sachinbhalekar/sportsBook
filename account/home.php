<?php
ob_start();
session_start();
require_once '../dbconnect.php';

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
		<title>SportsBook - <?php echo $userRow['userEmail']; ?></title>
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
					<li class="header_nav_list_item"><a href="../logout.php?logout" class="header_nav_list_item_a">Log out</a></li>
					<li class="header_nav_list_item"><a href="_blnak" target="_blank" class="header_nav_list_item_a">About Us</a></li>
				</ul>
			</section>
		</header>
		<section id="body_main">
			<section id="main_intro_section">
				<h2>Join now and never play your favorite sports alone!</h2>
			</section>
			<hr>
			<section id="main_login_section">
				
			</section>
		</section>
		<footer>
			<p>&copy; SportsBook</p>
		</footer>
	</body>
</html>
<?php ob_end_flush(); ?>