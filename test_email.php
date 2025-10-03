<?php
require __DIR__ . '/vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

echo "<h2>Email Configuration Test</h2>";

// Test 1: Check if PHPMailer is loaded
echo "<h3>1. PHPMailer Check</h3>";
if (class_exists('PHPMailer\PHPMailer\PHPMailer')) {
    echo "✅ PHPMailer is loaded successfully<br>";
} else {
    echo "❌ PHPMailer NOT loaded<br>";
    exit;
}

// Test 2: Test SMTP connection
echo "<h3>2. SMTP Connection Test</h3>";
$mail = new PHPMailer(true);

try {
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'aromaticrootq@gmail.com';
    $mail->Password = 'gdve sulq ofjv koun';
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;
    $mail->SMTPDebug = 2;
    $mail->Debugoutput = 'html';
    
    echo "Attempting to connect to Gmail SMTP...<br>";
    $mail->smtpConnect();
    echo "✅ SMTP connection successful!<br>";
    $mail->smtpClose();
    
} catch (Exception $e) {
    echo "❌ SMTP connection failed: " . $e->getMessage() . "<br>";
}

// Test 3: Check PHP extensions
echo "<h3>3. PHP Extensions Check</h3>";
$required_extensions = ['openssl', 'curl', 'mbstring'];
foreach ($required_extensions as $ext) {
    if (extension_loaded($ext)) {
        echo "✅ $ext extension is loaded<br>";
    } else {
        echo "❌ $ext extension is NOT loaded<br>";
    }
}

// Test 4: Check file permissions
echo "<h3>4. File Permissions Check</h3>";
$log_file = __DIR__ . '/mail_errors.log';
if (is_writable(__DIR__)) {
    echo "✅ Directory is writable<br>";
} else {
    echo "❌ Directory is NOT writable<br>";
}

echo "<br><a href='index.html'>Back to Contact Form</a>";
?>