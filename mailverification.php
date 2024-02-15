<?php
// Import PHPMailer classes into the global namespace
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader
require 'phpmailer/Exception.php';
require 'phpmailer/PHPMailer.php';
require 'phpmailer/SMTP.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $name = $_POST["fname"] . " " . $_POST["lname"];
    $email = $_POST["email"];
    $mobile = $_POST["mobile"];
    
    // Check if the amount is other or predefined
    if ($_POST["amount"] == "other") {
        $amount = $_POST["customAmount"]; // If the amount is custom, fetch it from customAmount field
    } else {
        $amount = $_POST["amount"]; // Otherwise, get the predefined amount
    }

    // Create an instance of PHPMailer
    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP();                                  // Send using SMTP
        $mail->Host       = 'smtp.gmail.com';             // Set the SMTP server to send through
        $mail->SMTPAuth   = true;                         // Enable SMTP authentication
        $mail->Username   = 'adityashrivastava6781@gmail.com';   // SMTP username
        $mail->Password   = 'aelc pkej wuzv psjd';             // SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;  // Enable implicit TLS encryption
        $mail->Port       = 465;                          // TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        // Recipients
        $mail->setFrom('adityashrivastava6781@gmail.com', 'meri company');
        $mail->addAddress($email, $name);  // Add a recipient email address
        // $mail->addAddress('prospectbpl@gmail.com'); // Optional

        // Content  
        $mail->isHTML(true);                         // Set email format to HTML
        $mail->Subject = "Heartfelt Thanks for Your Donation $name";
        $mail->Body    = "Dear $name,

        Thank you sincerely for your donation of ₹ $amount.
        Your support enables us to Prospect Education and Social Welfare Society. 
        We are immensely grateful for your generosity.
        
        Warm regards,
        Prospect Family";

        // Send email
        $mail->send();
        echo "Email verification sent.";
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}
?>
