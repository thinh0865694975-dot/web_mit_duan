<?php
require_once "../../db.php";

$action = $_POST['action'] ?? '';

if ($action == 'fetch') {
    echo json_encode($conn->query("SELECT * FROM theloai")->fetchAll(PDO::FETCH_ASSOC));
}

if ($action == 'save') {
    if ($_POST['theloai_id'] == '') {
        $stmt = $conn->prepare("INSERT INTO theloai(tentheloai) VALUES(?)");
        $stmt->execute([$_POST['tentheloai']]);
    } else {
        $stmt = $conn->prepare("UPDATE theloai SET tentheloai=? WHERE theloai_id=?");
        $stmt->execute([$_POST['tentheloai'], $_POST['theloai_id']]);
    }
    echo "success";
}

if ($action == 'delete') {
    $stmt = $conn->prepare("DELETE FROM theloai WHERE theloai_id=?");
    $stmt->execute([$_POST['id']]);
    echo "deleted";
}
