<?php
// addUser.php
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
$su_user = $data['su_user'] ?? '';
$su_pass = $data['su_pass'] ?? '';
$su_fname = $data['su_fname'] ?? '';
$su_position = $data['su_position'] ?? '';
$date_created = date('Y-m-d H:i:s');

if (!$su_user || !$su_pass || !$su_fname || !$su_position) {
    echo json_encode(['success' => false, 'message' => 'All fields are required']);
    exit;
}

// Hash password
$hashed_pass = password_hash($su_pass, PASSWORD_BCRYPT);

try {
    $sql = "INSERT INTO standardusers (su_user, su_pass, su_fname, su_position, date_created) 
            VALUES (:su_user, :su_pass, :su_fname, :su_position, :date_created)";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':su_user' => $su_user,
        ':su_pass' => $hashed_pass,
        ':su_fname' => $su_fname,
        ':su_position' => $su_position,
        ':date_created' => $date_created
    ]);

    echo json_encode(['success' => true, 'message' => 'User added successfully']);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Failed to add user', 'error' => $e->getMessage()]);
}
?>
