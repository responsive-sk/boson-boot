<?php
/**
 * Header partial - supports both Svelte and Alpine.js themes
 * Features: scroll detection, mobile menu, navigation
 */
?>



<?php if (isset($themeManager) && $themeManager->getCurrentTheme() === 'svelte'): ?>
    <!-- Svelte Header -->
    <div id="svelte-header"
         data-current-route="<?= $currentRoute ?? '' ?>"
         data-search-query="<?= $searchQuery ?? '' ?>"></div>

    <!-- Svelte Search Modal -->
    <div id="svelte-search-modal"></div>
<?php else: ?>
    <!-- Alpine.js Header -->

<header
    class="header" 
    x-data="{ 
        isScrolled: false,
        mobileMenuOpen: false,
        init() {
            this.handleScroll();
            window.addEventListener('scroll', () => this.handleScroll());
        },
        handleScroll() {
            this.isScrolled = window.pageYOffset > 0;
        },
        toggleMobileMenu() {
            this.mobileMenuOpen = !this.mobileMenuOpen;
            document.body.style.overflow = this.mobileMenuOpen ? 'hidden' : '';
        }
    }"
    :class="{ 'scrolled': isScrolled }"
>
    <!-- Decorative dots (absolute positioned) -->
    <div class="dots">
        <?php $this->insert('components/ui/dots-container') ?>
    </div>

    <!-- Main Navigation -->
    <nav class="nav" role="navigation" aria-label="Main navigation">
        <a href="/docs/latest" class="nav-link">Documentation</a>
        <a href="/articles" class="nav-link">Articles</a>
        <a href="/examples" class="nav-link">Examples</a>
        <a href="/download" class="nav-link">Download</a>
    </nav>

    <!-- Aside section (search, mobile menu) -->
    <aside class="aside">
        <!-- Search -->
        <div class="search-container">
            <?php $this->insert('components/ui/search-input', [
                'action' => '/search',
                'query' => $searchQuery ?? '',
                'placeholder' => 'Search documentation...'
            ]) ?>
        </div>

        <!-- Mobile Menu Toggle -->
        <div class="mobile-menu-toggle" x-show="true" @click="toggleMobileMenu()">
            <div class="menu-icon" x-show="!mobileMenuOpen">
                <span></span>
                <span></span>
                <span></span>
            </div>
            <div class="close-icon" x-show="mobileMenuOpen">
                <span></span>
                <span></span>
            </div>
        </div>
    </aside>

    <!-- Decorative dots -->
    <div class="dots">
        <?php $this->insert('components/ui/dots-container') ?>
    </div>

    <!-- Mobile Menu Overlay -->
    <div 
        class="mobile-menu-overlay" 
        x-show="mobileMenuOpen"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        @click="toggleMobileMenu()"
    ></div>

    <!-- Mobile Menu Content -->
    <div 
        class="mobile-menu-content"
        x-show="mobileMenuOpen"
        x-transition:enter="transition ease-out duration-300 transform"
        x-transition:enter-start="translate-y-full"
        x-transition:enter-end="translate-y-0"
        x-transition:leave="transition ease-in duration-200 transform"
        x-transition:leave-start="translate-y-0"
        x-transition:leave-end="translate-y-full"
    >
        <div class="mobile-menu-inner">
            <!-- References Section -->
            <div class="menu-section" x-data="{ expanded: false }">
                <div class="menu-title" @click="expanded = !expanded" :class="{ 'expanded': expanded }">
                    <span>References</span>
                    <svg class="chevron" :class="{ 'rotated': expanded }" width="12" height="8" viewBox="0 0 12 8">
                        <path d="M1 1L6 6L11 1" stroke="currentColor" stroke-width="2" fill="none"/>
                    </svg>
                </div>
                <div class="collapsible-content" x-show="expanded" x-collapse>
                    <a href="/docs/latest" class="menu-link">Documentation</a>
                    <a href="/api" class="menu-link">API Reference</a>
                    <a href="/examples" class="menu-link">Examples</a>
                </div>
            </div>

            <!-- Articles Section -->
            <div class="menu-section" x-data="{ expanded: false }">
                <div class="menu-title" @click="expanded = !expanded" :class="{ 'expanded': expanded }">
                    <span>Articles</span>
                    <svg class="chevron" :class="{ 'rotated': expanded }" width="12" height="8" viewBox="0 0 12 8">
                        <path d="M1 1L6 6L11 1" stroke="currentColor" stroke-width="2" fill="none"/>
                    </svg>
                </div>
                <div class="collapsible-content" x-show="expanded" x-collapse>
                    <a href="/articles" class="menu-link">All Articles</a>
                    <a href="/articles/category/1" class="menu-link">Tutorials</a>
                    <a href="/articles/category/2" class="menu-link">News</a>
                </div>
            </div>

            <!-- Direct Links -->
            <div class="menu-section">
                <a href="/download" class="menu-link primary">Download</a>
                <a href="/community" class="menu-link">Community</a>
                <a href="/support" class="menu-link">Support</a>
            </div>
        </div>
    </div>
</header>

<!-- Header padding to prevent content jump -->
<div class="header-padding"></div>
<?php endif; ?>



