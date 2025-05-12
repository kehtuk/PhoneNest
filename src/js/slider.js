document.addEventListener("DOMContentLoaded", () => {
    const track = document.querySelector('.slider-track');
    const slides = document.querySelectorAll('.slide');
    const dotsContainer = document.querySelector('.slider-dots');

    let currentIndex = 0;
    const total = slides.length;

    // Создаем точки
    for (let i = 0; i < total; i++) {
        const dot = document.createElement('div');
        dot.classList.add('slider-dot');
        if (i === 0) dot.classList.add('active');
        dot.dataset.index = i;
        dotsContainer.appendChild(dot);
    }

    const dots = document.querySelectorAll('.slider-dot');

    function updateSlider() {
        track.style.transform = `translateX(-${currentIndex * 100}%)`;
        dots.forEach(dot => dot.classList.remove('active'));
        dots[currentIndex].classList.add('active');
    }

    function nextSlide() {
        currentIndex = (currentIndex + 1) % total;
        updateSlider();
    }

    function goToSlide(index) {
        currentIndex = index;
        updateSlider();
    }

    // Навешиваем клик по точкам
    dots.forEach(dot => {
        dot.addEventListener('click', () => {
            goToSlide(Number(dot.dataset.index));
        });
    });

    // Автопрокрутка
    setInterval(nextSlide, 5000);
});