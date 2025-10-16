<?php
// Start the session
session_start();

// Database credentials
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root'); //  DB username
define('DB_PASSWORD', '');     //  DB password
define('DB_NAME', 'php_blog'); //  DB name

// Attempt to connect to MySQL database
$conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Check connection
if ($conn === false) {
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
?>