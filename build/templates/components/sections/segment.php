<?php
/**
 * Segment Section Component - converted from Lit segment-section component
 * Flexible section layout with title, subtitle, and content areas
 */

$type = $type ?? 'horizontal'; // horizontal, vertical, center
$sectionName = $sectionName ?? '';
$title = $title ?? '';
$content = $content ?? '';
$anchorId = $anchorId ?? null;
?>

<section class="segment-section segment-<?= $type ?>">
    <?php if ($anchorId): ?>
        <span id="<?= htmlspecialchars($anchorId) ?>" class="segment-anchor"></span>
    <?php endif; ?>
    
    <div class="segment-container">
        <!-- Title section -->
        <hgroup class="segment-title">
            <?php if ($sectionName): ?>
            <div class="segment-subtitle">
                <!-- Decorative icon -->
                <svg class="segment-icon" width="12" height="14" viewBox="0 0 12 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M4.20167 0L1.03888 14H0L3.15125 0H4.20167Z" />
                    <path d="M12 0L8.8372 14H7.79833L10.9496 0H12Z" />
                </svg>

                <h3 class="segment-name">
                    <?= htmlspecialchars($sectionName) ?>
                </h3>
            </div>
            <?php endif; ?>

            <?php if ($title): ?>
            <h4 class="segment-main-title">
                <?= htmlspecialchars($title) ?>
            </h4>
            <?php endif; ?>
        </hgroup>

        <!-- Content section -->
        <aside class="segment-content">
            <?php if ($content): ?>
                <?= $content ?>
            <?php endif; ?>
            
            <!-- Additional content can be inserted here -->
            <?php if (isset($additionalContent)): ?>
                <?= $additionalContent ?>
            <?php endif; ?>
        </aside>
    </div>
</section>



