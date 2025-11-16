# Developer Documentation - Load More Content Plugin

## Architecture Overview

The plugin follows a modular, object-oriented architecture with clear separation of concerns:

### Core Components

1. **LoadMorePlugin** (Main Class)
   - Singleton pattern implementation
   - Handles plugin initialization
   - Manages constants and file includes
   - Registers activation/deactivation hooks

2. **LoadMoreSettings** (Admin Settings)
   - Manages WordPress Settings API
   - Handles admin interface rendering
   - Sanitizes and validates user input
   - Enqueues admin assets

3. **LoadMoreFrontend** (Frontend Handler)
   - Processes post content
   - Renders load more buttons
   - Enqueues public assets
   - Manages frontend display logic

4. **LoadMoreAjax** (AJAX Handler)
   - Processes AJAX requests
   - Queries and returns posts
   - Handles security (nonce verification)
   - Renders post templates

## Code Standards

This plugin follows Microsoft-style coding standards:

### Naming Conventions

- **Classes**: PascalCase (e.g., `LoadMoreSettings`)
- **Methods**: camelCase (e.g., `getInstance()`)
- **Variables**: camelCase (e.g., `$buttonText`)
- **Constants**: UPPER_SNAKE_CASE (e.g., `LOAD_MORE_PLUGIN_VERSION`)
- **Files**: kebab-case (e.g., `class-load-more-settings.php`)

### Documentation

All classes and methods include PHPDoc blocks:

```php
/**
 * Short description
 *
 * Long description if needed
 *
 * @param string $param Parameter description
 * @return void
 */
public function methodName($param)
{
    // Implementation
}
```

## Hooks and Filters

### Actions

#### Frontend Actions

```php
// Enqueue frontend assets
add_action('wp_enqueue_scripts', 'callback');

// Modify post content
add_filter('the_content', 'callback', 10);

// Setup pagination
add_filter('the_posts', 'callback', 10, 2);
```

#### Admin Actions

```php
// Add admin menu
add_action('admin_menu', 'callback');

// Register settings
add_action('admin_init', 'callback');

// Enqueue admin assets
add_action('admin_enqueue_scripts', 'callback');
```

#### AJAX Actions

```php
// For logged-in users
add_action('wp_ajax_load_more_posts', 'callback');

// For non-logged-in users
add_action('wp_ajax_nopriv_load_more_posts', 'callback');
```

### Filters

#### Custom Query Arguments

Modify the WP_Query arguments for loading posts:

```php
add_filter('load_more_query_args', function($args) {
    // Add custom post types
    $args['post_type'] = array('post', 'portfolio', 'product');
    
    // Add taxonomy filters
    $args['tax_query'] = array(
        array(
            'taxonomy' => 'category',
            'field'    => 'slug',
            'terms'    => 'featured',
        ),
    );
    
    // Modify posts per page
    $args['posts_per_page'] = 15;
    
    return $args;
});
```

## JavaScript API

### Public Script (public-script.js)

The frontend JavaScript is organized into a handler object:

```javascript
const LoadMoreHandler = {
    init: function() {
        // Initialize the handler
    },
    
    handleContentLoadMore: function(e) {
        // Handle content load more clicks
    },
    
    handlePaginationLoadMore: function(e) {
        // Handle pagination load more clicks
    }
};
```

### Available Data

JavaScript has access to localized data via `loadMoreData`:

```javascript
loadMoreData.ajaxUrl        // WordPress AJAX URL
loadMoreData.nonce          // Security nonce
loadMoreData.buttonText     // Button text from settings
loadMoreData.loadingText    // Loading text from settings
loadMoreData.animationSpeed // Animation speed setting
```

## Custom Templates

### Creating a Custom Post Template

Create this file in your theme:

**Location**: `your-theme/template-parts/content-load-more.php`

