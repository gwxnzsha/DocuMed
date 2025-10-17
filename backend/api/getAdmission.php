<?php
header('Content-Type: application/json');
header("Access-Control-Allow-Origin: http://localhost:3003"); // your React app
header("Access-Control-Allow-Methods: GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit(0);
}

include '../db_connect.php';

$patientId = $_GET['patientId'] ?? 0;

if (!$patientId) {
    echo json_encode(['success' => false, 'message' => 'Patient ID is required']);
    exit;
}

try {
    $stmt = $pdo->prepare("SELECT * FROM add_patientadmission WHERE pr_id = :pr_id LIMIT 1");
    $stmt->execute([':pr_id' => $patientId]);
    $admission = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($admission) {
        echo json_encode(['success' => true, 'admission' => $admission]);
    } else {
        echo json_encode(['success' => true, 'admission' => null]);
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
?>
