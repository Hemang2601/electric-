<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conn = new mysqli("localhost", "root", "", "Demo");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $email = $_POST["login-useremail"];
    $password = $_POST["login-password"];

    $sql = "SELECT email, password FROM signup WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();

    $stmt->bind_result($dbEmail, $dbPassword);

    if ($stmt->fetch()) {
        if ($password === $dbPassword) {
            // Login successful, store user email in a session
            $_SESSION["email"] = $email;
           // header("Location: appointmentpage.php");
           echo "<script>alert('Login is Working'); window.location.href = 'index.php';</script>";
            exit();
        } else {
            echo "<script>alert('Incorrect password'); window.location.href = 'loginsignup.html';</script>";
        }
    } else {
        // User with this email not found, show an alert
        //echo "<script>alert('User with this email not found'); window.location.href = 'index.html';</script>";
    }

    $stmt->close();
    $conn->close();
}
?>
