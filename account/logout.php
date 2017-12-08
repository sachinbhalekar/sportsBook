<?php
session_start();

if (isset($_GET['logout'])) //if user selected logout
{
    unset($_SESSION['user']);
    session_unset();
    session_destroy();
    header("Location: ../index.php?logout");// redirect to home page
    exit;
}
else if (!isset($_SESSION['user'])) //if no user in session
{
    header("Location: ../index.php");
}
else if(isset($_SESSION['user'])!="") // if session present then redirect to home page
{
    header("Location: home.php");
}

?>