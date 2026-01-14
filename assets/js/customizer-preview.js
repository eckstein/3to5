/**
 * 3 to 5 Theme - Customizer Live Preview
 *
 * @package 3to5
 */

(function($) {
    'use strict';

    // Hero Section
    wp.customize('3to5_hero_tagline', function(value) {
        value.bind(function(to) {
            $('.hero__tagline').text(to);
        });
    });

    wp.customize('3to5_hero_title', function(value) {
        value.bind(function(to) {
            $('.hero__title').text(to);
        });
    });

    wp.customize('3to5_hero_subtitle', function(value) {
        value.bind(function(to) {
            $('.hero__subtitle').text(to);
        });
    });

    wp.customize('3to5_hero_cta_text', function(value) {
        value.bind(function(to) {
            $('.hero__buttons .btn--primary').text(to);
        });
    });

    wp.customize('3to5_hero_cta2_text', function(value) {
        value.bind(function(to) {
            $('.hero__buttons .btn--secondary').text(to);
        });
    });

    // About Section
    wp.customize('3to5_about_title', function(value) {
        value.bind(function(to) {
            $('.about__content h2').text(to);
        });
    });

    // Reasons Section
    wp.customize('3to5_reasons_title', function(value) {
        value.bind(function(to) {
            $('.why h2').text(to);
        });
    });

    // Action Section
    wp.customize('3to5_action_title', function(value) {
        value.bind(function(to) {
            $('.action h2').text(to);
        });
    });

    wp.customize('3to5_action_subtitle', function(value) {
        value.bind(function(to) {
            $('.action > .container > p').first().text(to);
        });
    });

    // Locations Section
    wp.customize('3to5_locations_title', function(value) {
        value.bind(function(to) {
            $('.locations h2').text(to);
        });
    });

    // FAQ Section
    wp.customize('3to5_faq_title', function(value) {
        value.bind(function(to) {
            $('.faq h2').text(to);
        });
    });

    // Contact Section
    wp.customize('3to5_contact_title', function(value) {
        value.bind(function(to) {
            $('.contact h2').first().text(to);
        });
    });

    // Footer Text
    wp.customize('3to5_footer_text', function(value) {
        value.bind(function(to) {
            $('.footer__bottom p').first().html(to);
        });
    });

})(jQuery);
