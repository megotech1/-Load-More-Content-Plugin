/**
 * Load More Plugin - Public JavaScript
 *
 * @package LoadMorePlugin
 * @since 1.0.0
 */

(function($) {
    'use strict';

    /**
     * Load More Handler
     */
    const LoadMoreHandler = {
        /**
         * Initialize
         */
        init: function() {
            this.bindEvents();
        },

        /**
         * Bind events
         */
        bindEvents: function() {
            console.log('Load More Plugin: Events bound');

            // Content load more (single button mode)
            $(document).on('click', '.load-more-btn[data-type="content"]', this.handleContentLoadMore.bind(this));

            // Content progressive load more (multiple mode - one button, loads X words each click)
            $(document).on('click', '.load-more-btn[data-type="content-progressive"]', this.handleContentProgressiveLoadMore.bind(this));

            // Pagination load more
            $(document).on('click', '.load-more-btn[data-type="pagination"]', this.handlePaginationLoadMore.bind(this));

            // Log what buttons we found
            setTimeout(function() {
                var contentButtons = $('.load-more-btn[data-type="content"]').length;
                var progressiveButtons = $('.load-more-btn[data-type="content-progressive"]').length;
                var paginationButtons = $('.load-more-btn[data-type="pagination"]').length;

                console.log('Load More Buttons Found:', {
                    content: contentButtons,
                    progressive: progressiveButtons,
                    pagination: paginationButtons
                });

                if (progressiveButtons > 0) {
                    var $btn = $('.load-more-btn[data-type="content-progressive"]').first();
                    console.log('Progressive Button Details:', {
                        totalSections: $btn.attr('data-total-sections'),
                        currentSection: $btn.attr('data-current-section'),
                        text: $btn.text()
                    });
                }
            }, 500);
        },

        /**
         * Handle content load more (single button mode)
         */
        handleContentLoadMore: function(e) {
            e.preventDefault();

            const $button = $(e.currentTarget);
            const $wrapper = $button.closest('.load-more-content-wrapper');
            const $hiddenContent = $wrapper.find('.load-more-hidden-content');

            // Get animation speed
            const speed = this.getAnimationSpeed();

            // Show hidden content
            $hiddenContent.slideDown(speed, function() {
                $button.parent().fadeOut(speed, function() {
                    $(this).remove();
                });
            });
        },

        /**
         * Handle content progressive load more (one button, loads X words each click)
         */
        handleContentProgressiveLoadMore: function(e) {
            console.log('=== PROGRESSIVE BUTTON CLICKED ===');
            e.preventDefault();

            const $button = $(e.currentTarget);
            const $wrapper = $button.closest('.load-more-content-wrapper');
            const totalSections = parseInt($button.attr('data-total-sections'));
            let currentSection = parseInt($button.attr('data-current-section'));

            console.log('Button element:', $button[0]);
            console.log('Wrapper element:', $wrapper[0]);
            console.log('Total sections:', totalSections);
            console.log('Current section:', currentSection);

            // Get animation speed
            const speed = this.getAnimationSpeed();

            // Increment to next section
            currentSection++;

            console.log('Loading section:', currentSection, 'of', totalSections);

            // Find the next section to show
            const $section = $wrapper.find('.load-more-progressive-section[data-section="' + currentSection + '"]');

            console.log('Section selector:', '.load-more-progressive-section[data-section="' + currentSection + '"]');
            console.log('Found sections:', $section.length);

            if ($section.length > 0) {
                console.log('Section element:', $section[0]);
                console.log('Section content length:', $section.text().length);
                console.log('Section HTML:', $section.html().substring(0, 100));

                // Show the section - change display to inline and animate
                $section.css({'display': 'inline', 'opacity': '0'}).animate({'opacity': '1'}, speed);

                // Update button's current section using attr
                $button.attr('data-current-section', currentSection);

                console.log('✓ Section', currentSection, 'shown successfully');

                // If this was the last section, remove the button
                if (currentSection >= totalSections) {
                    console.log('✓ Last section reached, removing button');
                    setTimeout(function() {
                        $button.parent().fadeOut(speed, function() {
                            $(this).remove();
                        });
                    }, speed);
                }
            } else {
                console.error('✗ Section not found:', currentSection);
                console.log('All sections in wrapper:', $wrapper.find('.load-more-progressive-section').length);
                $wrapper.find('.load-more-progressive-section').each(function(i) {
                    console.log('  Section', i, 'data-section:', $(this).attr('data-section'));
                });
            }
        },

        /**
         * Handle pagination load more
         */
        handlePaginationLoadMore: function(e) {
            e.preventDefault();
            
            const $button = $(e.currentTarget);
            const currentPage = parseInt($button.data('page')) || 1;
            const maxPages = parseInt($button.data('max-pages')) || 1;
            const nextPage = currentPage + 1;
            
            // Check if there are more pages
            if (nextPage > maxPages) {
                this.showMessage($button, 'No more posts to load', 'info');
                $button.fadeOut();
                return;
            }
            
            // Update button state
            this.setButtonLoading($button, true);
            
            // Get posts per page from settings
            const postsPerPage = loadMoreData.postsPerPage || 10;
            
            // Make AJAX request
            $.ajax({
                url: loadMoreData.ajaxUrl,
                type: 'POST',
                data: {
                    action: 'load_more_posts',
                    nonce: loadMoreData.nonce,
                    page: nextPage,
                    posts_per_page: postsPerPage
                },
                success: (response) => {
                    this.handleAjaxSuccess(response, $button, nextPage, maxPages);
                },
                error: (xhr, status, error) => {
                    this.handleAjaxError(error, $button);
                }
            });
        },

        /**
         * Handle AJAX success
         */
        handleAjaxSuccess: function(response, $button, nextPage, maxPages) {
            this.setButtonLoading($button, false);
            
            if (response.success && response.data.html) {
                const $wrapper = $button.closest('.load-more-pagination-wrapper');
                const speed = this.getAnimationSpeed();
                
                // Insert new posts before the button wrapper
                const $newPosts = $(response.data.html).hide();
                $wrapper.before($newPosts);
                $newPosts.fadeIn(speed);
                
                // Update button data
                $button.data('page', nextPage);
                
                // Hide button if no more pages
                if (nextPage >= maxPages) {
                    $button.fadeOut(speed, function() {
                        $(this).parent().remove();
                    });
                }
            } else {
                this.showMessage($button, response.data.message || 'No more posts', 'info');
                $button.fadeOut();
            }
        },

        /**
         * Handle AJAX error
         */
        handleAjaxError: function(error, $button) {
            this.setButtonLoading($button, false);
            this.showMessage($button, 'Error loading posts. Please try again.', 'error');
            console.error('Load More Error:', error);
        },

        /**
         * Set button loading state
         */
        setButtonLoading: function($button, isLoading) {
            if (isLoading) {
                $button.data('original-text', $button.text());
                $button.text(loadMoreData.loadingText || 'Loading...');
                $button.prop('disabled', true);
                $button.addClass('loading');
            } else {
                $button.text($button.data('original-text') || loadMoreData.buttonText || 'Load More');
                $button.prop('disabled', false);
                $button.removeClass('loading');
            }
        },

        /**
         * Show message
         */
        showMessage: function($button, message, type) {
            const $message = $('<div class="load-more-message load-more-message-' + type + '">' + message + '</div>');
            $button.parent().append($message);
            
            setTimeout(function() {
                $message.fadeOut(function() {
                    $(this).remove();
                });
            }, 3000);
        },

        /**
         * Get animation speed in milliseconds
         */
        getAnimationSpeed: function() {
            const speed = loadMoreData.animationSpeed || 'normal';
            const speeds = {
                'fast': 200,
                'normal': 400,
                'slow': 600
            };
            return speeds[speed] || 400;
        }
    };

    /**
     * Initialize on document ready
     */
    $(document).ready(function() {
        LoadMoreHandler.init();
    });

})(jQuery);

