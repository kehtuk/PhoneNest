<?php
require 'db.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = $_POST["id"];
    $sku = $_POST["sku"] ?? '';
    $name = $_POST["name"] ?? '';
    $description = $_POST["description"] ?? '';
    $price = $_POST["price"] ?? 0;
    $brand = $_POST["brand"] ?? '';
    $category = $_POST["category"] ?? '';
    $stock = $_POST["stock"] ?? 0;

    $screen_size = $_POST["screen_size"] ?? '';
    $screen_resolution = $_POST["screen_resolution"] ?? '';
    $ram = $_POST["ram"] ?? '';
    $storage = $_POST["storage"] ?? '';
    $battery_capacity = $_POST["battery_capacity"] ?? '';
    $os = $_POST["os"] ?? '';
    $camera_main = $_POST["camera_main"] ?? '';
    $camera_front = $_POST["camera_front"] ?? '';
    $cpu = $_POST["cpu"] ?? '';
    $sim_type = $_POST["sim_type"] ?? '';
    $network = $_POST["network"] ?? '';
    $weight = $_POST["weight"] ?? '';
    $dimensions = $_POST["dimensions"] ?? '';
    $color = $_POST["color"] ?? '';

    $image = $_POST["existing_image"] ?? '';

    // Загрузка изображения
    $image = '';
    if (isset($_FILES["image"]) && $_FILES["image"]["error"] === UPLOAD_ERR_OK) {
        $image = basename($_FILES["image"]["name"]);
        $uploadDir = $_SERVER['DOCUMENT_ROOT'] . '../img/';
        $targetPath = $uploadDir . $image;

        // Проверка и создание папки, если нужно
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        move_uploaded_file($_FILES["image"]["tmp_name"], $targetPath);
    }

    // Обновление записи
    $stmt = $pdo->prepare("
        UPDATE products SET 
            sku = ?, name = ?, description = ?, price = ?, brand = ?, category = ?, 
            image = ?, stock = ?, screen_size = ?, screen_resolution = ?, ram = ?, 
            storage = ?, battery_capacity = ?, os = ?, camera_main = ?, camera_front = ?, 
            cpu = ?, sim_type = ?, network = ?, weight = ?, dimensions = ?, color = ?
        WHERE id = ?
    ");

    $stmt->execute([
        $sku, $name, $description, $price, $brand, $category,
        $image, $stock, $screen_size, $screen_resolution, $ram,
        $storage, $battery_capacity, $os, $camera_main, $camera_front,
        $cpu, $sim_type, $network, $weight, $dimensions, $color,
        $id
    ]);

    header("Location: ../admin.php?tab=products");
    exit;
}
?>