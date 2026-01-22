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
    // Donation Stripe
    // =========================================================================

    wp.customize('3to5_donation_stripe_text', function(value) {
        value.bind(function(newval) {
            $('.donation-stripe__text p').text(newval);
        });
    });

    wp.customize('3to5_donation_stripe_btn_text', function(value) {
        value.bind(function(newval) {
            $('.btn--donate').text(newval);
        });
    });

    wp.customize('3to5_donation_stripe_btn_link', function(value) {
        value.bind(function(newval) {
            $('.btn--donate').attr('href', newval);
            // Also update footer button if it's using the default
            var $footerBtn = $('.btn--footer-donate');
            if ($footerBtn.length && !wp.customize('3to5_footer_donation_btn_link').get()) {
                $footerBtn.attr('href', newval);
            }
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

    // Note: About content uses 'refresh' transport due to WYSIWYG editor

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

    // Location items (dynamic repeater)
    wp.customize('3to5_location_items', function(value) {
        value.bind(function(newval) {
            var locations = [];

            // Parse JSON if string
            if (typeof newval === 'string') {
                try {
                    locations = JSON.parse(newval);
                } catch (e) {
                    locations = [];
                }
            } else if (Array.isArray(newval)) {
                locations = newval;
            }

            var $locationsList = $('.locations__list');

            // If locations section doesn't exist and we have locations, we need a refresh
            if ($locationsList.length === 0 && locations.length > 0) {
                return;
            }

            // Clear existing location items
            $locationsList.empty();

            // Add new location items
            locations.forEach(function(location, index) {
                if (location.name) {
                    var $item = $(
                        '<article class="location-card" data-location-index="' + index + '">' +
                            '<h3 class="location-card__name">' + escapeHtml(location.name) + '</h3>' +
                            (location.address ? '<p class="location-card__address">' + escapeHtml(location.address) + '</p>' : '') +
                            (location.hours ? '<p class="location-card__hours"><strong>Hours:</strong> ' + escapeHtml(location.hours) + '</p>' : '') +
                        '</article>'
                    );

                    $locationsList.append($item);
                }
            });

            // Show/hide the entire locations section based on content
            var $locationsSection = $('.locations.section');
            if (locations.length === 0 || !locations.some(function(l) { return l.name; })) {
                $locationsSection.hide();
            } else {
                $locationsSection.show();
            }
        });
    });

    // =========================================================================
    // FAQ Section
    // =========================================================================

    wp.customize('3to5_faq_title', function(value) {
        value.bind(function(newval) {
            $('.faq > .container > h2').text(newval);
        });
    });

    // FAQ items (dynamic repeater)
    wp.customize('3to5_faq_items', function(value) {
        value.bind(function(newval) {
            var faqs = [];

            // Parse JSON if string
            if (typeof newval === 'string') {
                try {
                    faqs = JSON.parse(newval);
                } catch (e) {
                    faqs = [];
                }
            } else if (Array.isArray(newval)) {
                faqs = newval;
            }

            var $faqList = $('.faq__list');

            // If FAQ section doesn't exist and we have FAQs, we need a refresh
            if ($faqList.length === 0 && faqs.length > 0) {
                return;
            }

            // Clear existing FAQ items
            $faqList.empty();

            // Add new FAQ items
            faqs.forEach(function(faq, index) {
                if (faq.question && faq.answer) {
                    var answerHtml = '<p>' + faq.answer.replace(/\n\n/g, '</p><p>').replace(/\n/g, '<br>') + '</p>';

                    var $item = $(
                        '<div class="faq-item" data-faq-index="' + index + '">' +
                            '<button class="faq-item__question" aria-expanded="false">' +
                                escapeHtml(faq.question) +
                            '</button>' +
                            '<div class="faq-item__answer" aria-hidden="true">' +
                                answerHtml +
                            '</div>' +
                        '</div>'
                    );

                    $faqList.append($item);
                }
            });

            // Show/hide the entire FAQ section based on content
            var $faqSection = $('.faq.section');
            if (faqs.length === 0 || !faqs.some(function(f) { return f.question && f.answer; })) {
                $faqSection.hide();
            } else {
                $faqSection.show();
            }
        });
    });

    /**
     * Escape HTML entities for safe output
     */
    function escapeHtml(text) {
        if (!text) return '';
        var div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
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

    wp.customize('3to5_footer_donation_title', function(value) {
        value.bind(function(newval) {
            $('.footer__donate-content h4').text(newval);
        });
    });

    wp.customize('3to5_footer_donation_text', function(value) {
        value.bind(function(newval) {
            $('.footer__donate-content p').text(newval);
        });
    });

    wp.customize('3to5_footer_donation_btn_text', function(value) {
        value.bind(function(newval) {
            $('.btn--footer-donate').text(newval);
        });
    });

    wp.customize('3to5_footer_donation_btn_link', function(value) {
        value.bind(function(newval) {
            if (newval) {
                $('.btn--footer-donate').attr('href', newval);
            } else {
                // Fall back to stripe link
                var stripeLink = wp.customize('3to5_donation_stripe_btn_link').get() || '#';
                $('.btn--footer-donate').attr('href', stripeLink);
            }
        });
    });

    wp.customize('3to5_footer_text', function(value) {
        value.bind(function(newval) {
            $('.footer__bottom p').first().html(newval);
        });
    });

})(jQuery);
