<?php

// this will avoid mysql_connect() deprecation error.
error_reporting( ~E_DEPRECATED & ~E_NOTICE );
// but I strongly suggest you to use PDO or MySQLi.

define('DBHOST', 'localhost');
define('DBUSER', 'sportsbook');
define('DBPASS', 'sportsbook');
define('DBNAME', 'sportsbook');

$conn = new mysqli(DBHOST,DBUSER,DBPASS,DBNAME);

// Check connection
if (!$conn) 
{
    die("Connection failed: " . mysqli_connect_error());
}
//echo "Connected successfully";
?>