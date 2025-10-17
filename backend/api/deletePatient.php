<?php
require_once '../cors.php';
require_once '../db_connect.php';
$data = json_decode(file_get_contents('php://input'), true);
$id = $data['id'] ?? null;
if (!$id) { echo json_encode(['success'=>false,'message'=>'Missing id']); exit; }

try {
    $stmt = $pdo->prepare("DELETE FROM patient_record WHERE pr_id = ?");
    $stmt->execute([$id]);
    echo json_encode(['success'=>true]);
} catch (Exception $e) {
    echo json_encode(['success'=>false,'message'=>$e->getMessage()]);
}
