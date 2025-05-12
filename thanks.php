<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Спасибо за заказ</title>
    <link rel="stylesheet" href="/src/css/style.css">
    <link rel="stylesheet" href="/src/css/transpage.css">
</head>
<body>
    <div class="wrapper">
        <?php include $_SERVER['DOCUMENT_ROOT'] . '/templates/header.php'; ?>

        <main class="content">
            <section class="thank-you">
                <div class="content">
                    <h1 class="title">Спасибо за заказ!</h1>
                    <p class="text">Мы свяжемся с вами в ближайшее  время для подтверждения.</p>
                    <a href="/index.php" class="button">Вернуться на главную</a>
                </div>
            </section>
        </main>

        <?php include $_SERVER['DOCUMENT_ROOT'] . '/templates/footer.php'; ?>
    </div>
</body>
</html>