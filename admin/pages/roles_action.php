<?php
require_once "../../db.php";

$action = $_POST['action'] ?? '';

if ($action == 'fetch') {
    echo json_encode($conn->query("SELECT * FROM roles")->fetchAll(PDO::FETCH_ASSOC));
}

if ($action == 'save') {
    if ($_POST['role_id'] == '') {
        $stmt = $conn->prepare("INSERT INTO roles(role_name) VALUES(?)");
        $stmt->execute([$_POST['role_name']]);
    } else {
        $stmt = $conn->prepare("UPDATE roles SET role_name=? WHERE role_id=?");
        $stmt->execute([$_POST['role_name'], $_POST['role_id']]);
    }
    echo "success";
}

if ($action == 'delete') {
    $stmt = $conn->prepare("DELETE FROM roles WHERE role_id=?");
    $stmt->execute([$_POST['id']]);
    echo "deleted";
}
