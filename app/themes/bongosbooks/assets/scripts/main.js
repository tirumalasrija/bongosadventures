/* ========================================================================
 * DOM-based Routing
 * Based on http://goo.gl/EUTi53 by Paul Irish
 *
 * Only fires on body classes that match. If a body class contains a dash,
 * replace the dash with an underscore when adding it to the object below.
 *
 * .noConflict()
 * The routing is enclosed within an anonymous function so that you can
 * always reference jQuery with $, even when in .noConflict() mode.
 * ======================================================================== */

(function ($) {

    // Namespace contains common and page-specific functions.
    var TMBase = {

        // All pages
        'common': {
            init: function () {

                // Remove html.no-js
                $('html').removeClass('no-js');

                // Primary navigation menu
                var primaryNavigation = $('#js-primary-nav'),
                    menuToggle = $('#js-toggle-nav-main').unbind();

                menuToggle.on('click', function (e) {
                    e.preventDefault();
                    $('body').toggleClass('nav-open');
                    primaryNavigation.slideToggle(function () {
                        if (primaryNavigation.is(':hidden')) {
                            primaryNavigation.removeAttr('style');
                        }
                    });
                });
            },
            finalize: function () {
                // JavaScript to be fired on all pages, after page specific JS is fired

                $(".cat-bar li a").bind("click", function () {
                    $(".cat-bar li a").removeClass("clicked");
                    $(this).addClass("clicked");
                });

                // Additional character content functionality, displayed on character archives
                $('.content-display-link').bind("click", function() {
                    $('.content-item').hide();
                    var target = $(this).attr("data-target");
                    var showElement = $('#' + target);
                    $(showElement).show();
                });
            }
        },

        // Pages with rotators
        'has_rotator': {
            init: function () {

                /**
                 * Initialize Rotators
                 */
                var rotators = $('.rotator-wrap');
                $(rotators).each(function (i) {
                    var owlEl = $(rotators[i]).find('.rotator'),
                        slides = $(rotators[i]).find('.banner'),
                        prevSlide = $(rotators[i]).find('.rotator-prev'),
                        nextSlide = $(rotators[i]).find('.rotator-next');

                    if (slides.length > 1) {
                        $(owlEl).owlCarousel({
                            animateOut: 'fadeOut',
                            items: 1,
                            loop: true
                        });
                        if (prevSlide.length) {
                            prevSlide.on('click', function () {
                                owlEl.trigger('prev.owl.carousel');
                            });
                        }
                        if (nextSlide.length) {
                            nextSlide.on('click', function () {
                                owlEl.trigger('next.owl.carousel');
                            });
                        }
                    }
                });
            }
        }
    };

    // The routing fires all common scripts, followed by the page specific scripts.
    // Add additional events for more control over timing e.g. a finalize event
    var UTIL = {
        fire: function (func, funcname, args) {
            var fire;
            var namespace = TMBase;
            funcname = (funcname === undefined) ? 'init' : funcname;
            fire = func !== '';
            fire = fire && namespace[func];
            fire = fire && typeof namespace[func][funcname] === 'function';

            if (fire) {
                namespace[func][funcname](args);
            }
        },
        loadEvents: function () {
            // Fire common init JS
            UTIL.fire('common');

            // Fire page-specific init JS, and then finalize JS
            $.each(document.body.className.replace(/-/g, '_').split(/\s+/), function (i, classnm) {
                UTIL.fire(classnm);
                UTIL.fire(classnm, 'finalize');
            });

            // Fire common finalize JS
            UTIL.fire('common', 'finalize');
        }
    };

    // Load Events
    $(document).ready(UTIL.loadEvents);

})(jQuery); // Fully reference jQuery after this point.
