<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StepsUP</title>
    <link rel="stylesheet" href="./src/css/style.css">
</head>
<body>
    <div class="wrapper">
        <?php include './templates/header.php'; ?>
        <main class="content">
        <section class="info-page">
            <div class="container">
                <div class="info">
                    <nav class="info-sidebar">
                        <ul>
                            <li><a href="#address">Наш адрес</a></li>
                            <li><a href="#schedule">Режим работы</a></li>
                            <li><a href="#contacts">Контакты для связи с нами</a></li>
                        </ul>
                    </nav>
                
                    <div class="info-content">
                        <div class="breadcrumbs">
                            <a href="index.php">Главная</a> <span> &gt; </span>
                            <span class="current">Контакты</span>
                        </div>
                        
                        <h1>Контакты</h1>
                        
                        <section id="address">
                            <h2>Наш адрес</h2>
                            <p>Главный офис и склад</p>
                            <p>г. Москва, ул. Примерная, д. 15, офис 305</p>
                        </section>
                        
                        <section id="schedule">
                            <h2>Режим работы</h2>
                            <p>Мы работаем:</p>
                            <ul>
                                <li>Понедельник – Пятница: 10:00 – 18:00</li>
                                <li>Суббота – Воскресенье: выходные</li>
                            </ul>
                            <p>Обратите внимание, что заказы, оформленные в выходные или праздничные дни, будут обработаны в ближайший рабочий день.</p>
                        </section>
                        
                        <section id="contacts">
                            <h2>Контакты для связи с нами</h2>
                            <p><strong>Электронная почта:</strong></p>
                            <ul>
                                <li>Для общих вопросов: <a href="mailto:info@stepsup.ru">info@stepsup.ru</a></li>
                                <li>Для возвратов и обменов: <a href="mailto:returns@stepsup.ru">returns@stepsup.ru</a></li>
                            </ul>
                            <p><strong>Телефон (пн – пт с 10:00 до 18:00):</strong></p>
                            <p>+7 (945) 935-82-82</p>
                            <p><strong>Социальные сети:</strong></p>
                            <div class="social-icons">
                                <a href="#"><img src="./img/telegram-icon-white.svg" class="Telegram" alt="Telegram"></a>
                                <a href="#"><img src="./img/vk-icon-white.svg" alt="VK"></a>
                                <a href="#"><img src="./img/youtube-icon-white.svg" alt="YouTube"></a>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        </section>
        </main>
        <?php include './templates/footer.php'; ?>
    </div>
</body>
<?php include './templates/scripts.php'; ?>
</html>