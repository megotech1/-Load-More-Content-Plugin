<?php
/**
 * Admin Settings Class
 *
 * Handles all admin settings and configuration pages
 *
 * @package LoadMorePlugin
 * @since 1.0.0
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * LoadMoreSettings Class
 */
class LoadMoreSettings
{
    /**
     * The single instance of the class
     *
     * @var LoadMoreSettings
     */
    private static $instance = null;

    /**
     * Settings option name
     *
     * @var string
     */
    private $optionName = 'load_more_plugin_settings';

    /**
     * Get instance
     *
     * @return LoadMoreSettings
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
        add_action('admin_menu', array($this, 'addAdminMenu'));
        add_action('admin_init', array($this, 'registerSettings'));
        add_action('admin_enqueue_scripts', array($this, 'enqueueAdminAssets'));
    }

    /**
     * Add admin menu
     *
     * @return void
     */
    public function addAdminMenu()
    {
        add_options_page(
            __('Load More Settings', 'load-more-plugin'),
            __('Load More', 'load-more-plugin'),
            'manage_options',
            'load-more-settings',
            array($this, 'renderSettingsPage')
        );
    }

    /**
     * Register settings
     *
     * @return void
     */
    public function registerSettings()
    {
        register_setting(
            'load_more_plugin_settings_group',
            $this->optionName,
            array($this, 'sanitizeSettings')
        );

        // General Settings Section
        add_settings_section(
            'load_more_general_section',
            __('General Settings', 'load-more-plugin'),
            array($this, 'renderGeneralSectionCallback'),
            'load-more-settings'
        );

        // Button Settings Section
        add_settings_section(
            'load_more_button_section',
            __('Button Settings', 'load-more-plugin'),
            array($this, 'renderButtonSectionCallback'),
            'load-more-settings'
        );

        // Style Settings Section
        add_settings_section(
            'load_more_style_section',
            __('Style Settings', 'load-more-plugin'),
            array($this, 'renderStyleSectionCallback'),
            'load-more-settings'
        );

        // Add settings fields
        $this->addSettingsFields();
    }

    /**
     * Add settings fields
     *
     * @return void
     */
    private function addSettingsFields()
    {
        // Word Count
        add_settings_field(
            'word_count',
            __('Load More After Words', 'load-more-plugin'),
            array($this, 'renderWordCountField'),
            'load-more-settings',
            'load_more_general_section'
        );

        // Posts Per Page
        add_settings_field(
            'posts_per_page',
            __('Posts Per Page', 'load-more-plugin'),
            array($this, 'renderPostsPerPageField'),
            'load-more-settings',
            'load_more_general_section'
        );

        // Enable Pagination
        add_settings_field(
            'enable_pagination',
            __('Enable Pagination Load More', 'load-more-plugin'),
            array($this, 'renderEnablePaginationField'),
            'load-more-settings',
            'load_more_general_section'
        );

        // Button Display Mode
        add_settings_field(
            'button_display_mode',
            __('Button Display Mode', 'load-more-plugin'),
            array($this, 'renderButtonDisplayModeField'),
            'load-more-settings',
            'load_more_general_section'
        );

        // Button Interval
        add_settings_field(
            'button_interval',
            __('Words Between Buttons', 'load-more-plugin'),
            array($this, 'renderButtonIntervalField'),
            'load-more-settings',
            'load_more_general_section'
        );

        // Button Text
        add_settings_field(
            'button_text',
            __('Button Text', 'load-more-plugin'),
            array($this, 'renderButtonTextField'),
            'load-more-settings',
            'load_more_button_section'
        );

        // Loading Text
        add_settings_field(
            'loading_text',
            __('Loading Text', 'load-more-plugin'),
            array($this, 'renderLoadingTextField'),
            'load-more-settings',
            'load_more_button_section'
        );

        // Button Style
        add_settings_field(
            'button_style',
            __('Button Style', 'load-more-plugin'),
            array($this, 'renderButtonStyleField'),
            'load-more-settings',
            'load_more_button_section'
        );

        // Button Position
        add_settings_field(
            'button_position',
            __('Button Position', 'load-more-plugin'),
            array($this, 'renderButtonPositionField'),
            'load-more-settings',
            'load_more_button_section'
        );

        // Animation Speed
        add_settings_field(
            'animation_speed',
            __('Animation Speed', 'load-more-plugin'),
            array($this, 'renderAnimationSpeedField'),
            'load-more-settings',
            'load_more_button_section'
        );

        // Custom CSS
        add_settings_field(
            'custom_css',
            __('Custom CSS', 'load-more-plugin'),
            array($this, 'renderCustomCssField'),
            'load-more-settings',
            'load_more_style_section'
        );
    }

