<?php
/**
 * Page Title Container Component
 * Inspired by mark.responsive.sk/blog design
 * 
 * @param string $title - Main page title
 * @param string $subtitle - Optional subtitle/description
 * @param array $breadcrumbs - Breadcrumb navigation array
 * @param array $filters - Optional filter tags
 * @param string $background - Background style: 'default', 'gradient', 'pattern' (default: 'default')
 * @param bool $centered - Center align content (default: false)
 */

$title = $title ?? 'Page Title';
$subtitle = $subtitle ?? null;
$breadcrumbs = $breadcrumbs ?? [];
$filters = $filters ?? [];
$background = $background ?? 'default';
$centered = $centered ?? false;

$backgroundClasses = [
    'default' => 'bg-default',
    'gradient' => 'bg-gradient',
    'pattern' => 'bg-pattern',
    'subtle' => 'bg-subtle'
];

$backgroundClass = $backgroundClasses[$background] ?? $backgroundClasses['default'];
$alignClass = $centered ? 'text-center' : '';
?>

<div class="page-title-container <?= $backgroundClass ?> <?= $alignClass ?>">
    <?php if ($background === 'pattern'): ?>
        <?php
        // Include SVG dots pattern for pattern background
        $color = 'F93904';
        $size = 2;
        $spacing = 8;
        $opacity = 0.05;
        $position = 'absolute';
        $className = 'hover-brighten';
        include __DIR__ . '/svg-dots-pattern.php';
        ?>
    <?php elseif ($background === 'subtle'): ?>
        <?php
        // Include subtle SVG dots pattern for subtle background - better visibility
        $color = 'cbd5e1'; // Darker gray for better visibility
        $size = 2;         // Slightly larger dots
        $spacing = 10;     // Tighter spacing
        $opacity = 0.15;   // Lower opacity but darker color
        $position = 'absolute';
        $className = '';
        include __DIR__ . '/svg-dots-pattern.php';
        ?>
    <?php endif; ?>

    <!-- Note: 'default' background has no dots pattern - clean white background -->

    <div class="container">
        
        <!-- Breadcrumbs -->
        <?php if (!empty($breadcrumbs)): ?>
            <nav class="breadcrumbs" aria-label="Breadcrumb navigation">
                <ol class="breadcrumb-list">
                    <?php foreach ($breadcrumbs as $index => $crumb): ?>
                        <li class="breadcrumb-item">
                            <?php if (isset($crumb['url']) && $index < count($breadcrumbs) - 1): ?>
                                <a href="<?= htmlspecialchars($crumb['url']) ?>" class="breadcrumb-link">
                                    <?= htmlspecialchars($crumb['label']) ?>
                                </a>
                            <?php else: ?>
                                <span class="breadcrumb-current" aria-current="page">
                                    <?= htmlspecialchars($crumb['label']) ?>
                                </span>
                            <?php endif; ?>
                            
                            <?php if ($index < count($breadcrumbs) - 1): ?>
                                <span class="breadcrumb-separator" aria-hidden="true">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <polyline points="9,18 15,12 9,6"></polyline>
                                    </svg>
                                </span>
                            <?php endif; ?>
                        </li>
                    <?php endforeach; ?>
                </ol>
            </nav>
        <?php endif; ?>

        <!-- Main Title -->
        <div class="page-title-content">
            <h1 class="page-title"><?= htmlspecialchars($title) ?></h1>
            
            <?php if ($subtitle): ?>
                <p class="page-subtitle"><?= htmlspecialchars($subtitle) ?></p>
            <?php endif; ?>
        </div>

        <!-- Filter Tags -->
        <?php if (!empty($filters)): ?>
            <div class="page-filters">
                <div class="filter-tags">
                    <?php foreach ($filters as $filter): ?>
                        <a href="<?= htmlspecialchars($filter['url'] ?? '#') ?>" 
                           class="filter-tag <?= ($filter['active'] ?? false) ? 'active' : '' ?>"
                           <?= ($filter['active'] ?? false) ? 'aria-current="page"' : '' ?>>
                            <?= htmlspecialchars($filter['label']) ?>
                            <?php if (isset($filter['count'])): ?>
                                <span class="filter-count"><?= (int)$filter['count'] ?></span>
                            <?php endif; ?>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>
        
    </div>
</div>

<style>
/* Page Title Container - Original Boson Design */
.page-title-container {
    background: url('/images/icons/dots.svg') center center repeat;
    border-bottom: 1px solid var(--border);
    padding: 0;
    position: relative;
    overflow: hidden;
}

.page-title-container.text-center {
    text-align: center;
}

/* Inner container with background that covers dots */
.page-title-inner {
    width: var(--width-content, 90%);
    max-width: var(--width-max, 1200px);
    margin: 0 auto;
    display: flex;
    flex-direction: column;
    justify-content: flex-start;
    align-items: flex-start;
    padding: 3rem 1rem 2rem;
}

.page-title-container.text-center .page-title-inner {
    align-items: center;
    text-align: center;
}

/* Content sections with background that covers dots */
.page-title-content,
.page-filters {
    background: var(--bg-primary);
    padding: 1rem 1.5rem;
    border-radius: 8px;
    margin-bottom: 1rem;
    position: relative;
}

.page-title-content {
    margin-bottom: 2rem;
}

/* Background Variants */
.bg-default {
    background: url('/images/icons/dots.svg') center center repeat;
}

