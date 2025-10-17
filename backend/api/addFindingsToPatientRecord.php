<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: POST, OPTIONS");

// Handle preflight
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

include '../db_connect.php';

// Get POSTed JSON
$input = file_get_contents('php://input');
$data = json_decode($input, true);

if (!$data || !isset($data['patients'])) {
    echo json_encode(['success' => false, 'message' => 'No patients received']);
    exit;
}

$patients = $data['patients'];
$inserted = 0;

try {
    $sql = "INSERT INTO patient_record 
        (pr_user_id, pr_fname, pr_mname, pr_lname, pr_gen, pr_age, pr_date)
        VALUES (:pr_user_id, :pr_fname, :pr_mname, :pr_lname, :pr_gen, :pr_age, :pr_date)";
    $stmt = $pdo->prepare($sql);

    foreach ($patients as $p) {
        $stmt->execute([
            ':pr_user_id' => $p['a_user_id'] ?? 0,
            ':pr_fname'   => $p['a_fname'] ?? '',
            ':pr_mname'   => $p['a_mname'] ?? '',
            ':pr_lname'   => $p['a_lname'] ?? '',
            ':pr_gen'     => $p['a_gender'] ?? '',
            ':pr_age'     => $p['a_age'] ?? 0,
            ':pr_date'    => $p['a_date'] ?? date('Y-m-d')
        ]);
        $inserted++;
    }

    echo json_encode(['success' => true, 'message' => "$inserted patient(s) added successfully"]);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Failed to add patients', 'error' => $e->getMessage()]);
}
?>
