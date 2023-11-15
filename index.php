<?php
session_start();

// Check if the user is logged in
if (isset($_SESSION['email'])) {
    $isLoggedIn = true;
} else {
    $isLoggedIn = false;
}

// Handle logout
if (isset($_POST['logout'])) {
    // Unset and destroy the session to log the user out
    session_unset();
    session_destroy();
    $isLoggedIn = false;
}

// Handle login (check against the "signup" table)
if (isset($_POST['login'])) {
  

    // Create a database connection
    $conn = new mysqli("localhost", "root", "", "Demo");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


    // Retrieve user data from the "signup" table
    $email = $_POST['email'];
    $password = $_POST['password'];

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
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Electrician Services - Home</title>
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
    <div class="container">
        <div class="section">
            <h2>Home Page</h2>
            <p>Welcome to Electrician Services, your trusted partner for electrical repairs and fittings.</p>
        </div>

        <div class="section">
            <h2>Our Services</h2>
            <div class="service">
                <h3>Electrical Repairs</h3>
                <p>We provide high-quality electrical repair services to ensure the safety and functionality of your electrical systems.</p>
            </div>
            <!-- Add more service sections as needed -->
        </div>

        <div class="section">
            <h2>Why Choose Us?</h2>
            <p>Our team of experienced electricians is dedicated to providing high-quality service. We prioritize safety, efficiency, and customer satisfaction. Whether you need a quick repair or a complete electrical installation, we've got you covered.</p>
        </div>
    </div>
</body>
</html>

