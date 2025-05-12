<?php
require $_SERVER['DOCUMENT_ROOT'] . '/server/db.php';

$sku = $_GET['sku'] ?? null;

if (!$sku) {
    header("Location: /404.php");
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM products WHERE sku = ?");
$stmt->execute([$sku]);
$product = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$product) {
    header("Location: /404.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($product['name']) ?> | StepsUP</title>
    <link rel="stylesheet" href="/src/css/style.css">
</head>
<body>
<div class="wrapper">
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/templates/header.php'; ?>

    <main class="content">
        <section class="product-page">
            <div class="container">
                <div class="breadcrumbs">
                    <a href="/index.php">Главная</a> > <a href="#">Обувь</a> > <a href="#">Кроссовки</a> > <span><?= htmlspecialchars($product['name']) ?></span>
                </div>

                <div class="product-content">
                    <div class="product-images">
                        <img src="<?= $product['image'] ?>" alt="<?= htmlspecialchars($product['name']) ?>" class="main-image">
                    </div>

                    <div class="product-details">
                        <h1><?= htmlspecialchars($product['name']) ?></h1>
                        <p class="product-sku">Артикул: <?= $product['sku'] ?></p>
                        <p class="product-price"><?= number_format($product['price'], 0, '', ' ') ?> ₽</p>
                        <p class="product-option"><strong class="product-type"><?= $product['stock'] > 0 ? 'В наличии' : 'Нет в наличии' ?></strong></p>
                        <p>Бренд: <?= htmlspecialchars($product['brand']) ?></p>

                        <div class="product-actions">
                            <button class="add-to-cart" type="button" data-sku="<?= $product['sku'] ?>">Добавить в корзину</button>
                            <button class="add-to-wishlist" type="button" title="Добавить в желаемое">
                                <img src="/img/liked-icon.svg" alt="Желаемое">
                            </button>
                        </div>
                    </div>
                </div>

                <!-- <div class="product-description">
                    <h2>Описание</h2>
                    <p><?= nl2br(htmlspecialchars($product['description'])) ?></p>
                </div> -->
            </div>
        </section>
    </main>

    <?php include $_SERVER['DOCUMENT_ROOT'] . '/templates/footer.php'; ?>
</div>
</body>
</html>