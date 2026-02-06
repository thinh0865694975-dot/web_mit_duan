<?php
require "db.php";

$id = $_POST['id'];

$pdo->beginTransaction();

try {
    $pdo->prepare("DELETE FROM invoice_details 
                   WHERE invoice_id IN (
                       SELECT invoice_id FROM invoices WHERE user_id = ?
                   )")->execute([$id]);

    $pdo->prepare("DELETE FROM invoices WHERE user_id = ?")
        ->execute([$id]);

    $pdo->prepare("DELETE FROM users WHERE user_id = ?")
        ->execute([$id]);

    $pdo->commit();
    echo json_encode(["success" => true]);
} catch (Exception $e) {
    $pdo->rollBack();
    echo json_encode(["error" => $e->getMessage()]);
}
