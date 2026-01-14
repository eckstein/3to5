/**
 * 3 to 5 Theme - Customizer FAQ Repeater
 *
 * Handles dynamic add/remove/reorder of FAQ items in the Customizer.
 *
 * @package 3to5
 */

(function($) {
    'use strict';

    // Wait for the customizer to be ready
    wp.customize.bind('ready', function() {
        initFaqRepeaters();
    });

    /**
     * Initialize all FAQ repeater controls
     */
    function initFaqRepeaters() {
        $('.faq-repeater-control').each(function() {
            var $control = $(this);
            var $input = $control.find('.faq-repeater-value');
            var $itemsContainer = $control.find('.faq-repeater-items');

            // Make items sortable
            $itemsContainer.sortable({
                handle: '.faq-repeater-item-header',
                placeholder: 'faq-repeater-placeholder',
                update: function() {
                    updateValue($control);
                }
            });

            // Toggle item content
            $control.on('click', '.faq-repeater-toggle', function(e) {
                e.preventDefault();
                var $item = $(this).closest('.faq-repeater-item');
                var $content = $item.find('.faq-repeater-item-content');
                var $icon = $(this).find('.dashicons');
                var isExpanded = $(this).attr('aria-expanded') === 'true';

                if (isExpanded) {
                    $content.slideUp(200);
                    $(this).attr('aria-expanded', 'false');
                    $icon.removeClass('dashicons-arrow-up-alt2').addClass('dashicons-arrow-down-alt2');
                } else {
                    $content.slideDown(200);
                    $(this).attr('aria-expanded', 'true');
                    $icon.removeClass('dashicons-arrow-down-alt2').addClass('dashicons-arrow-up-alt2');
                }
            });

            // Update on field change
            $control.on('input change', '.faq-question, .faq-answer', function() {
                var $item = $(this).closest('.faq-repeater-item');
                var question = $item.find('.faq-question').val();

                // Update header title
                $item.find('.faq-repeater-item-title').text(question || 'New FAQ');

                updateValue($control);
            });

            // Add new FAQ
            $control.on('click', '.faq-repeater-add', function(e) {
                e.preventDefault();

                var newIndex = $itemsContainer.find('.faq-repeater-item').length;
                var $newItem = createFaqItem(newIndex, { question: '', answer: '' });

                $itemsContainer.append($newItem);

                // Open the new item
                $newItem.find('.faq-repeater-toggle').trigger('click');
                $newItem.find('.faq-question').focus();

                updateValue($control);
            });

            // Remove FAQ
            $control.on('click', '.faq-repeater-remove', function(e) {
                e.preventDefault();

                var $item = $(this).closest('.faq-repeater-item');

                $item.slideUp(200, function() {
                    $item.remove();
                    reindexItems($itemsContainer);
                    updateValue($control);
                });
            });
        });
    }

    /**
     * Create a new FAQ item element
     */
    function createFaqItem(index, data) {
        var question = data.question || '';
        var answer = data.answer || '';
        var title = question || 'New FAQ';

        var html = '<div class="faq-repeater-item" data-index="' + index + '">' +
            '<div class="faq-repeater-item-header">' +
                '<span class="faq-repeater-item-title">' + escapeHtml(title) + '</span>' +
                '<button type="button" class="faq-repeater-toggle" aria-expanded="false">' +
                    '<span class="screen-reader-text">Toggle</span>' +
                    '<span class="dashicons dashicons-arrow-down-alt2"></span>' +
                '</button>' +
            '</div>' +
            '<div class="faq-repeater-item-content" style="display: none;">' +
                '<p>' +
                    '<label>Question</label>' +
                    '<input type="text" class="faq-question widefat" value="' + escapeHtml(question) + '">' +
                '</p>' +
                '<p>' +
                    '<label>Answer</label>' +
                    '<textarea class="faq-answer widefat" rows="4">' + escapeHtml(answer) + '</textarea>' +
                '</p>' +
                '<p class="faq-repeater-item-actions">' +
                    '<button type="button" class="button faq-repeater-remove">Remove</button>' +
                '</p>' +
            '</div>' +
        '</div>';

        return $(html);
    }

    /**
     * Re-index items after removal
     */
    function reindexItems($container) {
        $container.find('.faq-repeater-item').each(function(index) {
            $(this).attr('data-index', index);
        });
    }

    /**
     * Update the hidden input value and trigger customizer change
     */
    function updateValue($control) {
        var $input = $control.find('.faq-repeater-value');
        var $items = $control.find('.faq-repeater-item');
        var faqs = [];

        $items.each(function() {
            var question = $(this).find('.faq-question').val();
            var answer = $(this).find('.faq-answer').val();

            faqs.push({
                question: question,
                answer: answer
            });
        });

        var jsonValue = JSON.stringify(faqs);
        $input.val(jsonValue).trigger('change');
    }

    /**
     * Escape HTML entities
     */
    function escapeHtml(text) {
        if (!text) return '';
        var div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

})(jQuery);
