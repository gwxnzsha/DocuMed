<?php
// addPhysician.php
header('Content-Type: application/json');
header("Access-Control-Allow-Origin: http://localhost:3003");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: POST, OPTIONS");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit(0);
}

include '../db_connect.php';

$input = file_get_contents('php://input');
$data = json_decode($input, true);

if (!$data) {
    echo json_encode(['success' => false, 'message' => 'Invalid JSON']);
    exit;
}

// Map input fields
$ph_name = $data['ph_name'] ?? '';
$ph_fieldofphysician = $data['ph_fieldofphysician'] ?? '';

if (!$ph_name || !$ph_fieldofphysician) {
    echo json_encode(['success' => false, 'message' => 'All fields are required']);
    exit;
}

try {
    $sql = "INSERT INTO physicians (ph_name, ph_fieldofphysician) VALUES (:ph_name, :ph_fieldofphysician)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':ph_name' => $ph_name,
        ':ph_fieldofphysician' => $ph_fieldofphysician
    ]);

    echo json_encode(['success' => true, 'message' => 'Physician added successfully']);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Failed to add physician', 'error' => $e->getMessage()]);
}
?>
