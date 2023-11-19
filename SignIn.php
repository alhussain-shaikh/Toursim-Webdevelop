<?php
// Replace with your actual database credentials
$host = "localhost";
$username = "root";
$password = "040703";
$dbname = "web";

// Create a database connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get user input from the form
$email = $_POST['email'];
$password = $_POST['password'];

// Hash the password for comparison using bcrypt
$hashedPassword = password_hash($password, PASSWORD_BCRYPT);

// Prepare and execute the SQL query to check user credentials
$sql = "SELECT * FROM users WHERE email = '$email'";
$result = $conn->query($sql);

if ($result->num_rows == 1) {
    // Fetch the stored hashed password from the database
    $row = $result->fetch_assoc();
    $storedHashedPassword = $row['password']; // Corrected this line

    // Verify the password using password_verify
    if (password_verify($password, $storedHashedPassword)) {
        echo "Login successful!";
        header("Location: index.html");
        // Perform necessary actions after successful login
    } else {
        echo "Invalid email or password.";
    }
} else {
    echo "Invalid email or password.";
}

// Close the database connection
$conn->close();
?>
