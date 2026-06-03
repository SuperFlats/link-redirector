<?php
// Allow only POST requests
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(403);
    exit("Forbidden");
}

// Sanitize inputs
$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
$message = htmlspecialchars($_POST['message'] ?? '');

if (!$email) {
    exit("Invalid email address.");
}

// File where requests are stored
$logFile = "account_deletion_requests.txt";

// Prepare log entry
$entry  = "-----------------------------\n";
$entry .= "Email: {$email}\n";
$entry .= "Message: {$message}\n";
$entry .= "Date: " . date("Y-m-d H:i:s") . "\n";

// Write to file safely
file_put_contents($logFile, $entry, FILE_APPEND | LOCK_EX);

// Redirect user to success page
header("Location: deletion-success.html");
exit;
