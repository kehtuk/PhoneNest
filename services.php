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
                            <li><a href="#post">1. Доставка Почтой России</a></li>
                            <li><a href="#courier">2. Доставка курьером СДЭК</a></li>
                            <li><a href="#boxberry">3. Доставка в ПВЗ Boxberry</a></li>
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
                            <p>Мы передаем/возвращаем заказы в курьерские службы только по будням. К примеру, если Ваш заказ собран в пятницу после 11:00, мы отправим его в понедельник.</p>
                        </section>
                        
                        <section id="post">
                            <h3>1. Доставка Почтой России</h3>
                            <p>Цена и сроки доставки рассчитываются автоматически при оформлении заказа и зависят от веса посылки и точного адреса получателя.</p>
                            <p>При заказе на сумму более 10000 рублей — доставка бесплатная.</p>
                        </section>
                        
                        <section id="courier">
                            <h3>2. Доставка курьером СДЭК</h3>
                            <p>Сроки и цена доставки рассчитываются автоматически при оформлении заказа и зависят от веса посылки и точного адреса получателя.</p>
                            <p>При заказе на сумму более 10000 рублей — доставка бесплатная.</p>
                        </section>
                        
                        <section id="boxberry">
                            <h3>3. Доставка в ПВЗ Boxberry</h3>
                            <p>При оформлении заказа выбирайте удобный пункт выдачи заказа на карте города. Сроки и цена доставки рассчитываются автоматически.</p>
                            <p>При заказе на сумму более 10000 рублей — доставка бесплатная.</p>
                        </section>
                        
                        <section id="exchange">
                            <h2>Как обменять или вернуть товар</h2>
                            <p>Вы можете вернуть неподошедший товар в течение 14 дней с момента получения заказа.</p>
                            <p>Мы принимаем к возврату только неиспользованные вещи с бирками, наклейками и упаковкой.</p>
                        </section>
                        
                        <section id="return-customer">
                            <h3>Возврат по желанию покупателя</h3>
                            <p>Вы можете вернуть товар по собственному желанию, если вам не подошел размер, цвет, модель и т.п.</p>
                            <p>В этом случае стоимость обратной доставки оплачиваете вы.</p>
                        </section>
                        
                        <section id="return-seller">
                            <h3>Возврат по вине продавца</h3>
                            <p>Если вы получили не тот товар или вещь оказалась с браком, стоимость обратной доставки оплачиваем мы.</p>
                            <p>Деньги вернутся вам в течение 5-7 рабочих дней.</p>
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