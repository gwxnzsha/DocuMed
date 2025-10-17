<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

require_once("../db_connect.php");

try {
    // Get pr_id from query string if provided
    $pr_id = isset($_GET['pr_id']) ? intval($_GET['pr_id']) : null;

    if ($pr_id) {
        // Fetch single patient
        $stmt = $pdo->prepare("
            SELECT * 
            FROM patient_record 
            WHERE pr_id = ?
        ");
        $stmt->execute([$pr_id]);
        $patient = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($patient) {
            echo json_encode($patient);
        } else {
            echo json_encode([
                "error" => true,
                "message" => "Patient not found"
            ]);
        }
    } else {
        // Fetch all patients
        $stmt = $pdo->query("SELECT * FROM patient_record");
        $patients = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($patients ?: []);
    }
} catch (Exception $e) {
    echo json_encode([
        "error" => true,
        "message" => $e->getMessage()
    ]);
}
?>
