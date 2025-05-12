<?php
session_start();
require $_SERVER['DOCUMENT_ROOT'] . '/server/db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_SESSION['user_id'])) {
    header("Location: /");
    exit;
}

$user_id = $_SESSION['user_id'];
$email = $_POST['email'];
$fullname = $_POST['fullname'];
$phone = $_POST['phone'];
$city = $_POST['city'];
$delivery = $_POST['delivery'];
$comment = $_POST['comment'] ?? '';
$international = isset($_POST['international']) ? 1 : 0;

// Получаем корзину из сессии
$cart = $_SESSION['cart'] ?? [];
if (empty($cart)) {
    die("Корзина пуста.");
}

$skus = array_keys($cart);
$placeholders = implode(',', array_fill(0, count($skus), '?'));
$stmt = $pdo->prepare("SELECT * FROM products WHERE sku IN ($placeholders)");
$stmt->execute($skus);
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Подсчёт общей стоимости
$total = 0;
foreach ($products as $product) {
    $qty = $cart[$product['sku']]['quantity'];
    $total += $product['price'] * $qty;
}

// Вставка заказа
$orderStmt = $pdo->prepare("INSERT INTO orders (user_id, total_price, status) VALUES (?, ?, 0)");
$orderStmt->execute([$user_id, $total]);
$order_id = $pdo->lastInsertId();

// Вставка товаров заказа
$orderItemStmt = $pdo->prepare("INSERT INTO order_product (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");

foreach ($products as $product) {
    $qty = $cart[$product['sku']]['quantity'];
    $orderItemStmt->execute([
        $order_id,
        $product['id'],
        $qty,
        $product['price']
    ]);
}

// Очищаем корзину
$_SESSION['cart'] = [];

header("Location: /thanks.php");
exit;