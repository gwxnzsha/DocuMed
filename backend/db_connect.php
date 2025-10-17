<?php
// db_connect.php
$DB_HOST = '127.0.0.1';
$DB_NAME = 'patientrecord';
$DB_USER = 'root';
$DB_PASS = ''; // set this if your MySQL has a password


try {
    $pdo = new PDO("mysql:host={$DB_HOST};dbname={$DB_NAME};charset=utf8mb4", $DB_USER, $DB_PASS, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
} catch (Exception $ex) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'DB connection failed', 'error' => $ex->getMessage()]);
    exit;
}
