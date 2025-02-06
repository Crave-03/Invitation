<?php
session_start(); // Start the session to use session variables

// Check if the user is logged in
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: loginform.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>User Dashboard</title>
    <link rel="stylesheet" type="text/css" href="style1.css">
    <style>
        /* Basic styling for the page */
        body, html {
            height: 100%;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center; /* This will center the container vertically and horizontally */
            background-color: #f1f1f1;
        }

        .login-container {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            text-align: center;
            width: 80%;
            max-width: 1000px;
            overflow: hidden;
        }

        .login-container h2 {
            margin-bottom: 20px;
        }

        .login-container button {
            padding: 10px 20px;
            border: none;
            background-color: #4CAF50;
            color: white;
            cursor: pointer;
            border-radius: 5px;
            margin: 10px 0;
            width: 100%;
            max-width: 200px;
        }

        .dropdown {
            position: relative;
            display: inline-block;
            margin-top: 20px;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #f9f9f9;
            box-shadow: 0px 8px 16px rgba(0,0,0,0.2);
            z-index: 1;
            min-width: 160px;
        }

        .dropdown:hover .dropdown-content {
            display: block;
        }

        /* Style the table with margins */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            margin-bottom: 20px; /* Add bottom margin to the table */
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 8px;
            text-align: left;
        }

        .empty-message {
            text-align: center;
            font-size: 16px;
            color: #555;
        }

        /* Add some margin for spacing */
        .buttons-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-top: 20px;
        }

        .buttons-container button {
            width: 100%;
            max-width: 200px;
            margin: 10px 0;
        }

    </style>
</head>
<body>
    <div class="login-container">
        <h2>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h2>
        <p>You are now logged in.</p>

        <!-- Show Dashboard Options only for 'Mr. Carino' -->
        <?php if ($_SESSION['username'] === 'Mr. Carino'): ?>
            <div class="dropdown">
                <button>Dashboard Options</button>
                <div class="dropdown-content">
                    <a href="dashboard.php">User Dashboard</a>
                    <a href="admin_dashboard.php">Admin Dashboard</a>
                </div>
            </div>
        <?php endif; ?>

        <!-- Centered logout button -->
        <div class="buttons-container">
            <form action="logout.php" method="POST">
                <button type="submit">Logout</button>
            </form>
        </div>
    </div>
</body>
</html>
