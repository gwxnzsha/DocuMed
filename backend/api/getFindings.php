<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

require_once("../db_connect.php");

// Make sure to use the same parameter name from React
$pr_id = isset($_GET['pr_id']) ? intval($_GET['pr_id']) : 0;

if ($pr_id <= 0) {
    echo json_encode([]);
    exit;
}

try {
    // f_pr is the foreign key to patient_record.pr_id
    $stmt = $pdo->prepare("SELECT * FROM findings WHERE f_pr = ?");
    $stmt->execute([$pr_id]);
    $findings = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($findings);
} catch (Exception $e) {
    echo json_encode([
        "error" => true,
        "message" => $e->getMessage()
    ]);
}
?>
