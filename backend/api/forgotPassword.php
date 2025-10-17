<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: POST");

require_once("../db_connect.php");

$data = json_decode(file_get_contents("php://input"));
$username = trim($data->username ?? "");

if (!$username) {
    echo json_encode(["status" => "error", "message" => "Username is required"]);
    exit;
}

try {
    // Check if the user exists
    $stmt = $pdo->prepare("SELECT * FROM standardusers WHERE su_user = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        // Reset password to default
        $newPass = "DocuMed123";
        $hashed = password_hash($newPass, PASSWORD_BCRYPT);

        $update = $pdo->prepare("UPDATE standardusers SET su_pass = ? WHERE su_user = ?");
        $update->execute([$hashed, $username]);

        echo json_encode([
            "status" => "success",
            "message" => "Password reset to default: DocuMed123"
        ]);
    } else {
        echo json_encode(["status" => "error", "message" => "Username not found"]);
    }
} catch (Exception $e) {
    echo json_encode(["status" => "error", "message" => "Database error"]);
}
?>
