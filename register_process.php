<?php
session_start();
require 'db_connect.php'; // Include the database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']); // No hashing, as requested
    $passcode = $_POST['passcode']; // Passcode from form input
    $email = trim($_POST['email']); // Get the email from the form input

    // Check if the username or email already exists
    $stmt = $conn->prepare("SELECT passcode FROM Data WHERE username = ? OR email = ?");
    $stmt->bind_param("ss", $username, $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $_SESSION['error'] = "Username or email already taken!";
        header("Location: register.php");
        exit();
    }

    // Insert new user with unique passcode and email
    $stmt = $conn->prepare("INSERT INTO Data (username, password, passcode, email) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $username, $password, $passcode, $email);
    
    if ($stmt->execute()) {
        $_SESSION['success'] = "Registration successful! Your passcode is: " . $passcode;
        header("Location: loginform.php");
        exit();
    } else {
        $_SESSION['error'] = "Error registering user.";
        header("Location: register.php");
        exit();
    }
    
    $stmt->close();
    $conn->close();
} else {
    header("Location: register.php");
    exit();
}
?>
