<?php
require_once "../../db.php";

$action = $_POST['action'] ?? '';

if ($action == 'fetch') {
    $sql = "SELECT u.user_id, u.username, u.email, r.role_name
            FROM users u
            LEFT JOIN roles r ON u.role_id = r.role_id";
    echo json_encode($conn->query($sql)->fetchAll());
}

/* THÊM + SỬA */
if ($action == 'save') {
    $id = $_POST['user_id'] ?? '';

    if ($id == '') {
        $stmt = $conn->prepare(
            "INSERT INTO users(username,password,email,role_id)
             VALUES(?,?,?,?)"
        );
        $stmt->execute([
            $_POST['username'],
            '123456',
            $_POST['email'],
            $_POST['role_id']
        ]);
    } else {
        $stmt = $conn->prepare(
            "UPDATE users SET username=?, email=?, role_id=?
             WHERE user_id=?"
        );
        $stmt->execute([
            $_POST['username'],
            $_POST['email'],
            $_POST['role_id'],
            $id
        ]);
    }
    echo "success";
}

/* XÓA */
if ($action == 'delete') {
    $stmt = $conn->prepare("DELETE FROM users WHERE user_id=?");
    $stmt->execute([$_POST['id']]);
    echo "deleted";
}
