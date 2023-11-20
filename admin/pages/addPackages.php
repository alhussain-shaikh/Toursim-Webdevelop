<?php
// Establish a connection to your MySQL database
$servername = "localhost:3307";
$username = "root";
$password = "";
$dbname = "wanderlust";

$conn = new mysqli('localhost:3307', 'root', '', 'wanderlust');

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate input data
    $adminId = filter_input(INPUT_POST, 'adminId', FILTER_VALIDATE_INT);
    $packageName = filter_input(INPUT_POST, 'packageName', FILTER_SANITIZE_STRING);
    $city = filter_input(INPUT_POST, 'city', FILTER_SANITIZE_STRING);
    $state = filter_input(INPUT_POST, 'state', FILTER_SANITIZE_STRING);
    $duration = filter_input(INPUT_POST, 'duration', FILTER_VALIDATE_INT);
    $price = filter_input(INPUT_POST, 'price', FILTER_VALIDATE_FLOAT);

    // Ensure that required fields are present and valid
if ($adminId && $packageName && $city && $state && $duration !== false && $price !== false) {
    // Insert into packages table
    $stmtPackages = $connection->prepare("INSERT INTO packages (id, packageName, city, state, duration, price) VALUES (?, ?, ?, ?, ?, ?)");
    $stmtPackages->bind_param("isssid", $adminId, $packageName, $city, $state, $duration, $price);
    $stmtPackages->execute();
    $pid = $stmtPackages->insert_id;

    // Insert into hotel_info table
    if (isset($_POST['hotelStay'])) {
        $hotelName = filter_input(INPUT_POST, 'hotelName', FILTER_SANITIZE_STRING);
        $checkIn = filter_input(INPUT_POST, 'checkIn', FILTER_SANITIZE_STRING);
        $checkOut = filter_input(INPUT_POST, 'checkOut', FILTER_SANITIZE_STRING);
        $hotelLoc = filter_input(INPUT_POST, 'hotelLoc', FILTER_SANITIZE_STRING);
        $mealsIncluded = isset($_POST['mealsIncluded']) ? 1 : 0; // Assuming it's a checkbox

        $stmtHotel = $connection->prepare("INSERT INTO hotel_info (pid, hotelName, checkInTime, checkOutTime, hotelLoc, mealsIncluded) VALUES (?, ?, ?, ?, ?, ?)");
        $stmtHotel->bind_param("issssi", $pid, $hotelName, $checkIn, $checkOut, $hotelLoc, $mealsIncluded);
        $stmtHotel->execute();
        // Additional logic or error handling here
    }

    // Insert into tour_info table
    if (isset($_POST['tourItinerary'])) {
        $itineraryName = filter_input(INPUT_POST, 'itineraryName', FILTER_SANITIZE_STRING);
        $start = filter_input(INPUT_POST, 'start', FILTER_SANITIZE_STRING);
        $end = filter_input(INPUT_POST, 'end', FILTER_SANITIZE_STRING);
        $tourLoc = filter_input(INPUT_POST, 'tourLoc', FILTER_SANITIZE_STRING);
        $tourDesc = filter_input(INPUT_POST, 'tourDesc', FILTER_SANITIZE_STRING);
        $refreshMnt = isset($_POST['refreshMnt']) ? 1 : 0; // Assuming it's a checkbox

        $stmtTour = $connection->prepare("INSERT INTO tour_info (pid, itineraryName, startTime, endTime, tourLoc, tourDesc, refreshMnt) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmtTour->bind_param("isssssi", $pid, $itineraryName, $start, $end, $tourLoc, $tourDesc, $refreshMnt);
        $stmtTour->execute();
        // Additional logic or error handling here
    }
    echo "Records inserted successfully";
    // Redirect or display success message
} else {
    // Handle invalid or missing data
    echo "Error: " . $sql . "<br>" . $conn->error;
}
}
// Close the connection
$conn->close();
?>
