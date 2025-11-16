# Installation Guide - Load More Content Plugin

## Quick Start Guide

### Step 1: Install the Plugin

#### Option A: WordPress Admin Panel
1. Log in to your WordPress admin panel
2. Navigate to **Plugins → Add New**
3. Click the **Upload Plugin** button at the top
4. Click **Choose File** and select the `load-more-plugin.zip` file
5. Click **Install Now**
6. After installation completes, click **Activate Plugin**

#### Option B: FTP/File Manager
1. Extract the `load-more-plugin.zip` file on your computer
2. Connect to your website via FTP or use your hosting control panel's File Manager
3. Navigate to `/wp-content/plugins/`
4. Upload the entire `load-more-plugin` folder
5. Go to WordPress Admin → **Plugins**
6. Find "Load More Content Plugin" and click **Activate**

### Step 2: Configure Settings

1. After activation, go to **Settings → Load More** in your WordPress admin
2. You'll see three sections of settings:

#### General Settings
- **Load More After Words**: Set to `100` (or your preferred number)
  - This controls when the "Load More" button appears in post content
  - Example: If set to 100, the first 100 words will be visible
  
- **Posts Per Page**: Set to `10` (or your preferred number)
  - Controls how many posts load at once in pagination mode
  
- **Enable Pagination Load More**: Check this box
  - Replaces standard WordPress pagination with Load More button

#### Button Settings
- **Button Text**: Enter "Load More" (or customize)
- **Loading Text**: Enter "Loading..." (or customize)
- **Button Style**: Choose from:
  - `Default` - Blue WordPress style
  - `Primary` - Bootstrap primary blue
  - `Secondary` - Gray style
  - `Outline` - Transparent with border
  - `Custom CSS` - Use your own styles
- **Button Position**: Choose `Center`, `Left`, or `Right`
- **Animation Speed**: Choose `Normal` (or Fast/Slow)

#### Style Settings
- **Custom CSS**: Leave blank initially (add custom styles later if needed)

3. Click **Save Settings**

### Step 3: Test the Plugin

#### Test Content Load More
1. Create or edit a post with more than 100 words (or your configured word count)
2. View the post on the frontend
3. You should see:
   - First 100 words visible
   - "Load More" button below
   - Clicking reveals the rest of the content

#### Test Pagination Load More
1. Go to your blog page or any archive page
2. If you have more posts than your "Posts Per Page" setting
3. You should see:
   - Initial posts displayed
   - "Load More" button at the bottom
   - Clicking loads more posts without page refresh

## Advanced Configuration

### Custom Button Styling

To create a custom button style:

1. Go to **Settings → Load More**
2. Set **Button Style** to "Custom CSS"
3. In the **Custom CSS** field, add:

```css
.load-more-btn {
    background: #ff6b6b;
    color: white;
    border: none;
    border-radius: 30px;
    padding: 15px 35px;
    font-size: 16px;
    font-weight: bold;
    text-transform: uppercase;
    letter-spacing: 1px;
    box-shadow: 0 4px 15px rgba(255, 107, 107, 0.4);
    transition: all 0.3s ease;
}

.load-more-btn:hover {
    background: #ee5a6f;
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(255, 107, 107, 0.6);
}
```

4. Click **Save Settings**

### Theme Integration

The plugin works automatically, but you can customize the post template:

1. Create a new file in your theme: `template-parts/content-load-more.php`
2. Add your custom HTML structure:

```php
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
    <div class="post-meta">
        <?php echo get_the_date(); ?> | <?php the_author(); ?>
    </div>
    <?php the_excerpt(); ?>
    <a href="<?php the_permalink(); ?>">Read More →</a>
</article>
```

3. The plugin will automatically use this template for loaded posts

## Troubleshooting

### Button Not Appearing

**Problem**: Load More button doesn't show on posts
**Solution**: 
- Check that your post has more words than the configured word count
- Verify the plugin is activated
- Clear your browser cache and WordPress cache

### AJAX Not Working

**Problem**: Clicking button doesn't load content
**Solution**:
- Check browser console for JavaScript errors (F12 → Console)
- Ensure jQuery is loaded (included with WordPress by default)
- Disable other plugins temporarily to check for conflicts
- Check that your theme has `wp_footer()` in footer.php

### Styling Issues

**Problem**: Button looks broken or unstyled
**Solution**:
- Clear browser cache (Ctrl+F5 or Cmd+Shift+R)
- Check for CSS conflicts with your theme
- Try a different button style from settings
- Ensure your theme loads plugin styles correctly

### Posts Not Loading

**Problem**: Pagination load more doesn't work
**Solution**:
- Verify "Enable Pagination Load More" is checked
- Check that you have enough posts to paginate
- Ensure your theme uses standard WordPress loop
- Check browser console for AJAX errors

## Uninstallation

To completely remove the plugin:

1. Go to **Plugins** in WordPress admin
2. Deactivate "Load More Content Plugin"
3. Click **Delete**
4. All plugin files and settings will be removed automatically

## Next Steps

- Customize button styles to match your theme
- Adjust word count for optimal content display
- Test on mobile devices for responsive design
- Consider creating custom post templates
- Explore developer hooks for advanced customization

## Support

If you encounter any issues during installation or configuration, please check:
- WordPress version (5.0+ required)
- PHP version (7.0+ required)
- Theme compatibility
- Plugin conflicts

For additional help, refer to the main README.md file or contact support.

