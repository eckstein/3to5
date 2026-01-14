/**
 * 3 to 5 Theme - Customizer Live Preview
 *
 * @package 3to5
 */

(function($) {
    'use strict';

    // Make sure wp.customize exists
    if (typeof wp === 'undefined' || typeof wp.customize === 'undefined') {
        return;
    }

    // =========================================================================
    // Hero Section
    // =========================================================================

    wp.customize('3to5_hero_tagline', function(value) {
        value.bind(function(newval) {
            $('.hero__tagline').text(newval);
        });
    });

    wp.customize('3to5_hero_title', function(value) {
        value.bind(function(newval) {
            $('.hero__title').text(newval);
        });
    });

    wp.customize('3to5_hero_subtitle', function(value) {
        value.bind(function(newval) {
            $('.hero__subtitle').text(newval);
        });
    });

    wp.customize('3to5_hero_cta_text', function(value) {
        value.bind(function(newval) {
            $('.hero__buttons .btn--primary').text(newval);
        });
    });

    wp.customize('3to5_hero_cta2_text', function(value) {
        value.bind(function(newval) {
            $('.hero__buttons .btn--secondary').text(newval);
        });
    });

    // =========================================================================
    // About Section
    // =========================================================================

    wp.customize('3to5_about_title', function(value) {
        value.bind(function(newval) {
            $('.about .about__content h2').text(newval);
        });
    });

    wp.customize('3to5_about_content', function(value) {
        value.bind(function(newval) {
            // Convert newlines to paragraphs
            var html = '<p>' + newval.replace(/\n\n/g, '</p><p>').replace(/\n/g, '<br>') + '</p>';
            $('.about .about__content h2').nextAll('p').remove();
            $('.about .about__content h2').after(html);
        });
    });

    // =========================================================================
    // Reasons Section
    // =========================================================================

    wp.customize('3to5_reasons_title', function(value) {
        value.bind(function(newval) {
            $('.why > .container > h2').text(newval);
        });
    });

    // Reason cards (1-4)
    for (var i = 1; i <= 4; i++) {
        (function(index) {
            wp.customize('3to5_reason_' + index + '_title', function(value) {
                value.bind(function(newval) {
                    $('.reason-card').eq(index - 1).find('.reason-card__title').text(newval);
                });
            });

            wp.customize('3to5_reason_' + index + '_text', function(value) {
                value.bind(function(newval) {
                    $('.reason-card').eq(index - 1).find('.reason-card__text').text(newval);
                });
            });
        })(i);
    }

    // =========================================================================
    // Action Section
    // =========================================================================

    wp.customize('3to5_action_title', function(value) {
        value.bind(function(newval) {
            $('.action > .container > h2').text(newval);
        });
    });

    wp.customize('3to5_action_subtitle', function(value) {
        value.bind(function(newval) {
            $('.action > .container > p').first().text(newval);
        });
    });

    // Action steps (1-3)
    for (var j = 1; j <= 3; j++) {
        (function(index) {
            wp.customize('3to5_step_' + index + '_title', function(value) {
                value.bind(function(newval) {
                    $('.action-step').eq(index - 1).find('.action-step__title').text(newval);
                });
            });

            wp.customize('3to5_step_' + index + '_text', function(value) {
                value.bind(function(newval) {
                    $('.action-step').eq(index - 1).find('.action-step__text').text(newval);
                });
            });
        })(j);
    }

    // =========================================================================
    // Locations Section
    // =========================================================================

    wp.customize('3to5_locations_title', function(value) {
        value.bind(function(newval) {
            $('.locations > .container > h2').text(newval);
        });
    });

    // Location cards (1-4)
    for (var k = 1; k <= 4; k++) {
        (function(index) {
            wp.customize('3to5_location_' + index + '_name', function(value) {
                value.bind(function(newval) {
                    $('.location-card').eq(index - 1).find('.location-card__name').text(newval);
                });
            });

            wp.customize('3to5_location_' + index + '_address', function(value) {
                value.bind(function(newval) {
                    $('.location-card').eq(index - 1).find('.location-card__address').text(newval);
                });
            });
        })(k);
    }

    // =========================================================================
    // FAQ Section
    // =========================================================================

    wp.customize('3to5_faq_title', function(value) {
        value.bind(function(newval) {
            $('.faq > .container > h2').text(newval);
        });
    });

    // FAQ items (1-5)
    for (var l = 1; l <= 5; l++) {
        (function(index) {
            wp.customize('3to5_faq_' + index + '_question', function(value) {
                value.bind(function(newval) {
                    $('.faq-item').eq(index - 1).find('.faq-item__question').contents().first().replaceWith(newval);
                });
            });

            wp.customize('3to5_faq_' + index + '_answer', function(value) {
                value.bind(function(newval) {
                    var html = '<p>' + newval.replace(/\n\n/g, '</p><p>').replace(/\n/g, '<br>') + '</p>';
                    $('.faq-item').eq(index - 1).find('.faq-item__answer').html(html);
                });
            });
        })(l);
    }

    // =========================================================================
    // Contact Section
    // =========================================================================

    wp.customize('3to5_contact_title', function(value) {
        value.bind(function(newval) {
            $('.contact > .container > h2').first().text(newval);
        });
    });

    // =========================================================================
    // Footer
    // =========================================================================

    wp.customize('3to5_footer_text', function(value) {
        value.bind(function(newval) {
            $('.footer__bottom p').first().html(newval);
        });
    });

})(jQuery);
