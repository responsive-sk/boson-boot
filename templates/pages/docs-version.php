<?php $this->layout('layouts::app', [
    'title' => $title,
    'description' => $description,
    'currentRoute' => $currentRoute,
    'pageTitle' => $pageTitle,
    'pageSubtitle' => $pageSubtitle,
    'breadcrumbs' => $breadcrumbs
]) ?>

<?php $this->start('main') ?>

<div class="docs-page">
    <div class="container">
        <div class="docs-layout">
            <!-- Sidebar -->
            <aside class="docs-sidebar">
                <?= $sidebar ?>
            </aside>
            
            <!-- Main Content -->
            <main class="docs-content">
                <div class="version-info">
                    <span class="version-badge">Version <?= $this->escapeHtml($version) ?></span>
                </div>
                <?= $docsContent ?>
            </main>
        </div>
    </div>
</div>

<style>
.docs-layout {
    display: grid;
    grid-template-columns: 280px 1fr;
    gap: 3rem;
    align-items: start;
}

.docs-sidebar {
    position: sticky;
    top: 2rem;
    max-height: calc(100vh - 4rem);
    overflow-y: auto;
}

.docs-content {
    min-width: 0;
}

.version-info {
    margin-bottom: 2rem;
}

.version-badge {
    display: inline-block;
    background: var(--primary);
    color: white;
    padding: 0.25rem 0.75rem;
    border-radius: 1rem;
    font-size: 0.875rem;
    font-weight: 500;
}

@media (max-width: 768px) {
    .docs-layout {
        grid-template-columns: 1fr;
        gap: 2rem;
    }
    
    .docs-sidebar {
        position: static;
        max-height: none;
        order: 2;
    }
}
</style>

<?php $this->stop() ?>
