<?php
require_once "../../db.php";

$action = $_POST['action'] ?? '';

if ($action == 'fetch') {
    echo json_encode($conn->query("SELECT * FROM tacgia")->fetchAll(PDO::FETCH_ASSOC));
}

if ($action == 'save') {
    if ($_POST['tacgia_id'] == '') {
        $stmt = $conn->prepare("INSERT INTO tacgia(tentacgia) VALUES(?)");
        $stmt->execute([$_POST['tentacgia']]);
    } else {
        $stmt = $conn->prepare("UPDATE tacgia SET tentacgia=? WHERE tacgia_id=?");
        $stmt->execute([$_POST['tentacgia'], $_POST['tacgia_id']]);
    }
    echo "success";
}

if ($action == 'delete') {
    $stmt = $conn->prepare("DELETE FROM tacgia WHERE tacgia_id=?");
    $stmt->execute([$_POST['id']]);
    echo "deleted";
}
