<?php
require './server/products.php';
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StepsUP</title>
    <link rel="stylesheet" href="./src/css/style.css">
    <link rel="stylesheet" href="./src/css/main.css">
</head>
<body>
    <div class="wrapper">
        <?php include './templates/header.php'; ?>
        <main class="content">
            <section class="category-section">
                <div class="container">
                    <!-- Слайдер -->
                    <div class="custom-slider">
                        <div class="slider-track">
                            <div class="slide"><img src="./img/main-sneakers.jpg" alt="Слайд 1"></div>
                            <div class="slide"><img src="./img/slide1.jpg" alt="Слайд 2"></div>
                            <div class="slide"><img src="./img/slide2.jpg" alt="Слайд 3"></div>
                            <div class="slide"><img src="./img/slide3.jpg" alt="Слайд 4"></div>
                        </div>
                        <div class="slider-dots"></div>
                    </div>

                    <div class="sneakers-categories">
                        <div class="category-item">
                            <div class="image-wrapper"><img src="./img/mens-sneakers.jpg" alt="Мужские кроссовки"></div>
                            <div class="overlay">Мужские кроссовки</div>
                        </div>
                        <div class="category-item">
                            <div class="image-wrapper"><img src="./img/brand-collections.jpg" alt="Брендовые коллекции"></div>
                            <div class="overlay">Брендовые коллекции</div>
                        </div>
                        <div class="category-item">
                            <div class="image-wrapper"><img src="./img/sale.jpg" alt="Распродажа"></div>
                            <div class="overlay">Распродажа</div>
                        </div>
                    </div>
                </div>
            </section>
            <section class="shoes-section">
                <div class="container">
                    <!-- Фильтр выбора категории -->
                    <div class="filter-buttons">
                        <button class="active">Рекомендуем</button>
                        <button>Популярные</button>
                        <button>Новинки</button>
                    </div>

                    <!-- Мужская обувь -->
                    <h2>Мужская обувь 🡮</h2>
                    <div class="product-category">
                        <?php
                        $count = 0;
                        foreach ($products as $product) {
                            if ((int)$product["gender"] === 1) {
                                if ($count >= 4) break;
                                $count++;
                        ?>
                            <div class="product-card">
                                <?php if (!empty($product["label"])) { ?>
                                    <span class="label"><?= htmlspecialchars($product["label"]) ?></span>
                                <?php } ?>
                                <img src="<?= htmlspecialchars($product["image"]) ?>" alt="<?= htmlspecialchars($product["name"]) ?>">
                                <p class="price"><?= number_format($product["price"], 2, '.', ' ') ?> руб.</p>
                                <div class="product-name">
                                    <p><?= htmlspecialchars($product["description"]) ?></p>
                                </div>
                                <div class="details-container">
                                    <a href="/product/<?= urlencode($product['sku']) ?>" class="details-link">Подробнее</a>
                                </div>
                            </div>
                        <?php }
                        } ?>
                    </div>

                    <h2>Женская обувь 🡮</h2>
                    <div class="product-category">
                        <?php
                        $count = 0;
                        foreach ($products as $product) {
                            if ((int)$product["gender"] === 0) {
                                if ($count >= 4) break;
                                $count++;
                        ?>
                            <div class="product-card">
                                <?php if (!empty($product["label"])) { ?>
                                    <span class="label"><?= htmlspecialchars($product["label"]) ?></span>
                                <?php } ?>
                                <img src="<?= htmlspecialchars($product["image"]) ?>" alt="<?= htmlspecialchars($product["name"]) ?>">
                                <p class="price"><?= number_format($product["price"], 2, '.', ' ') ?> руб.</p>
                                <div class="product-name">
                                    <p><?= htmlspecialchars($product["description"]) ?></p>
                                </div>
                                <div class="details-container">
                                    <a href="/product/<?= urlencode($product['sku']) ?>" class="details-link">Подробнее</a>
                                </div>
                            </div>
                        <?php }
                        } ?>
                    </div>
                </div>
            </section>
        </main>
        <?php include './templates/footer.php'; ?>
    </div>
</body>
<script src="../src/js/slider.js"></script>
</html>