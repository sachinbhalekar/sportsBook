<?php

// this will avoid mysql_connect() deprecation error.
error_reporting( ~E_DEPRECATED & ~E_NOTICE );
// but I strongly suggest you to use PDO or MySQLi.

define('DBHOST', 'us-cdbr-iron-east-05.cleardb.net');
define('DBUSER', 'bf02b57bc5e498');
define('DBPASS', '6dc188ed');
define('DBNAME', 'heroku_2f106c6b6cd20ee');

$conn = new mysqli(DBHOST,DBUSER,DBPASS,DBNAME);

// Check connection
if (!$conn) 
{
    die("Connection failed: " . mysqli_connect_error());
}
//echo "Connected successfully";
?>