    /**
     * Enqueue admin assets
     *
     * @param string $hook Current admin page hook
     * @return void
     */
    public function enqueueAdminAssets($hook)
    {
        if ($hook !== 'settings_page_load-more-settings') {
            return;
        }

        wp_enqueue_style(
            'load-more-admin-style',
            LOAD_MORE_PLUGIN_URL . 'admin/css/admin-style.css',
            array(),
            LOAD_MORE_PLUGIN_VERSION
        );

        wp_enqueue_script(
            'load-more-admin-script',
            LOAD_MORE_PLUGIN_URL . 'admin/js/admin-script.js',
            array('jquery'),
            LOAD_MORE_PLUGIN_VERSION,
            true
        );
    }

    /**
     * Render settings page
     *
     * @return void
     */
    public function renderSettingsPage()
    {
        if (!current_user_can('manage_options')) {
            return;
        }

        // Check if settings were saved
        if (isset($_GET['settings-updated'])) {
            add_settings_error(
                'load_more_messages',
                'load_more_message',
                __('Settings Saved Successfully', 'load-more-plugin'),
                'updated'
            );
        }

        settings_errors('load_more_messages');
        ?>
        <div class="wrap load-more-settings-wrap">
            <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
            <form action="options.php" method="post">
                <?php
                settings_fields('load_more_plugin_settings_group');
                do_settings_sections('load-more-settings');
                submit_button(__('Save Settings', 'load-more-plugin'));
                ?>
            </form>
        </div>
        <?php
    }

    /**
     * Section callbacks
     */
    public function renderGeneralSectionCallback()
    {
        echo '<p>' . esc_html__('Configure general load more settings.', 'load-more-plugin') . '</p>';
    }

    public function renderButtonSectionCallback()
    {
        echo '<p>' . esc_html__('Customize the load more button appearance and text.', 'load-more-plugin') . '</p>';
    }

    public function renderStyleSectionCallback()
    {
        echo '<p>' . esc_html__('Add custom CSS to style your load more button.', 'load-more-plugin') . '</p>';
    }

    /**
     * Get settings
     *
     * @return array
     */
    private function getSettings()
    {
        $defaults = array(
            'word_count' => 100,
            'button_text' => 'Load More',
            'loading_text' => 'Loading...',
            'button_style' => 'default',
            'button_position' => 'center',
            'custom_css' => '',
            'enable_pagination' => true,
            'posts_per_page' => 10,
            'animation_speed' => 'normal',
            'button_display_mode' => 'once',
            'button_interval' => 100
        );

        $settings = get_option($this->optionName, $defaults);
        return wp_parse_args($settings, $defaults);
    }

    /**
     * Render field callbacks
     */
    public function renderWordCountField()
    {
        $settings = $this->getSettings();
        ?>
        <input type="number"
               name="<?php echo esc_attr($this->optionName); ?>[word_count]"
               value="<?php echo esc_attr($settings['word_count']); ?>"
               min="10"
               step="10"
               class="regular-text">
        <p class="description">
            <?php esc_html_e('Number of words to display before showing the "Load More" button.', 'load-more-plugin'); ?>
        </p>
        <?php
    }

    public function renderPostsPerPageField()
    {
        $settings = $this->getSettings();
        ?>
        <input type="number"
               name="<?php echo esc_attr($this->optionName); ?>[posts_per_page]"
               value="<?php echo esc_attr($settings['posts_per_page']); ?>"
               min="1"
               max="100"
               class="regular-text">
        <p class="description">
            <?php esc_html_e('Number of posts to load per page when using pagination load more.', 'load-more-plugin'); ?>
        </p>
        <?php
    }

