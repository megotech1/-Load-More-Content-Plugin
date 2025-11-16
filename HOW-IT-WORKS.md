# How the Load More Plugin Works

**Author:** Prof. Majid Saqr  
**Version:** 1.0.0

---

## 🎯 Two Display Modes Explained

### Mode 1: Display Once (Simple Mode)

**What it does:** Shows first X words, then ONE button that reveals ALL remaining content.

**Visual Example:**

```
┌─────────────────────────────────────┐
│  Your Blog Post (500 words total)  │
├─────────────────────────────────────┤
│  First 100 words are visible here  │
│  Lorem ipsum dolor sit amet...      │
│                                     │
│         [Load More Button]          │
│                                     │
│  (Remaining 400 words hidden)       │
└─────────────────────────────────────┘

        ↓ User clicks button ↓

┌─────────────────────────────────────┐
│  Your Blog Post (500 words total)  │
├─────────────────────────────────────┤
│  All 500 words now visible          │
│  Lorem ipsum dolor sit amet...      │
│  (entire content shown)             │
│                                     │
│  (Button removed)                   │
└─────────────────────────────────────┘
```

**Settings:**
- Button Display Mode: **Display Once**
- Load More After Words: `100`

**Result:** One click shows everything!

---

### Mode 2: Display Progressively (Advanced Mode)

**What it does:** Shows first X words, then ONE button that loads Y words EACH TIME you click it.

**Visual Example:**

```
┌─────────────────────────────────────┐
│  Your Tutorial (500 words total)   │
├─────────────────────────────────────┤
│  First 100 words visible            │
│  Introduction text here...          │
│                                     │
│         [Load More Button]          │
│                                     │
│  (Next 100 words hidden)            │
│  (Next 100 words hidden)            │
│  (Next 100 words hidden)            │
│  (Final 100 words hidden)           │
└─────────────────────────────────────┘

        ↓ User clicks button (1st time) ↓

┌─────────────────────────────────────┐
│  Your Tutorial (500 words total)   │
├─────────────────────────────────────┤
│  First 100 words visible            │
│  Introduction text here...          │
│                                     │
│  Next 100 words NOW VISIBLE         │
│  Step 1 instructions...             │
│                                     │
│         [Load More Button]          │
│                                     │
│  (Next 100 words hidden)            │
│  (Next 100 words hidden)            │
│  (Final 100 words hidden)           │
└─────────────────────────────────────┘

        ↓ User clicks button (2nd time) ↓

┌─────────────────────────────────────┐
│  Your Tutorial (500 words total)   │
├─────────────────────────────────────┤
│  First 100 words visible            │
│  Introduction text here...          │
│                                     │
│  Next 100 words visible             │
│  Step 1 instructions...             │
│                                     │
│  Next 100 words NOW VISIBLE         │
│  Step 2 instructions...             │
│                                     │
│         [Load More Button]          │
│                                     │
│  (Next 100 words hidden)            │
│  (Final 100 words hidden)           │
└─────────────────────────────────────┘

        ↓ User clicks button (3rd time) ↓

┌─────────────────────────────────────┐
│  Your Tutorial (500 words total)   │
├─────────────────────────────────────┤
│  First 100 words visible            │
│  Next 100 words visible             │
│  Next 100 words visible             │
│  Next 100 words NOW VISIBLE         │
│  Step 3 instructions...             │
│                                     │
│         [Load More Button]          │
│                                     │
│  (Final 100 words hidden)           │
└─────────────────────────────────────┘

        ↓ User clicks button (4th time) ↓

┌─────────────────────────────────────┐
│  Your Tutorial (500 words total)   │
├─────────────────────────────────────┤
│  All 500 words now visible          │
│  Complete tutorial shown            │
│                                     │
│  (Button removed - no more content) │
└─────────────────────────────────────┘
```

**Settings:**
- Button Display Mode: **Display Progressively**
- Load More After Words: `100` (initial visible)
- Words Between Buttons: `100` (load this many each click)

**Result:** Each click loads 100 more words until everything is shown!

---

## ⚙️ Configuration Examples

### Example 1: Blog Post (Simple)
**Goal:** Show introduction, one click reveals full article

**Settings:**
```
Load More After Words: 150
Button Display Mode: Display Once
Button Text: "Read Full Article"
```

**Behavior:**
- Shows first 150 words
- One button
- Click → Shows all remaining content
- Button disappears

---

