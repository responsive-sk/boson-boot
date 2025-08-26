<?php
/**
 * App Layout - for application pages (articles, docs, search, etc.)
 * Includes header, main content area, and footer
 */

$this->layout('layouts::base', [
    'title' => $title ?? 'Boson PHP',
    'description' => $description ?? 'Familiar PHP. Now for desktop applications.',
    'cssUrl' => isset($themeManager) ? null : ($cssUrl ?? '/assets/app.css'), // Let ThemeManager handle CSS
    'jsUrl' => $jsUrl ?? null,
    'canonical' => $canonical ?? null,
    'ogImage' => $ogImage ?? null,
    'htmxExtensions' => $htmxExtensions ?? [],
    'bodyClass' => ($bodyClass ?? '') . ' app-layout',
    'themeManager' => $themeManager ?? null,
])
?>

<?php $this->start('body') ?>

<!-- Header -->
<?php if (!isset($showHeader) || $showHeader): ?>
    <?php $this->insert('partials::header', [
        'currentRoute' => $currentRoute ?? '',
        'searchQuery' => $searchQuery ?? '',
        'blogCategories' => $blogCategories ?? [],
        'docsVersion' => $docsVersion ?? null,
        'docsCategories' => $docsCategories ?? [],
        'themeManager' => $themeManager ?? null,
    ]) ?>
<?php endif; ?>

<!-- Main Content -->
<main id="main-content" class="main-content">
    <!-- Breadcrumbs -->
    <?php if (isset($breadcrumbs) && !empty($breadcrumbs)): ?>
        <?php $this->insert('components/ui/breadcrumbs', ['items' => $breadcrumbs]) ?>
    <?php endif; ?>
    
    <!-- Page Header -->
    <?php if (isset($pageTitle)): ?>
        <div class="page-header">
            <div class="container">
                <h1 class="page-title"><?= $this->escapeHtml($pageTitle) ?></h1>
                <?php if (isset($pageSubtitle)): ?>
                    <p class="page-subtitle"><?= $this->escapeHtml($pageSubtitle) ?></p>
                <?php endif; ?>
            </div>
        </div>
    <?php endif; ?>
    
    <!-- Page Content -->
    <div class="page-content">
        <?= $this->section('main') ?>
    </div>
</main>

<!-- Footer -->
<?php if (!isset($showFooter) || $showFooter): ?>
    <?php $this->insert('partials::footer', [
        'themeManager' => $themeManager ?? null,
        'currentRoute' => $currentRoute ?? '',
    ]) ?>
<?php endif; ?>

<?php $this->stop() ?>

<?php $this->start('head') ?>
<style>
.app-layout {
    min-height: 100vh;
    display: flex;
    flex-direction: column;
}

.main-content {
    flex: 1;
    padding-top: 0;
}

.page-header {
    background: var(--surface);
    border-bottom: 1px solid var(--border);
    padding: 2rem 0;
    margin-bottom: 2rem;
}

.page-title {
    font-size: 2.5rem;
    font-weight: 700;
    color: var(--text-primary);
    margin-bottom: 0.5rem;
}

.page-subtitle {
    font-size: 1.125rem;
    color: var(--text-secondary);
    margin: 0;
}

.page-content {
    padding: 0 0 4rem;
}

@media (max-width: 768px) {
    .page-title {
        font-size: 2rem;
    }
    
    .page-header {
        padding: 1.5rem 0;
        margin-bottom: 1.5rem;
    }
}
</style>
<?php $this->stop() ?>
