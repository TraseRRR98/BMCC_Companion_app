<?php
session_start();
$_SESSION['logout_message'] = "You have been successfully logged out.";

// Destroy the session
session_unset();
session_destroy();

// Redirect to login page
header("Location: ../control_panel/control_panel.php");
exit;
?>
