<?php
session_start();
require $_SERVER['DOCUMENT_ROOT'] . '/server/db.php';

// Получаем содержимое корзины
$cartItems = [];
$total = 0;

if (!empty($_SESSION['cart'])) {
    $skus = array_keys($_SESSION['cart']);
    $placeholders = implode(',', array_fill(0, count($skus), '?'));
    $stmt = $pdo->prepare("SELECT * FROM products WHERE sku IN ($placeholders)");
    $stmt->execute($skus);
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($products as $product) {
        $quantity = $_SESSION['cart'][$product['sku']]['quantity'];
        $subtotal = $product['price'] * $quantity;
        $total += $subtotal;

        $cartItems[] = [
            'name' => $product['name'],
            'image' => $product['image'],
            'price' => $product['price'],
            'quantity' => $quantity,
            'sku' => $product['sku'],
        ];
    }
}

// Получение данных авторизованного пользователя
$userData = [
    'email' => '',
    'fullname' => '',
    'phone' => '',
    'address' => ''
];

if (!empty($_SESSION['user_id'])) {
    $stmt = $pdo->prepare("SELECT email, full_name, phone, address FROM users WHERE id = ?");
    $stmt->execute([$_SESSION['user_id']]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        $userData = [
            'email' => htmlspecialchars($user['email']),
            'fullname' => htmlspecialchars($user['full_name']),
            'phone' => htmlspecialchars($user['phone'] ?? ''),
            'address' => htmlspecialchars($user['address'] ?? '')
        ];
    }
}

?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Оформление заказа | StepsUP</title>
    <link rel="stylesheet" href="/src/css/style.css">
</head>
<body>
<div class="wrapper">
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/templates/header.php'; ?>

    <main class="checkout-page">
        <div class="checkout-layout">
            <section class="checkout-form">
                <h2>Оформите заказ</h2>
                <form action="/server/place_order.php" method="POST">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" placeholder="you@example.com"
                        value="<?= $userData['email'] ?>" required>

                    <label for="fullname">ФИО</label>
                    <input type="text" id="fullname" name="fullname" placeholder="Иванов Иван Иванович"
                        value="<?= $userData['fullname'] ?>" required>


                    <label for="phone">Телефон</label>
                    <input type="tel" id="phone" name="phone" placeholder="+7 900 000 00 00"
                        value="<?= $userData['phone'] ?>" required>

                    <label for="address">Адрес</label>
                    <input type="text" id="address" name="address" placeholder="г. Москва"
                        value="<?= $userData['address'] ?>" required>

                    <label>
                        <input type="checkbox" name="international"> За границу
                    </label>

                    <p>Выберите способ доставки</p>
                    <label><input type="radio" name="delivery" value="pickup" checked> Забрать из магазина — Бесплатно</label>
                    <label><input type="radio" name="delivery" value="courier"> Курьер Sneakerhead — 1–3 дня (500 ₽)</label>
                    <label><input type="radio" name="delivery" value="boxberry"> ПВЗ Boxberry — 3–6 дней (350 ₽)</label>

                    <label for="comment">Комментарий к заказу</label>
                    <textarea name="comment" id="comment" rows="4" placeholder="Комментарий к заказу..."></textarea>

                    <label>
                        <input type="checkbox" required> Нажимая «Заказать» вы даёте согласие на обработку данных
                    </label>

                    <button type="submit" class="order-btn">Оформить заказ</button>
                </form>
            </section>

            <aside class="checkout-summary">
                <h2>В корзине <?= count($cartItems) ?> товар(ов)</h2>

                <div class="price-breakdown">
                    <p>Стоимость товаров <span><?= number_format($total, 0, '', ' ') ?> ₽</span></p>
                    <p>Доставка <span>0 ₽</span></p>
                    <p class="total">Итого <span><?= number_format($total, 0, '', ' ') ?> ₽</span></p>
                </div>

                <?php if (!empty($cartItems)): ?>
                    <?php foreach ($cartItems as $item): ?>
                        <div class="cart-item">
                            <img src="<?= htmlspecialchars($item['image']) ?>" alt="<?= htmlspecialchars($item['name']) ?>">
                            <div>
                                <p class="cart-price"><?= number_format($item['price'], 0, '', ' ') ?> ₽</p>
                                <p><?= htmlspecialchars($item['name']) ?></p>
                                <div class="cart-options">
                                    <select>
                                        <option selected>41 1/3 EUR</option>
                                    </select>
                                    <input type="number" value="<?= $item['quantity'] ?>" min="1" readonly>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="cart-empty">Корзина пуста</p>
                <?php endif; ?>
            </aside>
        </div>
    </main>

    <?php include $_SERVER['DOCUMENT_ROOT'] . '/templates/footer.php'; ?>
</div>
</body>
</html>