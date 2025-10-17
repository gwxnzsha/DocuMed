<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

$host = "localhost";
$user = "root";
$pass = "";
$db   = "patientrecord";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    echo json_encode(["success" => false, "message" => "Database connection failed"]);
    exit();
}

// ✅ Check if frontend sent a specific a_case_number (for single patient findings)
$a_case_number = isset($_GET['a_case_number']) ? $_GET['a_case_number'] : null;

if ($a_case_number) {
    // 🔍 Fetch findings for a specific patient case
    $sql = "SELECT 
                apf.a_id,
                apf.a_case_number,
                su.su_user AS username,
                apf.a_fname,
                apf.a_mname,
                apf.a_lname,
                apf.a_gender,
                apf.a_age,
                apf.a_complaint,
                apf.a_historypresentillness,
                apf.a_bp,
                apf.a_rr,
                apf.a_cr,
                apf.a_temp,
                apf.a_wt,
                apf.a_pr,
                apf.a_physicalexam,
                apf.a_diagnosis,
                apf.a_medication,
                ph.ph_name AS physician_name,
                apf.a_date,
                apf.log_time
            FROM add_patientfindings apf
            LEFT JOIN standardusers su ON apf.a_user_id = su.su_id
            LEFT JOIN physicians ph ON apf.a_physician_id = ph.ph_id
            WHERE apf.a_case_number = ?
            ORDER BY apf.log_time DESC";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $a_case_number);
    $stmt->execute();
    $result = $stmt->get_result();

    $records = [];
    while ($row = $result->fetch_assoc()) {
        $records[] = $row;
    }

    echo json_encode(["success" => true, "records" => $records]);
    $stmt->close();
} else {
    // 📜 Fetch all patient findings logs if no specific case number provided
    $sql = "SELECT 
                apf.a_id,
                apf.a_case_number,
                su.su_user AS username,
                apf.a_fname,
                apf.a_mname,
                apf.a_lname,
                apf.a_complaint,
                apf.a_diagnosis,
                apf.a_medication,
                ph.ph_name AS physician_name,
                apf.a_date,
                apf.log_time
            FROM add_patientfindings apf
            LEFT JOIN standardusers su ON apf.a_user_id = su.su_id
            LEFT JOIN physicians ph ON apf.a_physician_id = ph.ph_id
            ORDER BY apf.log_time DESC";

    $result = $conn->query($sql);

    $records = [];
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $records[] = $row;
        }
    }

    echo json_encode(["success" => true, "records" => $records]);
}

$conn->close();
?>
