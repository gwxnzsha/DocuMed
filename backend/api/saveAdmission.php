<?php
// Always allow React origin
header("Access-Control-Allow-Origin: http://localhost:3003");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

// Handle preflight OPTIONS request
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}



// Include DB
include '../db_connect.php';

// Enable errors for debugging
ini_set('display_errors', 1);
error_reporting(E_ALL);

$data = json_decode(file_get_contents('php://input'), true);

// Validate required field
if (!$data || empty($data['pr_admission_id'])) {
    echo json_encode(['success' => false, 'message' => 'Invalid input: pr_admission_id is required']);
    exit;
}

// Map fields
$pr_admission_id      = $data['pr_admission_id'];
$ad_wardname          = $data['ward'] ?? '';
$ad_admittedby        = $data['admittedBy'] ?? '';
$ad_physician         = $data['physician'] ?? '';
$ad_father            = $data['father'] ?? '';
$ad_mother            = $data['mother'] ?? '';
$ad_chargetoaccount   = $data['chargeAccount'] ?? '';
$ad_relationtopatient = $data['relation'] ?? '';
$ad_address           = $data['address'] ?? '';
$ad_number            = $data['number'] ?? '';
$ad_totalpayment      = $data['totalPayment'] ?? '';
$ad_date              = date('Y-m-d');
$ad_dischargedate     = '';
$ad_complaint         = '';
$ad_completediagnosis = '';
$ad_medication        = '';
$ad_conditiontodischarge = '';
$ad_remarks           = '';

// Insert
$sql = "INSERT INTO admission_record 
(ad_wardname, ad_date, ad_admittedby, pr_admission_id, ad_physician, ad_father, ad_mother,
 ad_chargetoaccount, ad_relationtopatient, ad_address, ad_number, ad_totalpayment,
 ad_dischargedate, ad_complaint, ad_completediagnosis, ad_medication, ad_conditiontodischarge, ad_remarks)
 VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("sssissssssssssssss", 
    $ad_wardname, $ad_date, $ad_admittedby, $pr_admission_id, $ad_physician,
    $ad_father, $ad_mother, $ad_chargetoaccount, $ad_relationtopatient,
    $ad_address, $ad_number, $ad_totalpayment, $ad_dischargedate,
    $ad_complaint, $ad_completediagnosis, $ad_medication,
    $ad_conditiontodischarge, $ad_remarks
);

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => $stmt->error]);
}

$stmt->close();
$conn->close();
?>
