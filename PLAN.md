# 📋 Detailed Implementation Plan

## 🎯 Current Status
- **Location:** `/home/ian/Desktop/08/ddd-blog-htmx/`
- **Server:** `php -S localhost:8080 -t public` (PID: 8)
- **Demo URL:** http://localhost:8080
- **HTMX:** ✅ Working (click "Load Demo Content" button)

---

## 🚀 Next Steps (Priority Order)

### **1. Core Infrastructure (30 min)**
```bash
# Create Router.php
src/Shared/Infrastructure/Router.php

# Create Database.php  
src/Shared/Infrastructure/Database.php

# Create TemplateEngine.php
src/Shared/Infrastructure/TemplateEngine.php

# Create ServiceFactory.php
src/Shared/Infrastructure/ServiceFactory.php
```

### **2. Domain Layer (20 min)**
```bash
# Blog domain
src/Blog/Domain/Post.php
src/Blog/Domain/PostRepository.php
src/Blog/Domain/BlogService.php

# Infrastructure
src/Blog/Infrastructure/SqlitePostRepository.php

# Application
src/Blog/Application/HomeController.php
```

### **3. Database Setup (15 min)**
```bash
# Create SQLite database
data/blog.sqlite

# Schema with sample data
data/schema.sql
```

### **4. Templates (25 min)**
```bash
# Layout
templates/layout/master.php

# Components
templates/components/hero-section.php

# Pages
templates/pages/home.php

# Partials
templates/partials/post-list.php
```

### **5. Assets & Symlinks (10 min)**
```bash
# Link to original project assets
ln -s ../../ddd-blog-docs/public/fonts public/fonts
ln -s ../../ddd-blog-docs/public/images public/images

# Create basic CSS
public/assets/app.css
```

---

## 🎨 Component Conversion Plan

### **Hero Section: Lit → HTMX**

**Original Lit (complex):**
```javascript
// hero-section.js - 200+ lines
class HeroSection extends LitElement {
  render() {
    return html`<section>...</section>`;
  }
}
```

**New HTMX (simple):**
```php
<!-- templates/components/hero-section.php -->
<section class="hero-container">
  <div class="hero-content">
    <h1><?= $title ?></h1>
    <p><?= $description ?></p>
    <a href="<?= $buttonUrl ?>" class="btn"><?= $buttonText ?></a>
  </div>
</section>
```

### **Benefits of HTMX Approach:**
- ✅ **Server-side rendering** - Better SEO
- ✅ **No JavaScript bundle** - Faster loading
- ✅ **Progressive enhancement** - Works without JS
- ✅ **Simpler debugging** - Standard HTML/PHP
- ✅ **Better accessibility** - Native HTML semantics

---

## 🔧 Commands Reference

```bash
# Development server
php -S localhost:8080 -t public

# Install dependencies
composer install

# Check server status
curl -I http://localhost:8080

# Kill server (if needed)
kill 8

# Database operations
sqlite3 data/blog.sqlite < data/schema.sql
sqlite3 data/blog.sqlite "SELECT * FROM posts;"
```

---

## 📊 Progress Tracking

- [x] **Project setup** - Composer, structure
- [x] **HTMX demo** - Basic interactivity working
- [ ] **Router** - FastRoute implementation
- [ ] **Database** - SQLite wrapper
- [ ] **Templates** - Plates engine
- [ ] **Domain** - Post entity & services
- [ ] **Controllers** - Home & blog controllers
- [ ] **Assets** - CSS & symlinks
- [ ] **Testing** - Basic functionality test

---

## 🎯 Success Criteria

**Phase 1 Complete When:**
1. Homepage loads with hero section
2. Blog posts display from SQLite
3. HTMX lazy loading works
4. No JavaScript errors
5. Responsive design works

**Final Goal:**
- Full feature parity with Lit version
- Better performance (SSR)
- Simpler codebase
- Pragmatic DDD architecture

---

**Next Action:** Start with Router.php implementation
