<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["id"])) {
    $id = (int) $_POST["id"];

    $stmt = $pdo->prepare("DELETE FROM products WHERE id = ?");
    $success = $stmt->execute([$id]);

    echo $success ? 'success' : 'error';
    exit;
}

http_response_code(400);
echo "Неверный запрос";
?>