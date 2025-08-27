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
    <!-- Alpine.js Footer -->


<?php endif; ?>



