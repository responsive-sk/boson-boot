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
