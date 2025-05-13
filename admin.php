<?php
session_start();

if (!isset($_SESSION["user_id"]) || $_SESSION["user_role"] != 1) {
    header("Location: index.php");
    exit;
}

require './server/db.php';

$tab = $_GET['tab'] ?? 'orders';

if ($tab === 'orders') {
    $stmt = $pdo->query("
        SELECT o.id, o.total_price, o.created_at, o.status, u.full_name,
               GROUP_CONCAT(p.name SEPARATOR ', ') AS products
        FROM orders o
        JOIN users u ON o.user_id = u.id
        JOIN order_product op ON o.id = op.order_id
        JOIN products p ON op.product_id = p.id
        GROUP BY o.id
        ORDER BY o.created_at DESC
    ");
    $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    require './server/products.php';
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StepsUP - Админ панель</title>
    <link rel="stylesheet" href="./src/css/style.css">
    <link rel="stylesheet" href="./src/css/admin.css">
</head>
<body>
<div class="wrapper">
    <?php include './templates/header.php'; ?>

    <main class="content">
        <section class="user-account">
            <div class="account-container">
                <div class="account-sidebar">
                    <p class="account-name">Администратор</p>
                    <ul class="account-menu">
                        <li class="<?= $tab === 'orders' ? 'active' : '' ?>">
                            <a href="?tab=orders">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon <?= $tab === 'orders' ? 'icon-active' : '' ?>" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m20.25 7.5-.625 10.632a2.25 2.25 0 0 1-2.247 2.118H6.622a2.25 2.25 0 0 1-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125Z" />
                                </svg>
                                <p>Заказы</p>
                            </a>
                        </li>
                        <li class="<?= $tab === 'products' ? 'active' : '' ?>">
                            <a href="?tab=products">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon <?= $tab === 'products' ? 'icon-active' : '' ?>" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12.75V12A2.25 2.25 0 0 1 4.5 9.75h15A2.25 2.25 0 0 1 21.75 12v.75m-8.69-6.44-2.12-2.12a1.5 1.5 0 0 0-1.061-.44H4.5A2.25 2.25 0 0 0 2.25 6v12a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18V9a2.25 2.25 0 0 0-2.25-2.25h-5.379a1.5 1.5 0 0 1-1.06-.44Z" />
                                </svg>
                                <p>Товары</p>
                            </a>
                        </li>
                    </ul>
                </div>

                <div class="account-content">
                    <?php if ($tab === 'orders'): ?>
                        <h1 class="account-title">Все заказы</h1>

                        <?php if (empty($orders)): ?>
                            <p class="cart-empty">Нет заказов</p>
                        <?php else: ?>
                            <div class="order-list">
                                <?php foreach ($orders as $order): ?>
                                    <div class="order-card">
                                        <p><strong>Заказ №<?= $order['id'] ?></strong></p>
                                        <p>Клиент: <?= htmlspecialchars($order['full_name']) ?></p>
                                        <p>Дата: <?= date("d.m.Y H:i", strtotime($order['created_at'])) ?></p>
                                        <p>Статус: <?= $order['status'] == 0 ? 'В обработке' : 'Завершён' ?></p>
                                        <p>Товары: <?= htmlspecialchars($order['products']) ?></p>
                                        <p>Сумма: <?= number_format($order['total_price'], 0, '', ' ') ?> ₽</p>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>

                    <?php elseif ($tab === 'products'): ?>
                        <h1 class="account-title">Каталог товаров</h1>
                        <div class="admin-table-wrapper">
                            <table class="admin-table">
                                <thead>
                                    <tr>
                                        <th>Изображение</th>
                                        <th>Название</th>
                                        <th>Цена</th>
                                        <th>Категория</th>
                                        <th>Бренд</th>
                                        <th></th>
                                        <th><div class="admin-button"><button class="admin-add">+</button></div></th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                $shownSkus = [];
                                foreach ($products as $product):
                                    if (in_array($product['sku'], $shownSkus)) continue;
                                    $shownSkus[] = $product['sku'];
                                ?>
                                <tr>
                                    <td><img src="/img/<?= htmlspecialchars($product["image"]) ?>" alt="Товар" class="product-thumb"></td>
                                    <td><?= htmlspecialchars($product['name']) ?></td>
                                    <td><?= number_format($product['price'], 2, '.', ' ') ?> руб.</td>
                                    <td><?= $product['category'] ?></td>
                                    <td><?= $product['brand'] ?></td>
                                    <td>
                                        <button class="admin-edit"
                                            data-id="<?= $product['id'] ?>"
                                            data-sku="<?= $product['sku'] ?>"
                                            data-name="<?= htmlspecialchars($product['name']) ?>"
                                            data-description="<?= htmlspecialchars($product['description']) ?>"
                                            data-price="<?= $product['price'] ?>"
                                            data-stock="<?= $product['stock'] ?>"
                                            data-brand="<?= $product['brand'] ?>"
                                            data-category="<?= $product['category'] ?>"
                                            data-image="<?= $product['image'] ?>"
                                        >✎</button>
                                    </td>
                                    <td>
                                        <button class="admin-delete" data-id="<?= $product['id'] ?>" title="Удалить товар">✖</button>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </section>
    </main>
    <?php include './templates/footer.php'; ?>
</div>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/templates/product-modal.php'; ?>
</body>
</html>