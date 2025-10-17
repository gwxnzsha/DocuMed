<?php
require_once '../cors.php';
require_once '../db_connect.php';
$data = json_decode(file_get_contents('php://input'), true);
if (!$data) { echo json_encode(['success'=>false,'message'=>'No input']); exit; }

try {
    $sql = "INSERT INTO patient_record (pr_user_id, pr_date, pr_lname, pr_fname, pr_mname, pr_addrs, pr_age, pr_gen, pr_number)
            VALUES (1, CURDATE(), ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        $data['pr_lname'] ?? '',
        $data['pr_fname'] ?? '',
        $data['pr_mname'] ?? '',
        $data['pr_addrs'] ?? '',
        $data['pr_age'] ?? 0,
        $data['pr_gen'] ?? '',
        $data['pr_number'] ?? ''
    ]);
    echo json_encode(['success'=>true, 'id' => $pdo->lastInsertId()]);
} catch (Exception $e) {
    echo json_encode(['success'=>false,'message'=>$e->getMessage()]);
}
