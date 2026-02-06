<?php
session_start();
require_once "../config/db.php";

/*
|--------------------------------------------------------------------------
| API CART - SESSION BASED
|--------------------------------------------------------------------------
| action:
| - add     : thêm sản phẩm
| - list    : lấy danh sách giỏ hàng
| - count   : đếm số lượng (badge)
| - update  : cập nhật số lượng
| - delete  : xóa 1 sản phẩm
| - clear   : xóa toàn bộ giỏ
|--------------------------------------------------------------------------
*/

header("Content-Type: application/json; charset=UTF-8");

// Khởi tạo giỏ hàng
if (!isset($_SESSION['cart']) || !is_array($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

$action = $_GET['action'] ?? $_POST['action'] ?? 'add';

/* =====================================================
   ADD - Thêm sản phẩm vào giỏ
===================================================== */
if ($action === 'add') {

    $id = intval($_POST['product_id'] ?? 0);

    if ($id > 0) {
        $_SESSION['cart'][$id] = ($_SESSION['cart'][$id] ?? 0) + 1;
    }

    echo json_encode([
        "status" => "success",
        "count"  => array_sum($_SESSION['cart'])
    ]);
    exit;
}

/* =====================================================
   COUNT - Đếm tổng số lượng (badge)
===================================================== */
if ($action === 'count') {

    echo json_encode([
        "count" => array_sum($_SESSION['cart'])
    ]);
    exit;
}

/* =====================================================
   LIST - Lấy danh sách giỏ hàng
===================================================== */
if ($action === 'list') {

    if (empty($_SESSION['cart'])) {
        echo json_encode([]);
        exit;
    }

    $pdo = getPDO();

    // Lấy danh sách ID sản phẩm
    $ids = implode(",", array_keys($_SESSION['cart']));

    $sql = "
        SELECT 
            p.product_id,
            p.product_name,
            p.price,
            i.image_url
        FROM products p
        LEFT JOIN images i 
            ON p.product_id = i.product_id 
            AND i.is_primary = 1
        WHERE p.product_id IN ($ids)
    ";

    $stmt = $pdo->query($sql);
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Gắn số lượng + thành tiền
    foreach ($products as &$p) {
        $qty = $_SESSION['cart'][$p['product_id']];
        $p['qty']   = $qty;
        $p['total'] = $qty * $p['price'];
    }

    echo json_encode($products, JSON_UNESCAPED_UNICODE);
    exit;
}

/* =====================================================
   UPDATE - Cập nhật số lượng
===================================================== */
if ($action === 'update') {

    $id  = intval($_POST['product_id'] ?? 0);
    $qty = intval($_POST['qty'] ?? 0);

    if ($id > 0) {
        if ($qty <= 0) {
            unset($_SESSION['cart'][$id]);
        } else {
            $_SESSION['cart'][$id] = $qty;
        }
    }

    echo json_encode([
        "status" => "success",
        "count"  => array_sum($_SESSION['cart'])
    ]);
    exit;
}

/* =====================================================
   DELETE - Xóa 1 sản phẩm
===================================================== */
if ($action === 'delete') {

    $id = intval($_POST['product_id'] ?? 0);

    if ($id > 0 && isset($_SESSION['cart'][$id])) {
        unset($_SESSION['cart'][$id]);
    }

    echo json_encode([
        "status" => "success",
        "count"  => array_sum($_SESSION['cart'])
    ]);
    exit;
}

/* =====================================================
   CLEAR - Xóa toàn bộ giỏ hàng
===================================================== */
if ($action === 'clear') {

    $_SESSION['cart'] = [];

    echo json_encode([
        "status" => "cleared",
        "count"  => 0
    ]);
    exit;
}

/* =====================================================
   ACTION KHÔNG HỢP LỆ
===================================================== */
echo json_encode([
    "status" => "error",
    "message" => "Invalid action"
]);
