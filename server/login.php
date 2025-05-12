<?php
require 'db.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Некорректный email.";
        exit;
    }

    $stmt = $pdo->prepare("SELECT id, full_name, password, role FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && $password === $user["password"]) {
        $_SESSION["user_id"] = $user["id"];
        $_SESSION["user_name"] = $user["full_name"];
        $_SESSION["user_role"] = $user["role"];

        echo $user["role"] == 1 ? "admin.php" : "account.php";
    } else {
        echo "Неверный email или пароль.";
    }
}
?>