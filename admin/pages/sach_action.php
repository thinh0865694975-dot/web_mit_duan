<?php
require_once "../../db.php";

$action = $_POST['action'] ?? '';

if ($action == 'fetch') {
    $sql = "SELECT s.*, t.tentheloai
            FROM sach s
            LEFT JOIN theloai t ON s.theloai_id = t.theloai_id";
    echo json_encode($conn->query($sql)->fetchAll(PDO::FETCH_ASSOC));
}

if ($action == 'save') {
    $id = $_POST['sach_id'] ?? '';

    if ($id == '') {
        $stmt = $conn->prepare(
            "INSERT INTO sach(tensach, namxuatban, theloai_id, soluong)
             VALUES(?,?,?,?)"
        );
        $stmt->execute([
            $_POST['tensach'], $_POST['namxuatban'],
            $_POST['theloai_id'], $_POST['soluong']
        ]);
    } else {
        $stmt = $conn->prepare(
            "UPDATE sach SET tensach=?, namxuatban=?, theloai_id=?, soluong=?
             WHERE sach_id=?"
        );
        $stmt->execute([
            $_POST['tensach'], $_POST['namxuatban'],
            $_POST['theloai_id'], $_POST['soluong'], $id
        ]);
    }
    echo "success";
}

if ($action == 'delete') {
    $stmt = $conn->prepare("DELETE FROM sach WHERE sach_id=?");
    $stmt->execute([$_POST['id']]);
    echo "deleted";
}
