<?php
    // Define Database Credentials
    define('DB_SERVER', '127.0.0.1');
    define('DB_USERNAME', 'root');
    define('DB_PASSWORD', '');
    define('DB_NAME', 'bmcc_student_companion');
    
    global $conn;
    // Attempt To Connect To MySQL Database
    $conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
    
    // Verify Connection
    if ($conn === false) 
        die("ERROR: Could not connect: " . mysqli_connect_error());
?>