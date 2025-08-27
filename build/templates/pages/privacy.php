<?php $this->layout('layouts::app', [
    'title' => $title,
    'description' => $description,
    'currentRoute' => $currentRoute,
    'pageTitle' => $pageTitle,
    'breadcrumbs' => $breadcrumbs
]) ?>

<?php $this->start('main') ?>

<div class="privacy-page">
    <div class="container">
        <?= $privacyContent ?>
    </div>
</div>

<style>
.privacy-page {
    padding: 2rem 0 4rem;
}

.privacy-page .container {
    max-width: 800px;
}

.privacy-page h2 {
    font-size: 1.75rem;
    font-weight: 600;
    margin: 2.5rem 0 1rem;
    color: var(--text-primary);
}

.privacy-page h3 {
    font-size: 1.5rem;
    font-weight: 600;
    margin: 2rem 0 1rem;
    color: var(--text-primary);
}

.privacy-page h4 {
    font-size: 1.25rem;
    font-weight: 600;
    margin: 1.5rem 0 0.75rem;
    color: var(--text-primary);
}

.privacy-page p {
    margin-bottom: 1.5rem;
    line-height: 1.7;
    color: var(--text-secondary);
}

.privacy-page ul {
    margin-bottom: 1.5rem;
    padding-left: 1.5rem;
}

.privacy-page li {
    margin-bottom: 0.5rem;
    line-height: 1.6;
    color: var(--text-secondary);
}

.privacy-page .section {
    margin-bottom: 3rem;
}

.privacy-page .last-updated {
    background: var(--surface-secondary);
    padding: 1rem 1.5rem;
    border-radius: 8px;
    margin-bottom: 2rem;
    font-size: 0.875rem;
    color: var(--text-secondary);
}

.privacy-page .important {
    background: var(--surface);
    border: 1px solid var(--border);
    border-left: 4px solid var(--primary);
    padding: 1.5rem;
    border-radius: 8px;
    margin: 2rem 0;
}

.privacy-page .important h4 {
    margin-top: 0;
    color: var(--primary);
}
</style>

<?php $this->stop() ?>
