<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

// Database connection
$host = "localhost";
$user = "root";  // adjust if needed
$pass = "";      // adjust if needed
$db   = "patientrecord";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode([
        "success" => false,
        "message" => "Failed to connect to database",
        "error" => $conn->connect_error
    ]);
    exit();
}

// Fetch all wards
$sql = "SELECT w_id AS id, w_name AS name FROM wards ORDER BY w_name ASC";
$result = $conn->query($sql);

$wards = [];
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $wards[] = $row;
    }
    echo json_encode([
        "success" => true,
        "wards" => $wards
    ]);
} else {
    http_response_code(500);
    echo json_encode([
        "success" => false,
        "message" => "Failed to fetch wards",
        "error" => $conn->error
    ]);
}

$conn->close();
