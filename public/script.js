document.addEventListener("DOMContentLoaded", function () {
    var swiper = new Swiper('.mySwiper', {
        slidesPerView: 1,
        spaceBetween: 10,
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
        autoplay: {
            delay: 10000, // 3 seconds (adjust as needed)
            disableOnInteraction: false, // Keeps autoplay running even if the user interacts with the swiper
        },
        loop: true, // Enables the loop functionality
    });
});
