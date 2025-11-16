<?php
/**
 * Frontend Class
 *
 * Handles all frontend functionality
 *
 * @package LoadMorePlugin
 * @since 1.0.0
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * LoadMoreFrontend Class
 */
class LoadMoreFrontend
{
    /**
     * The single instance of the class
     *
     * @var LoadMoreFrontend
     */
    private static $instance = null;

    /**
     * Settings
     *
     * @var array
     */
    private $settings;

    /**
     * Get instance
     *
     * @return LoadMoreFrontend
     */
    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Constructor
     */
    private function __construct()
    {
        $this->settings = get_option('load_more_plugin_settings', array());
        
        add_action('wp_enqueue_scripts', array($this, 'enqueueAssets'));
        add_filter('the_content', array($this, 'modifyPostContent'), 10);
        
        // Replace pagination if enabled
        if (!empty($this->settings['enable_pagination'])) {
            add_filter('the_posts', array($this, 'setupPagination'), 10, 2);
        }
    }

    /**
     * Enqueue frontend assets
     *
     * @return void
     */
    public function enqueueAssets()
    {
        // Enqueue CSS
        wp_enqueue_style(
            'load-more-public-style',
            LOAD_MORE_PLUGIN_URL . 'public/css/public-style.css',
            array(),
            LOAD_MORE_PLUGIN_VERSION
        );

        // Enqueue JavaScript
        wp_enqueue_script(
            'load-more-public-script',
            LOAD_MORE_PLUGIN_URL . 'public/js/public-script.js',
            array('jquery'),
            LOAD_MORE_PLUGIN_VERSION,
            true
        );

        // Localize script
        wp_localize_script('load-more-public-script', 'loadMoreData', array(
            'ajaxUrl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('load_more_nonce'),
            'buttonText' => !empty($this->settings['button_text']) ? $this->settings['button_text'] : 'Load More',
            'loadingText' => !empty($this->settings['loading_text']) ? $this->settings['loading_text'] : 'Loading...',
            'animationSpeed' => !empty($this->settings['animation_speed']) ? $this->settings['animation_speed'] : 'normal'
        ));

        // Add custom CSS if provided
        if (!empty($this->settings['custom_css'])) {
            wp_add_inline_style('load-more-public-style', $this->settings['custom_css']);
        }
    }

    /**
     * Modify post content to add load more functionality
     *
     * @param string $content Post content
     * @return string Modified content
     */
    public function modifyPostContent($content)
    {
        // Only apply on single posts
        if (!is_single()) {
            return $content;
        }

        $wordCount = !empty($this->settings['word_count']) ? intval($this->settings['word_count']) : 100;
        $displayMode = !empty($this->settings['button_display_mode']) ? $this->settings['button_display_mode'] : 'once';

        // Split content into words
        $words = explode(' ', strip_tags($content));
        $totalWords = count($words);

        // If content is shorter than word count, return as is
        if ($totalWords <= $wordCount) {
            return $content;
        }

        // Get button settings
        $buttonStyle = !empty($this->settings['button_style']) ? $this->settings['button_style'] : 'default';
        $buttonPosition = !empty($this->settings['button_position']) ? $this->settings['button_position'] : 'center';
        $buttonText = !empty($this->settings['button_text']) ? $this->settings['button_text'] : 'Load More';

        // Check display mode
        if ($displayMode === 'multiple') {
            return $this->buildMultipleButtonContent($words, $totalWords, $wordCount, $buttonStyle, $buttonPosition, $buttonText);
        } else {
            return $this->buildSingleButtonContent($words, $totalWords, $wordCount, $buttonStyle, $buttonPosition, $buttonText);
        }
    }

