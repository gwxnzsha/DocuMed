<?php
header('Content-Type: application/json');
header("Access-Control-Allow-Origin: http://localhost:3003");

include '../db_connect.php';

try {
    $stmt = $pdo->query("SELECT su_id, su_user, su_fname, su_position, date_created FROM standardusers ORDER BY su_id DESC");
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode(['success' => true, 'users' => $users]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Failed to fetch users', 'error' => $e->getMessage()]);
}
?>
