<?php
session_start();

// Проверка авторизации и роли
if (!isset($_SESSION["user_id"]) || $_SESSION["user_role"] != 0) {
    header("Location: index.php");
    exit;
}

require './server/db.php';

// Получаем все заказы текущего пользователя
$stmt = $pdo->prepare("
    SELECT o.id, o.total_price, o.created_at, o.status,
           GROUP_CONCAT(p.name SEPARATOR ', ') AS products
    FROM orders o
    JOIN order_product op ON o.id = op.order_id
    JOIN products p ON op.product_id = p.id
    WHERE o.user_id = ?
    GROUP BY o.id
    ORDER BY o.created_at DESC
");
$stmt->execute([$_SESSION["user_id"]]);
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Переключение вкладок
$tab = $_GET['tab'] ?? 'orders';
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Личный кабинет</title>
    <link rel="stylesheet" href="./src/css/style.css">
</head>
<body>
    <div class="wrapper">
        <?php include './templates/header.php'; ?>
        <main class="content">
            <section class="user-account">
                <div class="account-container">
                    <div class="account-sidebar">
                        <p class="account-name"><?= htmlspecialchars($_SESSION["user_name"]) ?></p>
                        <ul class="account-menu">
                            <li class="<?= $tab !== 'profile' ? 'active' : '' ?>">
                                <a href="?tab=orders">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon <?= $tab !== 'profile' ? 'icon-active' : '' ?>" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m20.25 7.5-.625 10.632a2.25 2.25 0 0 1-2.247 2.118H6.622a2.25 2.25 0 0 1-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125Z" />
                                    </svg>
                                    <p>Мои заказы</p>
                                </a>
                            </li>
                            <li class="<?= $tab === 'profile' ? 'active' : '' ?>">
                                <a href="?tab=profile">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon <?= $tab === 'profile' ? 'icon-active' : '' ?>" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                                    </svg>
                                    <p>Личные данные</p>
                                </a>
                            </li>
                        </ul>
                    </div>

                    <div class="account-content">
                        <?php if ($tab === 'profile'): ?>
                            <h1 class="account-title">Личные данные</h1>

                            <?php
                            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                                $full_name = trim($_POST['full_name']);
                                $phone = trim($_POST['phone']);
                                $address = trim($_POST['address']);
                            
                                $updateStmt = $pdo->prepare("UPDATE users SET full_name = ?, phone = ?, address = ? WHERE id = ?");
                                $updateStmt->execute([$full_name, $phone, $address, $_SESSION['user_id']]);
                            
                                $_SESSION['user_name'] = $full_name;
                                echo '<p style="color: #EF0D22;">Данные успешно обновлены</p>';
                            }
                            
                            $stmt = $pdo->prepare("SELECT full_name, email, phone, address FROM users WHERE id = ?");
                            $stmt->execute([$_SESSION['user_id']]);
                            $user = $stmt->fetch(PDO::FETCH_ASSOC);                            
                            ?>

                            <form method="POST" class="user-form">
                                <label for="full_name">ФИО</label>
                                <input type="text" id="full_name" name="full_name" required value="<?= htmlspecialchars($user['full_name']) ?>">

                                <label for="email">Email</label>
                                <input type="email" id="email" name="email" disabled value="<?= htmlspecialchars($user['email']) ?>">

                                <label for="phone">Телефон</label>
                                <input type="tel" id="phone" name="phone" value="<?= htmlspecialchars($user['phone'] ?? '') ?>">

                                <label for="address">Адрес</label>
                                <textarea id="address" name="address" rows="3"><?= htmlspecialchars($user['address'] ?? '') ?></textarea>

                                <button type="submit" class="order-btn" style="margin-top: 20px;">Сохранить</button>
                            </form>

                        <?php else: ?>
                            <h1 class="account-title">Мои заказы</h1>

                            <?php if (empty($orders)): ?>
                                <p class="cart-empty">Заказы не найдены</p>
                            <?php else: ?>
                                <div class="order-list">
                                    <?php foreach ($orders as $order): ?>
                                        <div class="order-card">
                                            <p><strong>Заказ №<?= $order['id'] ?></strong></p>
                                            <p>Дата: <?= date("d.m.Y H:i", strtotime($order['created_at'])) ?></p>
                                            <p>Статус: <?= $order['status'] == 0 ? 'В обработке' : 'Завершён' ?></p>
                                            <p>Товары: <?= htmlspecialchars($order['products']) ?></p>
                                            <p>Сумма: <?= number_format($order['total_price'], 0, '', ' ') ?> ₽</p>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </section>
        </main>
        <?php include './templates/footer.php'; ?>
    </div>
</body>
</html>