.bg-gradient {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
}

.bg-pattern {
    background: url('/images/icons/dots.svg') center center repeat;
    position: relative;
}

.bg-subtle {
    background: url('/images/icons/dots.svg') center center repeat;
    position: relative;
}

/* Container */
.container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 1rem;
}

/* Breadcrumbs */
.breadcrumbs {
    margin-bottom: 1.5rem;
}

.breadcrumb-list {
    display: flex;
    align-items: center;
    flex-wrap: wrap;
    gap: 0.5rem;
    list-style: none;
    margin: 0;
    padding: 0;
    font-size: 0.875rem;
}

.breadcrumb-item {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.breadcrumb-link {
    color: var(--text-secondary);
    text-decoration: none;
    transition: color 0.2s ease;
}

.breadcrumb-link:hover {
    color: var(--primary);
    text-decoration: underline;
}

.breadcrumb-current {
    color: var(--text-primary);
    font-weight: 500;
}

.breadcrumb-separator {
    color: var(--text-muted);
    display: flex;
    align-items: center;
}

.bg-gradient .breadcrumb-link {
    color: rgba(255, 255, 255, 0.8);
}

.bg-gradient .breadcrumb-link:hover {
    color: white;
}

.bg-gradient .breadcrumb-current {
    color: white;
}

.bg-gradient .breadcrumb-separator {
    color: rgba(255, 255, 255, 0.6);
}

/* Page Title Content */
.page-title-content {
    margin-bottom: 2rem;
}

.page-title {
    font-size: 3rem;
    font-weight: 700;
    line-height: 1.1;
    margin: 0 0 1rem 0;
    color: var(--text-primary);
    letter-spacing: -0.025em;
}

.page-subtitle {
    font-size: 1.125rem;
    color: var(--text-secondary);
    margin: 0;
    line-height: 1.6;
    max-width: 600px;
}

.text-center .page-subtitle {
    margin-left: auto;
    margin-right: auto;
}

.bg-gradient .page-title {
    color: white;
}

.bg-gradient .page-subtitle {
    color: rgba(255, 255, 255, 0.9);
}

/* Filter Tags */
.page-filters {
    margin-top: 1.5rem;
}

.filter-tags {
    display: flex;
    flex-wrap: wrap;
    gap: 0.75rem;
    align-items: center;
}

.filter-tag {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.5rem 1rem;
    background: var(--bg-secondary);
    border: 1px solid var(--border);
    border-radius: 6px;
    color: var(--text-secondary);
    text-decoration: none;
    font-size: 0.875rem;
    font-weight: 500;
    transition: all 0.2s ease;
    position: relative;
}

.filter-tag:hover {
    background: var(--bg-tertiary);
    border-color: var(--border-dark);
    color: var(--text-primary);
    transform: translateY(-1px);
}

.filter-tag.active {
    background: var(--primary);
    border-color: var(--primary);
    color: var(--text-inverse);
}

.filter-tag.active:hover {
    background: var(--primary-dark);
    border-color: var(--primary-dark);
    transform: translateY(-1px);
}

.filter-count {
    background: rgba(255, 255, 255, 0.2);
    padding: 0.125rem 0.375rem;
    border-radius: 4px;
    font-size: 0.75rem;
    font-weight: 600;
}

.filter-tag:not(.active) .filter-count {
    background: var(--text-muted);
    color: var(--text-inverse);
}

.bg-gradient .filter-tag {
    background: rgba(255, 255, 255, 0.1);
    border-color: rgba(255, 255, 255, 0.2);
    color: rgba(255, 255, 255, 0.9);
}

.bg-gradient .filter-tag:hover {
    background: rgba(255, 255, 255, 0.2);
    border-color: rgba(255, 255, 255, 0.3);
    color: white;
}

.bg-gradient .filter-tag.active {
    background: white;
    border-color: white;
    color: var(--primary, #F93904);
}

/* Responsive Design */
@media (max-width: 768px) {
    .page-title-container {
        padding: 2rem 0 1.5rem;
    }
    
    .page-title {
        font-size: 2.25rem;
    }
    
    .page-subtitle {
        font-size: 1rem;
    }
    
    .breadcrumb-list {
        font-size: 0.8125rem;
    }
    
    .filter-tags {
        gap: 0.5rem;
    }
    
    .filter-tag {
        padding: 0.375rem 0.75rem;
        font-size: 0.8125rem;
    }
}

@media (max-width: 480px) {
    .page-title {
        font-size: 1.875rem;
    }
    
    .breadcrumb-list {
        flex-direction: column;
        align-items: flex-start;
        gap: 0.25rem;
    }
    
    .breadcrumb-item {
        gap: 0.25rem;
    }
}

/* Animation on load */
.page-title-container {
    animation: fadeInUp 0.6s ease-out;
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Accessibility */
@media (prefers-reduced-motion: reduce) {
    .page-title-container,
    .filter-tag {
        animation: none;
        transition: none;
    }
    
    .filter-tag:hover {
        transform: none;
    }
}

/* Focus styles */
.breadcrumb-link:focus,
.filter-tag:focus {
    outline: 2px solid var(--primary);
    outline-offset: 2px;
}

.bg-gradient .breadcrumb-link:focus,
.bg-gradient .filter-tag:focus {
    outline-color: white;
}
</style>
