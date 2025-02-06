<?php
session_start();
require 'db_connect.php'; // Include the database connection
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // Include PHPMailer autoload

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);

    // Check if email exists in the database
    $sql = "SELECT username FROM Data WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // Generate a secure token for the password reset
        $reset_token = bin2hex(random_bytes(16));  // 16-byte token

        // Store the token and its expiry in the database (expiry time set to 1 hour)
        $stmt = $conn->prepare("UPDATE Data SET reset_token = ?, token_expiry = DATE_ADD(NOW(), INTERVAL 1 HOUR) WHERE email = ?");
        $stmt->bind_param("ss", $reset_token, $email);
        $stmt->execute();

        // Send the reset email using PHPMailer
        $mail = new PHPMailer(true);
        try {
            //Server settings
            $mail->isSMTP();                                            // Send using SMTP
            $mail->Host       = 'smtp.gmail.com';                         // Set the SMTP server to Gmail
            $mail->SMTPAuth   = true;                                     // Enable SMTP authentication
            $mail->Username   = 'your_email@gmail.com';                   // SMTP username (your Gmail)
            $mail->Password   = 'your_gmail_password';                    // SMTP password (your Gmail password or App Password)
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;           // Enable TLS encryption
            $mail->Port       = 587;                                      // TCP port to connect to (587 for Gmail)

            //Recipients
            $mail->setFrom('your_email@gmail.com', 'Your Website');       // Set the sender's email address
            $mail->addAddress($email);                                    // Add the recipient's email address

            // Content
            $mail->isHTML(true);
            $mail->Subject = 'Password Reset Request';
            $mail->Body    = "Hello,<br><br>Please click the following link to reset your passcode: <br><br><a href='https://yourwebsite.com/reset_passcode.php?token=" . $reset_token . "'>Reset your passcode</a><br><br>This link will expire in 1 hour.<br><br>Best regards,<br>Your Website Team";

            // Send the email
            if ($mail->send()) {
                $_SESSION['success'] = "A password reset link has been sent to your email address.";
            } else {
                $_SESSION['error'] = "There was an error sending the reset email. Please try again later.";
            }

        } catch (Exception $e) {
            // Handle errors from PHPMailer
            $_SESSION['error'] = "Error sending email: " . $mail->ErrorInfo;
        }
    } else {
        // Email not found in the database
        $_SESSION['error'] = "Email address not found in our records.";
    }

    // Redirect to the forgot password page with appropriate session messages
    header("Location: forgot_passcode.php");
    exit();
} else {
    // If the request method isn't POST, redirect to the forgot password page
    header("Location: forgot_passcode.php");
    exit();
}
?>
