<?php
// addPatientAdmission.php
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

$pr_id = $data['pr_id'] ?? 0; // This links admission to a patient



// Map fields from input
$a_user_id = $data['a_user_id'] ?? 0;
$a_wardname = $data['a_wardname'] ?? '';
$a_date = $data['a_date'] ?? date('Y-m-d');
$a_admittedby = $data['a_admittedby'] ?? '';
$a_fname = $data['a_fname'] ?? '';
$a_mname = $data['a_mname'] ?? '';
$a_lname = $data['a_lname'] ?? '';
$a_gender = $data['a_gender'] ?? '';
$a_age = $data['a_age'] ?? '';
$a_physician_id = $data['a_physician_id'] ?? '';
$a_father = $data['a_father'] ?? '';
$a_mother = $data['a_mother'] ?? '';
$a_chargetoaccount = $data['a_chargetoaccount'] ?? '';
$a_relationtopatient = $data['a_relationtopatient'] ?? '';
$a_address = $data['a_address'] ?? '';
$a_number = $data['a_number'] ?? '';
$a_totalpayment = $data['a_totalpayment'] ?? '';
$a_dischargedate = $data['a_dischargedate'] ?? null;
$a_complaint = $data['a_complaint'] ?? '';
$a_completediagnosis = $data['a_completediagnosis'] ?? '';
$a_medication = $data['a_medication'] ?? '';
$a_conditiontodischarge = $data['a_conditiontodischarge'] ?? '';
$a_remarks = $data['a_remarks'] ?? '';
$log_time = date('Y-m-d H:i:s');

try {
   $sql = "INSERT INTO add_patientadmission (
            pr_id, a_wardname, a_date, a_admittedby,
            a_fname, a_mname, a_lname, a_gender, a_age, a_physician_id,
            a_father, a_mother, a_chargetoaccount, a_relationtopatient, a_address, a_number,
            a_totalpayment, a_dischargedate, a_complaint, a_completediagnosis, a_medication,
            a_conditiontodischarge, a_remarks, log_time
        ) VALUES (
            :pr_id, :a_wardname, :a_date, :a_admittedby,
            :a_fname, :a_mname, :a_lname, :a_gender, :a_age, :a_physician_id,
            :a_father, :a_mother, :a_chargetoaccount, :a_relationtopatient, :a_address, :a_number,
            :a_totalpayment, :a_dischargedate, :a_complaint, :a_completediagnosis, :a_medication,
            :a_conditiontodischarge, :a_remarks, :log_time
        )";

$stmt = $pdo->prepare($sql);
$stmt->execute([
    ':pr_id' => $pr_id,
    ':a_wardname' => $a_wardname,
    ':a_date' => $a_date,
    ':a_admittedby' => $a_admittedby,
    ':a_fname' => $a_fname,
    ':a_mname' => $a_mname,
    ':a_lname' => $a_lname,
    ':a_gender' => $a_gender,
    ':a_age' => $a_age,
    ':a_physician_id' => $a_physician_id,
    ':a_father' => $a_father,
    ':a_mother' => $a_mother,
    ':a_chargetoaccount' => $a_chargetoaccount,
    ':a_relationtopatient' => $a_relationtopatient,
    ':a_address' => $a_address,
    ':a_number' => $a_number,
    ':a_totalpayment' => $a_totalpayment,
    ':a_dischargedate' => $a_dischargedate,
    ':a_complaint' => $a_complaint,
    ':a_completediagnosis' => $a_completediagnosis,
    ':a_medication' => $a_medication,
    ':a_conditiontodischarge' => $a_conditiontodischarge,
    ':a_remarks' => $a_remarks,
    ':log_time' => $log_time
]);


    echo json_encode(['success' => true, 'message' => 'Admission record added successfully']);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Failed to add admission record', 'error' => $e->getMessage()]);
}
?>
