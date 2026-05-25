<?php
// Database connection
$host = 'localhost';
$user = 'root';
$password = '';
$database = 'real_estate';

$conn = new mysqli($host, $user, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
session_start(); // Start a session to store messages

// Input validation
if (empty($_POST["fullname"])) {
    $_SESSION['error'] = "Full name is required";
    header("Location: registration.php"); // Redirect back to the registration page
    exit;
}

if (empty($_POST["username"])) {
    $_SESSION['error'] = "Username is required";
    header("Location: registration.php"); // Redirect back to the registration page
    exit;
}

// Username should only contain letters, numbers, or underscores
if (!preg_match("/^[a-zA-Z0-9_]+$/", $_POST["username"])) {
    $_SESSION['error'] = "Username should not contain special characters";
    header("Location: registration.php"); // Redirect back to the registration page
    exit;
}

if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
    $_SESSION['error'] = "Valid email is required";
    header("Location: registration.php"); // Redirect back to the registration page
    exit;
}

// Password length must be between 8 and 16 characters
if (strlen($_POST["password"]) < 8 || strlen($_POST["password"]) > 16) {
    $_SESSION['error'] = "Password must be between 8 and 16 characters";
    header("Location: registration.php"); // Redirect back to the registration page
    exit;
}

// Password must contain at least one number and one letter
if (!preg_match("/[0-9]/", $_POST["password"]) || !preg_match("/[a-zA-Z]/", $_POST["password"])) {
    $_SESSION['error'] = "Invalid user password";
    header("Location: registration.php"); // Redirect back to the registration page
    exit;
}

// Check if passwords match
if ($_POST["password"] !== $_POST["password_confirmation"]) {
    $_SESSION['error'] = "Passwords must match";
    header("Location: registration.php"); // Redirect back to the registration page
    exit;
}

// Hash the password
$password_hash = password_hash($_POST["password"], PASSWORD_DEFAULT);

// Database connection
$mysqli = require _DIR_ . "/connection.php";

$sql = "INSERT INTO user_data (fullname, username, email, number, password_hash)
        VALUES (?, ?, ?, ?, ?)";

$stmt = $mysqli->stmt_init();

if (!$stmt->prepare($sql)) {
    $_SESSION['error'] = "SQL error: " . $mysqli->error;
    header("Location: registration.php"); // Redirect back to the registration page
    exit;
}

$stmt->bind_param(
    "sssss",
    $_POST["fullname"],
    $_POST["username"],
    $_POST["email"],
    $_POST["number"],
    $password_hash
);

if ($stmt->execute()) {
    $_SESSION['success'] = "Registration successful!";
    header("Location: registration-success.html"); // Redirect to success page
    exit;
} else {
    if ($mysqli->errno === 1062) {
        $_SESSION['error'] = "Email already taken";
    } else {
        $_SESSION['error'] = $mysqli->error . " " . $mysqli->errno;
    }
    header("Location: registration.php"); // Redirect back to the registration page
    exit;
}