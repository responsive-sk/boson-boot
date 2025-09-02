<?php
/**
 * Footer partial - supports both Svelte and Alpine.js themes
 * Features: navigation links, social links, copyright
 */
?>

<?php if (isset($themeManager) && $themeManager->getCurrentTheme() === 'svelte'): ?>
    <!-- Svelte Footer -->
    <div id="svelte-footer" data-current-route="<?= $currentRoute ?? '' ?>"></div>

    <!-- Fallback footer (will be hidden when Svelte loads) -->
    <footer class="footer-container fallback-footer" style="display: none;">
        <div class="footer-content">
            <div class="footer-top">
                <div class="main-link-section">
                    <a href="/docs/latest/installation" class="footer-main-link">Try Boson for Free</a>
                </div>
                <div class="aside-link-section">
                    <a href="/community" class="footer-aside-link">Join Community</a>
                </div>
            </div>
            <div class="footer-bottom">
                <div class="copyright">
                    <p>&copy; <?= date('Y') ?> Boson PHP Team. All rights reserved.</p>
                </div>
                <div class="secondary-links">
                    <a href="/privacy">Privacy Policy</a>
                    <a href="/terms">Terms of Service</a>
                    <a href="/contact">ContaCt</a>
                </div>
            </div>
        </div>
    </footer>
<?php else: ?>
    <!-- Enhanced Alpine.js Footer - Matching Svelte Theme -->
    <footer class="footer-container">
        <div class="footer-content">
            <!-- Top section with main links -->
            <div class="footer-top">
                <div class="holder"></div>

                <!-- Main link section -->
                <div class="main-link-section">
                    <a href="/docs/latest/installation" class="footer-main-link">
                        Try Boson for Free
                    </a>
                </div>

                <!-- Decorative dots -->
                <div class="dots-main">
                    <div class="dots-inner"></div>
                </div>

                <!-- Aside link section -->
                <div class="aside-link-section">
                    <a href="/community" class="footer-aside-link">
                        Join Community
                    </a>
                </div>

                <div class="holder"></div>
            </div>

            <!-- Middle section with navigation links -->
            <div class="footer-middle">
                <div class="holder"></div>

                <!-- References Section -->
                <div class="footer-section">
                    <h3 class="footer-section-title">
                        References
                        <svg class="footer-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <path d="M9 18l6-6-6-6"/>
                        </svg>
                    </h3>
                    <ul class="footer-links">
                        <li><a href="/docs/latest" class="footer-link">Documentation</a></li>
                        <li><a href="/api" class="footer-link">API Reference</a></li>
                        <li><a href="/examples" class="footer-link">Examples</a></li>
                    </ul>
                </div>

                <!-- Articles Section -->
                <div class="footer-section">
                    <h3 class="footer-section-title">
                        Articles
                        <svg class="footer-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <path d="M9 18l6-6-6-6"/>
                        </svg>
                    </h3>
                    <ul class="footer-links">
                        <li><a href="/articles" class="footer-link">All Articles</a></li>
                        <li><a href="/articles/category/1" class="footer-link">Tutorials</a></li>
                        <li><a href="/articles/category/2" class="footer-link">News</a></li>
                    </ul>
                </div>

                <!-- Community Section -->
                <div class="footer-section">
                    <h3 class="footer-section-title">
                        Community
                        <svg class="footer-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <path d="M9 18l6-6-6-6"/>
                        </svg>
                    </h3>
                    <ul class="footer-links">
                        <li><a href="/download" class="footer-link">Download</a></li>
                        <li><a href="/community" class="footer-link">Community</a></li>
                        <li><a href="/support" class="footer-link">Support</a></li>
                    </ul>
                </div>

                <div class="holder"></div>
            </div>

            <!-- Bottom section with copyright and legal links -->
            <div class="footer-bottom">
                <div class="holder"></div>

                <div class="footer-copyright">
                    <p>&copy; <?= date('Y') ?> Boson PHP Team. All rights reserved.</p>
                </div>

                <div class="footer-legal">
                    <a href="/privacy" class="footer-legal-link">Privacy Policy</a>
                    <span class="footer-separator">•</span>
                    <a href="/terms" class="footer-legal-link">Terms of Service</a>
                    <span class="footer-separator">•</span>
                    <a href="/contact" class="footer-legal-link">Contact</a>
                </div>

                <div class="holder"></div>
            </div>

            <!-- Decorative dots at bottom -->
            <div class="dots-bottom">
                <div class="dots-inner"></div>
            </div>
        </div>
    </footer>
<?php endif; ?>



