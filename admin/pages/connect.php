<?php
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Database connection
    $conn = new mysqli('localhost:3306', 'root', '040703', 'wonderlust');
    if($conn->connect_error){
        die("Connection Failed: " . $conn->connect_error);
    } else {
        $stmt = $conn->prepare("INSERT INTO admin (name, email, password) VALUES (?, ?, ?)");
        if (!$stmt) {
            die("Error in statement preparation: " . $conn->error);
        }
        $stmt->bind_param("sss", $name, $email, $password);
        $execval = $stmt->execute();
        if (!$execval) {
            die("Error in statement execution: " . $stmt->error);
        }
        header("Location: dashboard.html");
        exit(); // Make sure to exit after a header redirect

        $stmt->close();
        $conn->close();
    }
?>
