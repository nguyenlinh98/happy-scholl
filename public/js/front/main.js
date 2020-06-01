$(function () {
    /* very hacky addition of touchend event for mobile Safari */

    if (/^((?!chrome|android).)*safari/i.test(navigator.userAgent)) {
        var clickableElements = ".x-anchor-toggle, button, .x-anchor-button, li.menu-item, input.submit, .x-scroll-top";
        jQuery(clickableElements).attr("style", "cursor: pointer;");
        jQuery(clickableElements).bind("touchend", function (e) {
            jQuery(this).trigger("click");
        });
    }
    $(document).ready(function () {
        $('#choose-lang').change(function () {
            var url = $(this).find('option:selected').data('url');
            window.location.href = url;
        });
    });
    if ($('.slide.owl-carousel').length > 0) {
        $(".slide.owl-carousel").owlCarousel({
            nav: false,
            loop: true,
            center: true,
            autoplay: false,
            autoplayTimeout: 5000,
            autoplayHoverPause: false,
            dots: true,
            items: 1,
            responsive: {
                767: {
                    items: 1
                }
            }
        });
    }
    $('.change-view button').on('click', function () {
        // $('#calendar').fullCalendar('changeView', $(this).attr('data'));
    })
    $('.ahref').on('click', function () {
        var url = $(this).data('href');
        window.location.href = url;
    });
    $('body').on('click touchstart', function (e) {
        if ($(window).width() > 1023) {
            if ((!$('.menu-select a').is(e.target)&& !$('.menu-select li').is(e.target)&& !$('.menu-select a.resize-img span').is(e.target))) {
                $('#menu').removeClass('show');
            }
        }else {
            if ((!$('.menu-select a').is(e.target)&& !$('.menu-select li').is(e.target)&& !$('.menu-select a.resize-img img').is(e.target))) {
                $('#menu').removeClass('show');
            }
        }

    });
    //ON OFF input
    if ($('.sw-d label input:checked').length > 0) {
        $('.sw-d small').text("ON");
    } else {
        $('.sw-d small').text("OFF");
    }
    $(".sw-d label input").change(function () {
        if (this.checked) {
            $('.sw-d small').text("ON");
        } else {
            $('.sw-d small').text("OFF");
        }
    });

    //Scroll fixed menu

    // Hide Header on on scroll down
    var didScroll;
    var lastScrollTop = 0;
    var delta = 0;
    var navbarHeight = $('.nav-top').outerHeight();
    var menuSelect = $('.menu-select');
    $(window).scroll(function (event) {
        didScroll = true;
    });

    //Check menu exist
    if ($('.nav-top').length > 0) {
        //Add padding
        $('main').css('padding-top', '84px');
        var offset_top = navbarHeight - 10;
        var fixedMenuSelect = 0;
        if ($('.menu-select').length > 0) {
            fixedMenuSelect = $('.menu-select').offset().top;
        }

        $(window).bind('scroll', function () {
            //If mouse
            if ($(window).scrollTop() > offset_top) {
                $('.nav-top').css('top', '0');
                $('.menu-select').css('top', '50px');
                if ($(window).width() > 1024) {
                    $(".menu-select select").appendTo(".nav-top");
                }

                if (menuSelect.length > 0) {
                    // menuSelect.addClass('fixed-t');
                }
            } else {
                if (didScroll) {
                    hasScrolled();
                    didScroll = false;
                }
                if ($(window).width() < 1024) {
                    topMenuSelect = fixedMenuSelect - $(window).scrollTop();
                    if (topMenuSelect < 50) {
                        topMenuSelect = 50;
                    }
                    $('.menu-select').css('top', topMenuSelect);
                } else {
                    $('.menu-select').removeAttr('style');
                }
                $('.nav-top').removeAttr('style');
                // $('.menu-select').removeAttr('style');
                $(".nav-top select").prependTo(".menu-select");
                if (menuSelect.length > 0) {
                    //menuSelect.removeClass('fixed-t');
                }
            }
        });
    } else {
        if (didScroll) {
            hasScrolled();
            didScroll = false;
        }
    }


    function hasScrolled() {
        var st = $(this).scrollTop();

        // Make sure they scroll more than delta
        if (Math.abs(lastScrollTop - st) <= delta)
            return;
        if (st > lastScrollTop && st > navbarHeight) {
            // Scroll Down
            $('.header').css('transform', 'translateY(-100%)');
        } else {
            // Scroll Up

        }
        lastScrollTop = st;
    }
    /*Remove hover in mobile*/
    function hasTouch() {
        return 'ontouchstart' in document.documentElement
            || navigator.maxTouchPoints > 0
            || navigator.msMaxTouchPoints > 0;
    }
    if (hasTouch()) { // remove all the :hover stylesheets
        try { // prevent exception on browsers not supporting DOM styleSheets properly
            console.log('sssss12');
            for (var si in document.styleSheets) {
                var styleSheet = document.styleSheets[si];
                if (!styleSheet.rules) continue;

                for (var ri = styleSheet.rules.length - 1; ri >= 0; ri--) {
                    if (!styleSheet.rules[ri].selectorText) continue;

                    if (styleSheet.rules[ri].selectorText.match(':hover')) {
                        styleSheet.deleteRule(ri);
                    }
                }
            }
        } catch (ex) {console.log(ex);}
    }
});

// Valid phone numbers.
function validPhoneNumber(input, tranlation) {
    var text = input.value;

    if (0 === text.length) { // Empty input
        $(input).removeClass('is-invalid');
        $('.valid-phone-msg').html('');
    } else if (text.match(/^[^0]\d{0,12}/)) { // Has trunk prefix leading
        $(input).addClass('is-invalid');
        // $('.valid-phone-msg').html("Phone number must start with 0 digit.");
        $('.valid-phone-msg').html(tranlation.startWithZero);
    }
}

$.fn.textWidth = function (text) {
    var org = $(this)
    var html = $('<span style="postion:absolute;width:auto;left:-9999px">' + (text || org.html()) + '</span>');
    if (!text) {
        html.css("font-family", org.css("font-family"));
        html.css("font-size", org.css("font-size"));
    }
    $('body').append(html);
    var width = html.width();
    html.remove();
    return width;
}
