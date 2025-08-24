<?php
/**
 * Footer partial - converted from Lit boson-footer component
 * Simple footer with slots for main links, aside links, and copyright
 */
?>

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

        <!-- Bottom section with copyright and secondary links -->
        <div class="footer-bottom">
            <div class="holder"></div>

            <!-- Copyright -->
            <div class="copyright">
                <p>&copy; <?= date('Y') ?> Boson PHP Team. All rights reserved.</p>
            </div>

            <!-- Secondary links -->
            <div class="secondary-links">
                <a href="/privacy" class="footer-secondary-link">Privacy Policy</a>
                <a href="/terms" class="footer-secondary-link">Terms of Service</a>
                <a href="/contact" class="footer-secondary-link">Contact</a>
            </div>

            <div class="holder"></div>
        </div>

        <!-- Decorative dots - left side -->
        <div class="dots-left">
            <?php $this->insert('components::dots-container') ?>
        </div>

        <!-- Decorative dots - right side -->
        <div class="dots-right">
            <?php $this->insert('components::dots-container') ?>
        </div>
    </div>
</footer>



