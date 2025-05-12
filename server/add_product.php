<?php
require 'db.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = $_POST["name"] ?? '';
    $description = $_POST["description"] ?? '';
    $price = $_POST["price"] ?? 0;
    $brand = $_POST["brand"] ?? '';
    $category = $_POST["category"] ?? 0;
    $stock = $_POST["stock"] ?? 0;
    $image = '';

    // Upload image
    if (isset($_FILES["image"]) && $_FILES["image"]["error"] === UPLOAD_ERR_OK) {
        $uploadDir = "../img/";
        $image = basename($_FILES["image"]["name"]);
        move_uploaded_file($_FILES["image"]["tmp_name"], $uploadDir . $image);
    }

    $stmt = $pdo->prepare("INSERT INTO products (name, description, price, brand, category, image, stock) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$name, $description, $price, $brand, $category, $image, $stock]);

    header("Location: ../admin.php");
    exit;
}
?>