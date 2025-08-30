<?php
/**
 * Simple Card Component - No JS dependencies
 * Basic card for testing PHP component system
 */

$title = $title ?? 'Card Title';
$content = $content ?? 'Card content goes here.';
$footer = $footer ?? null;
$classes = $classes ?? '';
?>

<div class="card <?= $classes ?>">
    <?php if ($title): ?>
        <div class="card-header">
            <h3 class="card-title"><?= htmlspecialchars($title) ?></h3>
        </div>
    <?php endif; ?>
    
    <div class="card-body">
        <?= $content ?>
    </div>
    
    <?php if ($footer): ?>
        <div class="card-footer">
            <?= $footer ?>
        </div>
    <?php endif; ?>
</div>

<style>
/* Simple card styles */
.card {
    border: 1px solid #ddd;
    border-radius: 8px;
    background: white;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    margin: 10px 0;
}

.card-header {
    padding: 15px;
    border-bottom: 1px solid #eee;
    background: #f8f9fa;
    border-radius: 8px 8px 0 0;
}

.card-title {
    margin: 0;
    font-size: 18px;
    font-weight: 600;
    color: #333;
}

.card-body {
    padding: 15px;
    color: #666;
    line-height: 1.5;
}

.card-footer {
    padding: 15px;
    border-top: 1px solid #eee;
    background: #f8f9fa;
    border-radius: 0 0 8px 8px;
}
</style>
