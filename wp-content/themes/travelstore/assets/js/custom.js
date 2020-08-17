jQuery(document).ready(function ($) {


    /**
     * =========================
     * Accessibility codes start
     * =========================
     */

    // Keyboard navigation for whole site.
    $(document).on('mousemove', 'body', function (e) {
        $(this).removeClass('keyboard-nav-on');
    });
    $(document).on('keydown', 'body', function (e) {
        if (e.which == 9) {
            $(this).addClass('keyboard-nav-on');
        }
    });

    // Keyboard navigation for mobile menu.
    $(document).on('focus', '.keyboard-nav-on #site-navigation', function() {
        $('.keyboard-nav-on #site-navigation').addClass('toggled');
    });
    $(document).on('blur', '.keyboard-nav-on #site-navigation', function() {
        $('.keyboard-nav-on #site-navigation').removeClass('toggled');
    });
    $(document).on('focus', '.keyboard-nav-on #site-navigation .menu-item-has-children', function() {
        $(' .dropdown-toggle, .menu-item-has-children .sub-menu').addClass('toggled-on');
    });
    $(document).on('blur', '.keyboard-nav-on #site-navigation .menu-item-has-children', function() {
        $(' .dropdown-toggle, .menu-item-has-children .sub-menu').removeClass('toggled-on');
    });
    /**
     * =========================
     * Accessibility codes end
     * =========================
     */

    // Hero Slider
    jQuery('.hero-carousel').owlCarousel({
        loop: false,
        margin: 0,
        nav: true,
        dots: false,
        navText: ["<i class='fas fa-chevron-left'></i>", "<i class='fas fa-chevron-right'></i>"],
        responsive: {
            0: {
                items: 1
            },
            600: {
                items: 1
            },
            1000: {
                items: 1
            }
        }
    })

    // Trip Slider
    jQuery('.trip-slider').owlCarousel({
        loop: false,
        margin: 30,
        nav: true,
        dots: false,
        items: 3,
        //navText: ["‹","›"],
        responsive: {
            0: {
                items: 1
            },
            600: {
                items: 2
            },
            1000: {
                items: 3
            }
        }
    })

    // Featured Trip Slider
    jQuery('#featured-trip-slider').owlCarousel({
        //center: true,
        loop: false,
        margin: 30,
        nav: true,
        dots: false,
        items: 4,
        //navText: ["‹","›"],
        responsive: {
            0: {
                items: 1
            },
            600: {
                items: 2
            },
            1000: {
                items: 4
            }
        }
    })

    // Review Slider
    jQuery('#review-slider').owlCarousel({
        //center: true,
        loop: false,
        margin: 30,
        nav: true,
        dots: false,
        items: 2,
        //navText: ["‹","›"],
        responsive: {
            0: {
                items: 1
            },
            600: {
                items: 1
            },
            1000: {
                items: 2
            }
        }
    })



})