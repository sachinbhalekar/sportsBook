<?php
ob_start();
session_start();
require_once './connection/dbconnect.php';

// it will never let you open index(login) page if session is set
if ( isset($_SESSION['user'])!="" ) 
{
    header("Location: ./account/home.php");
    exit;
}

$error = false;

if( isset($_POST['login_btn']) ) 
{
    $email = trim($_POST['username']);
    $email = strip_tags($email);
    $email = htmlspecialchars($email);
    
    $pass = trim($_POST['password']);
    $pass = strip_tags($pass);
    $pass = htmlspecialchars($pass);
    
    // prevent sql injections / clear user invalid inputs
    /*
    if(empty($email))
    {
        $error = true;
        $emailError = "Please enter your email address.";
    } 
    else if ( !filter_var($email,FILTER_VALIDATE_EMAIL) ) 
    {
        $error = true;
        $emailError = "Please enter valid email address.";
    }
    
    if(empty($pass))
    {
        $error = true;
        $passError = "Please enter your password.";
    }
    */
    
    // if there's no error, continue to login
    if (!$error) 
    {
        
        $password = hash('sha256', $pass); // password hashing using SHA256
        
        $res=$conn->query("SELECT userId, userName, userPass FROM users WHERE userEmail='$email' and userPass='$password'");
        
        $count = $res->num_rows; // if uname/pass correct it returns must be 1 row
        //echo $count;
        if($count == 1 )
        {
            while( $row=$res->fetch_assoc())
            {
                if($row['userPass']==$password ) 
                {
                    $errTyp = "success";
                    $_SESSION['user'] = $row['userId'];
                    header("Location: ./account/home.php");
                }
            }
        }
        else 
        {
            $errTyp = "danger";
            $message = "Incorrect Credentials, Try again...";
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
		<link rel="icon" href="./images/favicon.ico" type="image/ico" sizes="16x16" />
		<title>SportsBook</title>
		<link rel="stylesheet" type="text/css" href="./css/login.css">
		<link href="https://fonts.googleapis.com/css?family=Zilla+Slab+Highlight" rel="stylesheet">
	</head>
	<body>
		<header id="body_header">
			<section id="header_title">
				<h1><a href="index.php" class="a_header">SportsBook</a></h1>
			</section>
			<!-- 
			<section id="header_logo">
				<img id="sportsLogo" src="./images/sports14.jpg" alt="All Sports" />
			</section>
			 -->
			<section id="header_nav_section">
				<ul>
					<li class="header_nav_list_item"><a href="#main_login_section" class="header_nav_list_item_a">Login</a></li>
					<li class="header_nav_list_item"><a href="./signup/signup.php" class="header_nav_list_item_a">Sign Up</a></li>
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
				<form id="login_form" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
					<?php
                    if ( isset($message) ) 
                    {
                    ?>
                        <div class="form-group">
                        	<div class="alert alert-<?php echo ($errTyp=="success") ? "success" : $errTyp; ?>">
                    			<span class="glyphicon glyphicon-info-sign"></span> <?php echo $message; ?>
                        	</div>
                        </div>               
                    <?php
                    }
                    ?>
					<table id="login_table">
						<tr>
							<td>Username</td>
							<td><input id="username" name="username" type="text" placeholder="Username/Email-ID" pattern="[^@]+@[^@]+\.[a-zA-Z]{2,6}" required value="<?php echo $email; ?>"/></td>
						</tr>
						<tr>
							<td>Password</td>
							<td><input id="password" name="password" type="password" required/></td>
						</tr>
						<tr>
							<td colspan="2" class="td_center"><input id="login_btn" type="submit" name="login_btn" value="Login"/></td>
						</tr>
						<tr>
							<td colspan="2" class="td_center">Not a member yet? <a href="./signup/signup.php">Sign Up</a></td>
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