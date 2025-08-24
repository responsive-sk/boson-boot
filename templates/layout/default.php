<?php
/**
 * Default Layout - converted from Lit default-layout component
 * Standard layout for content pages (docs, blog, etc.)
 */

$this->layout('layout::master', [
    'title' => $title ?? 'Boson PHP',
    'description' => $description ?? 'Familiar PHP. Now for desktop applications.',
    'showHeader' => $showHeader ?? true,
    'showFooter' => $showFooter ?? true,
    'cssUrl' => $cssUrl ?? '/assets/app.css',
    'currentRoute' => $currentRoute ?? '',
    'htmxExtensions' => $htmxExtensions ?? [],
    'metaTags' => $metaTags ?? null,
    'canonical' => $canonical ?? null,
    'ogImage' => $ogImage ?? null,
    'blogCategories' => $blogCategories ?? [],
    'docsVersion' => $docsVersion ?? null,
    'docsCategories' => $docsCategories ?? [],
    'searchQuery' => $searchQuery ?? '',
])
?>

<?php $this->start('main') ?>

<div class="default-layout">
    <!-- Breadcrumbs -->
    <?php if (isset($breadcrumbs) && !empty($breadcrumbs)): ?>
        <?php $this->insert('components::breadcrumbs', ['items' => $breadcrumbs]) ?>
    <?php endif; ?>

    <!-- Page Header -->
    <?php if (isset($pageTitle) || isset($pageSubtitle)): ?>
    <header class="page-header">
        <?php if (isset($pageTitle)): ?>
            <h1 class="page-title"><?= htmlspecialchars($pageTitle) ?></h1>
        <?php endif; ?>
        
        <?php if (isset($pageSubtitle)): ?>
            <p class="page-subtitle"><?= htmlspecialchars($pageSubtitle) ?></p>
        <?php endif; ?>
    </header>
    <?php endif; ?>

    <!-- Main Content Area -->
    <div class="content-wrapper">
        <!-- Sidebar (if present) -->
        <?php if (isset($sidebar)): ?>
        <aside class="sidebar">
            <?= $sidebar ?>
        </aside>
        <?php endif; ?>

        <!-- Main Content -->
        <main class="main-content <?= isset($sidebar) ? 'with-sidebar' : 'full-width' ?>">
            <?php if (isset($content)): ?>
                <?= $content ?>
            <?php endif; ?>
            
            <!-- Additional sections -->
            <?php if (isset($sections) && is_array($sections)): ?>
                <?php foreach ($sections as $section): ?>
                    <?php if ($section['type'] === 'component'): ?>
                        <?php $this->insert($section['template'], $section['data'] ?? []) ?>
                    <?php else: ?>
                        <?= $section['content'] ?>
                    <?php endif; ?>
                <?php endforeach; ?>
            <?php endif; ?>
        </main>
    </div>

    <!-- Table of Contents (for docs) -->
    <?php if (isset($tableOfContents)): ?>
        <?php $this->insert('components::table-of-contents', ['items' => $tableOfContents]) ?>
    <?php endif; ?>
</div>

<?php $this->stop() ?>



