<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['email'])) {
    // Redirect to login page or handle the case where the user is not logged in
    header('Location: loginsignup.html');
    exit();
}

// Create a database connection
$conn = new mysqli("localhost", "root", "", "Demo");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve user data from the "signup" table
$email = $_SESSION['email'];
$sql = "SELECT * FROM signup WHERE email = '$email'";
$result = $conn->query($sql);

// Check if the user exists
if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();
    $currentAddress = $user['address'];
} else {
    // Redirect to login page or handle the case where the user is not found
    header('Location: loginsignup.html');
    exit();
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Welcome to Your Profile</h1>
    </header>
    <nav>
        <a href="index.php">Home</a>
        <a href="services.php">Services</a>
        <a href="contact.php">Contact</a>
        <a href="profile.php">Profile</a>
        <a href="logout.php">Logout</a>
    </nav>
    <div class="container">
        <h2>User Profile</h2>
        <p>Email: <?php echo $user['email']; ?></p>
        <p>Name: <?php echo $user['name']; ?></p>
        <p>Address: 
        <?php if (!empty($currentAddress)) : ?>

              <!-- Show existing address and Update Address button -->
              <?php echo $currentAddress; ?>
            <form method="post" action="setnewaddress.php">
                <button type="submit" name="updateAddress">Update Address</button>
            </form>
            
        <?php else : ?>

             <!-- Show input field to set a new address -->
             <form method="post" action="setaddress.php">
                <label for="newAddress">New Address:</label>
                <input type="text" name="newAddress" id="newAddress" required>
                <button type="submit" name="setAddress">Set Address</button>
            </form>
          
        <?php endif; ?>
        </p>
    </div>
</body>
</html>
