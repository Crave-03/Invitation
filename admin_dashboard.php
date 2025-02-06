<?php
session_start();  // Start the session

// Check if the user is logged in and has the 'admin' role
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true || $_SESSION['account_type'] !== 'admin') {
    header("Location: loginform.php");  // Redirect to login if not logged in as admin
    exit();
}

// Database connection (use correct credentials here)
$host = 'localhost';          // Database host
$dbname = 'DataDB';           // Your database name
$user = 'root';               // Your database username (e.g., 'root' for localhost)
$password = '';               // Your database password (use empty string for default in XAMPP)

$data_rows = [];
try {
    // Create a PDO instance for database connection
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Query to fetch data (change to your actual table name)
    $stmt = $pdo->query("SELECT * FROM Data");   // Example query for fetching data
    $data_rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Database connection failed: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
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
			margin: 40px;
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

        /* Add some margin for spacing */
        .empty-message {
            text-align: center;
            font-size: 16px;
            color: #555;
        }

        /* Adjust the container for centered layout */
        .container {
            display: flex;
            flex-direction: column;
            align-items: center;
            width: 100%;
        }

        /* Ensure both buttons are in the center with consistent margins */
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
    <div class="container">
        <div class="login-container">
            <h2>Welcome, Admin <?php echo htmlspecialchars($_SESSION['username']); ?>!</h2>

            <h3>Database Records:</h3>
            <?php if (!empty($data_rows)): ?>
                <table>
                    <thead>
                        <tr>
                            <?php foreach (array_keys($data_rows[0]) as $column): ?>
                                <th><?php echo htmlspecialchars($column); ?></th>
                            <?php endforeach; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($data_rows as $row): ?>
                            <tr>
                                <?php foreach ($row as $cell): ?>
                                    <td><?php echo htmlspecialchars($cell); ?></td>
                                <?php endforeach; ?>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p class="empty-message">No data found.</p>
            <?php endif; ?>

            <div class="dropdown">
                <button>Dashboard Options</button>
                <div class="dropdown-content">
                    <a href="dashboard.php">User Dashboard</a>
                    <a href="admin_dashboard.php">Admin Dashboard</a>
                </div>
            </div>

            <!-- Centered logout button and dropdown button -->
            <div class="buttons-container">
                <form action="logout.php" method="POST">
                    <button type="submit">Logout</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
