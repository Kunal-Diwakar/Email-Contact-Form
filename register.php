<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["register"])) {
    $errors = [];

    // Check if all required fields are provided
    if (empty($_POST["fullname"]) || empty($_POST["phone"]) || empty($_POST["email"]) || empty($_POST["password"])) {
        $errors[] = "Please fill out all fields.";
    } else {
        // Sanitize input fields
        $fullname = filter_var(trim($_POST["fullname"]), FILTER_SANITIZE_STRING);
        $phone = filter_var(trim($_POST["phone"]), FILTER_SANITIZE_STRING);
        $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
        $password = trim($_POST["password"]);

        // Validate Full Name
        if (!preg_match("/^[a-zA-Z\s]+$/", $fullname)) {
            $errors[] = "Full Name can only contain letters and spaces.";
        }

        // Validate Phone Number
        if (!preg_match("/^\+?[1-9]\d{1,14}$/", $phone)) {
            $errors[] = "Phone Number must be a valid international number, starting with a '+' followed by 10 to 15 digits.";
        }

        // Validate Email Format
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Invalid email format.";
        }

        // Validate Password Strength
        if (strlen($password) < 8) {
            $errors[] = "Password must be at least 8 characters long.";
        } elseif (!preg_match("/[A-Z]/", $password)) {
            $errors[] = "Password must contain at least one uppercase letter.";
        } elseif (!preg_match("/[a-z]/", $password)) {
            $errors[] = "Password must contain at least one lowercase letter.";
        } elseif (!preg_match("/[0-9]/", $password)) {
            $errors[] = "Password must contain at least one number.";
        } elseif (!preg_match("/[\W_]/", $password)) {
            $errors[] = "Password must contain at least one special character.";
        }

        // If there are no validation errors, proceed with registration
        if (empty($errors)) {
            // Set session variable for logged-in user
            $_SESSION["email"] = $email;

            // Redirect to the index page after successful registration
            header("Location: index.html");
            exit(); // Stop further execution
        }
    }
}

// JavaScript code for displaying alert message after successful sign-up
if (isset($_SESSION["email"])) {
    echo "<script>alert('You Have Completed The Sign-up Process !!');</script>";
    unset($_SESSION["email"]); // Remove session variable after displaying the alert
}
?>
