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
                            <li><a href="#delivery">Доставка/Возврат</a></li>
                            <li><a href="#exchange">Как обменять или вернуть товар</a></li>
                            <li><a href="#return-customer">Возврат по желанию покупателя</a></li>
                            <li><a href="#return-seller">Возврат по вине продавца</a></li>
                        </ul>
                    </nav>
                    
                    <div class="info-content">
                        <div class="breadcrumbs">
                            <a href="index.php">Главная</a> 
                            <span> &gt; </span>
                            <span class="current">Услуги</span>
                        </div>
                        
                        <h1>Услуги</h1>

                        <section id="delivery">
                            <h2>Доставка/Возврат</h2>
                            <p>Мы передаём заказы в курьерские службы только по будням. Например, если ваш заказ был оплачен в пятницу после 11:00, он будет передан службе доставки в понедельник.</p>
                        </section>

                        <section id="exchange">
                            <h2>Как обменять или вернуть товар</h2>
                            <p>Вы можете вернуть товар в течение 14 дней с момента получения заказа, если он не был в эксплуатации и сохранён товарный вид.</p>
                            <p>Мы принимаем к возврату только товары без следов использования, в оригинальной упаковке, с полным комплектом и заводскими пломбами (если имеются).</p>
                        </section>

                        <section id="return-customer">
                            <h3>Возврат по желанию покупателя</h3>
                            <p>Вы можете вернуть товар, если он вам не подошёл по характеристикам, функциональности или просто не устроил. Возврат возможен только при сохранении товарного вида и упаковки.</p>
                            <p>В этом случае стоимость обратной доставки оплачиваете вы.</p>
                        </section>

                        <section id="return-seller">
                            <h3>Возврат по вине продавца</h3>
                            <p>Если вы получили товар с заводским браком, повреждением при транспортировке или ошибкой в комплекте — мы оплатим обратную доставку.</p>
                            <p>Средства возвращаются в течение 5–7 рабочих дней после получения и проверки возврата.</p>
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