<?php
// addOutPatient.php
header('Content-Type: application/json');

// Allow React app origin
header("Access-Control-Allow-Origin: http://localhost:3003");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: POST, OPTIONS");

// Preflight request handling
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit(0);
}

include '../db_connect.php';

// Get POSTed JSON
$input = file_get_contents('php://input');
$data = json_decode($input, true);

if (!$data) {
    echo json_encode(['success' => false, 'message' => 'Invalid JSON']);
    exit;
}

// Map fields
$a_user_id = $data['a_user_id'] ?? 0;
$a_case_number = $data['a_case_number'] ?? 0;
$a_fname = $data['a_fname'] ?? '';
$a_mname = $data['a_mname'] ?? '';
$a_lname = $data['a_lname'] ?? '';
$a_gender = $data['a_gender'] ?? '';
$a_age = $data['a_age'] ?? 0;
$a_complaint = $data['a_complaint'] ?? '';
$a_historypresentillness = $data['a_historypresentillness'] ?? '';
$a_bp = $data['a_bp'] ?? '';
$a_rr = $data['a_rr'] ?? '';
$a_cr = $data['a_cr'] ?? '';
$a_temp = $data['a_temp'] ?? '';
$a_wt = $data['a_wt'] ?? '';
$a_pr = $data['a_pr'] ?? '';
$a_physicalexam = $data['a_physicalexam'] ?? '';
$a_diagnosis = $data['a_diagnosis'] ?? '';
$a_medication = $data['a_medication'] ?? '';
$a_physician_id = $data['a_physician_id'] ?? 0;
$a_date = $data['a_date'] ?? date('Y-m-d');
$status = 1;

$a_addrs = $data['a_addrs'] ?? '';
$a_bdate = $data['a_bdate'] ?? '';
$a_bplace = $data['a_bplace'] ?? '';
$a_civilstat = $data['a_civilstat'] ?? '';
$a_religion = $data['a_religion'] ?? '';
$a_occup = $data['a_occup'] ?? '';

try {
    $sql = "INSERT INTO add_patientfindings (
                a_user_id, a_case_number, a_fname, a_mname, a_lname, a_gender, a_age,
                a_complaint, a_historypresentillness, a_bp, a_rr, a_cr,
                a_temp, a_wt, a_pr, a_physicalexam, a_diagnosis,
                a_medication, a_physician_id, a_date, status,
                a_addrs, a_bdate, a_bplace, a_civilstat, a_religion, a_occup
            ) VALUES (
                :a_user_id, :a_case_number, :a_fname, :a_mname, :a_lname, :a_gender, :a_age,
                :a_complaint, :a_historypresentillness, :a_bp, :a_rr, :a_cr,
                :a_temp, :a_wt, :a_pr, :a_physicalexam, :a_diagnosis,
                :a_medication, :a_physician_id, :a_date, :status,
                :a_addrs, :a_bdate, :a_bplace, :a_civilstat, :a_religion, :a_occup
            )";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([

        ':a_user_id' => $a_user_id,
        ':a_case_number' => $a_case_number,
        ':a_fname' => $a_fname,
        ':a_mname' => $a_mname,
        ':a_lname' => $a_lname,
        ':a_gender' => $a_gender,
        ':a_age' => $a_age,
        ':a_complaint' => $a_complaint,
        ':a_historypresentillness' => $a_historypresentillness,
        ':a_bp' => $a_bp,
        ':a_rr' => $a_rr,
        ':a_cr' => $a_cr,
        ':a_temp' => $a_temp,
        ':a_wt' => $a_wt,
        ':a_pr' => $a_pr,
        ':a_physicalexam' => $a_physicalexam,
        ':a_diagnosis' => $a_diagnosis,
        ':a_medication' => $a_medication,
        ':a_physician_id' => $a_physician_id,
        ':a_date' => $a_date,
        ':status' => $status,
        ':a_addrs' => $a_addrs,
        ':a_bdate' => $a_bdate,
        ':a_bplace' => $a_bplace,
        ':a_civilstat' => $a_civilstat,
        ':a_religion' => $a_religion,
        ':a_occup' => $a_occup
    ]);

    echo json_encode(['success' => true, 'message' => 'Record added successfully']);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Failed to add record', 'error' => $e->getMessage()]);
}
?>
