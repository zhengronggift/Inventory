<?php
session_start();
define('db_servername', 'localhost');
define('db_username', 'rzheng');
define('db_dbname', 'rzheng');
define('db_pass', 'TPY1QFy4gr');

// Create connection
$conn = new mysqli(db_servername, db_username, db_pass, db_dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
