<?php
session_start();
require $_SERVER['DOCUMENT_ROOT'] . '/server/db.php';

$cartItems = [];
$total = 0;

if (!empty($_SESSION['cart'])) {
    $skus = array_keys($_SESSION['cart']);
    $placeholders = implode(',', array_fill(0, count($skus), '?'));
    $stmt = $pdo->prepare("SELECT * FROM products WHERE sku IN ($placeholders)");
    $stmt->execute($skus);
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

    ob_start();
    foreach ($products as $product) {
        $quantity = $_SESSION['cart'][$product['sku']]['quantity'];
        $total += $product['price'] * $quantity;
        ?>
        <div class="cart-item" style="position: relative;">
            <img src="<?= htmlspecialchars($product['image']) ?>" class="cart-item__image" alt="<?= htmlspecialchars($product['name']) ?>">
            <div class="cart-item__info">
                <h3 class="cart-item__title"><?= htmlspecialchars($product['name']) ?></h3>
                <p class="cart-item__price"><?= number_format($product['price'], 0, '', ' ') ?> ₽</p>
                <p class="cart-item__size">41 1/3 EUR</p>
            </div>
            <button class="remove-from-cart" data-sku="<?= htmlspecialchars($product['sku']) ?>" title="Удалить товар"
                style="background: none; border: none; position: absolute; top: 12px; right: 12px; cursor: pointer;">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="20" height="20">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                </svg>
            </button>
        </div>
        <?php
    }
    ?>
    <div class="cart-footer">
        <div class="cart-total">
            <span>Итого</span>
            <strong><?= number_format($total, 0, '', ' ') ?> ₽</strong>
        </div>
        <a href="/checkout.php" class="cart-checkout-btn">Оформить заказ</a>
    </div>
    <?php

    $html = ob_get_clean();
    echo $html;
} else {
    echo '<p class="cart-empty">Корзина пуста</p>';
}