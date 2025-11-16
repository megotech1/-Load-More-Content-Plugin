# Quick Start Guide - Load More Content Plugin

**Author:** Prof. Majid Saqr  
**Get started in 5 minutes!**

---

## 🚀 Installation (2 minutes)

### Step 1: Upload Plugin
1. Go to **WordPress Admin** → **Plugins** → **Add New**
2. Click **Upload Plugin**
3. Choose the plugin ZIP file
4. Click **Install Now**
5. Click **Activate**

✅ **Done!** The plugin is now active.

---

## ⚙️ Basic Configuration (2 minutes)

### Step 2: Configure Settings
1. Go to **Settings** → **Load More**
2. You'll see a settings page with a live preview

### Recommended Settings for Beginners:

**General Settings:**
- Load More After Words: `100`
- Posts Per Page: `10`
- Enable Pagination: `✓ Checked`
- Button Display Mode: `Display Once`

**Button Settings:**
- Button Text: `Load More`
- Loading Text: `Loading...`
- Button Style: `Default`
- Button Position: `Center`
- Animation Speed: `Normal`

**Style Settings:**
- Custom CSS: `Leave empty for now`

3. Click **Save Settings**

✅ **Done!** Your plugin is configured.

---

## 🎯 What Happens Now?

### On Single Posts:
- If a post has more than 100 words:
  - First 100 words are visible
  - "Load More" button appears
  - Remaining content is hidden
  - Click button to reveal full content

### On Archive Pages:
- Shows 10 posts initially
- "Load More" button at bottom
- Click to load 10 more posts
- Continues until all posts loaded

---

## 🎨 Try Different Modes (1 minute)

### Mode 1: Single Button (Default)
**Best for:** Most websites, simple reading experience

**Settings:**
```
Button Display Mode: Display Once
Load More After Words: 100
```

**Result:** One button at the end of content

---

### Mode 2: Multiple Buttons
**Best for:** Long articles, tutorials, educational content

**Settings:**
```
Button Display Mode: Display Multiple Times
Load More After Words: 150
Words Between Buttons: 150
```

**Result:** Buttons appear every 150 words throughout content

---

## 🎨 Change Button Style

Go to **Settings** → **Load More** → **Button Style**

Choose from:
- **Default** - Blue WordPress style
- **Primary** - Bootstrap blue
- **Secondary** - Gray
- **Outline** - Transparent with border

Click **Save Settings** and see the preview update!

---

## 📱 Test Your Setup

### Test Content Load More:
1. Create a new post with 300+ words
2. Publish it
3. View the post on your site
4. You should see:
   - First 100 words visible
   - "Load More" button
   - Click reveals rest of content

### Test Pagination Load More:
1. Make sure you have 15+ published posts
2. Go to your blog page
3. You should see:
   - First 10 posts
   - "Load More" button at bottom
   - Click loads 10 more posts

---

## 🎯 Common Configurations

### Configuration 1: News Website
```
Load More After Words: 150
Button Display Mode: Display Once
Button Text: "Read Full Story"
Button Style: Primary
Posts Per Page: 12
```

### Configuration 2: Tutorial Blog
```
Load More After Words: 200
Button Display Mode: Display Multiple Times
Words Between Buttons: 200
Button Text: "Continue Reading"
Button Style: Default
```

### Configuration 3: Magazine Style
```
Load More After Words: 100
Button Display Mode: Display Once
Button Text: "Read More"
Button Style: Outline
Button Position: Center
Posts Per Page: 6
```

---

## 🎨 Quick Custom Styling

Want a custom button color? Add this to **Custom CSS**:

### Red Button:
```css
.load-more-btn {
    background-color: #e74c3c;
    border-color: #e74c3c;
}
```

### Green Button:
```css
.load-more-btn {
    background-color: #27ae60;
    border-color: #27ae60;
}
```

### Rounded Button:
```css
.load-more-btn {
    border-radius: 50px;
    padding: 15px 40px;
}
```

---

## ❓ Quick Troubleshooting

### Button Not Showing?
- ✓ Check post has more words than your setting
- ✓ Clear browser cache (Ctrl+F5)
- ✓ Check plugin is activated

### AJAX Not Working?
- ✓ Check browser console for errors (F12)
- ✓ Disable other plugins temporarily
- ✓ Try a different theme

### Styling Issues?
- ✓ Clear browser cache
- ✓ Try a different button style
- ✓ Check for theme CSS conflicts

---

## 📚 Next Steps

Once you're comfortable with the basics:

1. **Read EXAMPLES.md** - See real-world usage examples
2. **Read DEVELOPER.md** - Learn about customization
3. **Experiment with styles** - Try different button designs
4. **Test on mobile** - Ensure responsive design works

---

## 🎓 Understanding Display Modes

### Single Button Mode (Display Once)
```
[First 100 words - VISIBLE]
[Load More Button]
[Rest of content - HIDDEN]

↓ After Click ↓

[All content - VISIBLE]
```

### Multiple Button Mode (Display Multiple Times)
```
[First 150 words - VISIBLE]
[Load More Button #1]
[Next 150 words - HIDDEN]
[Load More Button #2]
[Next 150 words - HIDDEN]
[Load More Button #3]
[Final section - HIDDEN]

↓ After Clicking Button #1 ↓

[First 150 words - VISIBLE]
[Next 150 words - NOW VISIBLE]
[Load More Button #2]
[Next 150 words - STILL HIDDEN]
[Load More Button #3]
[Final section - STILL HIDDEN]
```

---

## ✨ Pro Tips

1. **Word Count:** Start with 100, adjust based on your content
2. **Multiple Mode:** Use for articles over 1000 words
3. **Button Text:** Keep it short and clear
4. **Mobile:** Test on phones - content loads faster
5. **Performance:** Don't set word count too low (minimum 50)

---

## 📞 Need Help?

- **Full Documentation:** See README.md
- **Installation Help:** See INSTALLATION.md
- **Code Examples:** See EXAMPLES.md
- **Developer Guide:** See DEVELOPER.md

---

## 🎉 You're All Set!

Your Load More Content Plugin is now configured and working!

**What you've accomplished:**
- ✅ Installed the plugin
- ✅ Configured basic settings
- ✅ Understood how it works
- ✅ Tested the functionality

**Enjoy your new load more functionality!**

---

**Plugin by:** Prof. Majid Saqr  
**Version:** 1.0.0  
**License:** GPL v2 or later