    public function renderEnablePaginationField()
    {
        $settings = $this->getSettings();
        ?>
        <label>
            <input type="checkbox"
                   name="<?php echo esc_attr($this->optionName); ?>[enable_pagination]"
                   value="1"
                   <?php checked($settings['enable_pagination'], true); ?>>
            <?php esc_html_e('Enable load more for post pagination', 'load-more-plugin'); ?>
        </label>
        <p class="description">
            <?php esc_html_e('When enabled, replaces default pagination with load more button.', 'load-more-plugin'); ?>
        </p>
        <?php
    }

    public function renderButtonDisplayModeField()
    {
        $settings = $this->getSettings();
        $modes = array(
            'once' => __('Display Once - Show all remaining content with one click', 'load-more-plugin'),
            'multiple' => __('Display Progressively - Load X words each time button is clicked', 'load-more-plugin')
        );
        ?>
        <select name="<?php echo esc_attr($this->optionName); ?>[button_display_mode]"
                class="regular-text"
                id="button_display_mode">
            <?php foreach ($modes as $value => $label) : ?>
                <option value="<?php echo esc_attr($value); ?>" <?php selected($settings['button_display_mode'], $value); ?>>
                    <?php echo esc_html($label); ?>
                </option>
            <?php endforeach; ?>
        </select>
        <p class="description">
            <strong><?php esc_html_e('Display Once:', 'load-more-plugin'); ?></strong> <?php esc_html_e('One button reveals all remaining content.', 'load-more-plugin'); ?><br>
            <strong><?php esc_html_e('Display Progressively:', 'load-more-plugin'); ?></strong> <?php esc_html_e('One button that loads X words each time you click it until all content is shown.', 'load-more-plugin'); ?>
        </p>
        <?php
    }

    public function renderButtonIntervalField()
    {
        $settings = $this->getSettings();
        ?>
        <input type="number"
               name="<?php echo esc_attr($this->optionName); ?>[button_interval]"
               value="<?php echo esc_attr($settings['button_interval']); ?>"
               min="50"
               step="10"
               class="regular-text"
               id="button_interval">
        <p class="description">
            <?php esc_html_e('How many words to load each time the "Load More" button is clicked (Progressive mode only).', 'load-more-plugin'); ?>
        </p>
        <script>
        jQuery(document).ready(function($) {
            function toggleButtonInterval() {
                var mode = $('#button_display_mode').val();
                var $intervalRow = $('#button_interval').closest('tr');
                if (mode === 'multiple') {
                    $intervalRow.show();
                } else {
                    $intervalRow.hide();
                }
            }
            toggleButtonInterval();
            $('#button_display_mode').on('change', toggleButtonInterval);
        });
        </script>
        <?php
    }

    public function renderButtonTextField()
    {
        $settings = $this->getSettings();
        ?>
        <input type="text"
               name="<?php echo esc_attr($this->optionName); ?>[button_text]"
               value="<?php echo esc_attr($settings['button_text']); ?>"
               class="regular-text">
        <p class="description">
            <?php esc_html_e('Text displayed on the load more button.', 'load-more-plugin'); ?>
        </p>
        <?php
    }

    public function renderLoadingTextField()
    {
        $settings = $this->getSettings();
        ?>
        <input type="text"
               name="<?php echo esc_attr($this->optionName); ?>[loading_text]"
               value="<?php echo esc_attr($settings['loading_text']); ?>"
               class="regular-text">
        <p class="description">
            <?php esc_html_e('Text displayed while content is loading.', 'load-more-plugin'); ?>
        </p>
        <?php
    }

    public function renderButtonStyleField()
    {
        $settings = $this->getSettings();
        $styles = array(
            'default' => __('Default', 'load-more-plugin'),
            'primary' => __('Primary', 'load-more-plugin'),
            'secondary' => __('Secondary', 'load-more-plugin'),
            'outline' => __('Outline', 'load-more-plugin'),
            'custom' => __('Custom CSS', 'load-more-plugin')
        );
        ?>
        <select name="<?php echo esc_attr($this->optionName); ?>[button_style]" class="regular-text">
            <?php foreach ($styles as $value => $label) : ?>
                <option value="<?php echo esc_attr($value); ?>" <?php selected($settings['button_style'], $value); ?>>
                    <?php echo esc_html($label); ?>
                </option>
            <?php endforeach; ?>
        </select>
        <p class="description">
            <?php esc_html_e('Choose a predefined button style or use custom CSS.', 'load-more-plugin'); ?>
        </p>
        <?php
    }

