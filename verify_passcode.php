<?php
session_start();

// Database connection setup
$servername = "localhost"; 
$username = "root"; 
$password = ""; 
$dbname = "DataDB"; 

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Redirect if session data is missing
if (!isset($_SESSION['username']) || !isset($_SESSION['account_type'])) {
    header("Location: loginform.php");
    exit();
}

$username = $_SESSION['username'];
$passcode_from_db = "";

// Fetch passcode from 'Data' table
$sql = "SELECT passcode FROM Data WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$stmt->bind_result($passcode_from_db);
$stmt->fetch();
$stmt->close();
$conn->close();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $entered_passcode = trim($_POST['passcode']);
    
    if ($entered_passcode === $passcode_from_db) {
        $_SESSION['logged_in'] = true;

        if ($_SESSION['account_type'] === 'admin') {
            header("Location: admin_dashboard.php");
        } else {
            header("Location: dashboard.php");
        }
        exit();
    } else {
        $_SESSION['error'] = "Incorrect passcode! Please try again.";
        header("Location: verify_passcode.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Passcode</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap');

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #FFD3A5 30%, #FD6585 100%);
            background-size: cover;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            position: relative;
        }

        /* Adding a cute polka-dot overlay */
        body::before {
            content: "";
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            background-image: radial-gradient(circle, rgba(255, 255, 255, 0.3) 1px, transparent 1px);
            background-size: 25px 25px;
            opacity: 0.4;
        }

        .container {
            background: white;
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.15);
            width: 100%;
            max-width: 400px;
            text-align: center;
            position: relative;
            z-index: 2;
        }

        h2 {
            color: #FD6585;
            font-weight: 600;
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 10px;
            font-weight: bold;
            color: #333;
        }

        /* Input field with adjusted margin and width */
        input[type="text"] {
            width: calc(100% - 40px); /* Adjust width to fit padding and margins */
            padding: 12px;
            margin: 0 20px 20px 20px; /* Adds margin to both left and right */
            border: 2px solid #FD6585;
            border-radius: 8px;
            font-size: 16px;
            outline: none;
            transition: 0.3s;
            box-sizing: border-box;
        }

        input[type="text"]:focus {
            border-color: #FF9A8B;
            box-shadow: 0 0 10px rgba(255, 154, 139, 0.5);
        }

        /* Cute Button Design */
        button {
            background: linear-gradient(135deg, #FD6585 30%, #FFD3A5 100%);
            color: white;
            padding: 12px;
            border: none;
            border-radius: 30px;
            cursor: pointer;
            width: calc(100% - 40px); /* Match the width with the input field */
            font-size: 16px;
            font-weight: bold;
            transition: all 0.3s ease-in-out;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            margin-left: 20px;
            margin-right: 20px;
        }

        button:hover {
            background: linear-gradient(135deg, #FF9A8B 30%, #FFD3A5 100%);
            transform: scale(1.05);
        }

        .error {
            color: red;
            margin-top: 15px;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Verify Passcode</h2>
        <form method="POST" action="">
            <label for="passcode">Unique Passcode:</label>
            <input type="text" name="passcode" id="passcode" required placeholder="Enter your passcode">
            <button type="submit"> Verify </button>
        </form>
        <?php
        if (isset($_SESSION['error'])) {
            echo "<p class='error'>" . $_SESSION['error'] . "</p>";
            unset($_SESSION['error']);
        }
        ?>
    </div>
</body>
</html>
