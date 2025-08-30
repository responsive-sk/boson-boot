<?php
/**
 * Breadcrumbs Component - converted from Lit boson-breadcrumbs component
 * Navigation breadcrumbs with proper accessibility
 */

$items = $items ?? [];
?>

<?php if (!empty($items)): ?>
<nav class="breadcrumbs-component" aria-label="Breadcrumb navigation">
    <ol class="breadcrumbs-list">
        <?php foreach ($items as $index => $item): ?>
            <li class="breadcrumb-item">
                <?php if (isset($item['url']) && $item['url'] && $index < count($items) - 1): ?>
                    <!-- Linked breadcrumb item -->
                    <?php $this->insert('components/ui/button', [
                        'href' => $item['url'],
                        'text' => $item['text'],
                        'type' => 'ghost',
                        'size' => 'small'
                    ]) ?>
                <?php else: ?>
                    <!-- Current page (no link) -->
                    <span class="breadcrumb-current" aria-current="page">
                        <?= htmlspecialchars($item['text']) ?>
                    </span>
                <?php endif; ?>
            </li>
        <?php endforeach; ?>
    </ol>
</nav>
<?php endif; ?>



