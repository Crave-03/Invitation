<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Passcode</title>
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

        input[type="email"] {
            width: calc(100% - 40px);
            padding: 12px;
            margin: 0 20px 20px 20px;
            border: 2px solid #FD6585;
            border-radius: 8px;
            font-size: 16px;
            outline: none;
            transition: 0.3s;
            box-sizing: border-box;
        }

        input[type="email"]:focus {
            border-color: #FF9A8B;
            box-shadow: 0 0 10px rgba(255, 154, 139, 0.5);
        }

        button {
            background: linear-gradient(135deg, #FD6585 30%, #FFD3A5 100%);
            color: white;
            padding: 12px;
            border: none;
            border-radius: 30px;
            cursor: pointer;
            width: calc(100% - 40px);
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

        .success {
            color: green;
            margin-top: 15px;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Forgot Passcode</h2>
        <form method="POST" action="send_reset_link.php">
            <label for="email">Enter your email address:</label>
            <input type="email" name="email" required placeholder="Your registered email">
            <button type="submit">Send Reset Link</button>
        </form>
        
        <?php
        if (isset($_SESSION['error'])) {
            echo "<p class='error'>" . $_SESSION['error'] . "</p>";
            unset($_SESSION['error']);
        }

        if (isset($_SESSION['success'])) {
            echo "<p class='success'>" . $_SESSION['success'] . "</p>";
            unset($_SESSION['success']);
        }
        ?>
    </div>
</body>
</html>
