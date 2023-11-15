<?php
session_start();

if (isset($_SESSION['email'])) {
    $isLoggedIn = true;
} else {
    $isLoggedIn = false;
}

// Handle login (check against the "signup" table)
if (isset($_POST['email'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Create a database connection
    $conn = new mysqli("localhost", "root", "", "Demo");

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Retrieve user data from the "signup" table
    $sql = "SELECT * FROM signup WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();

        // Verify the provided password against the stored hashed password
        if (password_verify($password, $row['password'])) {
            $_SESSION['email'] = $email; // Set a session variable to mark the user as logged in
            $isLoggedIn = true;
        }
    }

    // Close the database connection
    $conn->close();

    // Redirect to the services page if login is successful
    if ($isLoggedIn) {
        header('Location: services.php');
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Electrician Services - Services</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Welcome to Electrician Services</h1>
    </header>
    <nav>
        <a href="index.php">Home</a>
        <a href="services.php">Services</a>
        <a href="contact.php">Contact</a>
        <?php if ($isLoggedIn) : ?>
            <a href="profile.php">Profile</a> <!-- Link to the user's profile page -->
            <a href="logout.php">Logout</a> <!-- Link to a "logout.php" page that handles the logout -->
        <?php else : ?>
            <a href="loginsignup.html">Login</a>
        <?php endif; ?>
    </nav>
    
</body>
</html>
