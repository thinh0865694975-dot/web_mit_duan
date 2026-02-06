<?php
require 'db.php';

$baseUrl = "http://localhost/banhang/";

$sql = "
SELECT p.product_id, p.product_name, p.price, p.quantity,
       i.image_url
FROM products p
LEFT JOIN images i
ON p.product_id = i.product_id AND i.is_primary = 1
";

$stmt = $pdo->query($sql);
$data = [];

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $row['image_url'] = $row['image_url']
        ? $baseUrl . $row['image_url']
        : $baseUrl . "uploads/no-image.png";
    $data[] = $row;
}

echo json_encode($data, JSON_UNESCAPED_UNICODE);
