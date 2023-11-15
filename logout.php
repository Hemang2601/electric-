<?php
session_start();

// Check if the user is logged in
if (isset($_SESSION['email'])) {
    // Unset and destroy the session to log the user out
    session_unset();
    session_destroy();
}

// Redirect the user to the homepage or any other page after logging out
header("Location: index.php");
exit();
?>
