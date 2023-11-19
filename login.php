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

// Get data from the form
$name = $_POST['name'];
$email = $_POST['email'];
$password = $_POST['password'];

// Prepare and execute the SQL query to insert data
$sql = "INSERT INTO user_data (name, email, password) VALUES ('$name', '$email', '$password')";

if ($conn->query($sql) === TRUE) {
    echo "Data inserted successfully.";
    header("Location: index.html");
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// Close the database connection
$conn->close();
?>