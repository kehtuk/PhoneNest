<?php
require './server/products.php';

// Получаем параметры фильтрации
$order = $_GET['order'] ?? 'new';
$queryText = $_GET['query'] ?? null;
$priceMin = (isset($_GET['price_min']) && $_GET['price_min'] !== '') ? (float)$_GET['price_min'] : null;
$priceMax = (isset($_GET['price_max']) && $_GET['price_max'] !== '') ? (float)$_GET['price_max'] : null;
$category = $_GET['category'] ?? null;
$selectedBrands = $_GET['brands'] ?? [];
$ram = $_GET['ram'] ?? null;
$storage = $_GET['storage'] ?? null;
$resolution = $_GET['screen_resolution'] ?? null;
$sim = $_GET['sim_type'] ?? null;
$network = $_GET['network'] ?? null;
$color = $_GET['color'] ?? null;
$screenSize = $_GET['screen_size'] ?? null;

// Получение всех брендов из базы данных
$brandStmt = $pdo->query("SELECT DISTINCT brand FROM products ORDER BY brand ASC");
$allBrands = $brandStmt->fetchAll(PDO::FETCH_COLUMN);
$ramOptions = $pdo->query("SELECT DISTINCT ram FROM products WHERE ram IS NOT NULL AND ram != '' ORDER BY ram")->fetchAll(PDO::FETCH_COLUMN);
$storageOptions = $pdo->query("SELECT DISTINCT storage FROM products WHERE storage IS NOT NULL AND storage != '' ORDER BY storage")->fetchAll(PDO::FETCH_COLUMN);
$resolutionOptions = $pdo->query("SELECT DISTINCT screen_resolution FROM products WHERE screen_resolution IS NOT NULL AND screen_resolution != '' ORDER BY screen_resolution")->fetchAll(PDO::FETCH_COLUMN);
$simOptions = $pdo->query("SELECT DISTINCT sim_type FROM products WHERE sim_type IS NOT NULL AND sim_type != '' ORDER BY sim_type")->fetchAll(PDO::FETCH_COLUMN);
$networkOptions = $pdo->query("SELECT DISTINCT network FROM products WHERE network IS NOT NULL AND network != '' ORDER BY network")->fetchAll(PDO::FETCH_COLUMN);
$colorOptions = $pdo->query("SELECT DISTINCT color FROM products WHERE color IS NOT NULL AND color != '' ORDER BY color")->fetchAll(PDO::FETCH_COLUMN);
$screenSizes = $pdo->query("SELECT DISTINCT screen_size FROM products WHERE screen_size IS NOT NULL AND screen_size != '' ORDER BY screen_size ASC")->fetchAll(PDO::FETCH_COLUMN);

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

// Фильтрация по остальным параметрам
if (!empty($ram) && is_array($ram)) {
    $placeholders = implode(',', array_fill(0, count($ram), '?'));
    $query .= " AND ram IN ($placeholders)";
    $params = array_merge($params, $ram);
}

if (!empty($storage) && is_array($storage)) {
    $placeholders = implode(',', array_fill(0, count($storage), '?'));
    $query .= " AND storage IN ($placeholders)";
    $params = array_merge($params, $storage);
}

if (!empty($resolution) && is_array($resolution)) {
    $placeholders = implode(',', array_fill(0, count($resolution), '?'));
    $query .= " AND screen_resolution IN ($placeholders)";
    $params = array_merge($params, $resolution);
}

if (!empty($sim) && is_array($sim)) {
    $placeholders = implode(',', array_fill(0, count($sim), '?'));
    $query .= " AND sim_type IN ($placeholders)";
    $params = array_merge($params, $sim);
}

if (!empty($network) && is_array($network)) {
    $placeholders = implode(',', array_fill(0, count($network), '?'));
    $query .= " AND network IN ($placeholders)";
    $params = array_merge($params, $network);
}

if (!empty($color) && is_array($color)) {
    $placeholders = implode(',', array_fill(0, count($color), '?'));
    $query .= " AND color IN ($placeholders)";
    $params = array_merge($params, $color);
}

if (!empty($screenSize)) {
    $query .= " AND screen_size = ?";
    $params[] = $screenSize;
}

// Поиск по имени и описанию
if (!empty($queryText)) {
    $query .= " AND (name LIKE ? OR description LIKE ?)";
    $searchTerm = '%' . $queryText . '%';
    $params[] = $searchTerm;
    $params[] = $searchTerm;
}