```php
<article id="post-<?php the_ID(); ?>" <?php post_class('my-custom-post'); ?>>
    <div class="post-thumbnail">
        <?php if (has_post_thumbnail()) : ?>
            <a href="<?php the_permalink(); ?>">
                <?php the_post_thumbnail('large'); ?>
            </a>
        <?php endif; ?>
    </div>
    
    <div class="post-content">
        <h2 class="post-title">
            <a href="<?php the_permalink(); ?>">
                <?php the_title(); ?>
            </a>
        </h2>
        
        <div class="post-meta">
            <span class="date"><?php echo get_the_date(); ?></span>
            <span class="author"><?php the_author(); ?></span>
            <span class="comments"><?php comments_number(); ?></span>
        </div>
        
        <div class="post-excerpt">
            <?php the_excerpt(); ?>
        </div>
        
        <a href="<?php the_permalink(); ?>" class="read-more-link">
            Continue Reading →
        </a>
    </div>
</article>
```

## Extending the Plugin

### Example: Add Custom Post Type Support

```php
// In your theme's functions.php
add_filter('load_more_query_args', function($args) {
    $args['post_type'] = array('post', 'portfolio');
    return $args;
});
```

### Example: Modify Word Count Dynamically

```php
// In your theme's functions.php
add_filter('option_load_more_plugin_settings', function($settings) {
    // Different word count for mobile
    if (wp_is_mobile()) {
        $settings['word_count'] = 50;
    }
    return $settings;
});
```

### Example: Custom Button HTML

```php
// Override button rendering
add_filter('load_more_button_html', function($html, $settings) {
    return sprintf(
        '<button class="my-custom-btn" data-type="pagination">
            <span class="icon">↓</span>
            <span class="text">%s</span>
        </button>',
        esc_html($settings['button_text'])
    );
}, 10, 2);
```

## Database Schema

### Options Table

The plugin stores settings in a single option:

**Option Name**: `load_more_plugin_settings`

**Structure**:
```php
array(
    'word_count'       => 100,           // int
    'button_text'      => 'Load More',   // string
    'loading_text'     => 'Loading...',  // string
    'button_style'     => 'default',     // string
    'button_position'  => 'center',      // string
    'custom_css'       => '',            // string
    'enable_pagination'=> true,          // bool
    'posts_per_page'   => 10,            // int
    'animation_speed'  => 'normal'       // string
)
```

## Security

### Nonce Verification

All AJAX requests are protected with WordPress nonces:

```php
// Creating nonce (in localized script)
wp_create_nonce('load_more_nonce')

// Verifying nonce (in AJAX handler)
wp_verify_nonce($_POST['nonce'], 'load_more_nonce')
```

### Data Sanitization

All user input is sanitized:

```php
absint()              // For integers
sanitize_text_field() // For text
esc_html()           // For output
esc_attr()           // For attributes
wp_strip_all_tags()  // For CSS
```

## Performance Optimization

### Asset Loading

Assets are only loaded when needed:

```php
// Admin assets only on settings page
if ($hook !== 'settings_page_load-more-settings') {
    return;
}
```

### Caching Considerations

The plugin is cache-friendly:
- No dynamic content in cached pages
- AJAX loads fresh content
- Compatible with popular caching plugins

## Testing

### Manual Testing Checklist

- [ ] Install and activate plugin
- [ ] Configure settings
- [ ] Test content load more on single posts
- [ ] Test pagination load more on archives
- [ ] Test all button styles
- [ ] Test custom CSS
- [ ] Test on mobile devices
- [ ] Test with different themes
- [ ] Test AJAX functionality
- [ ] Test uninstall cleanup

## Contributing

When contributing to this plugin:

1. Follow the established code standards
2. Add PHPDoc blocks to all methods
3. Test thoroughly before submitting
4. Update documentation as needed
5. Maintain backward compatibility

## Version History

### 1.0.0 (Initial Release)
- Core functionality
- Admin settings page
- Multiple button styles
- AJAX support
- Responsive design

