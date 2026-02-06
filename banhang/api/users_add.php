<?php
require "db.php";

$username  = $_POST['username'] ?? '';
$password  = $_POST['password'] ?? '';
$full_name = $_POST['full_name'] ?? '';
$email     = $_POST['email'] ?? '';
$role_id   = $_POST['role_id'] ?? 2;
$status    = $_POST['status'] ?? 1;

if ($username == '' || $full_name == '' || $email == '') {
    echo json_encode(["error" => "Thiếu dữ liệu"]);
    exit;
}

$sql = "
INSERT INTO users (username, password, full_name, email, role_id, status)
VALUES (:username, :password, :full_name, :email, :role_id, :status)
";

$stmt = $pdo->prepare($sql);
$stmt->execute([
    ":username"  => $username,
    ":password"  => password_hash($password, PASSWORD_BCRYPT),
    ":full_name" => $full_name,
    ":email"     => $email,
    ":role_id"   => $role_id,
    ":status"    => $status
]);

echo json_encode(["success" => true]);
