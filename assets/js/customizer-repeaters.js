/**
 * 3 to 5 Theme - Customizer Repeater Controls
 *
 * Unified handler for all repeater controls (FAQ, Locations, Quotes).
 *
 * @package 3to5
 */

(function($) {
    'use strict';

    /**
     * Repeater type configurations
     * Each type defines its fields, default title field, and labels
     */
    var repeaterTypes = {
        faq: {
            fields: ['question', 'answer'],
            titleField: 'question',
            defaultTitle: 'New FAQ',
            fieldTemplates: {
                question: '<input type="text" class="repeater-field-question widefat" value="">',
                answer: '<textarea class="repeater-field-answer widefat" rows="4"></textarea>'
            },
            fieldLabels: {
                question: 'Question',
                answer: 'Answer'
            }
        },
        locations: {
            fields: ['name', 'address', 'hours'],
            titleField: 'name',
            defaultTitle: 'New Location',
            fieldTemplates: {
                name: '<input type="text" class="repeater-field-name widefat" value="">',
                address: '<input type="text" class="repeater-field-address widefat" value="">',
                hours: '<input type="text" class="repeater-field-hours widefat" value="">'
            },
            fieldLabels: {
                name: 'Name',
                address: 'Address',
                hours: 'Hours'
            }
        },
        quotes: {
            fields: ['text', 'author', 'title'],
            titleField: 'author',
            defaultTitle: 'New Quote',
            fieldTemplates: {
                text: '<textarea class="repeater-field-text widefat" rows="3"></textarea>',
                author: '<input type="text" class="repeater-field-author widefat" value="">',
                title: '<input type="text" class="repeater-field-title widefat" value="">'
            },
            fieldLabels: {
                text: 'Quote Text',
                author: 'Author Name',
                title: 'Author Title/Role (optional)'
            }
        }
    };

    // Wait for the customizer to be ready
    wp.customize.bind('ready', function() {
        initRepeaters();
    });

    /**
     * Initialize all repeater controls
     */
    function initRepeaters() {
        $('.repeater-control').each(function() {
            var $control = $(this);
            var type = $control.data('repeater-type');
            var config = repeaterTypes[type];

            if (!config) {
                console.warn('Unknown repeater type:', type);
                return;
            }

            var $itemsContainer = $control.find('.repeater-items');

            // Make items sortable
            $itemsContainer.sortable({
                handle: '.repeater-item-header',
                placeholder: 'repeater-placeholder',
                update: function() {
                    updateValue($control, config);
                }
            });

            // Toggle item content
            $control.on('click', '.repeater-toggle', function(e) {
                e.preventDefault();
                var $item = $(this).closest('.repeater-item');
                var $content = $item.find('.repeater-item-content');
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

            // Update on any field change
            var fieldSelectors = config.fields.map(function(f) {
                return '.repeater-field-' + f;
            }).join(', ');

            $control.on('input change', fieldSelectors, function() {
                var $item = $(this).closest('.repeater-item');
                var titleValue = $item.find('.repeater-field-' + config.titleField).val();

                // Update header title
                $item.find('.repeater-item-title').text(titleValue || config.defaultTitle);

                updateValue($control, config);
            });

            // Add new item
            $control.on('click', '.repeater-add', function(e) {
                e.preventDefault();

                var newIndex = $itemsContainer.find('.repeater-item').length;
                var emptyData = {};
                config.fields.forEach(function(f) {
                    emptyData[f] = '';
                });

                var $newItem = createItem(newIndex, emptyData, config);
                $itemsContainer.append($newItem);

                // Open the new item
                $newItem.find('.repeater-toggle').trigger('click');
                $newItem.find('.repeater-field-' + config.fields[0]).focus();

                updateValue($control, config);
            });

            // Remove item
            $control.on('click', '.repeater-remove', function(e) {
                e.preventDefault();

                var $item = $(this).closest('.repeater-item');

                $item.slideUp(200, function() {
                    $item.remove();
                    reindexItems($itemsContainer);
                    updateValue($control, config);
                });
            });
        });
    }

    /**
     * Create a new repeater item element
     */
    function createItem(index, data, config) {
        var titleValue = data[config.titleField] || config.defaultTitle;

        var html = '<div class="repeater-item" data-index="' + index + '">' +
            '<div class="repeater-item-header">' +
                '<span class="repeater-item-title">' + escapeHtml(titleValue) + '</span>' +
                '<button type="button" class="repeater-toggle" aria-expanded="false">' +
                    '<span class="screen-reader-text">Toggle</span>' +
                    '<span class="dashicons dashicons-arrow-down-alt2"></span>' +
                '</button>' +
            '</div>' +
            '<div class="repeater-item-content" style="display: none;">';

        // Add fields
        config.fields.forEach(function(field) {
            var value = data[field] || '';
            var template = config.fieldTemplates[field];
            var label = config.fieldLabels[field];

            // Insert value into template
            if (template.indexOf('textarea') !== -1) {
                template = template.replace('></textarea>', '>' + escapeHtml(value) + '</textarea>');
            } else {
                template = template.replace('value=""', 'value="' + escapeHtml(value) + '"');
            }

            html += '<p><label>' + label + '</label>' + template + '</p>';
        });

        html += '<p class="repeater-item-actions">' +
                    '<button type="button" class="button repeater-remove">Remove</button>' +
                '</p>' +
            '</div>' +
        '</div>';

        return $(html);
    }

    /**
     * Re-index items after removal
     */
    function reindexItems($container) {
        $container.find('.repeater-item').each(function(index) {
            $(this).attr('data-index', index);
        });
    }

    /**
     * Update the hidden input value and trigger customizer change
     */
    function updateValue($control, config) {
        var $input = $control.find('.repeater-value');
        var $items = $control.find('.repeater-item');
        var items = [];

        $items.each(function() {
            var item = {};
            var $this = $(this);

            config.fields.forEach(function(field) {
                item[field] = $this.find('.repeater-field-' + field).val();
            });

            items.push(item);
        });

        var jsonValue = JSON.stringify(items);
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
