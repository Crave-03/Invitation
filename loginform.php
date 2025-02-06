<?php 
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Pet Adoption</title>
    <link rel="stylesheet" type="text/css" href="style1.css?v=<?php echo time(); ?>">
</head>
<body>
    <div class="login-wrapper">
        <!-- Left image section -->
        <div class="image-section">
            <img src="Pets.JPG" alt="Cute Dog" class="login-image">
        </div>

        <!-- Right login form section -->
        <div class="login-container">
            <h2> Welcome to PetConnect! </h2>

            <?php 
            if (isset($_SESSION['success'])) { 
                echo '<p class="success">'.htmlspecialchars($_SESSION['success']).'</p>'; 
                unset($_SESSION['success']); 
            }
            if (isset($_SESSION['error'])) { 
                echo '<p class="error">'.htmlspecialchars($_SESSION['error']).'</p>'; 
                unset($_SESSION['error']); 
            }
            ?>

            <form action="login_processing.php" method="POST">
                <input type="text" name="username" placeholder="Username" required>
                <input type="password" name="password" placeholder="Password" required>
                <button type="submit">Login</button>
            </form>

            <p>Don't have an account?</p>
            <form action="register.php" method="GET">
                <button type="submit" class="register-btn">Register</button>
            </form>

            <!-- Forgot Passcode Link -->
            <div class="forgot-passcode">
                <p><a href="forgot_passcode.php" style="color: #FD6585; text-decoration: none;">Forgot your passcode?</a></p>
            </div>
        </div>
    </div>
</body>
</html>
