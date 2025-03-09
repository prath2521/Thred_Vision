<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Load PHPMailer
//require 'vendor/autoload.php'; // If using Composer
require 'PHPMailer/src/PHPMailer.php';  // Uncomment if manually installed
require 'PHPMailer/src/SMTP.php';
require 'PHPMailer/src/Exception.php';

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name    = htmlspecialchars($_POST['name']);
    $email   = htmlspecialchars($_POST['email']);
    $phone   = htmlspecialchars($_POST['phone']);
    $message = htmlspecialchars($_POST['message']);

    // PHPMailer Configuration
    $mail = new PHPMailer(true);
    
    try {
        // SMTP Configuration
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';  // SMTP server
        $mail->SMTPAuth   = true;
        $mail->Username   = 'prathamkamath25@gmail.com';  // Your Gmail email
        $mail->Password   = 'ftqzjhxaerubqqjv';    // Your Gmail App Password (NOT your Gmail password)
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; 
        $mail->Port       = 587;

        // Sender and Recipient Details
         $mail->setFrom($email, $name);  // Sender's email and name
        $mail->addAddress('prathamkamath25@gmail.com', 'Recipient Name'); // Admin Email

        // Email Content
        $mail->isHTML(true);
        $mail->Subject = "New Contact Form Submission";
        $mail->Body    = "
            <h2>New Contact Form Submission</h2>
            <p><strong>Name:</strong> $name</p>
            <p><strong>Email:</strong> $email</p>
            <p><strong>Phone:</strong> $phone</p>
            <p><strong>Message:</strong> $message</p>
        ";
        
        // Send Email
        $mail->send();
        echo json_encode(["status" => "success", "message" => "Thank you! Your message has been sent successfully."]);
    } catch (Exception $e) {
        echo "Mailer Error: " . $mail->ErrorInfo; // Show actual error message
    }
    
} else {
    echo json_encode(["status" => "error", "message" => "Invalid request."]);
}
?>
