<?php
session_start();
header('Content-Type: application/json');

$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['sku'])) {
    echo json_encode(['success' => false, 'message' => 'SKU не передан']);
    exit;
}

$sku = $data['sku'];

// Инициализируем корзину
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Обновление количества
if (isset($_SESSION['cart'][$sku])) {
    $_SESSION['cart'][$sku]['quantity'] += 1;
} else {
    $_SESSION['cart'][$sku] = [
        'sku' => $sku,
        'quantity' => 1
    ];
}

// Подсчёт всех товаров
$cartCount = 0;
foreach ($_SESSION['cart'] as $item) {
    $cartCount += $item['quantity'];
}

echo json_encode(['success' => true, 'cartCount' => $cartCount]);
?>