<?php
session_start(); // Start the session

// Check if the user is logged in and has the 'admin' role
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true || $_SESSION['account_type'] !== 'admin') {
    header("Location: loginform.php"); // Redirect to login if not logged in as admin
    exit();
}

// Database connection
$host = 'localhost';
$dbname = 'DataDB';
$user = 'root';
$password = '';

$data_rows = [];
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $pdo->query("SELECT * FROM Data");
    $data_rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Database connection failed: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f1f1f1;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .dashboard-container {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 80%;
            max-width: 900px;
            text-align: center;
        }

        h2 {
            margin-top: 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        table th, table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }

        table th {
            background-color: #f2f2f2;
        }

        .options-buttons {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-top: 20px;
        }

        .options-buttons a, .logout-btn {
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 5px;
            display: inline-block;
        }

        .logout-btn {
            background-color: #d9534f;
            border: none;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
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
            <p>No data found.</p>
        <?php endif; ?>

        <div class="options-buttons">
            <a href="dashboard.php">User Dashboard</a>
            <a href="admin_dashboard.php">Admin Dashboard</a>
        </div>

        <form action="logout.php" method="POST" style="margin-top: 20px;">
            <button class="logout-btn" type="submit">Logout</button>
        </form>
    </div>
</body>
</html>
