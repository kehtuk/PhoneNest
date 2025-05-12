<?php
require 'db.php';

try {
    $stmt = $pdo->query("SELECT * FROM products ORDER BY created_at DESC");
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    echo "Ошибка загрузки товаров: " . $e->getMessage();
    $products = [];
}
?>