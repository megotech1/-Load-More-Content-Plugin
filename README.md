# Load More Content Plugin

A professional WordPress plugin that adds "Load More" functionality to your posts and pagination. Built with clean, maintainable code following Microsoft-style coding standards.

**Author:** Prof. Majid Saqr

## Features

- **Content Load More**: Automatically truncate post content after a specified word count and add a "Load More" button
- **Multiple Display Modes**: Choose between single button at the end or multiple buttons throughout content
- **Flexible Button Placement**: Display one button at the end OR multiple buttons every X words
- **Pagination Load More**: Replace default WordPress pagination with AJAX-powered "Load More" button
- **Customizable Settings**: Full control over button appearance, text, and behavior
- **Multiple Button Styles**: Choose from Default, Primary, Secondary, Outline, or Custom CSS
- **Animation Control**: Adjust loading animation speed (Fast, Normal, Slow)
- **Custom CSS Support**: Add your own custom styles for complete design control
- **Responsive Design**: Mobile-friendly and works on all devices
- **AJAX Powered**: Smooth content loading without page refresh
- **Developer Friendly**: Clean code structure with hooks and filters for customization

## Installation

### Method 1: Upload via WordPress Admin

1. Download the plugin ZIP file
2. Go to WordPress Admin → Plugins → Add New
3. Click "Upload Plugin" button
4. Choose the ZIP file and click "Install Now"
5. Activate the plugin

### Method 2: Manual Installation

1. Download and extract the plugin files
2. Upload the `load-more-plugin` folder to `/wp-content/plugins/` directory
3. Go to WordPress Admin → Plugins
4. Activate "Load More Content Plugin"

## Configuration

After activation, configure the plugin:

1. Go to **Settings → Load More** in WordPress Admin
2. Configure the following settings:

### General Settings

- **Load More After Words**: Number of words to display before showing the "Load More" button (default: 100)
- **Posts Per Page**: Number of posts to load per page when using pagination load more (default: 10)
- **Enable Pagination Load More**: Replace default pagination with load more button
- **Button Display Mode**: Choose how buttons are displayed:
  - **Display Once**: Single button at the end of content (default)
  - **Display Multiple Times**: Button appears every X words throughout the content
- **Words Between Buttons**: When using multiple display mode, set how many words appear between each button (default: 100)

### Button Settings

- **Button Text**: Text displayed on the load more button (default: "Load More")
- **Loading Text**: Text displayed while content is loading (default: "Loading...")
- **Button Style**: Choose from predefined styles:
  - Default (Blue)
  - Primary (Bootstrap Blue)
  - Secondary (Gray)
  - Outline (Transparent with border)
  - Custom CSS
- **Button Position**: Left, Center, or Right alignment
- **Animation Speed**: Fast (200ms), Normal (400ms), or Slow (600ms)

### Style Settings

- **Custom CSS**: Add custom CSS code to style your button

## Usage

### Content Load More

The plugin automatically works on single post pages. If your post content exceeds the configured word count, it will:

**Single Button Mode (Display Once):**
1. Display the first X words (as configured)
2. Hide the remaining content
3. Show a "Load More" button at the end
4. Reveal the full content when clicked

**Multiple Button Mode (Display Multiple Times):**
1. Display the first X words (as configured)
2. Insert a "Load More" button
3. Hide the next section of Y words
4. Repeat for the entire content
5. Each button reveals its corresponding section when clicked
6. Allows readers to progressively load content in manageable chunks

### Pagination Load More

When enabled, the plugin replaces WordPress pagination on archive pages with a "Load More" button that:

1. Loads additional posts via AJAX
2. Appends them to the current page
3. Continues until all posts are loaded

## Customization

### Custom Template

Create a custom template for loaded posts by adding this file to your theme:

```
your-theme/template-parts/content-load-more.php
```

### Filters

Modify the query arguments for loading posts:

```php
add_filter('load_more_query_args', function($args) {
    // Modify $args as needed
    $args['post_type'] = array('post', 'custom_post_type');
    return $args;
});
```

