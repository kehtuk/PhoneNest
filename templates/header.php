<?php
session_start();
?>

<?php if (isset($_SESSION['user_name'])): ?>
<script>
    console.log("Авторизован как: <?= htmlspecialchars($_SESSION['user_name']) ?>");
</script>
<?php endif; ?>

<?php
$cartCount = 0;
if (isset($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $item) {
        $cartCount += $item['quantity'];
    }
}
?>

<script>
    window.currentUser = {
        isLoggedIn: <?= isset($_SESSION['user_id']) ? 'true' : 'false' ?>,
        role: <?= isset($_SESSION['user_role']) ? (int)$_SESSION['user_role'] : 'null' ?>
    };
</script>

<header>
    <div class="container">
        <nav class="header-main">
            <div class="header-nav">
                <ul>
                    <li><a href="about.php">О нас</a></li>
                    <li><a href="services.php">Услуги</a></li>
                    <li><a href="contacts.php">Контакты</a></li>
                </ul>
            </div>
            <div class="logo"><a href="/index.php"><img src="/img/logo.svg" alt="logo"></a></div>
            <div class="header-icons">
                <ul>
                    <li><a href="#" id="openSearchModal"><img src="/img/search-icon.svg" alt="Поиск"></a></li>
                    <li>
                        <a href="#" class="open-login-modal"><img src="/img/account-icon.svg" alt="Личный кабинет"></a>
                    </li>
                    <li>
                        <button class="open-cart" type="button" title="Корзина">
                            <img src="/img/cart-icon.svg" alt="Корзина">
                            <?php if ($cartCount > 0): ?>
                                <span class="cart-count"><?= $cartCount ?></span>
                            <?php else: ?>
                                <span class="cart-count" style="display: none;">0</span>
                            <?php endif; ?>
                        </button>
                    </li>


                    <?php if (isset($_SESSION['user_id'])): ?>
                        <li>
                            <form id="logout-form" action="/server/logout.php" method="POST" style="display:inline;">
                                <button type="submit" class="logout-button" style="background:none;border:none;cursor:pointer;">
                                    <img class="logout" src="/img/log-out.svg" alt="Выход" title="Выйти">
                                </button>
                            </form>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </nav>

        <nav class="header-categories">
            <ul>
                <li><a href="/catalog.php?category=Новинки">Новинки</a></li>
                <li><a href="/catalog.php?category=Бренд">Бренды</a></li>
                <li><a href="/catalog.php?gender=1">Мужские</a></li>
                <li><a href="/catalog.php?gender=0">Женские</a></li>
                <li><a href="/catalog.php?category=Детская">Детские</a></li>
                <li><a href="/catalog.php?category=Распродажа">Распродажа</a></li>
            </ul>
        </nav>
    </div>
</header>

<?php include 'register-modal.php'; ?>
<?php include 'login-modal.php'; ?>
<?php include 'cart-modal.php'; ?>
<?php include 'search-modal.php'; ?>
<?php include './templates/scripts.php'; ?>