<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/vendor/autoload.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Only allow POST method
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: error.html?reason=invalid_method");
    exit;
}

// Required fields
$requiredFields = ['name', 'email', 'message'];
foreach ($requiredFields as $field) {
    if (empty($_POST[$field])) {
        header("Location: error.html?reason=missing_fields");
        exit;
    }
}

// Clean inputs
$userName    = htmlspecialchars(trim($_POST['name']));
$userEmail   = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
$userPhone   = !empty($_POST['phone']) ? htmlspecialchars(trim($_POST['phone'])) : 'Not provided';
$userSubject = !empty($_POST['subject']) ? htmlspecialchars(trim($_POST['subject'])) : 'No subject';
$userMsg     = nl2br(htmlspecialchars(trim($_POST['message'])));

// Validate email format
if (!filter_var($userEmail, FILTER_VALIDATE_EMAIL)) {
    header("Location: error.html?reason=invalid_email");
    exit;
}

$mail = new PHPMailer(true);

try {
    // SMTP Configuration
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'aromaticrootq@gmail.com'; // your Gmail
    $mail->Password   = 'zjxp iegj tbqb zgog';      // your App Password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = 587;
    $mail->CharSet    = 'UTF-8';

    // Set sender & recipient
    $mail->setFrom('aromaticrootq@gmail.com', 'Aromaticroot Queen');
    $mail->addAddress('aromaticrootq@gmail.com');
    $mail->addReplyTo($userEmail, $userName);

    // Subject
    $mail->Subject = "New Contact Form Submission: $userSubject";

    // HTML body (from your local version)
    $mail->isHTML(true);
    $mail->Body = <<<HTML
<html>
<head>
  <style>
    body { font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 20px; }
    .email-box {
      background-color: #ffffff;
      padding: 20px;
      border-radius: 8px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
      max-width: 600px;
      margin: auto;
    }
    h2 {
      color: #2e7d32;
      margin-top: 0;
    }
    p {
      font-size: 14px;
      color: #333;
      margin: 8px 0;
    }
    .footer {
      margin-top: 20px;
      font-size: 12px;
      color: #777;
      text-align: center;
    }
  </style>
</head>
<body>
  <div class="email-box">
    <h2>🌿 New Contact Form Submission</h2>
    <p><strong>Name:</strong> {$userName}</p>
    <p><strong>Email:</strong> {$userEmail}</p>
    <p><strong>Phone:</strong> {$userPhone}</p>
    <p><strong>Subject:</strong> {$userSubject}</p>
    <p><strong>Message:</strong><br>{$userMsg}</p>
    <div class="footer">This message was sent automatically from the contact form on your website.</div>
  </div>
</body>
</html>
HTML;

    // Plain text fallback
    $mail->AltBody = "Name: $userName\nEmail: $userEmail\nPhone: $userPhone\nSubject: $userSubject\nMessage:\n" . strip_tags($userMsg);

    // Send email
    $mail->send();
    header("Location: thankyou.html");
    exit;

} catch (Exception $e) {
    file_put_contents(__DIR__ . '/mail_errors.log', date('Y-m-d H:i:s') . ' - ' . $e->getMessage() . "\n", FILE_APPEND);
    header("Location: error.html?reason=mail_failed");
    exit;
}
?>
