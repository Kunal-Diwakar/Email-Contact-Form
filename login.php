<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if email and password are provided
    if (empty($_POST["email"]) || empty($_POST["password"])) {
        $error = "Please enter both email and password.";
    } else {
        // Sanitize email input
        $email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);

        // Validate email format
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error = "Invalid email format.";
        } else {
            // Verify credentials (replace with your database logic)
            $valid_email = "user@example.com";
            $valid_password = "password";

            if ($_POST["email"] === $valid_email && $_POST["password"] === $valid_password) {
                // Set session variables
                $_SESSION["email"] = $email;

                // Redirect to dashboard or another page
                header("Location: index.html");
                exit();
            } else {
                $error = "Invalid email or password.";
            }
        }
    }
}
?>