### Example 2: Long Tutorial (Progressive)
**Goal:** Load content in manageable chunks

**Settings:**
```
Load More After Words: 200
Button Display Mode: Display Progressively
Words Between Buttons: 200
Button Text: "Continue Reading"
```

**Behavior:**
- Shows first 200 words
- One button stays visible
- Click 1 → Shows next 200 words
- Click 2 → Shows next 200 words
- Click 3 → Shows next 200 words
- Continues until all content shown
- Button disappears when done

---

### Example 3: News Article (Quick Read)
**Goal:** Show headline and lead, full story on demand

**Settings:**
```
Load More After Words: 75
Button Display Mode: Display Once
Button Text: "Read Full Story"
```

**Behavior:**
- Shows first 75 words (headline + lead)
- One button
- Click → Shows complete article
- Button disappears

---

### Example 4: Educational Content (Step-by-Step)
**Goal:** Reveal content in small, digestible sections

**Settings:**
```
Load More After Words: 100
Button Display Mode: Display Progressively
Words Between Buttons: 150
Button Text: "Next Section"
```

**Behavior:**
- Shows first 100 words
- One button
- Each click loads 150 more words
- Perfect for step-by-step guides
- Button disappears when complete

---

## 🎨 Real-World Scenarios

### Scenario 1: Food Blog Recipe
```
Settings:
- Display Mode: Display Once
- Initial Words: 100
- Button Text: "Show Full Recipe"

User Experience:
1. Sees introduction and ingredients (100 words)
2. Clicks "Show Full Recipe"
3. Sees complete cooking instructions
```

---

### Scenario 2: Technical Documentation
```
Settings:
- Display Mode: Display Progressively
- Initial Words: 150
- Load Per Click: 200
- Button Text: "Load More"

User Experience:
1. Sees overview (150 words)
2. Clicks "Load More" → Installation steps (200 words)
3. Clicks "Load More" → Configuration guide (200 words)
4. Clicks "Load More" → Advanced options (200 words)
5. Clicks "Load More" → Troubleshooting (remaining words)
6. Button disappears
```

---

### Scenario 3: Product Review
```
Settings:
- Display Mode: Display Once
- Initial Words: 120
- Button Text: "Read Complete Review"

User Experience:
1. Sees product overview and key features (120 words)
2. Clicks "Read Complete Review"
3. Sees detailed analysis, pros/cons, conclusion
```

---

## 📊 Comparison Table

| Feature | Display Once | Display Progressively |
|---------|--------------|----------------------|
| **Buttons** | One button | One button (reusable) |
| **Clicks** | One click | Multiple clicks |
| **Reveals** | All content at once | X words per click |
| **Best For** | Short-medium posts | Long articles, tutorials |
| **User Control** | Less control | More control |
| **Reading Flow** | Simple, direct | Gradual, paced |
| **Mobile** | Good | Excellent |
| **Engagement** | Lower | Higher |

---

## 🚀 Quick Setup Guide

### For Display Once Mode:
1. Go to **Settings → Load More**
2. Set **Load More After Words**: `100`
3. Set **Button Display Mode**: `Display Once`
4. Set **Button Text**: `Load More`
5. Click **Save Settings**

**Result:** Shows 100 words, one button reveals all.

---

### For Display Progressively Mode:
1. Go to **Settings → Load More**
2. Set **Load More After Words**: `150`
3. Set **Button Display Mode**: `Display Progressively`
4. Set **Words Between Buttons**: `150`
5. Set **Button Text**: `Load More`
6. Click **Save Settings**

**Result:** Shows 150 words, each click loads 150 more.

---

## 💡 Pro Tips

1. **Display Once** is perfect for:
   - Blog posts (500-1500 words)
   - News articles
   - Product descriptions
   - Simple content

2. **Display Progressively** is perfect for:
   - Long tutorials (2000+ words)
   - Educational content
   - Step-by-step guides
   - Technical documentation

3. **Word Count Guidelines:**
   - Short posts: 75-100 initial words
   - Medium posts: 100-150 initial words
   - Long posts: 150-200 initial words

4. **Progressive Loading:**
   - Keep intervals consistent
   - Don't make intervals too small (< 50 words)
   - Don't make intervals too large (> 300 words)
   - 100-200 words per click is ideal

---

**Developed by:** Prof. Majid Saqr  
**Version:** 1.0.0

**Now you understand exactly how both modes work!**

