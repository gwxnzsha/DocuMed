<?php
// updatePatient.php
header('Content-Type: application/json');

// CORS headers
header("Access-Control-Allow-Origin: http://localhost:3003");
header("Access-Control-Allow-Headers: Content-Type");
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
    exit(0);
}

// Include DB connection
include '../db_connect.php';

// Get patient ID from query string
$pr_id = isset($_GET['pr_id']) ? intval($_GET['pr_id']) : 0;
if (!$pr_id) {
    echo json_encode(['success' => false, 'message' => 'Missing patient ID']);
    exit;
}

// Get raw POST data
$input = file_get_contents('php://input');
$data = json_decode($input, true);
if (!$data) {
    echo json_encode(['success' => false, 'message' => 'Invalid JSON input']);
    exit;
}

// Map fields
$pr_lname = $data['pr_lname'] ?? '';
$pr_fname = $data['pr_fname'] ?? '';
$pr_mname = $data['pr_mname'] ?? '';
$pr_addrs = $data['pr_addrs'] ?? '';
$pr_gen   = $data['pr_gen'] ?? '';
$pr_civilstat = $data['pr_civilstat'] ?? '';
$pr_number   = $data['pr_number'] ?? '';

try {
    $sql = "UPDATE patient_record SET 
        pr_lname = :pr_lname,
        pr_fname = :pr_fname,
        pr_mname = :pr_mname,
        pr_addrs = :pr_addrs,
        pr_gen = :pr_gen,
        pr_civilstat = :pr_civilstat,
        pr_number = :pr_number
        WHERE pr_id = :pr_id";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':pr_lname' => $pr_lname,
        ':pr_fname' => $pr_fname,
        ':pr_mname' => $pr_mname,
        ':pr_addrs' => $pr_addrs,
        ':pr_gen' => $pr_gen,
        ':pr_civilstat' => $pr_civilstat,
        ':pr_number' => $pr_number,
        ':pr_id' => $pr_id
    ]);

    echo json_encode(['success' => true]);
} catch (Exception $ex) {
    echo json_encode(['success' => false, 'message' => 'Failed to update patient', 'error' => $ex->getMessage()]);
}
?>
