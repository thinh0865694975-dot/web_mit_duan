<?php
require 'db.php';
$stmt = $conn->query("SHOW TABLES");
echo "<h3>Kết nối thành công. Danh sách bảng:</h3>";
while ($row = $stmt->fetch()) {
    echo $row[0] . "<br>";
}
