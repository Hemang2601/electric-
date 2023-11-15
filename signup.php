<?php
// Connect to the database (replace with your database credentials)
$conn = new mysqli("localhost", "root", "", "Demo");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get data from the form
$name = $_POST["signup-username"];
$email = $_POST["signup-email"];
$password = $_POST["signup-password"];

// Check if the email is already in use
$check_sql = "SELECT * FROM signup WHERE email = '$email'";
$check_result = $conn->query($check_sql);

if ($check_result->num_rows > 0) {
    echo "<script>alert('E-mail is Already Used'); window.location.href = 'index.php';</script>";
    $conn->close();
    exit; // Stop execution if email is already in use
}

// Insert the appointment into the database
$sql = "INSERT INTO signup VALUES ('$name', '$email', '$password')";
if ($conn->query($sql) === TRUE) {
    echo "<script>alert('Registered successfully!'); window.location.href = 'index.php';</script>";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// Close the database connection
$conn->close();
?>
