# Usage Examples - Load More Content Plugin

**Author:** Prof. Majid Saqr

This document provides practical examples of how to use and customize the Load More Content Plugin.

## Table of Contents
1. [Basic Setup Examples](#basic-setup-examples)
2. [Button Display Mode Examples](#button-display-mode-examples)
3. [Styling Examples](#styling-examples)
4. [Developer Examples](#developer-examples)

---

## Basic Setup Examples

### Example 1: Simple Blog Setup

**Scenario:** You have a blog with long articles and want to show the first 150 words, then a "Load More" button.

**Settings:**
- Load More After Words: `150`
- Button Display Mode: `Display Once`
- Button Text: `Continue Reading`
- Button Style: `Default`
- Button Position: `Center`

**Result:** Readers see the first 150 words, then click "Continue Reading" to see the rest.

---

### Example 2: News Website with Multiple Sections

**Scenario:** You want readers to load content in smaller chunks, with a button every 200 words.

**Settings:**
- Load More After Words: `200`
- Button Display Mode: `Display Multiple Times`
- Words Between Buttons: `200`
- Button Text: `Read More`
- Button Style: `Primary`
- Button Position: `Center`

**Result:** 
- First 200 words visible
- Button appears
- Next 200 words hidden
- Button appears
- Pattern continues throughout the article

---

### Example 3: Magazine Style with Pagination

**Scenario:** Archive page showing 6 posts at a time with load more functionality.

**Settings:**
- Enable Pagination Load More: `✓ Checked`
- Posts Per Page: `6`
- Button Text: `Load More Articles`
- Button Style: `Outline`
- Button Position: `Center`

**Result:** Archive pages show 6 posts initially, then load 6 more when button is clicked.

---

## Button Display Mode Examples

### Single Button Mode (Display Once)

**Best for:**
- Short to medium articles (500-1500 words)
- Simple reading experience
- Mobile-first designs
- Minimalist layouts

**Configuration:**
```
Button Display Mode: Display Once
Load More After Words: 100
```

**Visual Flow:**
```
[First 100 words visible]
[Load More Button]
[Remaining content hidden]

↓ After Click ↓

[All content visible]
[No button]
```

---

### Multiple Button Mode (Display Multiple Times)

**Best for:**
- Long-form content (2000+ words)
- Educational articles
- Tutorials and guides
- Content with natural sections

**Configuration:**
```
Button Display Mode: Display Multiple Times
Load More After Words: 150
Words Between Buttons: 150
```

**Visual Flow:**
```
[First 150 words visible]
[Load More Button #1]
[Next 150 words hidden]
[Load More Button #2]
[Next 150 words hidden]
[Load More Button #3]
[Final section hidden]

↓ After Clicking Button #1 ↓

[First 150 words visible]
[Next 150 words now visible]
[Load More Button #2]
[Next 150 words hidden]
[Load More Button #3]
[Final section hidden]
```

---

## Styling Examples

### Example 1: Gradient Button

**Custom CSS:**
```css
.load-more-btn {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border: none;
    color: white;
    padding: 15px 40px;
    border-radius: 50px;
    font-size: 16px;
    font-weight: bold;
    text-transform: uppercase;
    letter-spacing: 1px;
    box-shadow: 0 10px 25px rgba(102, 126, 234, 0.5);
    transition: all 0.3s ease;
}

.load-more-btn:hover {
    transform: translateY(-3px);
    box-shadow: 0 15px 35px rgba(102, 126, 234, 0.7);
}
```

---

### Example 2: Minimal Underline Style

**Custom CSS:**
```css
.load-more-btn {
    background: transparent;
    border: none;
    color: #333;
    padding: 10px 0;
    font-size: 14px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 2px;
    border-bottom: 2px solid #333;
    border-radius: 0;
    transition: all 0.3s ease;
}

.load-more-btn:hover {
    color: #0073aa;
    border-bottom-color: #0073aa;
    transform: none;
    box-shadow: none;
}
```

---

### Example 3: Animated Arrow Button

**Custom CSS:**
```css
.load-more-btn {
    background: #ff6b6b;
    color: white;
    border: none;
    padding: 12px 30px 12px 20px;
    border-radius: 5px;
    font-size: 16px;
    position: relative;
    transition: all 0.3s ease;
}

.load-more-btn::after {
    content: '↓';
    position: absolute;
    right: 10px;
    top: 50%;
    transform: translateY(-50%);
    font-size: 20px;
    transition: transform 0.3s ease;
}

.load-more-btn:hover::after {
    transform: translateY(-40%);
    animation: bounce 0.6s infinite;
}

@keyframes bounce {
    0%, 100% { transform: translateY(-50%); }
    50% { transform: translateY(-30%); }
}
```

---

## Developer Examples

### Example 1: Custom Post Types

Add support for custom post types in pagination:

```php
// Add to your theme's functions.php
add_filter('load_more_query_args', function($args) {
    $args['post_type'] = array('post', 'portfolio', 'case-study');
    return $args;
});
```

---

### Example 2: Category-Specific Settings

Different word counts for different categories:

```php
// Add to your theme's functions.php
add_filter('option_load_more_plugin_settings', function($settings) {
    if (is_single()) {
        $categories = get_the_category();
        foreach ($categories as $category) {
            if ($category->slug === 'tutorials') {
                $settings['word_count'] = 200;
                $settings['button_display_mode'] = 'multiple';
                $settings['button_interval'] = 200;
            }
        }
    }
    return $settings;
});
```

---

### Example 3: Mobile-Specific Configuration

Shorter content sections on mobile devices:

```php
// Add to your theme's functions.php
add_filter('option_load_more_plugin_settings', function($settings) {
    if (wp_is_mobile()) {
        $settings['word_count'] = 75;
        $settings['button_interval'] = 75;
    }
    return $settings;
});
```

---

### Example 4: Custom Template for Loaded Posts

Create: `your-theme/template-parts/content-load-more.php`

```php
<article id="post-<?php the_ID(); ?>" <?php post_class('custom-load-more-post'); ?>>
    <?php if (has_post_thumbnail()) : ?>
        <div class="featured-image">
            <a href="<?php the_permalink(); ?>">
                <?php the_post_thumbnail('large'); ?>
            </a>
        </div>
    <?php endif; ?>
    
    <div class="post-header">
        <h2 class="post-title">
            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
        </h2>
        
        <div class="post-meta">
            <span class="author">By <?php the_author(); ?></span>
            <span class="date"><?php echo get_the_date(); ?></span>
            <span class="category"><?php the_category(', '); ?></span>
        </div>
    </div>
    
    <div class="post-excerpt">
        <?php the_excerpt(); ?>
    </div>
    
    <div class="post-footer">
        <a href="<?php the_permalink(); ?>" class="read-more-link">
            Read Full Article →
        </a>
    </div>
</article>
```

---

## Real-World Use Cases

### Use Case 1: Educational Blog
- **Mode:** Multiple buttons
- **First section:** 100 words
- **Intervals:** 150 words
- **Why:** Breaks complex topics into digestible sections

### Use Case 2: News Portal
- **Mode:** Single button
- **First section:** 200 words
- **Why:** Shows headline and lead, full story on demand

### Use Case 3: Portfolio Site
- **Mode:** Pagination load more
- **Posts per page:** 9
- **Why:** Grid layout with infinite scroll effect

### Use Case 4: Recipe Blog
- **Mode:** Single button
- **First section:** 150 words
- **Why:** Shows intro and ingredients, method on demand

---

## Tips and Best Practices

1. **Word Count Selection:**
   - Short posts (< 500 words): 100-150 words
   - Medium posts (500-1500 words): 150-250 words
   - Long posts (> 1500 words): 200-300 words

2. **Multiple Button Mode:**
   - Use for content > 1000 words
   - Keep intervals consistent (same as initial word count)
   - Great for tutorials and guides

3. **Button Text:**
   - Be clear: "Read More", "Continue Reading", "Load More"
   - Match your brand voice
   - Keep it short (2-3 words)

4. **Performance:**
   - Don't set word count too low (< 50 words)
   - Don't create too many sections (> 10 buttons)
   - Test on mobile devices

---

**Plugin Author:** Prof. Majid Saqr

