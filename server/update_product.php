<?php
require 'db.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = $_POST["id"];
    $name = $_POST["name"];
    $description = $_POST["description"];
    $price = $_POST["price"];
    $brand = $_POST["brand"];
    $category = $_POST["category"];
    $stock = $_POST["stock"];
    $image = $_POST["existing_image"];

    // Upload new image if provided
    if (isset($_FILES["image"]) && $_FILES["image"]["error"] === UPLOAD_ERR_OK) {
        $uploadDir = "../img/";
        $image = basename($_FILES["image"]["name"]);
        move_uploaded_file($_FILES["image"]["tmp_name"], $uploadDir . $image);
    }

    $stmt = $pdo->prepare("UPDATE products SET name = ?, description = ?, price = ?, brand = ?, category = ?, image = ?, stock = ? WHERE id = ?");
    $stmt->execute([$name, $description, $price, $brand, $category, $image, $stock, $id]);

    header("Location: ../admin.php");
    exit;
}
?>