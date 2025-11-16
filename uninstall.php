<?php
/**
 * Uninstall Script
 *
 * Fired when the plugin is uninstalled.
 *
 * @package LoadMorePlugin
 * @since 1.0.0
 */

// Exit if accessed directly or not uninstalling
if (!defined('WP_UNINSTALL_PLUGIN')) {
    exit;
}

/**
 * Delete plugin options
 */
function loadMorePluginUninstall()
{
    // Delete plugin settings
    delete_option('load_more_plugin_settings');
    
    // For multisite installations
    if (is_multisite()) {
        global $wpdb;
        
        // Get all blog IDs
        $blogIds = $wpdb->get_col("SELECT blog_id FROM {$wpdb->blogs}");
        
        foreach ($blogIds as $blogId) {
            switch_to_blog($blogId);
            delete_option('load_more_plugin_settings');
            restore_current_blog();
        }
    }
    
    // Clear any cached data
    wp_cache_flush();
}

// Execute uninstall
loadMorePluginUninstall();

