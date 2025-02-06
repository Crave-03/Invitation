<?php
// Verify token from the URL
if (isset($_GET['token'])) {
    $token = $_GET['token'];

    // Check if token exists and is valid
    $sql = "SELECT username FROM Data WHERE reset_token = ? AND token_expiry > NOW()";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // Token is valid, show passcode reset form
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $new_passcode = $_POST['passcode'];

            // Update the passcode
            $stmt = $conn->prepare("UPDATE Data SET passcode = ?, reset_token = NULL, token_expiry = NULL WHERE reset_token = ?");
            $stmt->bind_param("ss", $new_passcode, $token);
            $stmt->execute();

            echo "Your passcode has been updated!";
        }
    } else {
        echo "Invalid or expired token.";
    }
}
?>

<form method="POST">
    <label for="passcode">Enter your new passcode:</label>
    <input type="password" name="passcode" required placeholder="New passcode">
    <button type="submit">Reset Passcode</button>
</form>
