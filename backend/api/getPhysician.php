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

// Fetch all physicians
$sql = "SELECT ph_id AS id, ph_name AS name, ph_fieldofphysician AS field, date_added FROM physicians ORDER BY ph_name ASC";
$result = $conn->query($sql);

$physicians = [];
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $physicians[] = $row;
    }
    echo json_encode([
        "success" => true,
        "physicians" => $physicians
    ]);
} else {
    http_response_code(500);
    echo json_encode([
        "success" => false,
        "message" => "Failed to fetch physicians",
        "error" => $conn->error
    ]);
}

$conn->close();
