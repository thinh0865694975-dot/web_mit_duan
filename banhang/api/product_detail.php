<?php
require 'db.php';

$id = $_GET['id'] ?? 0;
$baseUrl = "http://localhost/banhang/";

$sql = "
SELECT p.*, c.category_name
FROM products p
LEFT JOIN categories c ON p.category_id = c.category_id
WHERE p.product_id = ?
";
$stmt = $pdo->prepare($sql);
$stmt->execute([$id]);
$product = $stmt->fetch(PDO::FETCH_ASSOC);

$sqlImg = "SELECT image_url FROM images WHERE product_id = ?";
$stmt = $pdo->prepare($sqlImg);
$stmt->execute([$id]);
$images = [];

while ($img = $stmt->fetch()) {
    $images[] = $baseUrl . $img['image_url'];
}

$sqlRel = "
SELECT p.product_id, p.product_name, p.price, i.image_url
FROM products p
LEFT JOIN images i ON p.product_id = i.product_id AND i.is_primary = 1
WHERE p.category_id = ? AND p.product_id != ?
LIMIT 4
";
$stmt = $pdo->prepare($sqlRel);
$stmt->execute([$product['category_id'], $id]);

$related = [];
while ($r = $stmt->fetch()) {
    $related[] = [
        "product_id"=>$r['product_id'],
        "product_name"=>$r['product_name'],
        "price"=>$r['price'],
        "image_url"=>$baseUrl.$r['image_url']
    ];
}

echo json_encode([
    "product"=>$product,
    "images"=>$images,
    "related"=>$related
], JSON_UNESCAPED_UNICODE);
