<?php
require './server/products.php';

// Получаем параметры фильтрации
$order = $_GET['order'] ?? 'new';
$queryText = $_GET['query'] ?? null;
$priceMin = (isset($_GET['price_min']) && $_GET['price_min'] !== '') ? (float)$_GET['price_min'] : null;
$priceMax = (isset($_GET['price_max']) && $_GET['price_max'] !== '') ? (float)$_GET['price_max'] : null;
$category = $_GET['category'] ?? null;
$selectedBrands = $_GET['brands'] ?? [];
$size = $_GET['size'] ?? null;
$gender = $_GET['gender'] ?? null;

// Получение всех брендов из базы данных
$brandStmt = $pdo->query("SELECT DISTINCT brand FROM products ORDER BY brand ASC");
$allBrands = $brandStmt->fetchAll(PDO::FETCH_COLUMN);

$query = "SELECT * FROM products WHERE 1";
$params = [];

// Фильтрация по цене
if ($priceMin !== null) {
    $query .= " AND price >= ?";
    $params[] = $priceMin;
}
if ($priceMax !== null) {
    $query .= " AND price <= ?";
    $params[] = $priceMax;
}

// Фильтрация по категории
if (!empty($category)) {
    $query .= " AND category = ?";
    $params[] = $category;
}

// Фильтрация по брендам
if (!empty($selectedBrands)) {
    $in = implode(',', array_fill(0, count($selectedBrands), '?'));
    $query .= " AND brand IN ($in)";
    $params = array_merge($params, $selectedBrands);
}

// Фильтрация по размеру
if (!empty($size)) {
    $query .= " AND size = ?";
    $params[] = $size;
}

// Фильтрация по полу
if ($gender !== null && $gender !== '') {
    $query .= " AND gender = ?";
    $params[] = $gender;
}

// Поиск по имени и описанию
if (!empty($queryText)) {
    $query .= " AND (name LIKE ? OR description LIKE ?)";
    $searchTerm = '%' . $queryText . '%';
    $params[] = $searchTerm;
    $params[] = $searchTerm;
}

// Получение товаров
$stmt = $pdo->prepare($query);
$stmt->execute($params);
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Каталог обуви</title>
    <link rel="stylesheet" href="./src/css/style.css">
</head>
<body>
<div class="wrapper">
    <?php include './templates/header.php'; ?>
    <main class="content">
        <section class="catalog">
            <div class="container">
                <div class="breadcrumbs">
                    <a href="index.php">Главная</a>
                    <span>&gt;</span>
                    <span class="current">Каталог</span>
                </div>

                <form method="GET" class="sort-form">
                    <h1 class="sort-title">КАТАЛОГ</h1>
                    <button class="sort-btn" type="submit" name="order" value="<?= $order === 'new' ? 'old' : 'new' ?>">
                        Дата поступления (<?= $order === 'new' ? 'сначала старые' : 'сначала новые' ?>)
                    </button>
                </form>

                <div class="catalog-wrapper">
                    <!-- Фильтр товаров -->
                    <aside class="filter">
                        <form method="GET">
                            <!-- Бренды -->
                            <h2 class="filter-title">Бренды</h2>
                            <ul class="filter-list">
                                <?php foreach ($allBrands as $brand): ?>
                                    <li>
                                        <label>
                                            <input type="checkbox" name="brands[]" value="<?= htmlspecialchars($brand) ?>"
                                                <?= in_array($brand, $selectedBrands) ? 'checked' : '' ?>>
                                            <?= htmlspecialchars($brand) ?>
                                        </label>
                                    </li>
                                <?php endforeach; ?>
                            </ul>

                            <!-- Категория -->
                            <h2 class="filter-title">Категория</h2>
                            <select class="filter-select" name="category">
                                <option value="">Все</option>
                                <option value="Бренд" <?= $category === 'Бренд' ? 'selected' : '' ?>>Бренд</option>
                                <option value="Распродажа" <?= $category === 'Распродажа' ? 'selected' : '' ?>>Распродажа</option>
                                <option value="Детская" <?= $category === 'Детская' ? 'selected' : '' ?>>Детская</option>
                            </select>

                             <!-- Пол -->
                             <h2 class="filter-title">Пол</h2>
                            <select class="filter-select" name="gender">
                                <option value="">Все</option>
                                <option value="1" <?= $gender === '1' ? 'selected' : '' ?>>Мужской</option>
                                <option value="0" <?= $gender === '0' ? 'selected' : '' ?>>Женский</option>
                            </select>

                            <!-- Цена -->
                            <h2 class="filter-title">Цена</h2>
                            <div class="price-filter">
                                <div class="filter-form">
                                    <input type="text" name="price_min" placeholder="От"
                                           value="<?= isset($_GET['price_min']) ? htmlspecialchars($_GET['price_min']) : '' ?>">
                                    <input type="text" name="price_max" placeholder="До"
                                           value="<?= isset($_GET['price_max']) ? htmlspecialchars($_GET['price_max']) : '' ?>">
                                </div>
                            </div>

                            <!-- Скрытый параметр сортировки -->
                            <input type="hidden" name="order" value="<?= htmlspecialchars($order) ?>">

                            <!-- Размеры (пока статичны) -->
                            <h2 class="filter-title">Размер EUR</h2>
                            <div class="size-grid">
                                <?php 
                                    $sizes = ['36','37','38','39','40','41','42','43','44','45'];
                                    foreach ($sizes as $s): 
                                ?>
                                    <button 
                                        type="button" 
                                        class="size-btn <?= ($size === $s) ? 'active' : '' ?>" 
                                        data-size="<?= $s ?>"
                                    >
                                        <?= $s ?>
                                    </button>
                                <?php endforeach; ?>
                            </div>
                            <input type="hidden" name="size" id="sizeInput" value="<?= htmlspecialchars($size ?? '') ?>">

                            <!-- Применить -->
                            <button type="submit" class="filter-submit">Применить</button>
                        </form>
                    </aside>

                    <!-- Каталог товаров -->
                    <section class="catalog-products">
                        <div class="product-grid">
                            <?php foreach ($products as $product): ?>
                                <div class="product-card">
                                    <?php if (!empty($product["label"])): ?>
                                        <span class="label"><?= htmlspecialchars($product["label"]) ?></span>
                                    <?php endif; ?>
                                    <img src="<?= htmlspecialchars($product["image"]) ?>" alt="<?= htmlspecialchars($product["name"]) ?>">
                                    <p class="price"><?= number_format($product["price"], 2, '.', ' ') ?> руб.</p>
                                    <div class="product-name">
                                        <p><?= htmlspecialchars($product["description"]) ?></p>
                                    </div>
                                    <div class="details-container">
                                        <a href="/product/<?= urlencode($product['sku']) ?>" class="details-link">Подробнее</a>
                                        <button class="cart-btn" data-sku="<?= $product['sku'] ?>">
                                            <img src="./img/white-cart-icon.svg" alt="Добавить в корзину">
                                        </button>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </section>
                </div>
            </div>
        </section>
    </main>
    <?php include './templates/footer.php'; ?>
</div>

<script>
    document.querySelectorAll('.size-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            const sizeInput = document.getElementById('sizeInput');

            // Если кнопка уже активна — снять выбор
            if (btn.classList.contains('active')) {
                btn.classList.remove('active');
                sizeInput.value = '';
            } else {
                // Убрать активность у всех, установить новую
                document.querySelectorAll('.size-btn').forEach(b => b.classList.remove('active'));
                btn.classList.add('active');
                sizeInput.value = btn.dataset.size;
            }
        });
    });
</script>

</body>
</html>