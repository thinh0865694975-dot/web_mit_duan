<?php
require_once "../../db.php";

$action = $_POST['action'] ?? '';

if ($action == 'fetch') {
    $sql = "SELECT m.*, d.hoten
            FROM muontra m
            JOIN docgia d ON m.docgia_id = d.docgia_id";
    echo json_encode($conn->query($sql)->fetchAll(PDO::FETCH_ASSOC));
}

if ($action == 'save') {
    if ($_POST['muontra_id'] == '') {
        $stmt = $conn->prepare(
            "INSERT INTO muontra(docgia_id, ngaymuon, hantra, trangthai)
             VALUES(?,?,?,?)"
        );
        $stmt->execute([
            $_POST['docgia_id'], $_POST['ngaymuon'],
            $_POST['hantra'], $_POST['trangthai']
        ]);
    } else {
        $stmt = $conn->prepare(
            "UPDATE muontra SET docgia_id=?, ngaymuon=?, hantra=?, trangthai=?
             WHERE muontra_id=?"
        );
        $stmt->execute([
            $_POST['docgia_id'], $_POST['ngaymuon'],
            $_POST['hantra'], $_POST['trangthai'], $_POST['muontra_id']
        ]);
    }
    echo "success";
}

if ($action == 'delete') {
    $stmt = $conn->prepare("DELETE FROM muontra WHERE muontra_id=?");
    $stmt->execute([$_POST['id']]);
    echo "deleted";
}
