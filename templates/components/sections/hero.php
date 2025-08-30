<?php
/**
 * Hero Section Component - converted from Lit hero-section component
 * Main landing page hero with title, description, buttons, and discovery link
 */

$title = $title ?? '';
$subtitle = $subtitle ?? '';
$description = $description ?? '';
$buttonText = $buttonText ?? 'Get Started';
$buttonUrl = $buttonUrl ?? '#';
$buttonIcon = $buttonIcon ?? '';
$discoveryText = $discoveryText ?? 'Discover more';
$discoveryUrl = $discoveryUrl ?? '#';
$showLogo = $showLogo ?? true;
?>

<section class="hero-section">
    <div class="hero-container">
        <!-- Main content area -->
        <div class="hero-top">
            <!-- Text content -->
            <div class="hero-text">
                <!-- Headlines -->
                <div class="hero-headlines">
                    <hgroup>
                        <?php if ($title): ?>
                            <h1 class="hero-title"><?= htmlspecialchars($title) ?></h1>
                        <?php endif; ?>
                        
                        <?php if ($subtitle): ?>
                            <h2 class="hero-subtitle"><?= htmlspecialchars($subtitle) ?></h2>
                        <?php endif; ?>
                    </hgroup>
                </div>

                <!-- Description -->
                <?php if ($description): ?>
                <p class="hero-description">
                    <?= htmlspecialchars($description) ?>
                </p>
                <?php endif; ?>

                <!-- Action buttons -->
                <div class="hero-buttons">
                    <?php if ($buttonText && $buttonUrl): ?>
                        <?php $this->insert('components/ui/button', [
                            'href' => $buttonUrl,
                            'text' => $buttonText,
                            'icon' => $buttonIcon,
                            'type' => 'primary',
                            'size' => 'large'
                        ]) ?>
                    <?php endif; ?>
                    
                    <!-- Additional buttons can be added here -->
                    <?php if (isset($secondaryButton)): ?>
                        <?php $this->insert('components/ui/button', $secondaryButton) ?>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Logo/Image section -->
            <?php if ($showLogo): ?>
            <div class="hero-image">
                <div class="hero-logo-container">
                    <?php $this->insert('components/ui/logo', [
                        'animated' => true,
                        'size' => 'large'
                    ]) ?>
                </div>
            </div>
            <?php endif; ?>
        </div>

        <!-- Discovery section -->
        <?php if ($discoveryText && $discoveryUrl): ?>
        <aside class="hero-bottom">
            <a href="<?= htmlspecialchars($discoveryUrl) ?>" 
               class="hero-discover"
               hx-boost="true">
                <span class="hero-discover-container">
                    <span class="hero-discover-text">
                        <?= htmlspecialchars($discoveryText) ?>
                    </span>
                    
                    <img class="hero-discover-icon"
                         src="/images/icons/arrow_down.svg" 
                         alt="down arrow" 
                         width="16" 
                         height="16"/>
                </span>
            </a>
        </aside>
        <?php endif; ?>
    </div>
</section>



