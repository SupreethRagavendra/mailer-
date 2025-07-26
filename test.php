<?php
require __DIR__ . '/vendor/autoload.php';
echo class_exists('PHPMailer\PHPMailer\PHPMailer') ? "✅ PHPMailer is loaded!" : "❌ PHPMailer NOT loaded!";