    /**
     * Build content with single button at the end
     *
     * @param array $words Array of words
     * @param int $totalWords Total word count
     * @param int $wordCount Initial visible word count
     * @param string $buttonStyle Button style
     * @param string $buttonPosition Button position
     * @param string $buttonText Button text
     * @return string Modified content
     */
    private function buildSingleButtonContent($words, $totalWords, $wordCount, $buttonStyle, $buttonPosition, $buttonText)
    {
        // Split content
        $visibleWords = array_slice($words, 0, $wordCount);
        $hiddenWords = array_slice($words, $wordCount);

        $visibleContent = implode(' ', $visibleWords);
        $hiddenContent = implode(' ', $hiddenWords);

        // Build the modified content
        $output = '<div class="load-more-content-wrapper">';
        $output .= '<div class="load-more-visible-content">' . $visibleContent . '</div>';
        $output .= '<div class="load-more-hidden-content" style="display:none;">' . $hiddenContent . '</div>';
        $output .= '<div class="load-more-button-wrapper align-' . esc_attr($buttonPosition) . '">';
        $output .= '<button class="load-more-btn load-more-btn-' . esc_attr($buttonStyle) . '" data-type="content">';
        $output .= esc_html($buttonText);
        $output .= '</button>';
        $output .= '</div>';
        $output .= '</div>';

        return $output;
    }

    /**
     * Build content with progressive loading (one button, loads X words each click)
     *
     * @param array $words Array of words
     * @param int $totalWords Total word count
     * @param int $wordCount Initial visible word count
     * @param string $buttonStyle Button style
     * @param string $buttonPosition Button position
     * @param string $buttonText Button text
     * @return string Modified content
     */
    private function buildMultipleButtonContent($words, $totalWords, $wordCount, $buttonStyle, $buttonPosition, $buttonText)
    {
        $buttonInterval = !empty($this->settings['button_interval']) ? intval($this->settings['button_interval']) : 100;

        $output = '<div class="load-more-content-wrapper load-more-progressive-mode">';

        // First visible section
        $visibleWords = array_slice($words, 0, $wordCount);
        $output .= '<div class="load-more-visible-content">' . implode(' ', $visibleWords) . '</div>';

        // Calculate remaining sections
        $remainingWords = array_slice($words, $wordCount);
        $remainingCount = count($remainingWords);

        if ($remainingCount > 0) {
            $sections = array_chunk($remainingWords, $buttonInterval);

            // Add all hidden sections
            foreach ($sections as $index => $section) {
                $sectionContent = implode(' ', $section);

                $output .= '<div class="load-more-progressive-section" data-section="' . ($index + 1) . '" style="display:none;">';
                $output .= ' ' . $sectionContent; // Add space before content
                $output .= '</div>';
            }

            // Add ONE button at the end that will progressively load sections
            $output .= '<div class="load-more-button-wrapper align-' . esc_attr($buttonPosition) . '">';
            $output .= '<button class="load-more-btn load-more-btn-' . esc_attr($buttonStyle) . '" data-type="content-progressive" data-total-sections="' . count($sections) . '" data-current-section="0">';
            $output .= esc_html($buttonText);
            $output .= '</button>';
            $output .= '</div>';
        }

        $output .= '</div>';

        return $output;
    }

    /**
     * Setup pagination load more
     *
     * @param array $posts Posts array
     * @param WP_Query $query Query object
     * @return array Posts
     */
    public function setupPagination($posts, $query)
    {
        // Only on main query and archive pages
        if (!$query->is_main_query() || is_singular()) {
            return $posts;
        }

        // Add load more button after posts
        if ($query->max_num_pages > 1) {
            add_action('loop_end', array($this, 'renderPaginationButton'));
        }

        return $posts;
    }

    /**
     * Render pagination load more button
     *
     * @return void
     */
    public function renderPaginationButton()
    {
        global $wp_query;

        if ($wp_query->max_num_pages <= 1) {
            return;
        }

        $buttonStyle = !empty($this->settings['button_style']) ? $this->settings['button_style'] : 'default';
        $buttonPosition = !empty($this->settings['button_position']) ? $this->settings['button_position'] : 'center';
        $buttonText = !empty($this->settings['button_text']) ? $this->settings['button_text'] : 'Load More';
        $currentPage = max(1, get_query_var('paged'));

        ?>
        <div class="load-more-pagination-wrapper align-<?php echo esc_attr($buttonPosition); ?>">
            <button class="load-more-btn load-more-btn-<?php echo esc_attr($buttonStyle); ?>"
                    data-type="pagination"
                    data-page="<?php echo esc_attr($currentPage); ?>"
                    data-max-pages="<?php echo esc_attr($wp_query->max_num_pages); ?>">
                <?php echo esc_html($buttonText); ?>
            </button>
        </div>
        <?php
    }
}
