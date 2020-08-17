jQuery(document).ready(function($) {

/*------------------------------------------------
            DECLARATIONS
------------------------------------------------*/

    var loader = $('#loader');
    var loader_container = $('#preloader');
    var scroll = $(window).scrollTop();  
    var scrollup = $('.backtotop');
    var menu_toggle = $('.menu-toggle');
    var dropdown_toggle = $('.main-navigation button.dropdown-toggle');
    var nav_menu = $('.main-navigation ul.nav-menu');

/*------------------------------------------------
            PRELOADER
------------------------------------------------*/

    loader_container.delay(1000).fadeOut();
    loader.delay(1000).fadeOut("slow");

/*------------------------------------------------
            BACK TO TOP
------------------------------------------------*/

    $(window).scroll(function() {
        if ($(this).scrollTop() > 1) {
            scrollup.css({bottom:"25px"});
        } 
        else {
            scrollup.css({bottom:"-100px"});
        }
    });

    scrollup.click(function() {
        $('html, body').animate({scrollTop: '0px'}, 800);
        return false;
    });

/*------------------------------------------------
            MAIN NAVIGATION
------------------------------------------------*/

    if( $(window).width() < 767 ) {
        $('#top-bar').click(function(){
            $('#top-bar .wrapper').slideToggle();
            $('#top-bar').toggleClass('top-menu-active');
            $('.menu-overlay').toggleClass('active');
        });
    }

    menu_toggle.click(function(){
        nav_menu.slideToggle();
       $('.main-navigation').toggleClass('menu-open');
       $('.menu-overlay').toggleClass('active');
    });

    dropdown_toggle.click(function() {
        $(this).toggleClass('active');
       $(this).parent().find('.sub-menu').first().slideToggle();
    });

    $(window).scroll(function() {
        if ($(this).scrollTop() > 1) {
            $('.menu-sticky #masthead').addClass('nav-shrink');
        }
        else {
            $('.menu-sticky #masthead').removeClass('nav-shrink');
        }
    });

/*--------------------------------------------------------------
 Keyboard Navigation
----------------------------------------------------------------*/
if( $(window).width() < 1024 ) {
    $('#primary-menu').find("li").last().bind( 'keydown', function(e) {
        if( e.which === 9 ) {
            e.preventDefault();
            $('#masthead').find('.menu-toggle').focus();
        }
    });
}
else {
    $( '#primary-menu li:last-child' ).unbind('keydown');
}

$(window).resize(function() {
    if( $(window).width() < 1024 ) {
        $('#primary-menu').find("li").last().bind( 'keydown', function(e) {
            if( e.which === 9 ) {
                e.preventDefault();
                $('#masthead').find('.menu-toggle').focus();
            }
        });
    }
    else {
        $( '#primary-menu li:last-child' ).unbind('keydown');
    }
});

/*------------------------------------------------
            SLICK SLIDER
------------------------------------------------*/

$('#featured-slider').slick({
    customPaging : function(slider, i) {
        var title = $(slider.$slides[i]).data('title');
        return '<div class="slider-nav"><span class="slide-title">'+title+'</span>';
    }
});

$('.tours-slider').slick({
    responsive: [{
        breakpoint: 992,
            settings: {
            slidesToShow: 3
        }
    },
    {
        breakpoint: 767,
        settings: {
            slidesToShow: 2
        }
    },
    {
        breakpoint: 550,
        settings: {
            slidesToShow: 1
        }
    }]
});

$('.posts-slider').slick({
    responsive: [{
        breakpoint: 1024,
            settings: {
            slidesToShow: 2
        }
    },
    {
        breakpoint: 767,
        settings: {
            slidesToShow: 1
        }
    }]
});
/*------------------------------------------------
            MATCH HEIGHT
------------------------------------------------*/

$('#travel-preparation .prepared-list .item-wrapper').matchHeight();
$('#travel-destinations article').matchHeight();
$('.item-wrapper').matchHeight();


/*------------------------------------------------
                END JQUERY
------------------------------------------------*/

});