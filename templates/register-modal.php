<div id="registrationModal" class="modal" style="display: none;">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h2 class="modal-title">Регистрация</h2>
        <form id="registerForm" class="modal-form">
            <input type="text" name="full_name" placeholder="ФИО">
            <input type="email" name="email" placeholder="Электронная почта" required>
            <input id="phone" type="tel" name="phone" placeholder="+7 (___) ___-__-__" required>
            <input type="password" name="password" placeholder="Пароль" required>
            <p class="modal-text">
                Нажимая кнопку «Продолжить» или совершая регистрацию через социальную сеть, вы подтверждаете свое согласие 
                с условиями предоставляемых услуг и договором «Оферта программы лояльности»
            </p>
            <button type="button" id="registerButton" class="modal-button">Продолжить</button>
        </form>
        <p class="modal-footer">
            Уже зарегистрированы? <a href="#" class="switch-to-login">Войдите</a>
        </p>
    </div>
</div>