/**
 * 3 to 5 Theme - Customizer Repeater Controls
 *
 * Handles dynamic add/remove/reorder of FAQ and Location items in the Customizer.
 *
 * @package 3to5
 */

(function($) {
    'use strict';

    // Wait for the customizer to be ready
    wp.customize.bind('ready', function() {
        initFaqRepeaters();
        initLocationsRepeaters();
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

    // =========================================================================
    // Locations Repeater
    // =========================================================================

    /**
     * Initialize all Locations repeater controls
     */
    function initLocationsRepeaters() {
        $('.locations-repeater-control').each(function() {
            var $control = $(this);
            var $input = $control.find('.locations-repeater-value');
            var $itemsContainer = $control.find('.locations-repeater-items');

            // Make items sortable
            $itemsContainer.sortable({
                handle: '.locations-repeater-item-header',
                placeholder: 'locations-repeater-placeholder',
                update: function() {
                    updateLocationsValue($control);
                }
            });

            // Toggle item content
            $control.on('click', '.locations-repeater-toggle', function(e) {
                e.preventDefault();
                var $item = $(this).closest('.locations-repeater-item');
                var $content = $item.find('.locations-repeater-item-content');
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
            $control.on('input change', '.location-name, .location-address, .location-hours', function() {
                var $item = $(this).closest('.locations-repeater-item');
                var name = $item.find('.location-name').val();

                // Update header title
                $item.find('.locations-repeater-item-title').text(name || 'New Location');

                updateLocationsValue($control);
            });

            // Add new location
            $control.on('click', '.locations-repeater-add', function(e) {
                e.preventDefault();

                var newIndex = $itemsContainer.find('.locations-repeater-item').length;
                var $newItem = createLocationItem(newIndex, { name: '', address: '', hours: '' });

                $itemsContainer.append($newItem);

                // Open the new item
                $newItem.find('.locations-repeater-toggle').trigger('click');
                $newItem.find('.location-name').focus();

                updateLocationsValue($control);
            });

            // Remove location
            $control.on('click', '.locations-repeater-remove', function(e) {
                e.preventDefault();

                var $item = $(this).closest('.locations-repeater-item');

                $item.slideUp(200, function() {
                    $item.remove();
                    reindexLocationItems($itemsContainer);
                    updateLocationsValue($control);
                });
            });
        });
    }

    /**
     * Create a new location item element
     */
    function createLocationItem(index, data) {
        var name = data.name || '';
        var address = data.address || '';
        var hours = data.hours || '';
        var title = name || 'New Location';

        var html = '<div class="locations-repeater-item" data-index="' + index + '">' +
            '<div class="locations-repeater-item-header">' +
                '<span class="locations-repeater-item-title">' + escapeHtml(title) + '</span>' +
                '<button type="button" class="locations-repeater-toggle" aria-expanded="false">' +
                    '<span class="screen-reader-text">Toggle</span>' +
                    '<span class="dashicons dashicons-arrow-down-alt2"></span>' +
                '</button>' +
            '</div>' +
            '<div class="locations-repeater-item-content" style="display: none;">' +
                '<p>' +
                    '<label>Name</label>' +
                    '<input type="text" class="location-name widefat" value="' + escapeHtml(name) + '">' +
                '</p>' +
                '<p>' +
                    '<label>Address</label>' +
                    '<input type="text" class="location-address widefat" value="' + escapeHtml(address) + '">' +
                '</p>' +
                '<p>' +
                    '<label>Hours</label>' +
                    '<input type="text" class="location-hours widefat" value="' + escapeHtml(hours) + '">' +
                '</p>' +
                '<p class="locations-repeater-item-actions">' +
                    '<button type="button" class="button locations-repeater-remove">Remove</button>' +
                '</p>' +
            '</div>' +
        '</div>';

        return $(html);
    }

    /**
     * Re-index location items after removal
     */
    function reindexLocationItems($container) {
        $container.find('.locations-repeater-item').each(function(index) {
            $(this).attr('data-index', index);
        });
    }

    /**
     * Update the hidden input value and trigger customizer change
     */
    function updateLocationsValue($control) {
        var $input = $control.find('.locations-repeater-value');
        var $items = $control.find('.locations-repeater-item');
        var locations = [];

        $items.each(function() {
            var name = $(this).find('.location-name').val();
            var address = $(this).find('.location-address').val();
            var hours = $(this).find('.location-hours').val();

            locations.push({
                name: name,
                address: address,
                hours: hours
            });
        });

        var jsonValue = JSON.stringify(locations);
        $input.val(jsonValue).trigger('change');
    }

})(jQuery);
