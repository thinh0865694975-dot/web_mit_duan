<?php
require "db.php";

$sql = "
SELECT 
    u.user_id,
    u.username,
    u.full_name,
    u.email,
    u.role_id,
    r.role_name,
    u.status,
    u.created_at
FROM users u
JOIN roles r ON u.role_id = r.role_id
ORDER BY u.user_id ASC
";

$stmt = $pdo->query($sql);
echo json_encode($stmt->fetchAll());
