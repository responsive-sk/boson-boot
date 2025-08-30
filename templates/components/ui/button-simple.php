<?php
/**
 * Simple Button Component - No JS dependencies
 * Basic button for testing PHP component system
 */

$text = $text ?? 'Button';
$type = $type ?? 'primary'; // primary, secondary, danger
$size = $size ?? 'default'; // small, default, large
$disabled = $disabled ?? false;
$classes = $classes ?? '';
?>

<button type="button" 
        class="btn btn-<?= $type ?> btn-<?= $size ?> <?= $classes ?>"
        <?= $disabled ? 'disabled' : '' ?>>
    <?= htmlspecialchars($text) ?>
</button>

<style>
/* Simple button styles */
.btn {
    padding: 8px 16px;
    border: 1px solid #ddd;
    border-radius: 4px;
    cursor: pointer;
    font-size: 14px;
    transition: all 0.2s;
}

.btn-primary {
    background: #007bff;
    color: white;
    border-color: #007bff;
}

.btn-secondary {
    background: #6c757d;
    color: white;
    border-color: #6c757d;
}

.btn-danger {
    background: #dc3545;
    color: white;
    border-color: #dc3545;
}

.btn:hover:not(:disabled) {
    opacity: 0.8;
}

.btn:disabled {
    opacity: 0.5;
    cursor: not-allowed;
}

.btn-small {
    padding: 4px 8px;
    font-size: 12px;
}

.btn-large {
    padding: 12px 24px;
    font-size: 16px;
}
</style>
