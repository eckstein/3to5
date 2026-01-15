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
            // Reason graphic
            wp.customize('3to5_reason_' + index + '_graphic', function(value) {
                value.bind(function(newval) {
                    $('.reason-card').eq(index - 1).find('.reason-card__graphic').attr('src', newval);
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

    wp.customize('3to5_footer_text', function(value) {
        value.bind(function(newval) {
            $('.footer__bottom p').first().html(newval);
        });
    });

})(jQuery);
