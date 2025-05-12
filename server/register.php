<?php
require 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $full_name = trim($_POST["full_name"]);
    $email = trim($_POST["email"]);
    $phone = trim($_POST["phone"]);
    $password = trim($_POST["password"]);

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Некорректный email.";
        exit;
    }

    if (!preg_match('/^\+7 \(\d{3}\) \d{3}-\d{2}-\d{2}$/', $phone)) {
        echo "Некорректный формат номера телефона.";
        exit;
    }

    $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->execute([$email]);

    if ($stmt->fetch()) {
        echo "Пользователь с таким email уже зарегистрирован.";
        exit;
    }

    $stmt = $pdo->prepare("INSERT INTO users (full_name, email, phone, password) VALUES (?, ?, ?, ?)");
    if ($stmt->execute([$full_name, $email, $phone, $password])) {
        echo "Регистрация прошла успешно";
    } else {
        echo "Ошибка при регистрации.";
    }
}
?>