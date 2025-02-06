<?php
session_start(); // Start the session to use session variables

// Check if the user is logged in
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: loginform.php");
    exit();
}

$is_admin = ($_SESSION['username'] === 'Mr. Carino');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <style>
        /* Full viewport styling */
        body, html {
            height: 100%;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #f8f9fa;
            font-family: 'Arial', sans-serif;
        }

        /* Container box */
        .dashboard-container {
            background-color: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
            text-align: center;
            max-width: 400px;
            width: 100%;
        }

        h2 {
            margin-top: 0;
            font-size: 24px;
            color: #333;
        }

        p {
            color: #555;
        }

        /* Buttons */
        .option-btn {
            background-color: #007bff;
            color: white;
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 5px;
            display: inline-block;
            margin-top: 10px;
        }

        .logout-btn {
            background-color: #28a745;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            margin-top: 15px;
        }

        .logout-btn:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <h2>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h2>
        <p>You are now logged in.</p>

        <?php if ($is_admin): ?>
            <a href="admin_dashboard.php" class="option-btn">Admin Dashboard Options</a>
        <?php endif; ?>

        <form action="logout.php" method="POST">
            <button type="submit" class="logout-btn">Logout</button>
        </form>
    </div>
</body>
</html>
