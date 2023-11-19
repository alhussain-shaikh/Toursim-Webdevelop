<?php
session_start();

$email = $_POST['email'];
$password = $_POST['password'];

$conn = new mysqli('localhost:3306', 'root', '040703', 'wonderlust');
if ($conn->connect_error) {
    die("Connection Failed: " . $conn->connect_error);
}

$stmt = $conn->prepare("SELECT * FROM admin WHERE email=? AND password=?");
if (!$stmt) {
    die("Error in statement preparation: " . $conn->error);
}

$stmt->bind_param("ss", $email, $password);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 1) {
    // Valid credentials, redirect to dashboard.html
    header("Location: dashboard.html");
    exit();
} else {
    // Invalid credentials, redirect back to login page
    header("Location: sign-in.html"); // Assuming your login page is named login.html
    exit();
}

$stmt->close();
$conn->close();
?>