### Custom CSS Examples

Add custom styles in the "Custom CSS" field:

```css
.load-more-btn {
    background: linear-gradient(45deg, #ff6b6b, #ee5a6f);
    border: none;
    border-radius: 25px;
    padding: 15px 40px;
    font-size: 18px;
    box-shadow: 0 4px 15px rgba(238, 90, 111, 0.4);
}

.load-more-btn:hover {
    transform: scale(1.05);
    box-shadow: 0 6px 20px rgba(238, 90, 111, 0.6);
}
```

## File Structure

```
load-more-plugin/
├── load-more-plugin.php          # Main plugin file
├── includes/
│   ├── class-load-more-settings.php   # Admin settings handler
│   ├── class-load-more-frontend.php   # Frontend functionality
│   └── class-load-more-ajax.php       # AJAX request handler
├── admin/
│   ├── css/
│   │   └── admin-style.css            # Admin panel styles
│   └── js/
│       └── admin-script.js            # Admin panel JavaScript
├── public/
│   ├── css/
│   │   └── public-style.css           # Frontend styles
│   └── js/
│       └── public-script.js           # Frontend JavaScript
├── uninstall.php                      # Cleanup on uninstall
└── README.md                          # Documentation
```

## Browser Support

- Chrome (latest)
- Firefox (latest)
- Safari (latest)
- Edge (latest)
- Mobile browsers (iOS Safari, Chrome Mobile)

## Requirements

- WordPress 5.0 or higher
- PHP 7.0 or higher
- jQuery (included with WordPress)

## Frequently Asked Questions

### Does this work with custom post types?

Yes! Use the `load_more_query_args` filter to customize which post types are loaded.

### Can I style the button to match my theme?

Absolutely! Use the Custom CSS option or choose "Custom CSS" as the button style and add your styles.

### Will this slow down my site?

No. The plugin uses AJAX to load content efficiently without refreshing the page.

### Can I use this with page builders?

Yes, the plugin works with most page builders. However, custom integration may be needed for some builders.

## Author

**Prof. Majid Saqr**
Professional WordPress Plugin Developer

## Documentation

This plugin includes comprehensive documentation:

- **[INDEX.md](INDEX.md)** - Documentation index and navigation guide
- **[QUICK-START.md](QUICK-START.md)** - Get started in 5 minutes
- **[INSTALLATION.md](INSTALLATION.md)** - Detailed installation guide
- **[EXAMPLES.md](EXAMPLES.md)** - Practical usage examples (20+ examples)
- **[FEATURES.md](FEATURES.md)** - Visual feature showcase (50+ features)
- **[DEVELOPER.md](DEVELOPER.md)** - Technical documentation for developers
- **[PLUGIN-SUMMARY.md](PLUGIN-SUMMARY.md)** - Complete plugin reference
- **[STRUCTURE.txt](STRUCTURE.txt)** - Visual file structure guide
- **[CHANGELOG.md](CHANGELOG.md)** - Version history and updates

**Total Documentation:** 2,100+ lines across 10 files

## Support

For detailed help, please refer to the comprehensive documentation files included with this plugin. Start with [INDEX.md](INDEX.md) to find the right documentation for your needs.

## License

This plugin is licensed under the GPL v2 or later.

## Credits

**Developed by:** Prof. Majid Saqr
**Version:** 1.0.0
**Release Date:** January 2024
**Coding Standards:** Microsoft-style coding standards
**Architecture:** Object-oriented, modular design with singleton pattern

## Changelog

See [CHANGELOG.md](CHANGELOG.md) for complete version history.

### Version 1.0.0
- Initial release by Prof. Majid Saqr
- Content load more functionality with dual display modes
- Single button mode (display once at end)
- Multiple button mode (display every X words)
- Configurable button intervals
- Pagination load more functionality
- Customizable button styles (4 presets + custom CSS)
- Admin settings page with live preview
- AJAX support with smooth animations
- Responsive design
- Comprehensive documentation (2,100+ lines across 10 files)

