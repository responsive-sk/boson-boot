<?php $this->layout('layouts::app', [
    'title' => $title,
    'description' => $description,
    'currentRoute' => $currentRoute,
    'pageTitle' => $pageTitle,
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
                
                <article class="docs-article">
                    <?= $doc['content'] ?>
                </article>
                
                <!-- Table of Contents -->
                <?php if (!empty($tableOfContents)): ?>
                    <aside class="table-of-contents">
                        <h3>On this page</h3>
                        <ul>
                            <?php foreach ($tableOfContents as $item): ?>
                                <li>
                                    <a href="#<?= $item['anchor'] ?? $item['id'] ?? '' ?>">
                                        <?= $this->escapeHtml($item['title']) ?>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </aside>
                <?php endif; ?>
            </main>
        </div>
    </div>
</div>

<style>
.docs-layout {
    display: grid;
    grid-template-columns: 280px 1fr 200px;
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

.docs-article {
    max-width: none;
    font-size: 1rem;
    line-height: 1.7;
}

.docs-article h1,
.docs-article h2,
.docs-article h3,
.docs-article h4 {
    margin-top: 2rem;
    margin-bottom: 1rem;
    color: var(--text-primary);
}

.docs-article h1 {
    font-size: 2rem;
    margin-top: 0;
}

.docs-article h2 {
    font-size: 1.5rem;
    border-bottom: 1px solid var(--border);
    padding-bottom: 0.5rem;
}

.docs-article h3 {
    font-size: 1.25rem;
}

.docs-article code {
    background: var(--surface-secondary);
    padding: 0.125rem 0.25rem;
    border-radius: 3px;
    font-size: 0.875em;
}

.docs-article pre {
    background: var(--surface-secondary);
    padding: 1rem;
    border-radius: 6px;
    overflow-x: auto;
    margin: 1.5rem 0;
}

.docs-article pre code {
    background: none;
    padding: 0;
}

.table-of-contents {
    position: sticky;
    top: 2rem;
    max-height: calc(100vh - 4rem);
    overflow-y: auto;
}

.table-of-contents h3 {
    font-size: 0.875rem;
    font-weight: 600;
    color: var(--text-primary);
    margin-bottom: 0.5rem;
}

.table-of-contents ul {
    list-style: none;
    padding: 0;
    margin: 0;
}

.table-of-contents li {
    margin-bottom: 0.25rem;
}

.table-of-contents a {
    color: var(--text-secondary);
    text-decoration: none;
    font-size: 0.875rem;
    line-height: 1.4;
    transition: color 0.2s ease;
}

.table-of-contents a:hover {
    color: var(--primary);
}

@media (max-width: 1024px) {
    .docs-layout {
        grid-template-columns: 280px 1fr;
    }
    
    .table-of-contents {
        display: none;
    }
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
