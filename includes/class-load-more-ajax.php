<?php
/**
 * AJAX Handler Class
 *
 * Handles all AJAX requests
 *
 * @package LoadMorePlugin
 * @since 1.0.0
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * LoadMoreAjax Class
 */
class LoadMoreAjax
{
    /**
     * The single instance of the class
     *
     * @var LoadMoreAjax
     */
    private static $instance = null;

    /**
     * Get instance
     *
     * @return LoadMoreAjax
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
        add_action('wp_ajax_load_more_posts', array($this, 'loadMorePosts'));
        add_action('wp_ajax_nopriv_load_more_posts', array($this, 'loadMorePosts'));
    }

    /**
     * Load more posts via AJAX
     *
     * @return void
     */
    public function loadMorePosts()
    {
        // Verify nonce
        if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'load_more_nonce')) {
            wp_send_json_error(array('message' => __('Security check failed', 'load-more-plugin')));
            return;
        }

        // Get parameters
        $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $postsPerPage = isset($_POST['posts_per_page']) ? intval($_POST['posts_per_page']) : 10;

        // Query arguments
        $args = array(
            'post_type' => 'post',
            'post_status' => 'publish',
            'posts_per_page' => $postsPerPage,
            'paged' => $page,
            'orderby' => 'date',
            'order' => 'DESC'
        );

        // Allow filtering of query args
        $args = apply_filters('load_more_query_args', $args);

        // Execute query
        $query = new WP_Query($args);

        if ($query->have_posts()) {
            ob_start();

            while ($query->have_posts()) {
                $query->the_post();
                
                // Load template part or default output
                if (locate_template('template-parts/content-load-more.php')) {
                    get_template_part('template-parts/content', 'load-more');
                } else {
                    $this->renderDefaultPostTemplate();
                }
            }

            $html = ob_get_clean();
            wp_reset_postdata();

            wp_send_json_success(array(
                'html' => $html,
                'max_pages' => $query->max_num_pages,
                'current_page' => $page
            ));
        } else {
            wp_send_json_error(array('message' => __('No more posts found', 'load-more-plugin')));
        }

        wp_die();
    }

    /**
     * Render default post template
     *
     * @return void
     */
    private function renderDefaultPostTemplate()
    {
        ?>
        <article id="post-<?php the_ID(); ?>" <?php post_class('load-more-post'); ?>>
            <header class="entry-header">
                <h2 class="entry-title">
                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                </h2>
                <div class="entry-meta">
                    <span class="posted-on"><?php echo get_the_date(); ?></span>
                    <span class="byline"> by <?php the_author(); ?></span>
                </div>
            </header>

            <?php if (has_post_thumbnail()) : ?>
                <div class="post-thumbnail">
                    <a href="<?php the_permalink(); ?>">
                        <?php the_post_thumbnail('medium'); ?>
                    </a>
                </div>
            <?php endif; ?>

            <div class="entry-content">
                <?php the_excerpt(); ?>
            </div>

            <footer class="entry-footer">
                <a href="<?php the_permalink(); ?>" class="read-more">
                    <?php esc_html_e('Read More', 'load-more-plugin'); ?>
                </a>
            </footer>
        </article>
        <?php
    }
}

