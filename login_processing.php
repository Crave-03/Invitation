<?php
session_start();
require 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if (empty($username) || empty($password)) {
        $_SESSION['error'] = "Please enter both username and password!";
        header("Location: loginform.php");
        exit();
    }

    $stmt = $conn->prepare("SELECT passcode, password, account_type FROM Data WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows == 1) {
        $stmt->bind_result($passcode, $db_password, $account_type);
        $stmt->fetch();

        if ($password === $db_password) {
            $_SESSION['logged_in'] = true;
            $_SESSION['username'] = $username;
            $_SESSION['account_type'] = $account_type; 
            $_SESSION['temp_passcode'] = $passcode; 

            if (empty($passcode)) {
                if ($account_type === 'admin') {
                    header("Location: admin_dashboard.php");
                    exit();
                } else {
                    header("Location: dashboard.php");
                    exit();
                }
            } else {
                header("Location: verify_passcode.php");
                exit();
            }
        } else {
            $_SESSION['error'] = "Incorrect username or password!";
            header("Location: loginform.php");
            exit();
        }
    } else {
        $_SESSION['error'] = "Incorrect username or password!";
        header("Location: loginform.php");
        exit();
    }

    $stmt->close();
    $conn->close();
} else {
    header("Location: loginform.php");
    exit();
}
