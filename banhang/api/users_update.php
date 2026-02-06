<?php
require "db.php";

$user_id   = $_POST['user_id'];
$username  = $_POST['username'];
$full_name = $_POST['full_name'];
$email     = $_POST['email'];
$role_id   = $_POST['role_id'];
$status    = $_POST['status'];
$password  = $_POST['password'] ?? '';

$sql = "
UPDATE users SET
    username = :username,
    full_name = :full_name,
    email = :email,
    role_id = :role_id,
    status = :status
WHERE user_id = :user_id
";

$stmt = $pdo->prepare($sql);
$stmt->execute([
    ":username" => $username,
    ":full_name" => $full_name,
    ":email" => $email,
    ":role_id" => $role_id,
    ":status" => $status,
    ":user_id" => $user_id
]);

// đổi mật khẩu nếu có nhập
if ($password != '') {
    $stmt = $pdo->prepare(
        "UPDATE users SET password = :password WHERE user_id = :id"
    );
    $stmt->execute([
        ":password" => password_hash($password, PASSWORD_BCRYPT),
        ":id" => $user_id
    ]);
}

echo json_encode(["success" => true]);
