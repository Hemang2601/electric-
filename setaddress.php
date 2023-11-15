<?php
// Connect to the database (replace with your database credentials)
$conn = new mysqli("localhost", "root", "", "Demo");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get data from the form
$address = $_POST["newAddress"];

// Check if the user is logged in
session_start();

if (!isset($_SESSION['email'])) {
    // Redirect to login page or handle the case where the user is not logged in
    header('Location: loginsignup.html');
    exit();
}

// Retrieve user data from the "signup" table
$email = $_SESSION['email'];
$check_sql = "SELECT * FROM signup WHERE email = '$email'";
$check_result = $conn->query($check_sql);

if ($check_result->num_rows === 1) {
    // User exists, update the address
    $update_sql = "UPDATE signup SET address = '$address' WHERE email = '$email'";
    if ($conn->query($update_sql) === TRUE) {
        echo "<script>alert('Address updated successfully!'); window.location.href = 'profile.php';</script>";
    } else {
        echo "Error updating address: " . $conn->error;
    }
} else {
    echo "User not found";
}

// Close the database connection
$conn->close();
?>
