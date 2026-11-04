/**
 * Luxury Hero Banner Slider Initializer
 * Bijoux Jewelry Store
 */
document.addEventListener('DOMContentLoaded', function () {
    if (typeof Swiper !== 'undefined' && document.querySelector('.luxury-hero-slider')) {
        new Swiper('.luxury-hero-slider', {
            loop: true,
            effect: 'fade',
            fadeEffect: {
                crossFade: true
            },
            speed: 1000,
            autoplay: {
                delay: 5500,
                disableOnInteraction: false,
                pauseOnMouseEnter: true
            },
            pagination: {
                el: '.luxury-hero-slider .swiper-pagination',
                clickable: true
            },
            navigation: {
                nextEl: '.luxury-hero-slider .swiper-button-next',
                prevEl: '.luxury-hero-slider .swiper-button-prev'
            },
            keyboard: {
                enabled: true
            },
            a11y: {
                prevSlideMessage: 'Previous slide',
                nextSlideMessage: 'Next slide'
            }
        });
    }
});

