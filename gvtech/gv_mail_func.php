<?
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Load PHPMailer
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

$mail = new PHPMailer(true);

try {
    // Server settings
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';     // Set Gmail SMTP server
    $mail->SMTPAuth   = true;
    $mail->Username   = 'balamuruganit1990@gmail.com';   // Your Gmail
    $mail->Password   = 'ikpc bkky bprh iiwq';      // App Password
    $mail->SMTPSecure = 'tls';
    $mail->Port       = 587;

    // Sender and recipient
    $mail->setFrom('balamuruganit1990@gmail.com', 'Balamurugan');
    $mail->addAddress('shanmugapriyam77@gmail.com', 'Priya');

    // Content
    $mail->isHTML(true);
    $mail->Subject = 'Test Email from GV Info Tech';
    $mail->Body    = 'This is a test email sent from GV Info Tech using PHPMailer and Gmail SMTP.';

    $mail->send();
    echo '? Message has been sent';
} catch (Exception $e) {
    echo "? Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
?>