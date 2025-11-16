# Debug Guide - Progressive Loading

**Author:** Prof. Majid Saqr

## 🔍 How to Debug Progressive Loading

### Step 1: Open Browser Console

1. Go to your post page
2. Press **F12** (or right-click → Inspect)
3. Click on **Console** tab
4. Keep it open while testing

### Step 2: Test the Button

1. Click the "Load More" button
2. Watch the console for messages like:
   ```
   Progressive Load More: {currentSection: 1, totalSections: 4, wrapper: 1}
   Found section: 1 Content length: 523
   Showed section 1 of 4
   ```

### Step 3: Check for Errors

**If you see:**
```
Section not found: 1
```

**This means:** The HTML structure is wrong. Check the page source.

**If you see:**
```
Found section: 0
```

**This means:** The section exists but is empty.

**If you see nothing:**
```
(no console messages)
```

**This means:** JavaScript is not loading or there's a conflict.

---

## 🔧 Common Issues and Fixes

### Issue 1: Button Does Nothing

**Symptoms:**
- Click button, nothing happens
- No console messages

**Fix:**
1. Clear browser cache (Ctrl+F5)
2. Check if JavaScript file is loaded:
   - In Console, type: `typeof LoadMoreHandler`
   - Should show: `object`
3. Check for JavaScript errors in Console

---

### Issue 2: Content Not Appearing

**Symptoms:**
- Console shows "Showed section X"
- But no content appears on page

**Fix:**
1. Check CSS - content might be hidden
2. In Console, type:
   ```javascript
   jQuery('.load-more-progressive-section').css('display', 'inline');
   ```
3. If content appears, it's a CSS issue

---

### Issue 3: Section Not Found

**Symptoms:**
- Console shows "Section not found: 1"

**Fix:**
1. View page source (Ctrl+U)
2. Search for: `load-more-progressive-section`
3. Check if sections exist with `data-section="1"`, `data-section="2"`, etc.
4. If not found, the PHP is not generating sections correctly

---

## 🧪 Manual Test in Console

### Test 1: Check if sections exist
```javascript
jQuery('.load-more-progressive-section').length
```
**Expected:** Number greater than 0 (e.g., 4)

### Test 2: Show all sections manually
```javascript
jQuery('.load-more-progressive-section').css({'display': 'inline', 'opacity': '1'});
```
**Expected:** All hidden content appears

### Test 3: Check button data
```javascript
var btn = jQuery('.load-more-btn[data-type="content-progressive"]');
console.log('Total sections:', btn.attr('data-total-sections'));
console.log('Current section:', btn.attr('data-current-section'));
```
**Expected:** 
```
Total sections: 4
Current section: 0
```

### Test 4: Manually trigger next section
```javascript
var currentSection = 1;
jQuery('.load-more-progressive-section[data-section="' + currentSection + '"]').css({'display': 'inline', 'opacity': '1'});
```
**Expected:** First hidden section appears

---

## 📋 Checklist

Before reporting an issue, check:

- [ ] Browser cache cleared (Ctrl+F5)
- [ ] Console shows no JavaScript errors
- [ ] Settings saved correctly (Display Progressively mode selected)
- [ ] Post has enough words (more than initial + interval)
- [ ] JavaScript file is loading (check Network tab)
- [ ] CSS file is loading (check Network tab)

---

## 🎯 Expected HTML Structure

When you view page source, you should see:

```html
<div class="load-more-content-wrapper load-more-progressive-mode">
    <div class="load-more-visible-content">First 100 words here...</div>
    
    <div class="load-more-progressive-section" data-section="1" style="display:none;">
        Next 100 words here...
    </div>
    
    <div class="load-more-progressive-section" data-section="2" style="display:none;">
        Next 100 words here...
    </div>
    
    <div class="load-more-progressive-section" data-section="3" style="display:none;">
        Final words here...
    </div>
    
    <div class="load-more-button-wrapper align-center">
        <button class="load-more-btn load-more-btn-default" 
                data-type="content-progressive" 
                data-total-sections="3" 
                data-current-section="0">
            Load More
        </button>
    </div>
</div>
```

---

## 🔍 Step-by-Step Debugging

### Step 1: Verify Settings
1. Go to **Settings → Load More**
2. Check:
   - Button Display Mode: **Display Progressively**
   - Load More After Words: **100** (or your value)
   - Words Between Buttons: **100** (or your value)
3. Click **Save Settings**

### Step 2: Create Test Post
1. Create a new post
2. Add at least **500 words** of content
3. Publish it
4. View the post

### Step 3: Inspect HTML
1. Right-click on the page → **View Page Source**
2. Search for: `load-more-progressive-section`
3. Count how many you find
4. Should be: (Total words - Initial words) / Interval

**Example:**
- Total words: 500
- Initial words: 100
- Interval: 100
- Sections: (500 - 100) / 100 = 4 sections

### Step 4: Test Button
1. Open Console (F12)
2. Click "Load More" button
3. Watch console messages
4. Watch page content

### Step 5: Manual Override
If button doesn't work, try manual test:

```javascript
// Show section 1
jQuery('.load-more-progressive-section[data-section="1"]').css({'display': 'inline', 'opacity': '1'});

// Show section 2
jQuery('.load-more-progressive-section[data-section="2"]').css({'display': 'inline', 'opacity': '1'});

// Show all sections
jQuery('.load-more-progressive-section').css({'display': 'inline', 'opacity': '1'});
```

---

## 📞 Report Issue

If still not working, provide:

1. **Console messages** (copy/paste from Console)
2. **HTML structure** (view source, copy the load-more-content-wrapper section)
3. **Settings** (screenshot of Settings → Load More page)
4. **Post word count** (how many words in your test post)
5. **Browser** (Chrome, Firefox, etc.)

---

**Developed by:** Prof. Majid Saqr

