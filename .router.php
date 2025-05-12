<?php
$request = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);

// Обработка роутинга вида /product/sku0001
if (preg_match('#^/product/(.+)$#', $request, $matches)) {
    $_GET['sku'] = $matches[1];
    include 'product.php';
    exit;
}

// Обработка прямых PHP-файлов (admin.php, catalog.php и т.д.)
$fullPath = __DIR__ . $request;
if (file_exists($fullPath) && pathinfo($fullPath, PATHINFO_EXTENSION) === 'php') {
    include $fullPath;
    exit;
}

// Раздача статики (CSS, JS, изображения и т.д.)
if (file_exists($fullPath)) {
    return false;
}
?>