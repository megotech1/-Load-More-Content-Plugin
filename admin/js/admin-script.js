/**
 * Load More Plugin - Admin JavaScript
 *
 * @package LoadMorePlugin
 * @since 1.0.0
 */

(function($) {
    'use strict';

    /**
     * Admin Settings Handler
     */
    const AdminSettings = {
        /**
         * Initialize
         */
        init: function() {
            this.bindEvents();
            this.toggleCustomCss();
        },

        /**
         * Bind events
         */
        bindEvents: function() {
            // Toggle custom CSS field visibility
            $('select[name="load_more_plugin_settings[button_style]"]').on('change', this.toggleCustomCss.bind(this));
            
            // Add preview functionality
            this.initPreview();
        },

        /**
         * Toggle custom CSS field
         */
        toggleCustomCss: function() {
            const $select = $('select[name="load_more_plugin_settings[button_style]"]');
            const $customCssRow = $('textarea[name="load_more_plugin_settings[custom_css]"]').closest('tr');
            
            if ($select.val() === 'custom') {
                $customCssRow.show();
            } else {
                $customCssRow.hide();
            }
        },

        /**
         * Initialize preview
         */
        initPreview: function() {
            const $previewContainer = $('<div class="load-more-preview-container"></div>');
            const $preview = $('<div class="load-more-preview">' +
                '<h3>Button Preview</h3>' +
                '<div class="preview-wrapper">' +
                '<button class="load-more-btn preview-btn">Load More</button>' +
                '</div>' +
                '</div>');
            
            $previewContainer.append($preview);
            $('.load-more-settings-wrap form').prepend($previewContainer);
            
            // Update preview on changes
            this.updatePreview();
            $('input, select, textarea').on('change keyup', this.updatePreview.bind(this));
        },

        /**
         * Update preview
         */
        updatePreview: function() {
            const buttonText = $('input[name="load_more_plugin_settings[button_text]"]').val() || 'Load More';
            const buttonStyle = $('select[name="load_more_plugin_settings[button_style]"]').val() || 'default';
            const buttonPosition = $('select[name="load_more_plugin_settings[button_position]"]').val() || 'center';
            
            const $previewBtn = $('.preview-btn');
            const $previewWrapper = $('.preview-wrapper');
            
            // Update text
            $previewBtn.text(buttonText);
            
            // Update style class
            $previewBtn.attr('class', 'load-more-btn preview-btn load-more-btn-' + buttonStyle);
            
            // Update position
            $previewWrapper.css('text-align', buttonPosition);
        }
    };

    /**
     * Initialize on document ready
     */
    $(document).ready(function() {
        AdminSettings.init();
    });

})(jQuery);

