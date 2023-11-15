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
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Electrician Services - Services</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        /* Add your existing styles here */
        .contact-info {
            display: none; /* Hide contact details by default */
        }
    </style>
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
        <p>If you need assistance or have any questions, please don't hesitate to contact our support team. We're here to help!</p>

        <div class="contact-info" id="contactInfo">
            <h2>Contact Information</h2>
            <p><strong>Name:</strong> Hemang Lakhadiya</p>
            <p><strong>Email:</strong> hemanglakhadiya@gmail.com</p>
            <p><strong>Phone:</strong> 789 456 123</p>
        </div>

        <button class="help-button" id="showHelpButton">Show Contact Details</button>
    </div>

    <script>
        // JavaScript to toggle the visibility of the contact details and change button text
        const showHelpButton = document.getElementById("showHelpButton");
        const contactInfo = document.getElementById("contactInfo");

        showHelpButton.addEventListener("click", () => {
            if (contactInfo.style.display === "none" || contactInfo.style.display === "") {
                contactInfo.style.display = "block";
                showHelpButton.textContent = "Hide Contact Details";
            } else {
                contactInfo.style.display = "none";
                showHelpButton.textContent = "Show Contact Details";
            }
        });
    </script>
</body>
</html>
