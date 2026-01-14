/**
 * 3 to 5 Theme - Customizer WYSIWYG Editor
 *
 * Initializes TinyMCE editors in the WordPress Customizer.
 *
 * @package 3to5
 */

(function($) {
    'use strict';

    // Wait for the customizer to be ready
    wp.customize.bind('ready', function() {
        initWysiwygEditors();
    });

    /**
     * Initialize all WYSIWYG editors
     */
    function initWysiwygEditors() {
        $('.wysiwyg-editor').each(function() {
            var $textarea = $(this);
            var textareaId = $textarea.attr('id');

            // Skip if already initialized
            if (tinymce.get(textareaId)) {
                return;
            }

            // Initialize TinyMCE
            tinymce.init({
                selector: '#' + textareaId,
                menubar: false,
                toolbar: 'bold italic underline | bullist numlist | insertlink removelink | removeformat',
                plugins: 'lists',
                branding: false,
                elementpath: false,
                statusbar: false,
                height: 200,
                content_style: 'body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif; font-size: 14px; line-height: 1.6; } a { color: #0073aa; }',
                setup: function(editor) {
                    // Insert link button using simple prompt
                    editor.addButton('insertlink', {
                        icon: 'link',
                        tooltip: 'Insert Link',
                        onclick: function() {
                            var selectedText = editor.selection.getContent({ format: 'text' });
                            
                            // Prompt for URL
                            var url = prompt('Enter the URL:', 'https://');
                            
                            if (url && url !== 'https://') {
                                // Prompt for link text if none selected
                                var linkText = selectedText;
                                if (!linkText) {
                                    linkText = prompt('Enter link text:', url);
                                    if (!linkText) {
                                        linkText = url;
                                    }
                                }
                                
                                // Insert the link
                                var linkHtml = '<a href="' + url + '">' + linkText + '</a>';
                                editor.insertContent(linkHtml);
                            }
                        }
                    });

                    // Remove link button
                    editor.addButton('removelink', {
                        icon: 'unlink',
                        tooltip: 'Remove Link',
                        onclick: function() {
                            editor.execCommand('unlink');
                        }
                    });

                    // Update the textarea and trigger change on content change
                    editor.on('change keyup paste input', function() {
                        editor.save();
                        $textarea.trigger('change');
                    });

                    // Also trigger on blur
                    editor.on('blur', function() {
                        editor.save();
                        $textarea.trigger('change');
                    });
                },
                init_instance_callback: function(editor) {
                    // Set initial content
                    editor.setContent($textarea.val());
                }
            });
        });
    }

    /**
     * Re-initialize editors when sections are expanded
     */
    wp.customize.section('3to5_about', function(section) {
        section.expanded.bind(function(isExpanded) {
            if (isExpanded) {
                setTimeout(function() {
                    var textareaId = '3to5_about_content';
                    var editor = tinymce.get(textareaId);

                    if (!editor) {
                        initWysiwygEditors();
                    } else {
                        editor.fire('focus');
                    }
                }, 100);
            }
        });
    });

})(jQuery);
