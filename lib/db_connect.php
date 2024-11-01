<?php
// Database connection settings
define('DB_SERVER', 'localhost');  // Server name or IP
define('DB_USERNAME', 'root');  // Replace with your actual MySQL username (often 'root' for XAMPP)
define('DB_PASSWORD', '');  // Replace with your actual MySQL password (often empty for XAMPP)
define('DB_NAME', 'bmcc_student_companion');  // Database name

// Establishing a connection to the MySQL database
$connection = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Check if the connection was successful
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}
?>