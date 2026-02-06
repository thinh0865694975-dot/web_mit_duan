<?php
require_once "../../db.php";

$action = $_POST['action'] ?? '';

if ($action == 'fetch') {
    echo json_encode($conn->query("SELECT * FROM docgia")->fetchAll());
}

if ($action == 'save') {
    if ($_POST['docgia_id'] == '') {
        $stmt = $conn->prepare(
            "INSERT INTO docgia(hoten,ngaysinh,gioitinh,email,dienthoai,diachi)
             VALUES(?,?,?,?,?,?)"
        );
        $stmt->execute([
            $_POST['hoten'], $_POST['ngaysinh'], $_POST['gioitinh'],
            $_POST['email'], $_POST['dienthoai'], $_POST['diachi']
        ]);
    } else {
        $stmt = $conn->prepare(
            "UPDATE docgia SET hoten=?,ngaysinh=?,gioitinh=?,email=?,dienthoai=?,diachi=?
             WHERE docgia_id=?"
        );
        $stmt->execute([
            $_POST['hoten'], $_POST['ngaysinh'], $_POST['gioitinh'],
            $_POST['email'], $_POST['dienthoai'], $_POST['diachi'],
            $_POST['docgia_id']
        ]);
    }
    echo "success";
}

if ($action == 'delete') {
    $stmt = $conn->prepare("DELETE FROM docgia WHERE docgia_id=?");
    $stmt->execute([$_POST['id']]);
    echo "deleted";
}
