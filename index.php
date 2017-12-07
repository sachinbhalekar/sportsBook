<?php
ob_start();
session_start();

//including for DB connection
require_once './connection/dbconnect.php';

// it will never let you open index(login) page if session is set
if ( isset($_SESSION['user'])!="" )
{
    header("Location: ./account/home.php");
    exit;
}

$error = false;

//check when form is submitted
if( isset($_POST['login_btn']) )
{
    // get values from form input tags
    $email = trim($_POST['username']);
    $email = strip_tags($email);
    $email = htmlspecialchars($email);
    
    $pass = trim($_POST['password']);
    $pass = strip_tags($pass);
    $pass = htmlspecialchars($pass);
    
    // if there's no error, continue to login
    if (!$error)
    {
        
        $password = hash('sha256', $pass); // password hashing using SHA256
        
        $query = "SELECT userEmail, userPass FROM users WHERE userEmail='$email' and userPass='$password'";
        $res=$conn->query($query);
        
        $count = $res->num_rows; // if uname/pass correct it returns 1 row
        //echo $count;
        if($count == 1 )// user found
        {
            while( $row=$res->fetch_assoc())
            {
                $errTyp = "success";
                //echo "<script type='text/javascript'>alert(Query1 : '$errTyp');</script>";
                $_SESSION['user'] = $row['userEmail'];
                header("Location: ./account/home.php");
            }
        }
        else// user not present or invalid credentials
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
    	<header>
    		<nav class="navbar navbar-inverse navbar-fixed-top">
              <div class="container-fluid">
                <div class="navbar-header">
                  <a class="navbar-brand" href="index.php"><i><strong>SportsBook</strong></i></a>
                </div>
                <ul class="nav navbar-nav navbar-right">
                  <li><a href="./signup/signup.php"><span class="glyphicon glyphicon-user"></span> Sign Up</a></li>
                  <li><a href="#main_login_section"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
                </ul>
              </div>
            </nav>
    	</header>
        <div class="container text-center">
    		<section id="main_intro_section">
    			<h1>Join now and never play your favorite sports alone!</h1>
    		</section>
    		<hr>
    		<section id="main_login_section">
    			<form id="login_form" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
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
    						<td>
    							<div class="input-group">
    								<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
    								<input id="username" name="username" class="form-control" type="text" placeholder="Username/Email-ID" required />
    							</div>
    						</td>
    					</tr>
    					<tr>
    						<td>
    							<div class="input-group">
    								<span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
    								<input id="password" name="password" class="form-control" type="password" placeholder="Password" required/>
    							</div>
    						</td>
    					</tr>
    					<tr>
    						<td class="td_center">
    							<input id="login_btn" name="login_btn" class="btn btn-primary" type="submit" value="Login">
    						</td>
    					</tr>
    					<tr>
    						<td class="td_center">
    							<div class="well well-sm"><p class="font_black">Not a member yet? </p><a href="./signup/signup.php"><span class="glyphicon glyphicon-user"></span> Sign Up</a></div>
    						</td>
    					</tr>
    				</table>
    			</form>
    		</section>
        </div>
    	<footer class="container-fluid text-center">
    		<p>&copy; SportsBook</p>
    	</footer>
	</body>
</html>
<?php ob_end_flush(); ?>