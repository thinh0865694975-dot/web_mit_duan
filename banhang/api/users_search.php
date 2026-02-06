<?php
require "db.php";

$kw = "%" . $_GET['keyword'] . "%";

$sql = "
SELECT u.user_id, u.username, u.full_name, u.email,
       u.role_id, r.role_name, u.status
FROM users u
JOIN roles r ON u.role_id = r.role_id
WHERE u.username LIKE ? OR u.full_name LIKE ? OR u.email LIKE ?
";

$stmt = $pdo->prepare($sql);
$stmt->execute([$kw, $kw, $kw]);
$data = $stmt->fetchAll();
echo json_encode($data);

while ($row = $res->fetch_assoc()) {
    $data[] = $row;
}

echo json_encode($data);
