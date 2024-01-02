<?php

$host = 'localhost';
$username = 'makilagied';
$password = 'Edick@7266';
$database = 'nyumbani_lodge';

// Create a connection
$connection = new mysqli($host, $username, $password, $database);

// Check the connection
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

?>