    public function renderButtonPositionField()
    {
        $settings = $this->getSettings();
        $positions = array(
            'left' => __('Left', 'load-more-plugin'),
            'center' => __('Center', 'load-more-plugin'),
            'right' => __('Right', 'load-more-plugin')
        );
        ?>
        <select name="<?php echo esc_attr($this->optionName); ?>[button_position]" class="regular-text">
            <?php foreach ($positions as $value => $label) : ?>
                <option value="<?php echo esc_attr($value); ?>" <?php selected($settings['button_position'], $value); ?>>
                    <?php echo esc_html($label); ?>
                </option>
            <?php endforeach; ?>
        </select>
        <p class="description">
            <?php esc_html_e('Choose the position of the load more button.', 'load-more-plugin'); ?>
        </p>
        <?php
    }

    public function renderAnimationSpeedField()
    {
        $settings = $this->getSettings();
        $speeds = array(
            'fast' => __('Fast (200ms)', 'load-more-plugin'),
            'normal' => __('Normal (400ms)', 'load-more-plugin'),
            'slow' => __('Slow (600ms)', 'load-more-plugin')
        );
        ?>
        <select name="<?php echo esc_attr($this->optionName); ?>[animation_speed]" class="regular-text">
            <?php foreach ($speeds as $value => $label) : ?>
                <option value="<?php echo esc_attr($value); ?>" <?php selected($settings['animation_speed'], $value); ?>>
                    <?php echo esc_html($label); ?>
                </option>
            <?php endforeach; ?>
        </select>
        <p class="description">
            <?php esc_html_e('Choose the animation speed for loading content.', 'load-more-plugin'); ?>
        </p>
        <?php
    }

    public function renderCustomCssField()
    {
        $settings = $this->getSettings();
        ?>
        <textarea name="<?php echo esc_attr($this->optionName); ?>[custom_css]"
                  rows="10"
                  class="large-text code"><?php echo esc_textarea($settings['custom_css']); ?></textarea>
        <p class="description">
            <?php esc_html_e('Add custom CSS to style your load more button. Example: .load-more-btn { background: #ff0000; }', 'load-more-plugin'); ?>
        </p>
        <?php
    }

    /**
     * Sanitize settings
     *
     * @param array $input Input settings
     * @return array Sanitized settings
     */
    public function sanitizeSettings($input)
    {
        $sanitized = array();

        $sanitized['word_count'] = isset($input['word_count']) ? absint($input['word_count']) : 100;
        $sanitized['posts_per_page'] = isset($input['posts_per_page']) ? absint($input['posts_per_page']) : 10;
        $sanitized['enable_pagination'] = isset($input['enable_pagination']) ? true : false;
        $sanitized['button_text'] = isset($input['button_text']) ? sanitize_text_field($input['button_text']) : 'Load More';
        $sanitized['loading_text'] = isset($input['loading_text']) ? sanitize_text_field($input['loading_text']) : 'Loading...';
        $sanitized['button_style'] = isset($input['button_style']) ? sanitize_text_field($input['button_style']) : 'default';
        $sanitized['button_position'] = isset($input['button_position']) ? sanitize_text_field($input['button_position']) : 'center';
        $sanitized['custom_css'] = isset($input['custom_css']) ? wp_strip_all_tags($input['custom_css']) : '';
        $sanitized['animation_speed'] = isset($input['animation_speed']) ? sanitize_text_field($input['animation_speed']) : 'normal';
        $sanitized['button_display_mode'] = isset($input['button_display_mode']) ? sanitize_text_field($input['button_display_mode']) : 'once';
        $sanitized['button_interval'] = isset($input['button_interval']) ? absint($input['button_interval']) : 100;

        return $sanitized;
    }
}

