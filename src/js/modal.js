document.addEventListener("DOMContentLoaded", function () {
    const regModal = document.getElementById("registrationModal");
    const loginModal = document.getElementById("loginModal");
    const editModal = document.getElementById("editProductModal");
    const searchModal = document.getElementById("searchModal");
    const openSearchBtn = document.getElementById("openSearchModal");

    // Маска телефона
    let inputPhone = document.getElementById("phone");
    if (inputPhone) {
        inputPhone.addEventListener("input", () => phoneMask(inputPhone));
    }

    function phoneMask(inputEl) {
        let patStringArr = "+7 (___) ___-__-__".split('');
        let arrPush = [4, 5, 6, 9, 10, 11, 13, 14, 16, 17]; 
        let val = inputEl.value.replace(/\D+/g, "").split('').splice(1);
        let n;

        val.forEach((s, i) => {
            n = arrPush[i];
            patStringArr[n] = s;
        });

        inputEl.value = patStringArr.join('');
        inputEl.setSelectionRange(n ? n + 1 : 18, n ? n + 1 : 18);
    }

    // Регистрация
    document.getElementById("registerButton")?.addEventListener("click", function () {
        const registerForm = document.getElementById("registerForm");

        if (registerForm) {
            const phoneField = registerForm.querySelector("input[name='phone']");
            if (phoneField) {
                phoneField.value = phoneField.value.replace(/\D+/g, "");
            }

            const formData = new FormData(registerForm);

            fetch("../server/register.php", {
                method: "POST",
                body: formData
            })
            .then(response => response.text())
            .then(data => {
                if (data.trim() === "success") {
                    alert("Регистрация прошла успешно!");
                    if (regModal) regModal.style.display = "none";
                    if (loginModal) loginModal.style.display = "flex";
                } else {
                    alert(data);
                }
            });
        }
    });

    // Авторизация
    document.getElementById("loginButton")?.addEventListener("click", function () {
        const loginForm = document.getElementById("loginForm");

        if (loginForm) {
            const formData = new FormData(loginForm);

            fetch("../server/login.php", {
                method: "POST",
                body: formData
            })
            .then(response => response.text())
            .then(data => {
                if (data.trim().endsWith(".php")) {
                    window.location.href = data.trim();
                } else {
                    alert(data);
                }
            });
        }
    });

    // Кнопка аккаунта: переход по роли
    document.querySelector(".open-login-modal")?.addEventListener("click", (e) => {
        e.preventDefault();

        if (window.currentUser?.isLoggedIn) {
            if (window.currentUser.role === 1) {
                window.location.href = "admin.php";
            } else {
                window.location.href = "account.php";
            }
        } else {
            if (loginModal) loginModal.style.display = "flex";
        }
    });

    // Открытие окна редактирования товара
    document.querySelectorAll(".admin-edit")?.forEach(editBtn => {
        editBtn.addEventListener("click", function (e) {
            e.preventDefault();
            if (editModal) editModal.style.display = "flex";
        });
    });

    // Открытие модального окна поиска
    openSearchBtn?.addEventListener("click", (e) => {
        e.preventDefault();
        if (searchModal) searchModal.style.display = "block";
    });

    // Закрытие окон по крестику
    document.querySelectorAll(".close")?.forEach(closeBtn => {
        closeBtn.addEventListener("click", () => {
            if (regModal) regModal.style.display = "none";
            if (loginModal) loginModal.style.display = "none";
            if (editModal) editModal.style.display = "none";
        });
    });

    // Переключение между модальными окнами
    document.querySelector(".switch-to-login")?.addEventListener("click", (e) => {
        e.preventDefault();
        if (regModal) regModal.style.display = "none";
        if (loginModal) loginModal.style.display = "flex";
    });

    document.querySelector(".switch-to-register")?.addEventListener("click", (e) => {
        e.preventDefault();
        if (loginModal) loginModal.style.display = "none";
        if (regModal) regModal.style.display = "flex";
    });

    // Закрытие по клику вне окна
    window.addEventListener("click", (event) => {
        if (event.target === regModal) regModal.style.display = "none";
        if (event.target === loginModal) loginModal.style.display = "none";
        if (event.target === editModal) editModal.style.display = "none";
        if (event.target === searchModal) searchModal.style.display = "none";
    });

    // Закрытие по кнопке
    document.addEventListener("click", (e) => {
        if (
            searchModal.style.display === "block" &&
            !searchModal.contains(e.target) &&
            e.target !== openSearchBtn &&
            !openSearchBtn.contains(e.target)
        ) {
            searchModal.style.display = "none";
        }
    });
});