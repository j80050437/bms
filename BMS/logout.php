<?php
session_start();

// Check if the user is an admin
if (isset($_SESSION['admin_logged_in'])) {
    // Destroy the admin session and redirect to admin login
    session_destroy();
    header("Location: adminlogin.php");
} else {
    // Destroy the user session and redirect to home
    session_destroy();
    header("Location: home.php");
}

exit();
?>
