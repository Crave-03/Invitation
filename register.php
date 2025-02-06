<?php 
session_start();
require 'db_connect.php'; // Include database connection

// Generate a unique 6-character passcode
$passcode = substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, 6);
$_SESSION['passcode'] = $passcode;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register | Pet Adoption</title>
    <link rel="stylesheet" type="text/css" href="style1.css?v=<?php echo time(); ?>">
    <style>
        /* This will ensure all fields are aligned properly */
        input[type="text"], input[type="password"], input[type="email"] {
            width: 100%; /* Makes the input fields full-width */
            padding: 12px;
            margin: 10px 0; /* Adds vertical spacing */
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 16px;
            box-sizing: border-box; /* Ensures padding is included in the width */
        }

        /* Optional: Style the submit button */
        .register-btn {
            background-color: #FD6585;
            color: white;
            border: none;
            padding: 12px 20px;
            border-radius: 30px;
            cursor: pointer;
            font-size: 16px;
            width: 100%;
            transition: background-color 0.3s ease;
        }

        .register-btn:hover {
            background-color: #FF9A8B;
        }
    </style>
</head>
<body>
    <div class="login-wrapper">
        <!-- Left register form section -->
        <div class="login-container">
            <h2> Register for PetConnect! </h2>

            <?php 
            if (isset($_SESSION['error'])) { 
                echo '<p class="error">'.htmlspecialchars($_SESSION['error']).'</p>'; 
                unset($_SESSION['error']); 
            } 
            ?>

            <form action="register_process.php" method="POST">
                <!-- Username Field -->
                <input type="text" name="username" placeholder="Username" required>
                
                <!-- Password Field -->
                <input type="password" name="password" placeholder="Password" required>
                
                <!-- Email Field (Gmail) -->
                <input type="email" name="email" placeholder="Your Email (Gmail)" required>
                
                <!-- Hidden Passcode Field (for database storage) -->
                <input type="hidden" name="passcode" value="<?php echo $passcode; ?>">
                
                <p>Your unique passcode: <strong><?php echo $passcode; ?></strong></p>
                <button type="submit" class="register-btn">Register</button>
            </form>

            <p>Already have an account?</p>
            <form action="loginform.php" method="GET">
                <button type="submit">Login</button>
            </form>
        </div>

        <!-- Right image section -->
        <div class="image-section">
            <img src="bird.JPG" alt="Cute Cat" class="login-image">
        </div>
    </div>
</body>
</html>
