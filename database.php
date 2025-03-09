<?php

$host = 'localhost';       // The database server address (it can be 'localhost' or the IP of your server)
$db_name = 'your_database'; // The name of your database
$username = 'your_username'; // The database username
$password = 'your_password'; // The database password

$mysqli = new mysqli(hostname: $host,
                     username: $username,
                     password: $password,
                     database: $dbname);
                     
if ($mysqli->connect_errno) {
    die("Connection error: " . $mysqli->connect_error);
}

return $mysqli;
?>
