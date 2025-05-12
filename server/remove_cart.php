<?php
session_start();
header('Content-Type: application/json');

$data = json_decode(file_get_contents("php://input"), true);
$sku = $data['sku'] ?? null;

if (!$sku || !isset($_SESSION['cart'][$sku])) {
    echo json_encode(['success' => false, 'message' => 'Товар не найден']);
    exit;
}

unset($_SESSION['cart'][$sku]);

$cartCount = 0;
foreach ($_SESSION['cart'] ?? [] as $item) {
    $cartCount += $item['quantity'];
}

echo json_encode(['success' => true, 'cartCount' => $cartCount]);
?>