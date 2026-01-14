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

            // Initialize TinyMCE (WordPress uses TinyMCE 4.x)
            tinymce.init({
                selector: '#' + textareaId,
                menubar: false,
                toolbar: 'bold italic underline | bullist numlist | customlink unlink | removeformat',
                plugins: 'lists',
                branding: false,
                elementpath: false,
                statusbar: false,
                height: 200,
                content_style: 'body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif; font-size: 14px; line-height: 1.6; } a { color: #0073aa; }',
                setup: function(editor) {
                    // Custom link button using TinyMCE 4.x API
                    editor.addButton('customlink', {
                        icon: 'link',
                        tooltip: 'Insert/Edit Link',
                        onclick: function() {
                            var selectedText = editor.selection.getContent({ format: 'text' });
                            var selectedNode = editor.selection.getNode();
                            var existingHref = '';
                            var existingTarget = '';

                            // Check if we're inside an existing link
                            if (selectedNode.nodeName === 'A') {
                                existingHref = selectedNode.getAttribute('href') || '';
                                existingTarget = selectedNode.getAttribute('target') || '';
                                if (!selectedText) {
                                    selectedText = selectedNode.textContent;
                                }
                            }

                            // Open custom dialog using TinyMCE 4.x windowManager
                            editor.windowManager.open({
                                title: 'Insert Link',
                                width: 400,
                                height: 150,
                                body: [
                                    {
                                        type: 'textbox',
                                        name: 'url',
                                        label: 'URL',
                                        value: existingHref,
                                        placeholder: 'https://example.com'
                                    },
                                    {
                                        type: 'textbox',
                                        name: 'text',
                                        label: 'Link Text',
                                        value: selectedText
                                    },
                                    {
                                        type: 'checkbox',
                                        name: 'newwindow',
                                        label: 'Open in new window',
                                        checked: existingTarget === '_blank'
                                    }
                                ],
                                onsubmit: function(e) {
                                    var url = e.data.url;
                                    var text = e.data.text || url;
                                    var target = e.data.newwindow ? ' target="_blank" rel="noopener noreferrer"' : '';

                                    if (url) {
                                        // If editing existing link
                                        if (selectedNode.nodeName === 'A') {
                                            selectedNode.setAttribute('href', url);
                                            if (e.data.newwindow) {
                                                selectedNode.setAttribute('target', '_blank');
                                                selectedNode.setAttribute('rel', 'noopener noreferrer');
                                            } else {
                                                selectedNode.removeAttribute('target');
                                                selectedNode.removeAttribute('rel');
                                            }
                                            selectedNode.textContent = text;
                                        } else {
                                            // Insert new link
                                            var linkHtml = '<a href="' + url + '"' + target + '>' + text + '</a>';
                                            editor.insertContent(linkHtml);
                                        }
                                    }
                                }
                            });
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
     * This handles cases where the editor wasn't visible initially
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
                        // Refresh the editor if it exists
                        editor.fire('focus');
                    }
                }, 100);
            }
        });
    });

})(jQuery);
