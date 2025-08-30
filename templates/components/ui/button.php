<?php
/**
 * Button Component - converted from Lit boson-button component
 * Versatile button with multiple types, sizes, and states
 */

$href = $href ?? null;
$text = $text ?? 'Button';
$type = $type ?? 'primary'; // primary, secondary, ghost, outline
$size = $size ?? 'default'; // small, default, large
$icon = $icon ?? null;
$iconPosition = $iconPosition ?? 'right'; // left, right
$external = $external ?? false;
$active = $active ?? false;
$disabled = $disabled ?? false;
$htmlType = $htmlType ?? 'button'; // button, submit, reset
$onClick = $onClick ?? null;
$htmxAttributes = $htmxAttributes ?? [];
$classes = $classes ?? '';
?>

<?php if ($href && !$disabled): ?>
    <!-- Link Button -->
    <a href="<?= htmlspecialchars($href) ?>" 
       class="btn btn-<?= $type ?> btn-<?= $size ?> <?= $active ? 'active' : '' ?> <?= $classes ?>"
       <?= $external ? 'target="_blank" rel="noopener noreferrer"' : '' ?>
       <?php if ($external): ?>aria-label="<?= htmlspecialchars($text) ?> (opens in new tab)"<?php endif; ?>
       <?php foreach ($htmxAttributes as $attr => $value): ?>
           <?= $attr ?>="<?= htmlspecialchars($value) ?>"
       <?php endforeach; ?>>
        
        <?php if ($icon && $iconPosition === 'left'): ?>
            <img src="<?= htmlspecialchars($icon) ?>" alt="" class="btn-icon btn-icon-left" width="16" height="16">
        <?php endif; ?>
        
        <span class="btn-text"><?= htmlspecialchars($text) ?></span>
        
        <?php if ($icon && $iconPosition === 'right'): ?>
            <img src="<?= htmlspecialchars($icon) ?>" alt="" class="btn-icon btn-icon-right" width="16" height="16">
        <?php endif; ?>
        
        <?php if ($external): ?>
            <svg class="btn-external-icon" width="12" height="12" viewBox="0 0 12 12" fill="none">
                <path d="M3.5 3H8.5V8M8.5 3L3.5 8" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        <?php endif; ?>
    </a>
<?php else: ?>
    <!-- Button Element -->
    <button type="<?= $htmlType ?>" 
            class="btn btn-<?= $type ?> btn-<?= $size ?> <?= $active ? 'active' : '' ?> <?= $classes ?>"
            <?= $disabled ? 'disabled' : '' ?>
            <?php if ($onClick): ?>onclick="<?= htmlspecialchars($onClick) ?>"<?php endif; ?>
            <?php foreach ($htmxAttributes as $attr => $value): ?>
                <?= $attr ?>="<?= htmlspecialchars($value) ?>"
            <?php endforeach; ?>>
        
        <?php if ($icon && $iconPosition === 'left'): ?>
            <img src="<?= htmlspecialchars($icon) ?>" alt="" class="btn-icon btn-icon-left" width="16" height="16">
        <?php endif; ?>
        
        <span class="btn-text"><?= htmlspecialchars($text) ?></span>
        
        <?php if ($icon && $iconPosition === 'right'): ?>
            <img src="<?= htmlspecialchars($icon) ?>" alt="" class="btn-icon btn-icon-right" width="16" height="16">
        <?php endif; ?>
    </button>
<?php endif; ?>



