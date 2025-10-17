<?php
// cors.php - place this at the very top of your PHP files

// Allow your React app origin
header("Access-Control-Allow-Origin: http://localhost:3003");

// Allow necessary headers
header("Access-Control-Allow-Headers: Content-Type, Authorization");

// Allow HTTP methods
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");

// Set content type to JSON
header("Content-Type: application/json; charset=UTF-8");

// Handle preflight OPTIONS request
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}
