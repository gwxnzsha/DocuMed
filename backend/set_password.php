<?php
require_once 'db_connect.php';
$username = 'marilyn';     // change if you want another user
$newpass  = 'Test1234!';   // change to your chosen password
$hash = password_hash($newpass, PASSWORD_BCRYPT);
$stmt = $pdo->prepare("UPDATE standardusers SET su_pass = ? WHERE su_user = ?");
$stmt->execute([$hash, $username]);
echo json_encode(['success' => true, 'username' => $username, 'newpass' => $newpass]);
