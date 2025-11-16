<?php
/**
 * Plugin Name: Load More Content Plugin
 * Plugin URI: https://example.com/load-more-plugin
 * Description: A professional WordPress plugin to load more post content with customizable settings including word count triggers, button styles, and custom CSS.
 * Version: 1.0.0
 * Author: Prof. Majid Saqr
 * Author URI: https://example.com
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: load-more-plugin
 * Domain Path: /languages
 *
 * @package LoadMorePlugin
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Main Plugin Class
 * 
 * @since 1.0.0
 */
final class LoadMorePlugin
{
    /**
     * Plugin version
     *
     * @var string
     */
    const VERSION = '1.0.0';

    /**
     * The single instance of the class
     *
     * @var LoadMorePlugin
     */
    private static $instance = null;

    /**
     * Main LoadMorePlugin Instance
     *
     * Ensures only one instance of LoadMorePlugin is loaded or can be loaded.
     *
     * @return LoadMorePlugin - Main instance
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
        $this->defineConstants();
        $this->includeFiles();
        $this->initHooks();
    }

    /**
     * Define plugin constants
     *
     * @return void
     */
    private function defineConstants()
    {
        define('LOAD_MORE_PLUGIN_VERSION', self::VERSION);
        define('LOAD_MORE_PLUGIN_PATH', plugin_dir_path(__FILE__));
        define('LOAD_MORE_PLUGIN_URL', plugin_dir_url(__FILE__));
        define('LOAD_MORE_PLUGIN_BASENAME', plugin_basename(__FILE__));
    }

    /**
     * Include required files
     *
     * @return void
     */
    private function includeFiles()
    {
        require_once LOAD_MORE_PLUGIN_PATH . 'includes/class-load-more-settings.php';
        require_once LOAD_MORE_PLUGIN_PATH . 'includes/class-load-more-frontend.php';
        require_once LOAD_MORE_PLUGIN_PATH . 'includes/class-load-more-ajax.php';
    }

    /**
     * Initialize WordPress hooks
     *
     * @return void
     */
    private function initHooks()
    {
        add_action('plugins_loaded', array($this, 'onPluginsLoaded'));
        add_action('init', array($this, 'onInit'));
        
        // Activation and deactivation hooks
        register_activation_hook(__FILE__, array($this, 'onActivation'));
        register_deactivation_hook(__FILE__, array($this, 'onDeactivation'));
    }

    /**
     * Plugins loaded callback
     *
     * @return void
     */
    public function onPluginsLoaded()
    {
        // Load text domain for translations
        load_plugin_textdomain('load-more-plugin', false, dirname(LOAD_MORE_PLUGIN_BASENAME) . '/languages');
    }

    /**
     * Init callback
     *
     * @return void
     */
    public function onInit()
    {
        // Initialize plugin components
        LoadMoreSettings::getInstance();
        LoadMoreFrontend::getInstance();
        LoadMoreAjax::getInstance();
    }

    /**
     * Plugin activation callback
     *
     * @return void
     */
    public function onActivation()
    {
        // Set default options
        $defaultOptions = array(
            'word_count' => 100,
            'button_text' => 'Load More',
            'loading_text' => 'Loading...',
            'button_style' => 'default',
            'button_position' => 'center',
            'custom_css' => '',
            'enable_pagination' => true,
            'posts_per_page' => 10,
            'animation_speed' => 'normal',
            'button_display_mode' => 'once', // 'once' or 'multiple'
            'button_interval' => 100 // Words between buttons when mode is 'multiple'
        );

        add_option('load_more_plugin_settings', $defaultOptions);
    }

    /**
     * Plugin deactivation callback
     *
     * @return void
     */
    public function onDeactivation()
    {
        // Cleanup tasks if needed
    }
}

/**
 * Initialize the plugin
 *
 * @return LoadMorePlugin
 */
function loadMorePlugin()
{
    return LoadMorePlugin::getInstance();
}

// Start the plugin
loadMorePlugin();

