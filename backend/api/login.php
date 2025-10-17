<?php
require_once '../cors.php';
require_once '../db_connect.php';
$data = json_decode(file_get_contents('php://input'), true);
$username = $data['username'] ?? '';
$password = $data['password'] ?? '';

try {
    $stmt = $pdo->prepare("SELECT * FROM standardusers WHERE su_user = ? LIMIT 1");
    $stmt->execute([$username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$user) {
        echo json_encode(['success'=>false,'message'=>'User not found']);
        exit;
    }

    if (password_verify($password, $user['su_pass'])) {
        echo json_encode(['success'=>true, 'user' => [
            'id' => $user['su_id'], 'name' => $user['su_fname'], 'position' => $user['su_position']
        ]]);
    } else {
        echo json_encode(['success'=>false,'message'=>'Invalid credentials']);
    }

} catch (Exception $e) {
    echo json_encode(['success'=>false,'message'=>$e->getMessage()]);
}
