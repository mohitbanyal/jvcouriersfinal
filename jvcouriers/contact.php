<?php
// Start session if needed
session_start();

// Your email address where messages will be sent
$to_email = "jvcouriersltd@gmail.com"; // Replace with your email
$subject = "New Contact Form Submission";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Collect form data
    $name    = htmlspecialchars(trim($_POST['name']));
    $email   = htmlspecialchars(trim($_POST['email']));
    $phone   = htmlspecialchars(trim($_POST['phone']));
    $message = htmlspecialchars(trim($_POST['message']));

    // CAPTCHA validation
    $user_captcha = isset($_POST['captcha']) ? (int)$_POST['captcha'] : 0;
    $correct_captcha = isset($_POST['captcha_answer']) ? (int)$_POST['captcha_answer'] : 0;

    if ($user_captcha !== $correct_captcha) {
        echo "<script>alert('Incorrect CAPTCHA answer. Please try again.'); window.history.back();</script>";
        exit;
    }

    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert('Invalid email address.'); window.history.back();</script>";
        exit;
    }

    // Prepare email headers
    $headers = "From: $name <$email>" . "\r\n";
    $headers .= "Reply-To: $email" . "\r\n";
    $headers .= "Content-Type: text/html; charset=UTF-8" . "\r\n";

    // Email body
    $body = "
    <h2>New Contact Form Submission</h2>
    <p><strong>Name:</strong> $name</p>
    <p><strong>Email:</strong> $email</p>
    <p><strong>Phone:</strong> $phone</p>
    <p><strong>Message:</strong><br>$message</p>
    ";

    // Send the email
    if (mail($to_email, $subject, $body, $headers)) {
        echo "<script>alert('Message sent successfully!'); window.location.href='index.html';</script>";
    } else {
        echo "<script>alert('Failed to send message. Please try again later.'); window.history.back();</script>";
    }

} else {
    // Not a POST request
    echo "<script>alert('Invalid request.'); window.location.href='index.html';</script>";
}
?>