// Сортировка по дате поступления
if ($order === 'old') {
    $query .= " ORDER BY created_at ASC";
} else {
    $query .= " ORDER BY created_at DESC";
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
                            <h2 class="filter-title">Производитель</h2>
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

                            <!-- Оперативная память -->
                            <h2 class="filter-title">Оперативная память</h2>
                            <ul class="filter-list">
                                <?php foreach ($ramOptions as $option): ?>
                                    <li>
                                        <label>
                                            <input type="checkbox" name="ram[]" value="<?= htmlspecialchars($option) ?>"
                                                <?= is_array($ram) && in_array($option, $ram) ? 'checked' : '' ?>>
                                            <?= htmlspecialchars($option) ?>
                                        </label>
                                    </li>
                                <?php endforeach; ?>
                            </ul>

                            <!-- Встроенная память -->
                            <h2 class="filter-title">Встроенная память</h2>
                            <ul class="filter-list">
                                <?php foreach ($storageOptions as $option): ?>
                                    <li>
                                        <label>
                                            <input type="checkbox" name="storage[]" value="<?= htmlspecialchars($option) ?>"
                                                <?= is_array($storage) && in_array($option, $storage) ? 'checked' : '' ?>>
                                            <?= htmlspecialchars($option) ?>
                                        </label>
                                    </li>
                                <?php endforeach; ?>
                            </ul>

                            <!-- Разрешение экрана -->
                            <h2 class="filter-title">Разрешение экрана</h2>
                            <ul class="filter-list">
                                <?php foreach ($resolutionOptions as $option): ?>
                                    <li>
                                        <label>
                                            <input type="checkbox" name="screen_resolution[]" value="<?= htmlspecialchars($option) ?>"
                                                <?= is_array($resolution) && in_array($option, $resolution) ? 'checked' : '' ?>>
                                            <?= htmlspecialchars($option) ?>
                                        </label>
                                    </li>
                                <?php endforeach; ?>
                            </ul>

                            <!-- Тип SIM-карты -->
                            <h2 class="filter-title">Тип SIM-карты</h2>
                            <ul class="filter-list">
                                <?php foreach ($simOptions as $option): ?>
                                    <li>
                                        <label>
                                            <input type="checkbox" name="sim_type[]" value="<?= htmlspecialchars($option) ?>"
                                                <?= is_array($sim) && in_array($option, $sim) ? 'checked' : '' ?>>
                                            <?= htmlspecialchars($option) ?>
                                        </label>
                                    </li>
                                <?php endforeach; ?>
                            </ul>

                            <!-- Модуль связи -->
                            <h2 class="filter-title">Модуль связи</h2>
                            <ul class="filter-list">
                                <?php foreach ($networkOptions as $option): ?>
                                    <li>
                                        <label>
                                            <input type="checkbox" name="network[]" value="<?= htmlspecialchars($option) ?>"
                                                <?= is_array($network) && in_array($option, $network) ? 'checked' : '' ?>>
                                            <?= htmlspecialchars($option) ?>
                                        </label>
                                    </li>
                                <?php endforeach; ?>
                            </ul>

                            <!-- Цвет -->
                            <h2 class="filter-title">Цвет</h2>
                            <ul class="filter-list">
                                <?php foreach ($colorOptions as $option): ?>
                                    <li>
                                        <label>
                                            <input type="checkbox" name="color[]" value="<?= htmlspecialchars($option) ?>"
                                                <?= is_array($color) && in_array($option, $color) ? 'checked' : '' ?>>
                                            <?= htmlspecialchars($option) ?>
                                        </label>
                                    </li>
                                <?php endforeach; ?>
                            </ul>

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

                            <!-- Диагональ экрана -->
                            <h2 class="filter-title">Размер экрана</h2>
                            <div class="size-grid">
                                <?php foreach ($screenSizes as $s): ?>
                                    <button 
                                        type="button" 
                                        class="size-btn <?= ($screenSize === $s) ? 'active' : '' ?>" 
                                        data-screen="<?= htmlspecialchars($s) ?>"
                                    >
                                        <?= htmlspecialchars($s) ?>
                                    </button>
                                <?php endforeach; ?>
                            </div>
                            <input type="hidden" name="screen_size" id="screenSizeInput" value="<?= htmlspecialchars($screenSize ?? '') ?>">

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
    document.querySelectorAll('.size-btn[data-screen]').forEach(btn => {
        btn.addEventListener('click', () => {
            const input = document.getElementById('screenSizeInput');

            if (btn.classList.contains('active')) {
                btn.classList.remove('active');
                input.value = '';
            } else {
                document.querySelectorAll('.size-btn[data-screen]').forEach(b => b.classList.remove('active'));
                btn.classList.add('active');
                input.value = btn.dataset.screen;
            }
        });
    });
</script>

</body>
</html>