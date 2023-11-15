<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if the user is logged in
    if (!isset($_SESSION['email'])) {
        header('Location: loginsignup.html');
        exit();
    }

    // Create a database connection
    $conn = new mysqli("localhost", "root", "", "Demo");

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $email = $_SESSION['email'];

    // Check if the 'updateAddress' button is clicked
    if (isset($_POST['updateAddress'])) {
        $sql = "SELECT * FROM signup WHERE email = '$email'";
        $result = $conn->query($sql);

        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();
            $currentAddress = $user['address'];

            // Display a form to update the address
            echo '
                <!DOCTYPE html>
                <html lang="en">
                <head>
                    <meta charset="UTF-8">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    <title>Update Address</title>
                    <link rel="stylesheet" href="styles.css">
                </head>
                <body>
                    <header>
                        <h1>Update Address</h1>
                    </header>
                    <nav>
                        <a href="index.php">Home</a>
                        <a href="services.php">Services</a>
                        <a href="contact.php">Contact</a>
                        <a href="profile.php">Profile</a>
                        <a href="logout.php">Logout</a>
                    </nav>
                    <div class="container">
                        <h2>Update Address</h2>
                        <form method="post" action="setaddress.php">
                            <label for="updatedAddress">Updated Address:</label>
                            <input type="text" name="updatedAddress" id="updatedAddress" value="' . $currentAddress . '" required>
                            <button type="submit" name="saveUpdatedAddress">Save Address</button>
                        </form>
                    </div>
                </body>
                </html>
            ';

        } else {
            header('Location: loginsignup.html');
            exit();
        }
    }

    // Check if the 'saveUpdatedAddress' button is clicked
    if (isset($_POST['saveUpdatedAddress'])) {
        $updatedAddress = $conn->real_escape_string($_POST['updatedAddress']);
        $updateSql = "UPDATE signup SET address = '$updatedAddress' WHERE email = '$email'";
        
        if ($conn->query($updateSql) === TRUE) {
            header('Location: profile.php');
            exit();
        } else {
            echo 'Error updating address: ' . $conn->error;
        }
    }

    // Check if the 'setAddress' button is clicked
    if (isset($_POST['setAddress'])) {
        $newAddress = $conn->real_escape_string($_POST['newAddress']);
        $insertSql = "INSERT INTO signup (address) VALUES ('$newAddress') WHERE email = '$email'";
        
        if ($conn->query($insertSql) === TRUE) {
            header('Location: profile.php');
            exit();
        } else {
            echo 'Error inserting address: ' . $conn->error;
        }
    }

    // Close the database connection
    $conn->close();
} else {
    header('Location: index.php');
    exit();
}
?>
